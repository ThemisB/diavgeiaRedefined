<?php
/**
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
*/

use_unit("grids.inc.php");
use_unit("comctrls.inc.php");

/**
 * Base class for DBGrid.
 *
 * DBGrid displays and manipulates records from a dataset in a tabular grid.
 *
 * Put a DBGrid object on a form to display and edit the records from a database
 * table or query. Applications can use the data grid to insert, delete, or edit
 * data in the database, or simply to display it.
 *
 * At runtime, users can use the database paginator (DBPaginator) to move through
 * data in the grid, and to insert, delete, and edit the data. Edits that are made
 * in the data grid are not posted to the underlying dataset until the user moves
 * to a different record or closes the application.
 *
 */
class CustomDBGrid extends CustomGrid
{
        protected $_database;
        protected $_deletelink='';

        /**
        * If true, each record will show a delete link to allow the user delete that record
        *
        * @return boolean
        */
        function getDeleteLink() { return $this->_deletelink; }
        function setDeleteLink($value) { $this->_deletelink=$value; }
        function defaultDeleteLink() { return ""; }

        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=400;
                $this->Height=200;
        }
}

/**
 * DBGrid displays and manipulates records from a dataset in a tabular grid.
 *
 * Put a DBGrid object on a form to display and edit the records from a database
 * table or query. Applications can use the data grid to insert, delete, or edit
 * data in the database, or simply to display it.
 *
 * At runtime, users can use the database paginator (DBPaginator) to move through
 * data in the grid, and to insert, delete, and edit the data. Edits that are made
 * in the data grid are not posted to the underlying dataset until the user moves
 * to a different record or closes the application.
 *
 * DBGrid implements the generic behavior introduced in CustomDBGrid. DBGrid publishes
 * many of the properties inherited from CustomDBGrid, but does not introduce any new behavior.
 *
 * @example Ajax/Database/ajaxdatabase.php How to use ajax in a database application with a DBGrid
 */
class DBGrid extends CustomListView
{
        //Publish common properties
        function getVisible() { return $this->readVisible(); }
        function setVisible($value) { $this->writeVisible($value); }

        protected $_datasource=null;
        private $_latestheader=null;

        function getColumns() { return $this->readcolumns(); }
        function setColumns($value) { $this->writecolumns($value); }


    protected $_readonly=0;

    /**
    * Indicates whether the grid is used for display only, or whether the user can edit data using the grid.
    *
    * Set ReadOnly to true to prevent users from changing the data in the dataset.
    * Set ReadOnly to false to allow users to edit data using the grid.
    *
    * When ReadOnly is true, users cannot edit information on the grid.
    *
    * @return boolean
    */
    function getReadOnly() { return $this->_readonly; }
    function setReadOnly($value) { $this->_readonly=$value; }
    function defaultReadOnly() { return 0; }



        function __construct($aowner=null)
        {
                //Calls inherited constructor
                parent::__construct($aowner);

                $this->Width=400;
                $this->Height=200;
                $this->ControlStyle="csSlowRedraw=1";
        }

        function init()
        {
                parent::init();

                //Include the RPC to handle any request
                use_unit("rpc/rpc.inc.php");
        }

        function unserialize()
        {
                $this->_objectcolumns=false;
                parent::unserialize();
        }

        /**
        * To give permission to execute certain methods
        *
        * @param string $method Method for which we want to know the accessibility
        * @param integer $defaccesibility If the method is not found, this will be returned
        * @return integer
        */
        function readAccessibility($method, $defaccessibility)
        {
                switch($method)
                {
                case "updateRow": return Accessibility_Domain;
                }

                return(parent::readAccessibility($method, $defaccessibility));
        }

