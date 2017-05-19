{**
*  This file is part of the VCL for PHP project
*
*  Copyright (c) 2004-2008 qadram software S.L. <support@qadram.com>
*
*  Checkout AUTHORS file for more information on the developers
*
*  This library is free software; you can redistribute it and/or
*  modify it under the terms of the GNU Lesser General Public
*  License as published by the Free Software Foundation; either
*  version 2.1 of the License, or (at your option) any later version.
*
*  This library is distributed in the hope that it will be useful,
*  but WITHOUT ANY WARRANTY; without even the implied warranty of
*  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
*  Lesser General Public License for more details.
*
*  You should have received a copy of the GNU Lesser General Public
*  License along with this library; if not, write to the Free Software
*  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307
*  USA
*
*}
unit uACLRulesEditor;

interface

uses
    Windows, Messages, SysUtils,
    Variants, Classes, Graphics,
    Controls, Forms, Dialogs, Clipbrd,
    StdCtrls, ExtCtrls, D4PHPIntf,
    Buttons, ActnList;

const
    ruleHeight = 30;

type
    //Holds all information regarding the rule set, all values for roles and
    //resources attached to it
    TRuleSet = class
    public
        roles: TList; //List all roles for this ruleset
        resources: TList; //List all resources for this ruleset
        constructor Create;
        destructor Destroy; override;
        procedure addNewRole(const atype, aname: string); //Adds a new role to the ruleset
        procedure addNewResource(const a1, a2, a3, a4, a5: string); //Adds a new resource to the ruleset
    end;

    //This class represents the detail line inside a rules panel
    TRule = class(TPanel)
    private
        FSelected: boolean;
        procedure SetSelected(const Value: boolean);
        procedure CNKeyDown(var Message: TWMKeyDown); message CN_KEYDOWN; //Processes key up and down to allow user navigate through the rules using keyboard
    protected
        labels: TList; //List all labels the rule is going to show
        combos: TList; //List all combos the rule is going to show
    public
        values: TStringList; //This is a reference to the values of the ruleset for this rule
        setlist: TList; //Reference to the list that holds the values stringlist
        procedure selectDownRule; //Select the rule just below this one, if any
        procedure selectUpRule; //Select the rule just above this one, if any
        property Selected: boolean read FSelected write SetSelected; //Specifies if this rule is selected inside the rule panel or not
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
    end;

    //This class is the panel where all rules are going to be shown
    //derive from ScrollBox to have a scrollbar automatically created
    TRulesPanel = class(TScrollBox)
    protected
        FSelectedRule: TRule;
        FColumnCount: integer;
        inupdate: boolean; //Specifies the control is inside an update, to optimize redrawing
        bufferpanel: TPanel; //This is the parent for all rules inside this panel, to optimize redrawing
        oldbufferpanel: TPanel; //To improve updates, the previous buffer panel is release after everything is created on the new one
        procedure OnSelectRule(sender: TObject); //Called when a rule has been selected
        procedure SetSelectedRule(const Value: TRule);
        procedure SetColumnCount(const Value: integer);
    public
        loading: boolean; //Specifies the control is being populated with data
        procedure createBufferPanel; //Creates the buffer panel
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;

        function AddNewRule: TRule; overload; //Adds a new rule to the rule panel, it returns the rule just being added
        function AddNewRule(values: TStringList): TRule; overload; //Adds a new rule and sets the values for it to the ones passed on value
        procedure updateRuleCombos(rule: TRule);

        procedure beginclear; //Begins a clear operation, it creates a new buffer panel for controls to live on
        procedure endclear; //Finishes a clear operation by freeing the oldbufferpanel

        procedure beginupdate; //Starts an update operation, you must call endupdate to reflect changes
        procedure endupdate; //Finishes an update operation

        procedure OnCombosChange(sender: TObject); virtual; //Called whenever a combo is changed to another value
        procedure OnCombosExit(sender: TObject); virtual; abstract; //Called when the user exits from a combo
        procedure OnTypeComboChange(Sender: TObject); virtual; abstract; //The first combo in a rule defines the type of it, override to provide a layout change for the rule
        procedure updateValues; //Called to update the values for this rule with the values of the combos

        procedure AddControlsToRule(rule: TRule); virtual; //Adds all controls to the rule, override this method to provide a different schema for controls

        procedure DeleteSelectedRule; //Deletes the selected rule, if any and selects the right one
        property SelectedRule: TRule read FSelectedRule write SetSelectedRule; //Specifies which rule is selected on the panel
        property ColumnCount: integer read FColumnCount write SetColumnCount; //Specifies how many colums, at max, must have rules created on this panel
    end;

    //Top panel, for rules, inherits from rules panel and overrides
    //required methods to provide customizations
    TRolesPanel = class(TRulesPanel)
    public
        availableroles: TStringList; //Roles available on the combo when the type for the selected rule is Role
        availableusers: TStringList; //Users available on the combo when the type for the selected rule is User
        procedure OnTypeComboChange(Sender: TObject); override;
        procedure OnCombosExit(sender: TObject); override;
        procedure updateCombos(rule: TRule; forceindex: integer = -1); //Updates combos in a rule to match the current combo selection
        procedure AddControlsToRule(rule: TRule); override;
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
    end;


    //Bottom panel, for resoures, inherits from rules panel and overrides
    //required methods to provide customizations
    TResourcesPanel = class(TRulesPanel)
    public
        availablepages: TStringList; //Pages available
        availableactions: TStringList; //Actions available
        availablecontrols: TStringList; //Controls available
        actionsforaction: TStringList; //Available actions for an specific action
        controlsforcontrol: TStringList; //Controls available for an specific class

        procedure setupPageLayout; //Setups the active rule as a Page rule
        procedure setupActionLayout; //Setups the active rule as an Action rule
        procedure setupControlLayout; //Setups the active rule as a Control rule
        procedure setupCustomLayout; //Setups the active rule as a Control rule

        procedure OnCombosExit(sender: TObject); override;
        procedure updateCombos(rule: TRule; forceindex: integer = -1); //Update combos on the specified rule according to the selections
        procedure OnCombosChange(sender: TObject); override;
        procedure OnTypeComboChange(Sender: TObject); override;
        procedure AddControlsToRule(rule: TRule); override;
        constructor Create(AOwner: TComponent); override;
        destructor Destroy; override;
    end;


    TfrmACLRulesEditorDlg = class(TForm)
        lbRuleSets: TListBox;
        Label1: TLabel;
        sbRolesAdd: TSpeedButton;
        sbResourceAdd: TSpeedButton;
        sbRolesDelete: TSpeedButton;
        edRulesetName: TEdit;
        sbAddRule: TSpeedButton;
        sbDeleteRule: TSpeedButton;
        sbRuleUp: TSpeedButton;
        sbRuleDown: TSpeedButton;
        ActionList1: TActionList;
        RuleSetAddCommand: TAction;
        RuleSetDeleteCommand: TAction;
        RuleSetUpCommand: TAction;
        RuleSetupDownCommand: TAction;
        RoleAddCommand: TAction;
        RoleDeleteCommand: TAction;
        ResourceAddCommand: TAction;
        ResourceDeleteCommand: TAction;
        sbDeleteResource: TSpeedButton;
        InsertRuleCommand: TAction;
        lbRoles: TLabel;
        lbResources: TLabel;
        Button1: TButton;
        Button2: TButton;
        procedure sbResourceAddClick(Sender: TObject);
        procedure FormCreate(Sender: TObject);
        procedure lbRuleSetsClick(Sender: TObject);
        procedure edRulesetNameChange(Sender: TObject);
        procedure RuleSetAddCommandExecute(Sender: TObject);
        procedure RuleSetAddCommandUpdate(Sender: TObject);
        procedure RuleSetDeleteCommandExecute(Sender: TObject);
        procedure RuleSetDeleteCommandUpdate(Sender: TObject);
        procedure RuleSetUpCommandExecute(Sender: TObject);
        procedure RuleSetupDownCommandExecute(Sender: TObject);
        procedure RoleAddCommandUpdate(Sender: TObject);
        procedure RoleAddCommandExecute(Sender: TObject);
        procedure RoleDeleteCommandUpdate(Sender: TObject);
        procedure RoleDeleteCommandExecute(Sender: TObject);
        procedure ResourceAddCommandUpdate(Sender: TObject);
        procedure ResourceDeleteCommandUpdate(Sender: TObject);
        procedure ResourceAddCommandExecute(Sender: TObject);
        procedure ResourceDeleteCommandExecute(Sender: TObject);
        procedure InsertRuleCommandUpdate(Sender: TObject);
        procedure InsertRuleCommandExecute(Sender: TObject);
        procedure FormShow(Sender: TObject);
    private
    { Private declarations }
    public
    { Public declarations }
        roles: TRulesPanel; //Top panel for roles
        resources: TRulesPanel; //Bottom panel for resources

        procedure createLayout; //Creates dialog layout
        procedure destroyLayout; //Destroys all created elements

        procedure addNewRuleset(newname: string = ''); //Adds a new ruleset
        procedure deleteSelectedRuleset; //Deletes the selected ruleset, if any

        procedure updateRulepanels; //Updates the rule panels at the right with the selected ruleset information

        function getRulesinArrayFormat: string;
    end;

    TACLRulesPropertyEditor = class(TD4PHPPropertyEditor)
    public
        function Execute(value: string; out newvalue: string): boolean; override;
        function getDisplayText: string; override;
        function getStyle: TD4PHPPropertyEditorStyles; override;
    end;

