object frmACLRulesEditorDlg: TfrmACLRulesEditorDlg
  Left = 0
  Top = 0
  BorderStyle = bsDialog
  Caption = 'ACL Rules Editor'
  ClientHeight = 516
  ClientWidth = 898
  Color = clBtnFace
  Constraints.MinHeight = 504
  Constraints.MinWidth = 800
  Font.Charset = DEFAULT_CHARSET
  Font.Color = clWindowText
  Font.Height = -11
  Font.Name = 'Tahoma'
  Font.Style = []
  OldCreateOrder = False
  Position = poScreenCenter
  ShowHint = True
  OnCreate = FormCreate
  OnShow = FormShow
  DesignSize = (
    898
    516)
  PixelsPerInch = 96
  TextHeight = 13
  object Label1: TLabel
    Left = 8
    Top = 8
    Width = 149
    Height = 13
    Caption = 'Enter a name for your rule set:'
  end
  object sbRolesAdd: TSpeedButton
    Left = 867
    Top = 156
    Width = 23
    Height = 22
    Action = RoleAddCommand
    Anchors = [akTop, akRight]
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -11
    Font.Name = 'Tahoma'
    Font.Style = [fsBold]
    ParentFont = False
    ExplicitLeft = 865
  end
  object sbResourceAdd: TSpeedButton
    Left = 867
    Top = 295
    Width = 23
    Height = 22
    Action = ResourceAddCommand
    Anchors = [akTop, akRight]
  end
  object sbRolesDelete: TSpeedButton
    Left = 867
    Top = 184
    Width = 23
    Height = 22
    Action = RoleDeleteCommand
    Anchors = [akTop, akRight]
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -11
    Font.Name = 'Tahoma'
    Font.Style = [fsBold]
    ParentFont = False
    ExplicitLeft = 865
  end
  object sbAddRule: TSpeedButton
    Left = 864
    Top = 27
    Width = 23
    Height = 22
    Action = RuleSetAddCommand
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -11
    Font.Name = 'Tahoma'
    Font.Style = [fsBold]
    ParentFont = False
  end
  object sbDeleteRule: TSpeedButton
    Left = 864
    Top = 55
    Width = 23
    Height = 22
    Action = RuleSetDeleteCommand
    Font.Charset = DEFAULT_CHARSET
    Font.Color = clWindowText
    Font.Height = -11
    Font.Name = 'Tahoma'
    Font.Style = [fsBold]
    ParentFont = False
  end
  object sbRuleUp: TSpeedButton
    Left = 864
    Top = 83
    Width = 23
    Height = 22
    Action = RuleSetUpCommand
    Glyph.Data = {
      2E020000424D2E0200000000000036000000280000000C0000000E0000000100
      180000000000F8010000120B0000120B00000000000000000000FF00FFFF00FF
      FF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00
      FFFF00FFFF00FFFF00FF808080808080808080808080808080FF00FFFF00FFFF
      00FFFF00FFFF00FFFF00FFBF0000BF0000BF0000BF0000BF0000808080FF00FF
      FF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF0000BF00008080
      80FF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF0000BF
      0000808080FF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000
      FF0000BF0000808080FF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF00
      00FF0000FF0000BF0000808080FF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF
      0000FF0000FF0000FF0000BF0000808080808080808080FF00FFFF00FFFF0000
      FF0000FF0000FF0000FF0000FF0000FF0000FF0000FF0000FF00FFFF00FFFF00
      FFFF00FFFF0000FF0000FF0000FF0000FF0000FF0000FF0000FF00FFFF00FFFF
      00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF0000FF0000FF00FFFF00FF
      FF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF00FFFF00
      FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF00FFFF
      00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FF
      FF00FFFF00FFFF00FFFF00FFFF00FFFF00FF}
  end
  object sbRuleDown: TSpeedButton
    Left = 864
    Top = 107
    Width = 23
    Height = 22
    Action = RuleSetupDownCommand
    Glyph.Data = {
      2E020000424D2E0200000000000036000000280000000C0000000E0000000100
      180000000000F8010000120B0000120B00000000000000000000FF00FFFF00FF
      FF00FFFF00FFFF00FFFF00FF808080FF00FFFF00FFFF00FFFF00FFFF00FFFF00
      FFFF00FFFF00FFFF00FFFF00FFBF0000808080808080FF00FFFF00FFFF00FFFF
      00FFFF00FFFF00FFFF00FFFF00FFFF0000FF0000BF0000808080808080FF00FF
      FF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF0000BF00008080
      80808080FF00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF0000FF0000FF
      0000BF0000808080808080FF00FFFF00FFFF0000FF0000FF0000FF0000FF0000
      FF0000BF0000BF0000BF0000FF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF00
      00FF0000FF0000BF0000808080FF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF
      0000FF0000FF0000FF0000BF0000808080FF00FFFF00FFFF00FFFF00FFFF00FF
      FF00FFFF0000FF0000FF0000FF0000BF0000808080FF00FFFF00FFFF00FFFF00
      FFFF00FFFF00FFFF0000FF0000FF0000FF0000BF0000808080FF00FFFF00FFFF
      00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF0000BF0000808080FF00FF
      FF00FFFF00FFFF00FFFF00FFFF00FFFF0000FF0000FF0000FF0000BF0000FF00
      FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF
      00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FFFF00FF
      FF00FFFF00FFFF00FFFF00FFFF00FFFF00FF}
  end
  object sbDeleteResource: TSpeedButton
    Left = 867
    Top = 323
    Width = 23
    Height = 22
    Action = ResourceDeleteCommand
    Anchors = [akTop, akRight]
  end
  object lbRoles: TLabel
    Left = 8
    Top = 136
    Width = 30
    Height = 13
    Caption = 'Roles:'
  end
  object lbResources: TLabel
    Left = 8
    Top = 288
    Width = 54
    Height = 13
    Caption = 'Resources:'
  end
  object lbRuleSets: TListBox
    Left = 8
    Top = 54
    Width = 850
    Height = 81
    Anchors = [akLeft, akTop, akBottom]
    ItemHeight = 13
    TabOrder = 0
    OnClick = lbRuleSetsClick
  end
  object edRulesetName: TEdit
    Left = 8
    Top = 27
    Width = 850
    Height = 21
    TabOrder = 1
    OnChange = edRulesetNameChange
  end
  object Button1: TButton
    Left = 704
    Top = 480
    Width = 75
    Height = 25
    Caption = 'OK'
    Default = True
    ModalResult = 1
    TabOrder = 2
  end
  object Button2: TButton
    Left = 792
    Top = 480
    Width = 75
    Height = 25
    Cancel = True
    Caption = 'Cancel'
    ModalResult = 2
    TabOrder = 3
  end
  object ActionList1: TActionList
    Left = 288
    Top = 320
    object RuleSetAddCommand: TAction
      Category = 'Ruleset'
      Caption = '+'
      Hint = 'Adds a new rule set'
      ShortCut = 16462
      OnExecute = RuleSetAddCommandExecute
      OnUpdate = RuleSetAddCommandUpdate
    end
    object RuleSetDeleteCommand: TAction
      Category = 'Ruleset'
      Caption = '-'
      Hint = 'Delete selected rule set'
      ShortCut = 16430
      OnExecute = RuleSetDeleteCommandExecute
      OnUpdate = RuleSetDeleteCommandUpdate
    end
    object RuleSetUpCommand: TAction
      Category = 'Ruleset'
      Hint = 'Moves up the selected rule set'
      ShortCut = 16422
      OnExecute = RuleSetUpCommandExecute
      OnUpdate = RuleSetDeleteCommandUpdate
    end
    object RuleSetupDownCommand: TAction
      Category = 'Ruleset'
      Hint = 'Moves down the selected rule set'
      ShortCut = 16424
      OnExecute = RuleSetupDownCommandExecute
      OnUpdate = RuleSetDeleteCommandUpdate
    end
    object RoleAddCommand: TAction
      Category = 'Role'
      Caption = '+'
      Hint = 'Adds a new role'
      OnExecute = RoleAddCommandExecute
      OnUpdate = RoleAddCommandUpdate
    end
    object RoleDeleteCommand: TAction
      Category = 'Role'
      Caption = '-'
      Hint = 'Deletes selected role'
      OnExecute = RoleDeleteCommandExecute
      OnUpdate = RoleDeleteCommandUpdate
    end
    object ResourceAddCommand: TAction
      Category = 'Resource'
      Caption = '+'
      Hint = 'Adds a new resource'
      OnExecute = ResourceAddCommandExecute
      OnUpdate = ResourceAddCommandUpdate
    end
    object ResourceDeleteCommand: TAction
      Category = 'Resource'
      Caption = '-'
      Hint = 'Deletes selected resource'
      OnExecute = ResourceDeleteCommandExecute
      OnUpdate = ResourceDeleteCommandUpdate
    end
    object InsertRuleCommand: TAction
      Caption = 'InsertRuleCommand'
      ShortCut = 45
      OnExecute = InsertRuleCommandExecute
      OnUpdate = InsertRuleCommandUpdate
    end
  end
end