        /**
        *  Updates a row of the attached datasource->dataset.
        *
        *  This method is called everytime the user changes a row on the dbgrid
        *  to update the same row on the attached table.
        *
        *  @see getReadOnly()
        *
        *  @param array $params Array of parameters to this method
        *  @param object $error RPC Error object to return if anything goes wrong
        *  @return mixed
        */
        function updateRow($params, $error)
        {
                if (count($params) != 4)
                {
                    $error->SetError(JsonRpcError_ParameterMismatch, "Expected 4 parameter; got " . count($params));
                    return $error;
                }
                else
                {
                        $fieldnames=$params[0];
                        $fieldvalues=$params[1];
                        $origvalues=$params[2];
                        $dbgridrow=$params[3];

                        reset($fieldnames);
                        reset($fieldvalues);

                        if ($this->_datasource!=null)
                        {
                                if ($this->_datasource->Dataset!=null)
                                {
                                        if ($this->_datasource->Dataset->Database!=null)
                                        {
                                                try
                                                {
                                                    //Get an array with the keys and fields to change
                                                    $output=array();

                                                    $keys=$this->_datasource->DataSet->_keyfields;
                                                    while (list($k,$v)=each($fieldnames))
                                                    {
                                                        if ((in_array($v,$keys)) || ($fieldvalues[$k]!=$origvalues[$k]))
                                                        {
                                                            $output[$v]=$fieldvalues[$k];
                                                        }
                                                    }
                                                    $this->_datasource->DataSet->edit();
                                                    $this->_datasource->DataSet->fieldbuffer=$output;
                                                    $this->_datasource->DataSet->Post();
                                                }
                                                catch (Exception $e)
                                                {
                                                        $error->SetError(-104, 'Caught exception: '.$e->getMessage());
                                                        return $error;
                                                }
                                                return $dbgridrow;
                                        }
                                        else
                                        {
                                            $error->SetError(-103, "Datasource->Dataset->Database not assigned");
                                            return $error;
                                        }
                                }
                                else
                                {
                                    $error->SetError(-102, "Datasource->Dataset not assigned");
                                    return $error;
                                }
                        }
                        else
                        {
                            $error->SetError(-101, "Datasource not assigned");
                            return $error;
                        }
                }

                return -1;

        }