var
    frmACLRulesEditorDlg: TfrmACLRulesEditorDlg;
    selectedruleset: TRuleSet; //A reference to the selected ruleset

implementation

{$R *.dfm}

{ TfrmACLRulesEditorDlg }

procedure TfrmACLRulesEditorDlg.addNewRuleset(newname: string = '');
var
    i: integer;
    li: TRuleSet;
    s: string;
const
    basename = 'ACLRule';
begin
    //Iterates to create a new name for the new ruleset
    if (newname = '') then begin

        i := 1;
        while true do begin
            s := basename + inttostr(i);
            if (lbRuleSets.Items.IndexOf(s) = -1) then begin
                break;
            end;
            inc(i);
        end;
    end
    else s := newname;

    //Creates the rule set and updates layout
    li := TRuleSet.create;
    lbRuleSets.Items.AddObject(s, li);
    lbRuleSets.ItemIndex := lbRuleSets.count - 1;
    lbRuleSetsClick(lbRuleSets);
    if (newname = '') then begin
        if (edRulesetname.CanFocus) then begin
            edRulesetName.SetFocus;
        end;
        edRulesetName.SelectAll;
    end;
end;

procedure TfrmACLRulesEditorDlg.createLayout;
begin
    //Roles panel creation

    roles := TRolesPanel.Create(self);
    with roles do begin
        parent := self;
        left := lbRuleSets.left;
        top := lbRoles.Top + lbRoles.height + 5;
        anchors := [akLeft, akTop, akRight];
        height := (ruleHeight * 3) + 4;
    end;

    lbResources.top := roles.Top + roles.Height + 20;

    //Resources panel creation
    resources := TResourcesPanel.Create(self);
    with resources do begin
        parent := self;
        left := roles.left;
        top := lbResources.top + lbResources.height + 5;
        anchors := [akLeft, akTop, akRight, akBottom];
    end;
end;

procedure TfrmACLRulesEditorDlg.deleteSelectedRuleset;
var
    index: integer;
begin
    if (lbRuleSets.ItemIndex <> -1) then begin
        { TODO : Destroy the ruleset to destroy created objects }
        index := lbRuleSets.itemindex;
        lbRuleSets.Items.Delete(index);
        if (index <= lbRuleSets.items.count - 1) then lbRuleSets.ItemIndex := index
        else lbRuleSets.itemindex := lbRuleSets.Items.count - 1;
        lbRuleSetsClick(lbRuleSets);
    end;
end;

procedure TfrmACLRulesEditorDlg.destroyLayout;
begin
{ TODO : Destroy the layout properly }
end;

procedure TfrmACLRulesEditorDlg.edRulesetNameChange(Sender: TObject);
begin
    //Changes the text of the selected ruleset, if any
    if (lbRuleSets.itemindex <> -1) then lbRuleSets.Items[lbRuleSets.ItemIndex] := edRulesetName.Text;
end;

