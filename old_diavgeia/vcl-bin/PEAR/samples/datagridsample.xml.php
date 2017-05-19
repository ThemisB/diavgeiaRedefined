<?php
<object class="DataGridSample" name="DataGridSample" baseclass="page">
  <property name="Background"></property>
  <property name="Caption">DataGrid Sample</property>
  <property name="DocType">dtNone</property>
  <property name="Font">
    <property name="Align">taNone</property>
    <property name="Case"></property>
    <property name="Color"></property>
    <property name="Family">Verdana</property>
    <property name="LineHeight"></property>
    <property name="Size">10px</property>
    <property name="Style"></property>
    <property name="Variant"></property>
    <property name="Weight"></property>
  </property>
  <property name="Height">600</property>
  <property name="IsMaster">0</property>
  <property name="Layout">
    <property name="Cols">5</property>
    <property name="Rows">5</property>
    <property name="Type">ABS_XY_LAYOUT</property>
  </property>
  <property name="Name">DataGridSample</property>
  <property name="Width">1128</property>
  <property name="OnAfterShow"></property>
  <property name="OnAfterShowFooter"></property>
  <property name="OnBeforeShow"></property>
  <property name="OnBeforeShowHeader"></property>
  <property name="OnCreate"></property>
  <property name="OnShow"></property>
  <property name="OnShowHeader"></property>
  <property name="OnStartBody"></property>
  <property name="OnTemplate"></property>
  <object class="PearDataGrid" name="PearDataGrid1" >
    <property name="DSN">mysql://root:test@localhost/oscommerce</property>
    <property name="Height">224</property>
    <property name="Left">89</property>
    <property name="Name">PearDataGrid1</property>
    <property name="RecordsPerPage">20</property>
    <property name="SQL"><![CDATA[a:1:{i:0;s:99:&quot;select products_id, products_quantity, products_model, products_image, products_price from products&quot;;}]]></property>
    <property name="Top">80</property>
    <property name="Width">767</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
  <object class="MainMenu" name="MainMenu1" >
    <property name="Caption">MainMenu1</property>
    <property name="Font">
        <property name="Align">taNone</property>
        <property name="Case"></property>
        <property name="Color"></property>
        <property name="Family">Verdana</property>
        <property name="LineHeight"></property>
        <property name="Size">10px</property>
        <property name="Style"></property>
        <property name="Variant"></property>
        <property name="Weight"></property>
    </property>
    <property name="Height">24</property>
    <property name="Items">a:0:{}</property>
    <property name="Left">88</property>
    <property name="Name">MainMenu1</property>
    <property name="Top">40</property>
    <property name="Width">300</property>
    <property name="OnAfterShow"></property>
    <property name="OnBeforeShow"></property>
    <property name="OnShow"></property>
  </object>
</object>
?>