        /**
        * Dump javascript code to attach the updateRow method to the grid using ajax
        *
        * This method is used by the component to generate the required code to
        * allow the dbgrid to update contents on the server. It uses the qooxdoo
        * RPC engine to make all this work.
        *
        * You don't need to call this method directly.
        *
        * @see updateRow()
        */
        function dumpRPC()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
?>
                function <?php echo $this->Name; ?>_rpcdatachanged(event)
                {

<?php
                        if (($this->_jsondatachanged!="") && ($this->_jsondatachanged!=null))
                        {
                                echo $this->_jsondatachanged."(event);\n";
                        }
?>
                        var obj;
                        obj=this;
                        data=event.getData();
                        modifiedRow=data.firstRow;

                        row=this.getRowData(modifiedRow);
                        orow=this.originalData[modifiedRow];

                        qx.Settings.setCustomOfClass("qx.io.Json", "enableDebug", true);

                        var rpc = new qx.io.remote.Rpc();
                        rpc.setTimeout(10000);
                        var mycall = null;
                        rpc.setUrl("<?php echo $_SERVER['PHP_SELF']; ?>");
                        rpc.setServiceName("<?php echo $this->owner->Name; ?>.<?php echo $this->Name; ?>");
                        rpc.setCrossDomain(false);

                        mycall = rpc.callAsync
                        (
                                function(result, ex, id)
                                {
                                    mycall = null;
                                    event=new Object();
                                    event.result=result;
                                    event.ex=ex;
                                    event.id=id;

                                    if (result>=0)
                                    {
                                        if (obj)
                                        {
                                            row=obj.getRowData(result);
                                            if (row)
                                            {
                                                obj.originalData[result]=row.slice();
                                            }
                                        }
                                    }
<?php
                                        if (($this->_jsonrowsaved!="") && ($this->_jsonrowsaved!=null))
                                        {
                                                echo $this->_jsonrowsaved."(event);";
                                        }
?>
                                    send.setEnabled(true);
                                    abort.setEnabled(false);
                                }
                        , "updateRow", this.ColumnNames, row, orow, modifiedRow
                        );
                }
<?php
            }
        }

        /**
        * Creates the DBGrid Table Model
        *
        * This method is used to generate the qooxdoo code to create the table
        * model required to build the grid.
        *
        * You don't need to call this method directly.
        *
        *  @see dumpContents()
        */
        function createTableModel()
        {
?>
            // table model
            var <?php echo $this->Name; ?>_tableModel = new qx.ui.table.SimpleTableModel();
            <?php
                if ($this->owner!=null)
                {
            ?>
            <?php echo $this->owner->Name.".".$this->Name; ?>_tableModel=<?php echo $this->Name; ?>_tableModel;
            <?php
                }
            ?>
<?php
        }
        //TODO: Datasource must link with controls to update their state when the dataset changes
        /**
        * Dumps required code to show information, and columns on the grid
        *
        * This is an internal method used by the component to generate all columns
        * and rows required to build up the control.
        *
        * You don't need to call this method directly.
        *
        *  @see dumpForAjax()
        */
        function updateControl()
        {
            if (($this->ControlState & csDesigning)!=csDesigning)
            {
                //Ensure there is a valid datasource
                $this->setDataSource($this->_datasource);

                if (is_object($this->_datasource))
                {
                        $ds=$this->_datasource->DataSet;

                        if ($ds->Active)
                        {
                            $ds->first();
                            $fields=$ds->Fields;
?>
         var <?php echo $this->Name; ?>_tableModel=<?php echo $this->owner->Name.".".$this->Name; ?>_tableModel;
        <?php echo $this->Name; ?>_tableModel.setColumns([
<?php
        if (count($this->_columns)>=1)
        {
            reset($this->_columns);
            $i=0;
            while(list($key, $val)=each($this->_columns))
            {
                $fname=$val['Fieldname'];
                if ($fname!="")
                {
                    $props=$this->_datasource->DataSet->readFieldProperties($fname);
                }
                $dlabel=$val['Caption'];

                if ($props)
                {
                        if (array_key_exists('displaylabel',$props))
                        {
                                $dlabel=$props['displaylabel'][0];
                        }
                }

                if ($i>0) echo ",";
                echo '"'.$dlabel.'"';
                $i++;

            }
        }
        else if (is_array($fields))
        {
        reset($fields);
        $i=0;
        while(list($fname, $value)=each($fields))
        {
                $props=$this->_datasource->DataSet->readFieldProperties($fname);
                $dlabel=$fname;

                if ($props)
                {
                        if (array_key_exists('displaylabel',$props))
                        {
                                $dlabel=$props['displaylabel'][0];
                        }
                }

                if ($i>0) echo ",";
                echo '"'.$dlabel.'"';
                $i++;
        }
        }
?>
 ]);


        <?php echo $this->Name; ?>_tableModel.ColumnNames=new Array(
<?php
        $cnames=$ds->Fields;
        if (count($this->_columns))
        {
            $cnames=array();
            reset($this->_columns);
            while(list($key, $val)=each($this->_columns))
            {
              $cnames[$val['Fieldname']]='1';
            }
        }

        if (is_array($cnames))
        {
        reset($cnames);
        $i=0;
        while(list($fname, $value)=each($cnames))
        {
                if ($i>0) echo ",";
                echo '"'.$fname.'"';
                $i++;
        }
        }
?>
);



        var rowData = [];
        var oData = [];
<?php
        $colvalues=array();

        if (count($this->_columns)>=1)
        {
            reset($this->_columns);
            while(list($key, $val)=each($this->_columns))
            {
                $colvalues[$val['Fieldname']]=1;
            }

        }

                                $ds->first();
                                while (!$ds->EOF)
                                {
                                        $rvalues=$ds->Fields;

                                        if (count($colvalues)>=1)
                                        {
                                            $avalues=array();
                                            reset($colvalues);
                                            while(list($key, $val)=each($colvalues))
                                            {
                                                $avalues[$key]=$rvalues[$key];
                                            }
                                            $rvalues=$avalues;
                                        }
?>
                        rowData.push([
                        <?php
                                        reset($rvalues);
                                        $i=0;
                                        while (list($k,$v)=each($rvalues))
                                        {

                                                $v=str_replace("\n\r",'\n',$v);
                                                $v=str_replace("\n",'\n',$v);
                                                $v=str_replace("\r",'',$v);
                                                $v=str_replace('"','\"',$v);
                                                $v=str_replace("\\",'\\',$v);
                                                $v=str_replace('<','\<',$v);
                                                $v=str_replace('>','\>',$v);
                                                if ($i>0) echo ",";

                                                $numeric=false;
                                                if (count($this->_columns)>=1)
                                                {
                                                        $sorttype=$this->_columns[$i]['SortType'];
                                                        if ($sorttype=='stNumeric')
                                                        {
                                                                $numeric=true;
                                                        }
                                                }
                                                if (!$numeric) echo '"'.$v.'"';
                                                else echo $v;

                                                $i++;

                                        }
                        ?>
                        ]);
                        oData.push([
                        <?php
                                        reset($rvalues);
                                        $i=0;
                                        while (list($k,$v)=each($rvalues))
                                        {
                                            if (count($colvalues)>=1)
                                            {
                                                if (!array_key_exists($k,$colvalues)) continue;
                                            }

                                                $v=str_replace("\n\r",'\n',$v);
                                                $v=str_replace("\n",'\n',$v);
                                                $v=str_replace("\r",'',$v);
                                                $v=str_replace('"','\"',$v);
                                                $v=str_replace("\\",'\\',$v);
                                                $v=str_replace('<','\<',$v);
                                                $v=str_replace('>','\>',$v);
//                                                $v=htmlentities($v);
                                                if ($i>0) echo ",";
                                                echo '"'.$v.'"';
                                                $i++;

                                        }
                        ?>
                        ]);
                        <?php
                                        $ds->next();
                                }
                                $ds->first();

?>
        <?php echo $this->Name; ?>_tableModel.originalData=oData;
        <?php echo $this->Name; ?>_tableModel.setData(rowData);
<?php
        $this->_latestheader=$fields;

        if (count($this->_columns)>=1)
        {
            reset($this->_columns);
            $i=0;
            while(list($key, $value)=each($this->_columns))
            {
                $editable='true';
                if ($value['ReadOnly']=='true') $editable='false';

                if ($this->_readonly) $editable='false';
?>
            <?php echo $this->Name; ?>_tableModel.setColumnEditable(<?php echo $i; ?>, <?php echo $editable; ?>);
<?php
            $i++;
            }

        }
        else if (is_array($fields))
        {
            reset($fields);
            $i=0;
            while(list($fname, $value)=each($fields))
            {
                $editable='true';
                if ($this->_readonly) $editable='false';
?>
            <?php echo $this->Name; ?>_tableModel.setColumnEditable(<?php echo $i; ?>, <?php echo $editable; ?>);
<?php
            $i++;
            }


        }
                      }
                }
            }
        }

        function dumpHeaderCode()
        {
            parent::dumpHeaderCode();
            if (!defined('QOOXDOO_EASYDATACELLRENDERER'))
            {
                define('QOOXDOO_EASYDATACELLRENDERER',1);
                echo "<script type=\"text/javascript\">\n"
?>
qx.OO.defineClass("qx.ui.table.ComboBoxCellEditorFactory", qx.ui.table.CellEditorFactory,
function() {
  qx.ui.table.CellEditorFactory.call(this);
  this.data=[];
});


// overridden
qx.Proto.createCellEditor = function(cellInfo) {
  var cellEditor = new qx.ui.form.ComboBoxEx;

  cellEditor.setWidth('100%');
  cellEditor.getField().setWidth('1*');


  cellEditor.setSelection(this.data);

  cellEditor.originalValue = cellInfo.value;
  cellEditor.setValue("" + cellInfo.value);

  return cellEditor;
}


// overridden
qx.Proto.getCellEditorValue = function(cellEditor) {
  var value = cellEditor.getSelectedRow();
  value=value[1];

  if (typeof cellEditor.originalValue == "number") {
    value = parseFloat(value);
  }
  return value;
}

            qx.OO.defineClass("qx.ui.table.EasyDataCellRenderer", qx.ui.table.DefaultDataCellRenderer,
            function()
            {
                this.color='';
                this.fontcolor='';
                this.alignment='';

                this.setUseAutoAlign(true);
                qx.ui.table.DefaultDataCellRenderer.call(this);

            });


            // overridden
            qx.Proto._getCellStyle = function(cellInfo)
            {
              var html = cellInfo.style;

              html+=';overflow:hidden;border-bottom:1px solid #F0F0F0;border-right:1px solid #F0F0F0';
              if (this.color!='')
              {
                  html+=';background-color:'+this.color;
              }

              if (this.fontcolor!='')
              {
                  html+=';color:'+this.fontcolor;
              }

              if (this.alignment!='')
              {
                  html+=';text-align:'+this.alignment;
              }
              return html;
            };
<?php
            echo "</script>";
            }

        }

        /**
        * DataSource property allows you to link this control to a dataset containing
        * rows of data.
        *
        * To make it work, you must also assign DataField property with
        * the name of the column you want to use
        *
        * @return Datasource
        */
        function getDataSource() { return $this->_datasource;   }
        function setDataSource($value)
        {
                $this->_datasource=$this->fixupProperty($value);
        }

        function loaded()
        {
                parent::loaded();
                $this->setDataSource($this->_datasource);
        }

            protected $_jsondatachanged=null;

        /**
        * This event is fired whenever the contents of a cell is changed
        *
        * Use this event to get notified whenever a cell value is changed, so you
        * can react to this event.
        *
        * @see getjsOnRowSaved(), getjsOnRowChanged()
        *
        * @return mixed
        */
            function getjsOnDataChanged() { return $this->_jsondatachanged; }
            function setjsOnDataChanged($value) { $this->_jsondatachanged=$value; }
            function defaultjsOnDataChanged() { return null; }

            protected $_jsonrowsaved=null;

        /**
        * This event is fired whenever the contents of a row are saved
        *
        * Once the DBGrid sends the signal to the server to update a row on the attached
        * table, when it returns back to the javascript, you can get notified the row has
        * been saved using this event.
        *
        * @see getjsOnDataChanged(), getjsOnRowChanged()
        *
        * @return mixed
        */
            function getjsOnRowSaved() { return $this->_jsonrowsaved; }
            function setjsOnRowSaved($value) { $this->_jsonrowsaved=$value; }
            function defaultjsOnOnRowSaved() { return null; }

            protected $_jsonrowchanged=null;

        /**
        * This event is fired whenever the active row is changed
        *
        * Use this event to get notified whenever the user changes the active
        * or selected row on the dbgrid. This event is useful to update another
        * controls depending on the dbgrid selection.
        *
        * @see getjsOnDataChanged(), getjsOnRowSaved()
        *
        * @return mixed
        */
            function getjsOnRowChanged() { return $this->_jsonrowchanged; }
            function setjsOnRowChanged($value) { $this->_jsonrowchanged=$value; }
            function defaultjsOnOnRowChanged() { return null; }

        function getjsOnClick                   () { return $this->readjsOnClick(); }
        function setjsOnClick                   ($value) { $this->writejsOnClick($value); }

        function getjsOnDblClick                () { return $this->readjsOnDblClick(); }
        function setjsOnDblClick                ($value) { $this->writejsOnDblClick($value); }

          /**
         * Dump Javascript events
         *
         */
        function dumpJsEvents()
        {
                parent::dumpJsEvents();
                $this->dumpJSEvent($this->_jsondatachanged);
                $this->dumpJSEvent($this->_jsonrowsaved);
                $this->dumpJSEvent($this->_jsonrowchanged);
        }

    protected $_fixedcolumns=0;

    /**
    * Specifies the number of columns on the left of the grid that cannot be scrolled.
    *
    * Set FixedColumns to create or get rid of nonscrolling columns. Nonscrolling
    * columns appear at the left of the grid, and are always visible, even when the
    * user scrolls the other columns in the grid. Use nonscrolling columns for displaying
    * row titles or row numbers, or to implement a scroll lock that the user can set.
    *
    * @return integer
    */
    function getFixedColumns() { return $this->_fixedcolumns; }
    function setFixedColumns($value) { $this->_fixedcolumns=$value; }
    function defaultFixedColumns() { return 0; }



                /**
                * This is an internal method you don't need to call directly
                *
                * It dumps the common javascript code to update the control if used
                * inside an Ajax call
                *
                * @see dumpForAjax()
                *
                */
        function commonScript()
        {
//                echo "  if (!$this->Name) { var div=findObj('$this->Name'); var $this->Name=div.firstChild.firstChild.qx_Widget; }\n";
//                echo " alert($this->Name); \n";
                if ($this->owner!=null)
                {
                        echo "        var $this->Name=".$this->owner->Name.".".$this->Name.";\n";
                }
                echo "        ".$this->Name.".setBorder(qx.renderer.border.BorderPresets.getInstance().shadow);\n";
                echo "        ".$this->Name.".setBackgroundColor(\"white\");\n";
                /*
                echo "        $this->Name.setLeft(0);\n";
                echo "        $this->Name.setTop(0);\n";
                */
//                echo "        $this->Name.setOverflow(\"auto\");\n";
                echo "        $this->Name.setWidth($this->Width);\n";
                echo "        $this->Name.setHeight($this->Height);\n";
                if ($this->_fixedcolumns!=0)
                {
                    echo "        $this->Name.setMetaColumnCounts([$this->_fixedcolumns, -1]);\n";
                }
                echo "        $this->Name.getSelectionModel().setSelectionMode(qx.ui.table.SelectionModel.MULTIPLE_INTERVAL_SELECTION);\n";
//                table-header-cell




            $fields=$this->_latestheader;

            if (($this->ControlState & csDesigning)!=csDesigning)
            {

                    if (($this->_datasource!=null) && ($this->_datasource->Dataset!=null))
                    {

        if (count($this->_columns)>=1)
        {
            reset($this->_columns);
            $i=0;
            while(list($key, $value)=each($this->_columns))
            {
                $dwidth=$value['Width'];
                $color=$value['Color'];
                $fontcolor=$value['FontColor'];
                $alignment=$value['Alignment'];
                $fname=$value['Fieldname'];

                    $props=$this->_datasource->DataSet->readFieldProperties($fname);
                    if ($props)
                    {
                            if (array_key_exists('displaywidth',$props))
                            {
                                    $dwidth=$props['displaywidth'][0];
                            }
                    }


                echo "        $this->Name.getTableColumnModel().setColumnWidth($i,$dwidth);\n";




                $picklist=$value['PickList'];
                if ($picklist!='')
                {
                if (is_string($picklist))
                {
                    $picklist=safeunserialize($picklist);
                }

                if (count($picklist)>0)
                {
                    echo "var dat=[];\n";
                    reset($picklist);
                    while(list($key, $val)=each($picklist))
                    {
                        $val=str_replace("'","\\'",$val);
                        echo "dat.push(['$val','$val']);\n";
                    }
                    echo "  var factory=new qx.ui.table.ComboBoxCellEditorFactory(); \n";
                    echo "  factory.data=dat;\n";
                    echo "  $this->Name.getTableColumnModel().setCellEditorFactory($i,factory);\n";
                }
                }

                echo " var renderer=new qx.ui.table.EasyDataCellRenderer();\n";
                if ($color!='') echo " renderer.color=\"$color\";\n";
                if ($fontcolor!='') echo " renderer.fontcolor=\"$fontcolor\";\n";
                if ($alignment!='')
                {
                    switch($alignment)
                    {
                        case "taLeftJustify": $alignment='left'; break;
                        case "taRightJustify": $alignment='right'; break;
                        case "taCenter": $alignment='center'; break;
                    }
                    echo " renderer.alignment=\"$alignment\";\n";
                }
                echo " $this->Name.getTableColumnModel().setDataCellRenderer($i,renderer);\n";

            $i++;
            }

        }
        else if (is_array($fields))
            {
                reset($fields);
                $i=0;
                while(list($fname, $value)=each($fields))
                {
                    $props=$this->_datasource->DataSet->readFieldProperties($fname);
                    $dwidth=100;
                    $color='';
                    $alignment='';

                    if ($props)
                    {
                            if (array_key_exists('displaywidth',$props))
                            {
                                    $dwidth=$props['displaywidth'][0];
                            }

                            if (array_key_exists('color',$props))
                            {
                                    $color=$props['color'][0];
                            }

                            if (array_key_exists('alignment',$props))
                            {
                                    $alignment=$props['alignment'][0];
                            }
                    }

                    echo "        $this->Name.getTableColumnModel().setColumnWidth($i,$dwidth);\n";

                    echo " var renderer=new qx.ui.table.EasyDataCellRenderer();\n";
                    if ($color!='') echo " renderer.color=\"$color\";\n";

                    if ($alignment!='')
                    {
                        switch($alignment)
                        {
                            case "taLeftJustify": $alignment='left'; break;
                            case "taRightJustify": $alignment='right'; break;
                            case "taCenter": $alignment='center'; break;
                        }
                        echo " renderer.alignment=\"$alignment\";\n";
                    }

                    echo " $this->Name.getTableColumnModel().setDataCellRenderer($i,renderer);\n";

                $i++;
                }
            }
            }
            }
        }

        function dumpContents()
        {
                $this->dumpCommonContentsTop();
                $this->createTableModel();
                $this->updateControl();
                echo "        var ".$this->Name."    = new qx.ui.table.Table(".$this->Name."_tableModel);\n";
                if ($this->owner!=null)
                {
                        echo "        ".$this->owner->Name.".".$this->Name."    = $this->Name;\n";
                }
                $this->commonScript();
                $this->callEvent('onshow', array());

                if (($this->ControlState & csDesigning)!=csDesigning)
                {
                        $this->dumpRPC();

                        echo "        ".$this->Name."_tableModel.addEventListener(\"dataChanged\", ".$this->Name."_rpcdatachanged, ".$this->Name."_tableModel);\n";

                        if (($this->_jsonclick!="") && ($this->_jsonclick!=null))
                        {
                                echo "        $this->Name.addEventListener(\"click\", $this->_jsonclick);\n";
                        }

                        if (($this->_jsonrowchanged!="") && ($this->_jsonrowchanged!=null))
                        {
                                echo "        $this->Name.getSelectionModel().addEventListener(\"changeSelection\", $this->_jsonrowchanged);\n";
                        }

                        if (($this->_jsondblclick!="") && ($this->_jsondblclick!=null))
                        {
                                echo "        $this->Name.addEventListener(\"dblclick\", $this->_jsondblclick);\n";
                        }


                }

//                echo "        alert($this->Name.getTableColumnModel().getDataCellRenderer());\n";

                $this->dumpCommonContentsBottom();
        }

        /**
        * This is an internal method you don't need to call directly
        *
        * This method is called by the Ajax engine to get the code to update the
        * component after an ajax call
        *
        * @see commonScript(), updateControl()
        */
        function dumpForAjax()
        {
                $this->updateControl();
                $this->commonScript();
        }
}

?>