procedure TfrmACLRulesEditorDlg.FormCreate(Sender: TObject);
begin
    selectedruleset := nil;
    createLayout;
end;

procedure TfrmACLRulesEditorDlg.FormShow(Sender: TObject);
begin
    roles.bufferpanel.AutoSize := false;
    roles.bufferpanel.AutoSize := true;
    resources.bufferpanel.AutoSize := false;
    resources.bufferpanel.AutoSize := true;
end;

function TfrmACLRulesEditorDlg.getRulesinArrayFormat: string;
var
    i: integer;
    rules: TStringList;
    ruleset: TRuleSet;
    items: TStringList;
    srule: string;
    sitems: string;
    trule: TStringList;
    k: integer;
    ast: TStringList;
    roles: TStringList;
    sroles: string;
    resources: TStringList;
    sresources: string;
begin
// a:1:{i:0;a:1:{s:19:"My Rule Description";a:2:{s:5:"Roles";a:2:{i:0;a:3:{s:4:"type";s:4:"User";s:5:"value";s:4:"pepe";s:7:"parents";s:0:"";}i:1;a:3:{s:4:"type";s:4:"Role";s:5:"value";s:8:"managers";s:7:"parents";s:4:"pepe";}}s:9:"Resources";a:4:{i:0;a:6:{s:4:"type";s:4:"Page";s:6:"value1";s:9:"index.php";s:6:"value2";s:0:"";s:4:"perm";s:5:"Allow";s:5:"right";s:12:"show,execute";s:6:"parent";s:0:"";}i:1;a:6:{s:4:"type";s:6:"Action";s:6:"value1";s:9:"ActnList1";s:6:"value2";s:13:"view_invoices";s:4:"perm";s:4:"Deny";s:5:"right";s:7:"execute";s:6:"parent";s:0:"";}i:2;a:6:{s:4:"type";s:7:"Control";s:6:"value1";s:6:"Button";s:6:"value2";s:9:"btnReport";s:4:"perm";s:5:"Allow";s:5:"right";s:7:"execute";s:6:"parent";s:0:"";}i:3;a:6:{s:4:"type";s:6:"Custom";s:6:"value1";s:6:"custom";s:6:"value2";s:6:"custom";s:4:"perm";s:4:"Deny";s:5:"right";s:4:"show";s:6:"parent";s:0:"";}}}}}
//          a:1:{s:19:"My Rule Description";a:2:{s:5:"Roles";a:2:{i:0;a:2:{s:4:"type";s:4:"User";s:5:"value";s:4:"pepe";}                     i:1;a:2:{s:4:"type";s:4:"Role";s:5:"value";s:8:"managers";}}                         s:9:"Resources";a:4:{i:0;a:5:{s:4:"type";s:4:"Page";s:6:"value1";s:9:"index.php";s:6:"value2";s:0:"";s:5:"right";s:12:"show,execute";s:4:"perm";s:5:"Allow";}i:1;a:5:{s:4:"type";s:6:"Action";s:6:"value1";s:9:"ActnList1";s:6:"value2";s:13:"view_invoices";s:5:"right";s:7:"execute";s:4:"perm";s:4:"Deny";}i:2;a:5:{s:4:"type";s:7:"Control";s:6:"value1";s:6:"Button";s:6:"value2";s:9:"btnReport";s:5:"right";s:7:"execute";s:4:"perm";s:5:"Allow";}i:3;a:5:{s:4:"type";s:6:"Custom";s:6:"value1";s:6:"custom";s:6:"value2";s:6:"custom";s:5:"right";s:4:"show";s:4:"perm";s:4:"Deny";}}}}

//          a:1:{s:19:"My Rule Description";a:2:{s:5:"Roles";a:2:{i:0;a:2:{s:4:"type";s:4:"User";s:5:"value";s:4:"pepe";}i:1;a:2:{s:4:"type";s:4:"Role";s:5:"value";s:8:"managers";}}s:9:"Resources";s:3:"###";}}

//          a:1:{s:19:"My Rule Description";a:2:{s:5:"Roles";s:3:"@@@";s:9:"Resources";s:3:"###";}}

//          a:1:{s:19:"My Rule Description";s:54:"a:2:{s:5:"Roles";s:3:"@@@";s:9:"Resources";s:3:"###";}";}
    result := '';
    rules := TStringList.create;
    items := TStringList.create;
    trule := TStringList.create;
    roles := TStringList.create;
    resources := TStringList.create;
    try
        for i := 0 to lbRuleSets.items.count - 1 do begin
            ruleset := TRuleSet(lbRuleSets.items.objects[i]);

            roles.clear;
            for k := 0 to ruleset.roles.count - 1 do begin
                ast := ruleset.roles[k];
                ast[0] := 'type=' + ast[0];
                ast[1] := 'value=' + ast[1];
                roles.add(stringlisttoarray(ast));
            end;

            sroles := 'a:' + inttostr(roles.count) + ':{';
            for k := 0 to roles.count - 1 do begin
                sroles := sroles + 'i:' + inttostr(k) + ';' + roles[k];
            end;
            sroles := sroles + '}';

            resources.clear;
            for k := 0 to ruleset.resources.count - 1 do begin
                ast := ruleset.resources[k];
                ast[0] := 'type=' + ast[0];
                ast[1] := 'value1=' + ast[1];
                ast[2] := 'value2=' + ast[2];
                ast[3] := 'right=' + ast[3];
                ast[4] := 'perm=' + ast[4];
                resources.add(stringlisttoarray(ast));
            end;

            sresources := 'a:' + inttostr(resources.count) + ':{';
            for k := 0 to resources.count - 1 do begin
                sresources := sresources + 'i:' + inttostr(k) + ';' + resources[k];
            end;
            sresources := sresources + '}';

            items.clear;
            items.add('Roles=@@@');
            items.add('Resources=###');
            sitems := stringlisttoarray(items);
            sitems := stringreplace(sitems, 's:3:"@@@";', sroles, []);
            sitems := stringreplace(sitems, 's:3:"###";', sresources, []);

            trule.clear;
            trule.add(lbRuleSets.Items[i] + '=@@@');
            srule := stringlisttoarray(trule);
            srule := stringreplace(srule, 's:3:"@@@";', sitems, []);
            rules.add(srule);
        end;

        result := 'a:' + inttostr(rules.count) + ':{';
        for k := 0 to rules.count - 1 do begin
            result := result + 'i:' + inttostr(k) + ';' + rules[k];
        end;
        result := result + '}';
    finally
        resources.free;
        roles.free;
        trule.free;
        items.free;
        rules.free;
    end;
