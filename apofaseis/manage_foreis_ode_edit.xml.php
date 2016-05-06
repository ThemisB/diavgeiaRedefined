<?php
<object class="manage_foreis_ode_edit" name="manage_foreis_ode_edit" baseclass="page">
  <property name="Background"></property>
  <property name="Caption"><![CDATA[Διαχείριση Υπογραφόντων]]></property>
  <property name="DocType">dtNone</property>
  <property name="Encoding">Unicode (UTF-8)            |utf-8</property>
  <property name="Height">963</property>
  <property name="IsMaster">0</property>
  <property name="Layout">
    <property name="Type">XY_LAYOUT</property>
  </property>
  <property name="Name">manage_foreis_ode_edit</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">manage_foreis_ode_edit.htm</property>
  <property name="Width">800</property>
  <property name="OnBeforeShow">manage_foreis_ode_editBeforeShow</property>
  <property name="OnCreate">manage_foreis_ode_editCreate</property>
  <object class="Panel" name="Panel1" >
    <property name="BorderColor">#0000A0</property>
    <property name="BorderWidth">2</property>
    <property name="Dynamic"></property>
    <property name="Height">864</property>
    <property name="Layout">
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">8</property>
    <property name="Name">Panel1</property>
    <property name="Top">94</property>
    <property name="Visible">0</property>
    <property name="Width">776</property>
    <property name="OnAfterShow">Panel1AfterShow</property>
    <object class="Label" name="Label14" >
      <property name="Caption"><![CDATA[Τρέχοντα Στοιχεία Φορέα στη ΔΙΑΥΓΕΙΑ:]]></property>
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
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">25</property>
      <property name="Name">field_name</property>
      <property name="ReadOnly">1</property>
      <property name="Top">211</property>
      <property name="Width">726</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label9" >
      <property name="Caption"><![CDATA[Πεδίο ονόματος φορέα]]></property>
      <property name="Font">
            <property name="Color"></property>
      </property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label9</property>
      <property name="ParentFont">0</property>
      <property name="Top">195</property>
      <property name="Width">244</property>
    </object>
    <object class="Button" name="btnUpdate" >
      <property name="Caption"><![CDATA[Ενημέρωση]]></property>
      <property name="Height">25</property>
      <property name="Left">342</property>
      <property name="Name">btnUpdate</property>
      <property name="Top">822</property>
      <property name="Width">75</property>
      <property name="jsOnClick">btnUpdateJSClick</property>
    </object>
    <object class="HiddenField" name="foreas_pb_id" >
      <property name="Height">18</property>
      <property name="Left">336</property>
      <property name="Name">foreas_pb_id</property>
      <property name="Top">1</property>
      <property name="Width">200</property>
    </object>
    <object class="HiddenField" name="ID" >
      <property name="Height">18</property>
      <property name="Left">545</property>
      <property name="Name">ID</property>
      <property name="Top">1</property>
      <property name="Width">200</property>
    </object>
    <object class="ComboBox" name="field_level0_text" >
      <property name="Height">18</property>
      <property name="Items">a:1:{i:1;s:6:"level0";}</property>
      <property name="Left">25</property>
      <property name="Name">field_level0_text</property>
      <property name="Top">258</property>
      <property name="Width">727</property>
    </object>
    <object class="Label" name="Label3" >
      <property name="Caption"><![CDATA[Φορέας εποπτείας]]></property>
      <property name="Height">12</property>
      <property name="Left">25</property>
      <property name="Name">Label3</property>
      <property name="Top">243</property>
      <property name="Width">547</property>
    </object>
    <object class="Edit" name="diefthinsi" >
      <property name="DataField">diefthinsi</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">diefthinsi</property>
      <property name="Top">353</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label6" >
      <property name="Caption"><![CDATA[Διεύθυνση:]]></property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label6</property>
      <property name="Top">357</property>
      <property name="Width">179</property>
    </object>
    <object class="Edit" name="arithmos" >
      <property name="DataField">arithmos</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">arithmos</property>
      <property name="Top">385</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label7" >
      <property name="Caption"><![CDATA[Αριθμός:]]></property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label7</property>
      <property name="Top">389</property>
      <property name="Width">179</property>
    </object>
    <object class="Edit" name="TK" >
      <property name="DataField">TK</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">TK</property>
      <property name="Top">417</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label8" >
      <property name="Caption"><![CDATA[ΤΚ:]]></property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label8</property>
      <property name="Top">421</property>
      <property name="Width">179</property>
    </object>
    <object class="Edit" name="contact_email" >
      <property name="DataField">contact_email</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">contact_email</property>
      <property name="Top">483</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label10" >
      <property name="Caption"><![CDATA[Ηλ. Διεύθυνση Φορέα  (E-mail):]]></property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label10</property>
      <property name="Top">487</property>
      <property name="Width">179</property>
    </object>
    <object class="Edit" name="foreas_afm" >
      <property name="DataField">foreas_afm</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">foreas_afm</property>
      <property name="Top">451</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label11" >
      <property name="Caption"><![CDATA[ΑΦΜ Φορέα:]]></property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label11</property>
      <property name="Top">455</property>
      <property name="Width">179</property>
    </object>
    <object class="Edit" name="foreas_url" >
      <property name="DataField">foreas_url</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">foreas_url</property>
      <property name="Top">547</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label12" >
      <property name="Caption"><![CDATA[Ιστοσελίδα Φορέα:]]></property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label12</property>
      <property name="Top">551</property>
      <property name="Width">179</property>
    </object>
    <object class="Edit" name="foreas_new_name" >
      <property name="DataField">foreas_new_name</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">foreas_new_name</property>
      <property name="Top">163</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label15" >
      <property name="Caption"><![CDATA[Δίορθωση ονοματος Φορέα ( αν <br>απαιτείται σύμφωνα με το <br>παραπάνω ΦΕΚ):]]></property>
      <property name="Height">33</property>
      <property name="Left">27</property>
      <property name="Name">Label15</property>
      <property name="Top">157</property>
      <property name="Width">203</property>
    </object>
    <object class="Edit" name="support_contact_phone" >
      <property name="DataField">support_contact_phone</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">support_contact_phone</property>
      <property name="Top">515</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label16" >
      <property name="Caption"><![CDATA[Tηλέφωνο Φορέα:]]></property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label16</property>
      <property name="Top">519</property>
      <property name="Width">179</property>
    </object>
    <object class="Label" name="status_label" >
      <property name="Caption"><![CDATA[Kατάσταση]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">status_label</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">708</property>
      <property name="Width">179</property>
    </object>
    <object class="Label" name="Label20" >
      <property name="Caption"><![CDATA[(Δεν τροποποιείται)]]></property>
      <property name="Font">
            <property name="Color">#FF0000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">467</property>
      <property name="Name">Label20</property>
      <property name="ParentFont">0</property>
      <property name="Top">706</property>
      <property name="Visible">0</property>
      <property name="Width">139</property>
    </object>
    <object class="ComboBox" name="status" >
      <property name="DataField">status</property>
      <property name="DataSource">EditTableDs</property>
      <property name="Height">18</property>
      <property name="Items"><![CDATA[a:3:{i:1;s:10:"1 : Ενεργή";i:2;s:13:"2 : Μη ενεργή";s:0:"";s:33:"3 : Νεος Φορέας (Χωρίς κατάσταση)";}]]></property>
      <property name="Left">233</property>
      <property name="Name">status</property>
      <property name="Top">708</property>
      <property name="Width">185</property>
    </object>
    <object class="ComboBox" name="dimos_pb_id" >
      <property name="DataField">dimos_pb_id</property>
      <property name="DataSource">EditTableDs</property>
      <property name="Height">18</property>
      <property name="Items">a:1:{s:0:"";s:0:"";}</property>
      <property name="Left">234</property>
      <property name="Name">dimos_pb_id</property>
      <property name="Top">323</property>
      <property name="Width">509</property>
    </object>
    <object class="Label" name="dimos_lgoid_label" >
      <property name="Caption"><![CDATA[Δήμος]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">dimos_lgoid_label</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">325</property>
      <property name="Width">179</property>
    </object>
    <object class="Label" name="dimos_status_label" >
      <property name="Caption"><![CDATA[Επιλέξτε την κατάσταση του Φορέα:]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">dimos_status_label</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">740</property>
      <property name="Width">203</property>
    </object>
    <object class="ComboBox" name="dimos_status" >
      <property name="DataField">dimos_status</property>
      <property name="DataSource">EditTableDs</property>
      <property name="Height">18</property>
      <property name="Items"><![CDATA[a:3:{i:3;s:0:"";i:1;s:32:"1 : Νέος Φορέας Βάσει Καλλικράτη";i:2;s:33:"2 : Εχει καταργηθεί / συγχωνευθεί";}]]></property>
      <property name="Left">233</property>
      <property name="Name">dimos_status</property>
      <property name="Top">740</property>
      <property name="Width">185</property>
    </object>
    <object class="Edit" name="ypefthinos_telephone" >
      <property name="DataField">ypefthinos_telephone</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">ypefthinos_telephone</property>
      <property name="Top">643</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Edit" name="ypefthinos_email" >
      <property name="DataField">ypefthinos_email</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">ypefthinos_email</property>
      <property name="Top">611</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Edit" name="ypefthinos_onomateponymo" >
      <property name="DataField">ypefthinos_onomateponymo</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">ypefthinos_onomateponymo</property>
      <property name="Top">579</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label4" >
      <property name="Caption"><![CDATA[Στοιχεία προσώπου επαφής πλατφόρμας:]]></property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label4</property>
      <property name="Top">583</property>
      <property name="Width">203</property>
    </object>
    <object class="Label" name="Label5" >
      <property name="Caption"><![CDATA[Email υπευθύνου:]]></property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label5</property>
      <property name="Top">615</property>
      <property name="Width">196</property>
    </object>
    <object class="Label" name="Label13" >
      <property name="Caption"><![CDATA[Yπηρεσιακό τηλέφωνο:]]></property>
      <property name="Height">23</property>
      <property name="Left">26</property>
      <property name="Name">Label13</property>
      <property name="Top">642</property>
      <property name="Width">204</property>
    </object>
    <object class="Label" name="Label18" >
      <property name="Caption"><![CDATA[ΑΡΙΘΜΟΣ:]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label18</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">67</property>
      <property name="Width">59</property>
    </object>
    <object class="Label" name="Label22" >
      <property name="Caption"><![CDATA[ΕΤΟΣ (π.χ 2010):]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">27</property>
      <property name="Name">Label22</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">131</property>
      <property name="Width">122</property>
    </object>
    <object class="Edit" name="fek_etos" >
      <property name="DataField">fek_etos</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">233</property>
      <property name="Name">fek_etos</property>
      <property name="Top">127</property>
      <property name="Width">69</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="Label23" >
      <property name="Caption"><![CDATA[ΤΕΥΧΟΣ:]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">27</property>
      <property name="Name">Label23</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">99</property>
      <property name="Width">50</property>
    </object>
    <object class="ComboBox" name="fek_tefxos" >
      <property name="DataField">fek_tefxos</property>
      <property name="DataSource">EditTableDs</property>
      <property name="Height">18</property>
      <property name="Items">a:1:{s:0:"";s:0:"";}</property>
      <property name="Left">233</property>
      <property name="Name">fek_tefxos</property>
      <property name="Top">97</property>
      <property name="Width">91</property>
    </object>
    <object class="Label" name="Label24" >
      <property name="Caption"><![CDATA[Στοιχεία του με βάση το ΦΕΚ]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">22</property>
      <property name="Left">27</property>
      <property name="Name">Label24</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">26</property>
      <property name="Width">732</property>
    </object>
    <object class="ComboBox" name="field_oda_members_foreas_type" >
      <property name="DataField">oda_members_foreas_type</property>
      <property name="DataSource">EditTableDs</property>
      <property name="Height">18</property>
      <property name="Items">a:1:{s:0:"";s:0:"";}</property>
      <property name="Left">234</property>
      <property name="Name">field_oda_members_foreas_type</property>
      <property name="Top">291</property>
      <property name="Width">221</property>
    </object>
    <object class="Label" name="Label21" >
      <property name="Caption"><![CDATA[Τύπος Φορέα:]]></property>
      <property name="Font">
            <property name="Color">#000000</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label21</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">293</property>
      <property name="Width">179</property>
    </object>
    <object class="Label" name="Label19" >
      <property name="Caption"><![CDATA[Κινητό τηλέφωνο υπευθύνου]]></property>
      <property name="Height">16</property>
      <property name="Left">26</property>
      <property name="Name">Label19</property>
      <property name="Top">677</property>
      <property name="Width">204</property>
    </object>
    <object class="Edit" name="ypefthinos_mobile_phone" >
      <property name="DataField">ypefthinos_mobile_phone</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">ypefthinos_mobile_phone</property>
      <property name="Top">675</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Edit" name="fek_arithmos" >
      <property name="DataField">fek_arithmos</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">fek_arithmos</property>
      <property name="Top">63</property>
      <property name="Width">69</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
    </object>
    <object class="Label" name="foreas_latin_name_label" >
      <property name="Caption"><![CDATA[Λατινικό όνομα:]]></property>
      <property name="Height">16</property>
      <property name="Left">26</property>
      <property name="Name">foreas_latin_name_label</property>
      <property name="Top">773</property>
      <property name="Width">204</property>
    </object>
    <object class="Edit" name="foreas_latin_name" >
      <property name="DataField">foreas_latin_name</property>
      <property name="Datasource">EditTableDs</property>
      <property name="Height">21</property>
      <property name="Left">234</property>
      <property name="Name">foreas_latin_name</property>
      <property name="Top">771</property>
      <property name="Width">509</property>
      <property name="OnBeforeShow">field_nameBeforeShow</property>
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
      <property name="Height">13</property>
      <property name="Left">768</property>
      <property name="Name">Label17</property>
      <property name="ParentColor">0</property>
      <property name="Top">2</property>
      <property name="Width">10</property>
      <property name="OnBeforeShow">Label17BeforeShow</property>
      <property name="jsOnClick">Label17JSClick</property>
    </object>
    <object class="Label" name="LineLabel" >
      <property name="Caption">line label</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Height">14</property>
      <property name="Left">6</property>
      <property name="Name">LineLabel</property>
      <property name="Top">2</property>
      <property name="Width">608</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
    </object>
    <object class="Label" name="editLabel" >
      <property name="Caption"><![CDATA[[Επεξεργασία]]]></property>
      <property name="Height">13</property>
      <property name="Left">684</property>
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
    <property name="Caption"><![CDATA[Εμφάνιση]]></property>
    <property name="Height">25</property>
    <property name="Left">615</property>
    <property name="Name">Button_searchterms</property>
    <property name="Top">35</property>
    <property name="Width">75</property>
  </object>
  <object class="Label" name="Label_searchterms" >
    <property name="Caption"><![CDATA[Μπορείτε να αναζητήσετε τους φορεις που χρησιμοποιούν την εφαρμογή εδώ :]]></property>
    <property name="Height">13</property>
    <property name="Left">354</property>
    <property name="Name">Label_searchterms</property>
    <property name="Top">53</property>
    <property name="Width">430</property>
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
        <property name="Top">183</property>
    <property name="Dataset">apAuth.oda_masterTable</property>
    <property name="Name">dsRepeater</property>
  </object>
  <object class="Datasource" name="EditTableDs" >
        <property name="Left">643</property>
        <property name="Top">183</property>
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
    <property name="TableName">oda_members_master</property>
  </object>
</object>
?>
