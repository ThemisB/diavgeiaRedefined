<?php
<object class="manage_ypografontes_types" name="manage_ypografontes_types" baseclass="page">
  <property name="Background"></property>
  <property name="Caption"><![CDATA[Διαχείριση Υπογραφόντων]]></property>
  <property name="DocType">dtNone</property>
  <property name="Encoding">Unicode (UTF-8)            |utf-8</property>
  <property name="Height">299</property>
  <property name="IsMaster">0</property>
  <property name="Layout">
    <property name="Type">XY_LAYOUT</property>
  </property>
  <property name="Name">manage_ypografontes_types</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">manage_ypografontes_types.htm</property>
  <property name="Width">800</property>
  <property name="OnBeforeShow">manage_ypografontes_typesBeforeShow</property>
  <property name="OnCreate">manage_ypografontes_typesCreate</property>
  <property name="jsOnSubmit">manage_ypografontes_typesJSSubmit</property>
  <object class="Panel" name="Panel1" >
    <property name="BorderColor">#0000A0</property>
    <property name="BorderWidth">2</property>
    <property name="Dynamic"></property>
    <property name="Height">192</property>
    <property name="Layout">
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">8</property>
    <property name="Name">Panel1</property>
    <property name="Top">96</property>
    <property name="Visible">0</property>
    <property name="Width">776</property>
    <property name="OnAfterShow">Panel1AfterShow</property>
    <object class="Button" name="btnPost" >
      <property name="Caption"><![CDATA[Αποθήκευση]]></property>
      <property name="Height">25</property>
      <property name="Left">330</property>
      <property name="Name">btnPost</property>
      <property name="Top">152</property>
      <property name="Width">99</property>
      <property name="OnClick">btnPostClick</property>
      <property name="jsOnMouseUp">btnPostJSMouseUp</property>
    </object>
    <object class="Label" name="Label14" >
      <property name="Caption"><![CDATA[Ενημέρωση Τύπου Υπογράφοντα:]]></property>
      <property name="Font">
            <property name="Weight">bold</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">27</property>
      <property name="Name">Label14</property>
      <property name="ParentFont">0</property>
      <property name="Top">6</property>
      <property name="Width">229</property>
    </object>
    <object class="Edit" name="field_name" >
      <property name="DataField">name</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">183</property>
      <property name="Name">field_name</property>
      <property name="Top">49</property>
      <property name="Width">549</property>
      <property name="jsOnClick">btnUpdateJSMouseUp</property>
    </object>
    <object class="Label" name="Label9" >
      <property name="Caption"><![CDATA[Όνομα Τύπου Υπογράφοντα:]]></property>
      <property name="Height">13</property>
      <property name="Left">14</property>
      <property name="Name">Label9</property>
      <property name="Top">53</property>
      <property name="Width">163</property>
    </object>
    <object class="Button" name="btnUpdate" >
      <property name="Caption"><![CDATA[Ενημέρωση]]></property>
      <property name="Height">25</property>
      <property name="Left">342</property>
      <property name="Name">btnUpdate</property>
      <property name="Top">152</property>
      <property name="Width">75</property>
      <property name="OnClick">btnUpdateClick</property>
      <property name="jsOnMouseUp">btnUpdateJSMouseUp</property>
    </object>
    <object class="HiddenField" name="pb_id" >
      <property name="Height">18</property>
      <property name="Left">576</property>
      <property name="Name">pb_id</property>
      <property name="Top">61</property>
      <property name="Width">200</property>
    </object>
    <object class="HiddenField" name="ypourgeio_table" >
      <property name="Height">18</property>
      <property name="Left">576</property>
      <property name="Name">ypourgeio_table</property>
      <property name="Top">35</property>
      <property name="Width">200</property>
    </object>
    <object class="HiddenField" name="ID" >
      <property name="Height">18</property>
      <property name="Left">576</property>
      <property name="Name">ID</property>
      <property name="Top">13</property>
      <property name="Width">200</property>
    </object>
    <object class="ComboBox" name="field_servicetype" >
      <property name="Height">18</property>
      <property name="Items"><![CDATA[a:3:{i:1;s:20:"Υπουργείο και γενικά";i:2;s:13:"Γενικός Τύπος";i:3;s:33:"Ειδικός Τύπος (π.χ. Προθυπουργός)";}]]></property>
      <property name="Left">183</property>
      <property name="Name">field_servicetype</property>
      <property name="Top">96</property>
      <property name="Width">305</property>
    </object>
    <object class="Label" name="Label3" >
      <property name="Caption"><![CDATA[Ο Τύπος Αφορά:]]></property>
      <property name="Height">13</property>
      <property name="Left">14</property>
      <property name="Name">Label3</property>
      <property name="Top">98</property>
      <property name="Width">163</property>
    </object>
  </object>
  <object class="DBRepeater" name="DBRepeater1" >
    <property name="BorderColor">#000040</property>
    <property name="BorderWidth">1</property>
    <property name="DataSource">dsRepeater</property>
    <property name="Dynamic"></property>
    <property name="Height">18</property>
    <property name="Layout">
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">2</property>
    <property name="Name">DBRepeater1</property>
    <property name="RestartDataset">0</property>
    <property name="Top">69</property>
    <property name="Width">782</property>
    <object class="Label" name="Label17" >
      <property name="Caption"><![CDATA[[Διαγραφή]]]></property>
      <property name="Height">13</property>
      <property name="Left">707</property>
      <property name="Name">Label17</property>
      <property name="ParentColor">0</property>
      <property name="Top">2</property>
      <property name="Width">70</property>
      <property name="OnBeforeShow">Label17BeforeShow</property>
      <property name="jsOnClick">Label17JSClick</property>
    </object>
    <object class="Label" name="LineLabel" >
      <property name="Caption">line label</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Height">14</property>
      <property name="Left">5</property>
      <property name="Name">LineLabel</property>
      <property name="Top">2</property>
      <property name="Width">608</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
    </object>
    <object class="Label" name="editLabel" >
      <property name="Caption"><![CDATA[[Επεξεργασία]]]></property>
      <property name="Height">13</property>
      <property name="Left">620</property>
      <property name="Name">editLabel</property>
      <property name="ParentColor">0</property>
      <property name="Top">2</property>
      <property name="Width">77</property>
      <property name="OnBeforeShow">Label17BeforeShow</property>
    </object>
  </object>
  <object class="Label" name="Label2" >
    <property name="Caption"><![CDATA[Κάνετε Click στον χρήστη που θέλετε να ενημερώσετε,&nbsp;click στο [διαγραφή] για διαγραφή χρήστη ή&nbsp;click στο Νέος Χρήστης για δημιουργία καινούγριου χρήστη.&nbsp;]]></property>
    <property name="Height">35</property>
    <property name="Left">654</property>
    <property name="Name">Label2</property>
    <property name="Width">126</property>
  </object>
  <object class="Button" name="btnAdd" >
    <property name="Caption"><![CDATA[Νέος Τύπος Υπογράφοντα]]></property>
    <property name="Height">25</property>
    <property name="Left">206</property>
    <property name="Name">btnAdd</property>
    <property name="Top">41</property>
    <property name="Width">182</property>
    <property name="OnClick">btnAddClick</property>
  </object>
  <object class="Label" name="lbMessages" >
    <property name="Caption">lbMessages</property>
    <property name="Font">
        <property name="Color">#FF0000</property>
        <property name="Weight">bold</property>
    </property>
    <property name="Height">13</property>
    <property name="Left">376</property>
    <property name="Name">lbMessages</property>
    <property name="ParentFont">0</property>
    <property name="Top">31</property>
    <property name="Visible">0</property>
    <property name="Width">356</property>
    <property name="OnAfterShow">lbMessagesAfterShow</property>
  </object>
  <object class="Label" name="Label1" >
    <property name="Caption"><![CDATA[<P><STRONG>Logged in as</STRONG></P>]]></property>
    <property name="Height">30</property>
    <property name="Left">17</property>
    <property name="Name">Label1</property>
    <property name="Top">11</property>
    <property name="Width">777</property>
  </object>
  <object class="Label" name="LogoutLabel" >
    <property name="Caption">Logout</property>
    <property name="Height">13</property>
    <property name="Left">17</property>
    <property name="Link">login.php?restore_session=1</property>
    <property name="Name">LogoutLabel</property>
    <property name="Top">47</property>
    <property name="Width">75</property>
  </object>
  <object class="Edit" name="field_searchterms" >
    <property name="Height">21</property>
    <property name="Left">615</property>
    <property name="Name">field_searchterms</property>
    <property name="Top">31</property>
    <property name="Width">185</property>
  </object>
  <object class="Button" name="Button_searchterms" >
    <property name="Caption"><![CDATA[Προβολή]]></property>
    <property name="Height">25</property>
    <property name="Left">615</property>
    <property name="Name">Button_searchterms</property>
    <property name="Top">34</property>
    <property name="Width">75</property>
  </object>
  <object class="Label" name="Label_searchterms" >
    <property name="Caption"><![CDATA[Αναζήτηση σε όνομα (κενό για όλα):]]></property>
    <property name="Height">13</property>
    <property name="Left">410</property>
    <property name="Name">Label_searchterms</property>
    <property name="Top">53</property>
    <property name="Width">374</property>
  </object>
  <object class="Pager" name="Pager" >
    <property name="DataSource">dsRepeater</property>
    <property name="Height">33</property>
    <property name="Left">91</property>
    <property name="Name">Pager</property>
    <property name="NextCaption"><![CDATA[Επόμενη σελίδα >>]]></property>
    <property name="PreviousCaption"><![CDATA[<< Προηγούμενη σελίδα]]></property>
    <property name="RecordsPerPage">20</property>
    <property name="Top">8</property>
    <property name="Width">593</property>
  </object>
  <object class="Datasource" name="dsRepeater" >
        <property name="Left">574</property>
        <property name="Top">167</property>
    <property name="Dataset">apAuth.YpografontesTypesTable</property>
    <property name="Name">dsRepeater</property>
  </object>
  <object class="Datasource" name="EditTableDs" >
        <property name="Left">643</property>
        <property name="Top">167</property>
    <property name="DataSet">EditTable</property>
    <property name="Name">EditTableDs</property>
  </object>
  <object class="MySQLTable" name="EditTable" >
        <property name="Left">722</property>
        <property name="Top">178</property>
    <property name="Database">apAuth.DB_General</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">EditTable</property>
    <property name="TableName">ypografontes_types</property>
  </object>
</object>
?>