end;

procedure TfrmACLRulesEditorDlg.InsertRuleCommandExecute(Sender: TObject);
begin
    if (ActiveControl = roles) then roles.AddNewRule
    else if (activecontrol = resources) then resources.addnewrule;

end;

procedure TfrmACLRulesEditorDlg.InsertRuleCommandUpdate(Sender: TObject);
begin
    (sender as TAction).enabled := assigned(selectedruleset);
end;

procedure TfrmACLRulesEditorDlg.lbRuleSetsClick(Sender: TObject);
var
    alogicalrule: TRuleSet;
begin
    //Must change the selected ruleset and refresh the rule panels, only if the
    //selected ruleset has changed
    if (lbRuleSets.ItemIndex <> -1) then begin
        edRulesetName.Text := lbRuleSets.Items[lbRuleSets.ItemIndex];
        application.processmessages;
        alogicalrule := TRuleSet(lbRuleSets.Items.Objects[lbRuleSets.ItemIndex]);
        if (selectedruleset <> alogicalrule) then begin
            selectedruleset := alogicalrule;
            updateRulepanels;
        end;
    end
    else begin
        edRulesetName.text := '';
        selectedruleset := nil;
        updateRulepanels;
    end;
end;

procedure TfrmACLRulesEditorDlg.ResourceAddCommandExecute(Sender: TObject);
begin
    resources.AddNewRule;
end;

procedure TfrmACLRulesEditorDlg.ResourceAddCommandUpdate(Sender: TObject);
begin
    (sender as TAction).enabled := assigned(selectedruleset);
end;

procedure TfrmACLRulesEditorDlg.ResourceDeleteCommandExecute(Sender: TObject);
begin
    resources.DeleteSelectedRule;
end;

procedure TfrmACLRulesEditorDlg.ResourceDeleteCommandUpdate(Sender: TObject);
begin
    (sender as TAction).enabled := assigned(resources.SelectedRule);
end;

procedure TfrmACLRulesEditorDlg.RoleAddCommandExecute(Sender: TObject);
begin
    roles.AddNewRule;
end;

procedure TfrmACLRulesEditorDlg.RoleAddCommandUpdate(Sender: TObject);
begin
    (sender as TAction).enabled := assigned(selectedruleset);
end;

procedure TfrmACLRulesEditorDlg.RoleDeleteCommandExecute(Sender: TObject);
begin
    roles.DeleteSelectedRule;
end;

procedure TfrmACLRulesEditorDlg.RoleDeleteCommandUpdate(Sender: TObject);
begin
    (sender as TAction).enabled := assigned(roles.SelectedRule);
end;

procedure TfrmACLRulesEditorDlg.RuleSetAddCommandExecute(Sender: TObject);
begin
    addNewRuleset;
end;

procedure TfrmACLRulesEditorDlg.RuleSetAddCommandUpdate(Sender: TObject);
begin
    (sender as TAction).enabled := true;
end;

procedure TfrmACLRulesEditorDlg.RuleSetDeleteCommandExecute(Sender: TObject);
begin
    if (lbRuleSets.ItemIndex <> -1) then begin
        if (MessageDlg('Are you sure you want to delete this rule?', mtWarning, mbYesNo, 0) = mrYes) then begin
            deleteSelectedRuleset;
        end;
    end;
end;

procedure TfrmACLRulesEditorDlg.RuleSetDeleteCommandUpdate(Sender: TObject);
begin
    (sender as TAction).enabled := (lbRuleSets.itemindex <> -1);
end;

procedure TfrmACLRulesEditorDlg.RuleSetUpCommandExecute(Sender: TObject);
begin
    if (lbRuleSets.ItemIndex <> -1) then begin
        if (lbRuleSets.itemIndex > 0) then begin
            lbRuleSets.Items.Exchange(lbRuleSets.itemIndex, lbRuleSets.itemindex - 1);
        end;
    end;
end;

procedure TfrmACLRulesEditorDlg.RuleSetupDownCommandExecute(Sender: TObject);
begin
    if (lbRuleSets.ItemIndex <> -1) then begin
        if (lbRuleSets.itemIndex < lbRuleSets.items.count - 1) then begin
            lbRuleSets.Items.Exchange(lbRuleSets.itemIndex, lbRuleSets.itemindex + 1);
        end;
    end;
end;

procedure TfrmACLRulesEditorDlg.sbResourceAddClick(Sender: TObject);
begin
    resources.addNewRule;
end;

procedure TfrmACLRulesEditorDlg.updateRulepanels;
var
    i: integer;
    s: TStringList;
    arule: TRule;
begin
    if (assigned(selectedruleset)) then begin
        roles.beginupdate;
        roles.beginclear;
        try
            //Fills the roles panels with the ruleset roles
            for i := 0 to selectedruleset.roles.count - 1 do begin
                s := selectedruleset.roles[i];
                arule := roles.AddNewRule(s);
                arule.setlist := selectedruleset.roles;
            end;
        finally
            roles.endclear;
            roles.endupdate;
        end;

        resources.beginupdate;
        resources.beginclear;
        try
            //Fills the resources panels with the ruleset resources
            for i := 0 to selectedruleset.resources.count - 1 do begin
                s := selectedruleset.resources[i];
                arule := resources.AddNewRule(s);
                arule.setlist := selectedruleset.resources;
            end;
        finally
            resources.endclear;
            resources.endupdate;
        end;
    end
    else begin
        roles.beginclear;
        roles.endclear;
        resources.beginclear;
        resources.endclear;
    end;

end;


{ TRulesPanel }

procedure TRulesPanel.AddControlsToRule(rule: TRule);
var
    i: integer;
    lb: TLabel;
    cb: TComboBox;
begin
    rule.labels.clear;
    rule.combos.clear;

    //Depending on how many columns we need
    for I := 0 to FColumnCount - 1 do begin
        //Creates all labels
        lb := TLabel.create(rule);
        with lb do begin
            left := 8 + (170 * i);
            top := 8;
            parent := rule;
            OnClick := rule.OnClick; //To allow select this rule when clicking on the label
        end;
        rule.labels.add(lb);

        //Creates all combos
        cb := TComboBox.create(rule);
        with cb do begin
            left := 60 + (170 * i);
            top := 4;
            parent := rule;
            width := 110;
            OnEnter := rule.OnClick; //To allow select this rule when entering on the combo
            OnExit := OnCombosExit;
            OnChange := OnCombosChange; //When the value of the combo changes, update the values of the ruleset
        end;
        rule.combos.add(cb);
    end;
end;

function TRulesPanel.AddNewRule: TRule;
begin
    bufferpanel.parent := self;
    //Creates the new rule panel
    result := TRule.create(self);
    with result do begin
        visible := false;
        ParentBackground := false;
        bufferpanel.AutoSize := false; //Autosize to false, to allow place the rule below
        try
            top := bufferpanel.ControlCount * ruleHeight + 10;
            height := ruleHeight;
            Align := alTop;
            Parent := bufferpanel;
        finally
            bufferpanel.AutoSize := true; //The buffer panel now resizes itself
        end;
        onclick := OnSelectRule; //Clicking on the rule, will select it
    end;
    AddControlsToRule(result); //Now provide an oportunity for the child classes to customize the rule layout
    selectedrule := result;
    result.visible := true;
    //Scrolls this rule inside the panel
    if (not inupdate) then begin
        if (result.canfocus) then begin
            result.setfocus;
        end;
    end;
end;

function TRulesPanel.AddNewRule(values: TStringList): TRule;
var
    i: integer;
    cb: TComboBox;
begin
    //It creates a rule
    result := addNewRule;
    result.values := values;

    updateRuleCombos(result);

    (**
    //Set the combos to the right values
    for i := 0 to values.count - 1 do begin
        cb := result.combos[i];
        cb.Text := values[i];

        //If combos are non editable, select the right item
        if (cb.text <> values[i]) then begin
            cb.ItemIndex := cb.Items.indexof(values[i]);
        end;
    end;

    //The first combo will change the layout of the rule
    cb := result.combos[0];
    if (cb.itemindex <> 0) then OnTypeComboChange(cb);
    **)

end;

procedure TRulesPanel.beginclear;
begin
    selectedrule := nil;
    oldbufferpanel := bufferpanel;
    oldbufferpanel.sendtoback;
    createBufferPanel;
end;

procedure TRulesPanel.beginupdate;
begin
    inupdate := true;
end;

constructor TRulesPanel.Create(AOwner: TComponent);
begin
    inherited;
    loading := false;
    createBufferPanel;
    inupdate := false;
    VertScrollBar.Increment := ruleHeight;
    FSelectedRule := nil;
    FColumnCount := 2;
    width := 850;
    height := (ruleHeight * 6) + 4;
    BevelOuter := bvLowered;
    tabstop := true;
end;

procedure TRulesPanel.createBufferPanel;
begin
    bufferpanel := TPanel.create(self);
    bufferpanel.Height := 0;
    bufferpanel.width := 0;
    bufferpanel.align := alTop;
    bufferpanel.AutoSize := true;
    bufferpanel.BevelOuter := bvNone;
    if (inupdate) then bufferpanel.visible := false;

end;

procedure TRulesPanel.DeleteSelectedRule;
var
    nextrule: TRule;
begin
    if (assigned(FSelectedRule)) then begin
        //First check for the rule to select after delete this one
        nextrule := TRule(bufferpanel.ControlAtPos(Point(FSelectedRule.left + 2, FSelectedRule.BoundsRect.bottom + 2), false, true));
        if (not assigned(nextrule)) then nextrule := TRule(bufferpanel.ControlAtPos(Point(FSelectedRule.left + 2, FSelectedRule.top - 2), false, true));


        if (assigned(FSelectedRule.setlist)) then begin
            FSelectedRule.setlist.Remove(FSelectedRule.values);
        end;

        FreeAndNil(FSelectedRule);

        //If any, gets selected
        if (assigned(nextrule)) then begin
            SelectedRule := nextrule;
        end;
    end;
end;

destructor TRulesPanel.Destroy;
begin
    bufferpanel.free;
    inherited;
end;

procedure TRulesPanel.endclear;
begin
    oldbufferpanel.free;
end;

procedure TRulesPanel.endupdate;
begin
    inupdate := false;
    bufferpanel.visible := true;
end;

procedure TRulesPanel.OnCombosChange(sender: TObject);
begin
    updatevalues;
end;

procedure TRulesPanel.OnSelectRule(sender: TObject);
begin
    if (sender is TRule) then begin
        SelectedRule := (sender as TRule);
        if (selectedrule.canfocus) then SelectedRule.setfocus;
    end
    else begin
        SelectedRule := TRule((sender as TControl).parent);
        if (sender is TLabel) then begin
            if (selectedrule.canfocus) then SelectedRule.setfocus;
        end;
    end;
end;

procedure TRulesPanel.SetColumnCount(const Value: integer);
begin
    FColumnCount := Value;
end;

procedure TRulesPanel.SetSelectedRule(const Value: TRule);
begin
    if (value <> FSelectedRule) then begin
        if (FSelectedRule <> nil) and (not inupdate) then begin
            FSelectedRule.selected := false;
        end;
        FSelectedRule := Value;
        if (FSelectedRule <> nil) and (not inupdate) then begin
            FSelectedRule.selected := true;
        end;
    end;
end;

procedure TRulesPanel.updateRuleCombos(rule: TRule);
var
    i: integer;
    cb: TComboBox;
begin
    with rule do begin
    //Set the combos to the right values
        for i := 0 to values.count - 1 do begin
            cb := combos[i];
            cb.Text := values[i];

        //If combos are non editable, select the right item
            if (cb.text <> values[i]) then begin
                cb.ItemIndex := cb.Items.indexof(values[i]);
            end;
        end;

    //The first combo will change the layout of the rule
        cb := combos[0];
        if (cb.itemindex <> 0) then OnTypeComboChange(cb);
    end;
end;

procedure TRulesPanel.updatevalues;
var
    i: integer;
    cb: TComboBox;
begin
    if (assigned(FSelectedRule)) then begin
        with FSelectedRule do begin
            for i := 0 to FColumnCount - 1 do begin
                cb := combos[i];
                values[i] := cb.Text;
            end;
        end;
    end;
end;

{ TResourcesPanel }

procedure TResourcesPanel.AddControlsToRule(rule: TRule);
var
    lb: TLabel;
    cb: TComboBox;
begin
    inherited;
    with rule do begin
        lb := labels[0];
        lb.caption := 'Type:';

        cb := combos[0];
        cb.Style := csDropDownList;
        cb.OnChange := OnTypeComboChange;
        cb.items.BeginUpdate;
        try
            cb.Items.add('Page');
            cb.Items.add('Action');
            cb.Items.add('Control');
            cb.Items.add('Custom');
            cb.ItemIndex := 0;
        finally
            cb.items.endupdate;
        end;

        lb := labels[1];
        lb.caption := 'Page:';

        lb := labels[2];
        lb.caption := '';

        cb := combos[1];
        cb.Items.Assign(availablepages);

        cb := combos[2];
        cb.visible := false;

        lb := labels[3];
        lb.caption := 'Right:';

        cb := combos[3];
        cb.width := 80;
//        cb.Style := csDropDownList;
        cb.items.BeginUpdate;
        try
            cb.Items.add('Show');
            cb.Items.add('Execute');
            cb.ItemIndex := 0;
        finally
            cb.items.endupdate;
        end;

        lb := labels[4];
        lb.left := lb.left - 10;
        lb.caption := 'Permission:';

        cb := combos[4];
        cb.width := 80;
        cb.Style := csDropDownList;
        cb.items.BeginUpdate;
        try
            cb.Items.add('Deny');
            cb.Items.add('Allow');
            cb.ItemIndex := 0;
        finally
            cb.items.endupdate;
        end;

        if (not inupdate) or (loading) then begin
            selectedruleset.addNewResource('Page', '', '', 'Show', 'Deny');
            values := selectedruleset.resources.last;
            setlist := selectedruleset.resources;
        end;
    end;

end;

{ TRoles }

procedure TRolesPanel.AddControlsToRule(rule: TRule);
var
    lb: TLabel;
    cb: TComboBox;
    cb1: TComboBox;
begin
    inherited;

    with rule do begin
        lb := labels[0];
        lb.caption := 'Type:';

        cb := combos[0];
        cb.Style := csDropDownList;
        cb.OnChange := OnTypeComboChange;
        cb.items.BeginUpdate;
        try
            cb.items.add('Role');
            cb.items.add('User');
            cb.ItemIndex := 0;
        finally
            cb.items.endupdate;
        end;

        cb1 := combos[1];
        cb1.items.BeginUpdate;
        try
            cb1.items.assign(availableroles);
        finally
            cb1.items.endupdate;
        end;

        lb := labels[1];
        lb.caption := 'Entity:';
        if (not inupdate) or (loading) then begin
            selectedruleset.addNewRole(cb.Text, '');
            values := selectedruleset.roles.Last;
            setlist := selectedruleset.roles;
        end;
    end;
end;

constructor TResourcesPanel.Create(AOwner: TComponent);
var
    i: integer;
begin
    inherited;
    FColumnCount := 5;
    availablepages := TStringList.create;
    GetProjectFilenames(availablepages);
    for i := 0 to availablepages.count - 1 do begin
        availablepages[i] := extractfilename(availablepages[i]);
    end;
    availablepages.sorted := true;

    availableactions := TStringList.create;
    availableactions.sorted := true;
    GetComponents('ActionList',availableactions);

    actionsforaction := TStringList.create;
    actionsforaction.sorted := false;

    availablecontrols := TStringList.create;
    availablecontrols.sorted := true;
    GetRegisteredComponents(availablecontrols);

    controlsforcontrol := TStringList.create;
    controlsforcontrol.sorted := false;
end;

destructor TResourcesPanel.Destroy;
begin
    availablepages.free;
    availableactions.free;
    availablecontrols.free;
    inherited;
end;

procedure TResourcesPanel.OnCombosChange(sender: TObject);
var
    cb: TComboBox;
    index: integer;
    list: TStringList;
    i: integer;
    c: TControl;
    rule: TRule;
    actioname: string;
    cname: string;
begin
    inherited;
    rule := ((sender as TComboBox).parent as TRule);
    if (assigned(rule)) then begin
        //Changing value for second combo
        cb := rule.combos[1];
        if (cb = sender) then begin
            cb := rule.combos[0];
          //When first combo is actionlist
            if (cb.itemindex = 1) then begin
                actioname := (sender as TComboBox).text;
                cb := rule.combos[2];
                cb.items.beginupdate;
                try
                    cb.items.clear;
                    //Add to the third combo actions for the actions specified in second combo
                    for i := 0 to actionsforaction.count - 1 do begin
                        if (actionsforaction.Names[i] = actioname) then begin
                            cb.items.add(actionsforaction.ValueFromIndex[i]);
                        end;
                    end;
                finally
                    cb.items.endupdate;
                end;
            end;

          //When first combo is controls
            if (cb.itemindex = 2) then begin
                cname := (sender as TComboBox).text;
                cb := rule.combos[2];
                cb.items.beginupdate;
                try
                    cb.items.clear;
                    //Add to the third combo controls for the class specified in second combo
                    controlsforcontrol.clear;
                    GetComponents(cname, controlsforcontrol);
                    cb.items.assign(controlsforcontrol);
                    (*
                    for i := 0 to controlsforcontrol.count - 1 do begin
                        if (controlsforcontrol.Names[i] = cname) then begin
                            cb.items.add(controlsforcontrol.ValueFromIndex[i]);
                        end;
                    end;
                    *)
                finally
                    cb.items.endupdate;
                end;
            end;
        end;
    end;
end;

procedure TResourcesPanel.OnCombosExit(sender: TObject);
var
    cb: TComboBox;
    index: integer;
    list: TStringList;
    i: integer;
    c: TControl;
    rule: TRule;
begin
    rule := ((sender as TComboBox).parent as TRule);
    if (assigned(rule)) then begin
        cb := rule.combos[1];
        if (cb = sender) then begin
            cb := rule.combos[0];
            index := cb.itemindex;

            //Depending on the type of rule
            list := nil;
            if (index = 0) then list := availablepages
            else if (index = 1) then list := availableactions
            else if (index = 2) then list := availablecontrols;

            //Adds the entry to the right list
            if (assigned(list)) then begin

                cb := (sender as TComboBox);
                if (cb.text <> '') then begin
                    if (list.indexof(cb.text) = -1) then begin
                        list.Add(cb.text);
                    //And refreshes combos
                        for i := 0 to bufferpanel.controlcount - 1 do begin
                            c := bufferpanel.controls[i];
                            if (c is TRule) then updateCombos((c as TRule), index);
                        end;
                    end;
                end;
            end;
        end;
    end;
end;

procedure TResourcesPanel.OnTypeComboChange(Sender: TObject);
begin
    //Depending on the type, change the layout
    case (sender as TComboBox).ItemIndex of
      //Page
        0: setupPageLayout;

      //Action
        1: setupActionLayout;

      //Control
        2: setupControlLayout;
      //Control
        3: setupCustomLayout;
    end;

    //Update values for the ruleset
    updatevalues;

    //Update combos according to the layout
    updateCombos(FSelectedRule);
end;

procedure TResourcesPanel.setupActionLayout;
var
    lb: TLabel;
    cb: TComboBox;
begin
    if (assigned(FSelectedRule)) then begin
        with FSelectedRule do begin
            lb := labels[1];
            lb.caption := 'ActionList:';

            lb := labels[2];
            lb.caption := 'Actions:';

            cb := combos[1];
            cb.Items.Assign(availableactions);

            OnCombosChange(cb);

            cb := combos[2];
            cb.visible := true;
        end;
    end;
end;

procedure TResourcesPanel.setupControlLayout;
var
    lb: TLabel;
    cb: TComboBox;
begin
    if (assigned(FSelectedRule)) then begin
        with FSelectedRule do begin
            lb := labels[1];
            lb.caption := 'Class:';

            lb := labels[2];
            lb.caption := 'Name:';

            cb := combos[1];
            cb.Items.Assign(availablecontrols);

            OnCombosChange(cb);

            cb := combos[2];
            cb.visible := true;
        end;
    end;
end;

procedure TResourcesPanel.setupCustomLayout;
var
    lb: TLabel;
    cb: TComboBox;
begin
    if (assigned(FSelectedRule)) then begin
        with FSelectedRule do begin
            lb := labels[1];
            lb.caption := 'Value1:';

            lb := labels[2];
            lb.caption := 'Value2:';

            cb := combos[2];
            cb.visible := true;
        end;
    end;
end;

procedure TResourcesPanel.setupPageLayout;
var
    lb: TLabel;
    cb: TComboBox;
begin
    if (assigned(FSelectedRule)) then begin
        with FSelectedRule do begin
            lb := labels[1];
            lb.caption := 'Page:';

            lb := labels[2];
            lb.caption := '';

            cb := combos[1];
            cb.Items.Assign(availablepages);

            cb := combos[2];
            cb.visible := false;
        end;
    end;
end;

procedure TResourcesPanel.updateCombos(rule: TRule; forceindex: integer);
var
    cb: TComboBox;
    acb: TComboBox;
begin
    if (assigned(rule)) then begin
        cb := rule.combos[0];
        if (forceindex <> -1) then begin
            if (cb.itemindex <> forceindex) then exit;
        end;

        //Assigns the right list to the second combo depending on the selection of the first combo
        acb := rule.combos[1];
        acb.items.beginupdate;
        try
            case cb.itemindex of
                0: acb.items.assign(availablepages);
                1: acb.items.assign(availableactions);
                2: acb.items.assign(availablecontrols);
            end;
        finally
            acb.items.endupdate;
        end;
    end;
end;

{ TRule }

procedure TRule.CNKeyDown(var Message: TWMKeyDown);
begin
    //Select the right rule depending on keystroke
    if (message.CharCode = VK_DOWN) then begin
        message.Result := 1;
        selectDownRule;
    end
    else if (message.CharCode = VK_UP) then begin
        message.Result := 1;
        selectUpRule;
    end
    else message.result := 0;
end;

constructor TRule.Create(AOwner: TComponent);
begin
    inherited;
    labels := TList.create;
    combos := TList.create;
    FSelected := false;
end;

destructor TRule.Destroy;
begin
    labels.free;
    combos.free;
    inherited;
end;

procedure TRule.selectDownRule;
var
    rule: TRule;
begin
    rule := TRule(parent.ControlAtPos(Point(left, boundsrect.bottom + 5), false, true));

    if (assigned(rule)) then begin
        (parent.parent as TRulesPanel).SelectedRule := rule;
        if (rule.canfocus) then rule.setfocus;
    end;
end;

procedure TRule.selectUpRule;
var
    rule: TRule;
begin
    rule := TRule(parent.ControlAtPos(Point(left, top - 5), false, true));

    if (assigned(rule)) then begin
        (parent.parent as TRulesPanel).SelectedRule := rule;
        if (rule.canfocus) then rule.setfocus;
    end;
end;

procedure TRule.SetSelected(const Value: boolean);
var
    i: integer;
    c: TControl;
begin
    if (FSelected <> Value) then begin
        FSelected := Value;
        if (FSelected) then color := clActiveCaption
        else Color := clBtnFace;

        //Change label text when selected, to be more readable
        for i := 0 to controlCount - 1 do begin
            c := controls[i];
            if (c is TLabel) then begin
                if (FSelected) then (c as TLabel).font.color := clHighlightText
                else (c as TLabel).font.color := clWindowText;
            end;
        end;
    end;
end;

constructor TRolesPanel.Create(AOwner: TComponent);
begin
    inherited;
    availableroles := TStringList.create;
    availableusers := TStringList.create;
    availableroles.Sorted := true;
    availableusers := TStringList.create;
    availableusers.Sorted := true;
end;

destructor TRolesPanel.Destroy;
begin
    availableroles.free;
    availableusers.free;
    inherited;
end;

procedure TRolesPanel.OnCombosExit(sender: TObject);
var
    cb: TComboBox;
    index: integer;
    list: TStringList;
    i: integer;
    c: TControl;
    rule: TRule;
begin
    rule := ((sender as TComboBox).parent as TRule);
    if (assigned(rule)) then begin
        //Get second combo
        cb := rule.combos[1];
        //If the user is existing from it
        if (cb = sender) then begin
            cb := rule.combos[0];
            index := cb.itemindex;

            //Select the list to which add a new entry
            if (index = 0) then list := availableroles
            else list := availableusers;

            //If there is a valid new one
            cb := (sender as TComboBox);
            if (cb.text <> '') then begin
                if (list.indexof(cb.text) = -1) then begin
                    list.Add(cb.text);

                    //It refreshes all rules combos where appropiate
                    for i := 0 to bufferpanel.controlcount - 1 do begin
                        c := bufferpanel.controls[i];
                        if (c is TRule) then updateCombos((c as TRule), index);
                    end;

                end;
            end;
        end;
    end;
end;

procedure TRolesPanel.OnTypeComboChange(Sender: TObject);
begin
    //Update ruleset values
    updatevalues;

    //Update combos accordingly
    updatecombos(FSelectedRule);
end;

procedure TRolesPanel.updateCombos(rule: TRule; forceindex: integer = -1);
var
    cb: TComboBox;
    acb: TComboBox;
begin
    cb := rule.combos[0];

    //If the first combo doesn't match with the forced index, exit
    if (forceindex <> -1) then begin
        if (cb.itemindex <> forceindex) then exit;
    end;

    //Get second combo
    acb := rule.combos[1];
    acb.items.beginupdate;
    try
        //Assigns the right list to the combo depending on the selection of the first combo
        case cb.itemindex of
            0: acb.items.assign(availableroles);
            1: acb.items.assign(availableusers);
        end;
    finally
        acb.items.endupdate;
    end;
end;

{ TRuleSet }

procedure TRuleSet.addNewResource(const a1, a2, a3, a4, a5: string);
var
    sl: TStringList;
begin
    sl := TStringList.create;
    sl.add(a1);
    sl.add(a2);
    sl.add(a3);
    sl.add(a4);
    sl.add(a5);
    resources.add(sl);
end;

procedure TRuleSet.addNewRole(const atype, aname: string);
var
    sl: TStringList;
begin
    sl := TStringList.create;
    sl.add(atype);
    sl.add(aname);
    roles.add(sl);
end;

constructor TRuleSet.Create;
begin
    roles := TList.create;
    resources := TList.create;
end;

destructor TRuleSet.Destroy;
begin
    roles.free;
    resources.free;
    inherited;
end;

{ TACLRulesPropertyEditor }

function TACLRulesPropertyEditor.Execute(value: string; out newvalue: string): boolean;
var
    strings: TStringList;
    i: integer;
    k: integer;
    rule: TStringList;
    ser: string;
    key: string;
    avalue: string;
    pieces: TStringList;
    sroles: string;
    sresources: string;
    lroles: TStringList;
    lresources: TStringList;
    r: integer;
    kvalues: TStringList;
    lvalues: TStringList;
begin
    result := false;
    newvalue := value;
    with TfrmACLRulesEditorDlg.Create(nil) do begin
        strings := TStringList.create;
        try
            arraytostringlist(value, strings);
            for i := 0 to strings.count - 1 do begin
                ser := strings.ValueFromIndex[i];
                rule := TStringList.create;
                try
                    arraytostringlist(ser, rule);
                    for k := 0 to rule.count - 1 do begin
                        key := rule.Names[k];
                        addNewRuleset(key);
                        avalue := rule.ValueFromIndex[k];
                        pieces := TStringList.create;
                        try
                            arraytostringlist(avalue, pieces);
                            //**** ROLES POPULATION
                            sroles := pieces.Values['Roles'];
                            lroles := TStringList.create;
                            roles.beginupdate;
                            roles.loading := true;
                            try
                                arraytostringlist(sroles, lroles);
                                for r := 0 to lroles.count - 1 do begin
                                    kvalues := TStringList.create;
                                    lvalues := TStringList.create;
                                    try
                                        arraytostringlist(lroles.ValueFromIndex[r], kvalues);
                                        lvalues.add(kvalues.Values['type']);
                                        lvalues.add(kvalues.Values['value']);
                                        roles.SelectedRule := roles.AddNewRule;
                                        roles.selectedrule.values.assign(lvalues);
                                        roles.updateRuleCombos(roles.selectedrule);
                                    finally
                                        lvalues.free;
                                        kvalues.free;
                                    end;
                                end;
                            finally
                                roles.loading := false;
                                roles.endupdate;
                                lroles.free;
                            end;
                            //**** RESOURCES POPULATION
                            sresources := pieces.Values['Resources'];
                            lresources := TStringList.create;
                            resources.beginupdate;
                            resources.loading := true;
                            try
                                arraytostringlist(sresources, lresources);
                                for r := 0 to lresources.count - 1 do begin
                                    kvalues := TStringList.create;
                                    lvalues := TStringList.create;
                                    try
                                        arraytostringlist(lresources.ValueFromIndex[r], kvalues);
                                        lvalues.add(kvalues.Values['type']);
                                        lvalues.add(kvalues.Values['value1']);
                                        lvalues.add(kvalues.Values['value2']);
                                        lvalues.add(kvalues.Values['right']);
                                        lvalues.add(kvalues.Values['perm']);
                                        resources.SelectedRule := resources.AddNewRule;
                                        resources.selectedrule.values.assign(lvalues);
                                        resources.updateRuleCombos(resources.selectedrule);
                                    finally
                                        lvalues.free;
                                        kvalues.free;
                                    end;
                                end;
                            finally
                                resources.loading := false;
                                resources.endupdate;
                                lresources.free;
                            end;

                        finally
                            pieces.free;
                        end;
                    end;
                finally
                    rule.free;
                end;
            end;
            if showmodal = mrOk then begin
                newvalue := getrulesinarrayformat;
                result := true;
            end;
        finally
            strings.free;
            free;
        end;
    end;
end;

function TACLRulesPropertyEditor.getDisplayText: string;
begin
    result := '(array)';
end;

function TACLRulesPropertyEditor.getStyle: TD4PHPPropertyEditorStyles;
begin
    result := [];
end;

initialization
    registerPropertyEditor('ZACL', 'Rules', TACLRulesPropertyEditor);

end.

