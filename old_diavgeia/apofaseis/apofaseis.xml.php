<?php
<object class="Apofaseis_Ypourgeiou" name="Apofaseis_Ypourgeiou" baseclass="page">
  <property name="Background"></property>
  <property name="Cached">Z</property>
  <property name="Caption"><![CDATA[Αποφάσεις]]></property>
  <property name="DocType">dtNone</property>
  <property name="Encoding">Unicode (UTF-8)            |utf-8</property>
  <property name="Height">1528</property>
  <property name="IsMaster">0</property>
  <property name="Name">Apofaseis_Ypourgeiou</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">apofaseis.htm</property>
  <property name="Width">1000</property>
  <property name="OnBeforeShow">Apofaseis_YpourgeiouBeforeShow</property>
  <property name="OnCreate">Apofaseis_YpourgeiouCreate</property>
  <object class="Label" name="Label2" >
    <property name="Caption"><![CDATA[<P><STRONG>Logged in as</STRONG></P>]]></property>
    <property name="Height">30</property>
    <property name="Left">16</property>
    <property name="Name">Label2</property>
    <property name="Top">16</property>
    <property name="Width">975</property>
  </object>
  <object class="Label" name="LogoutLabel" >
    <property name="Caption">Logout</property>
    <property name="Height">13</property>
    <property name="Left">16</property>
    <property name="Link">login.php?restore_session=1</property>
    <property name="Name">LogoutLabel</property>
    <property name="Top">64</property>
    <property name="Width">75</property>
  </object>
  <object class="Edit" name="field_arithmos_protokolou" >
    <property name="Height">21</property>
    <property name="Left">146</property>
    <property name="Name">field_arithmos_protokolou</property>
    <property name="Top">88</property>
    <property name="Width">297</property>
  </object>
  <object class="Label" name="Label_arithmos_protokolou" >
    <property name="Caption"><![CDATA[<h3>Αριθμός πρωτοκόλλου του εγγράφου (*)</h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">146</property>
    <property name="Name">Label_arithmos_protokolou</property>
    <property name="Top">64</property>
    <property name="Width">251</property>
  </object>
  <object class="ComboBox" name="field_level5_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level5";}</property>
    <property name="Left">145</property>
    <property name="Name">field_level5_text</property>
    <property name="Top">217</property>
    <property name="Width">816</property>
    <property name="jsOnChange">field_level5_textJSChange</property>
  </object>
  <object class="Label" name="Label_foreas_ekdosis" >
    <property name="Caption"><![CDATA[<h3>Φορέας έκδοσης</h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">143</property>
    <property name="Name">Label_foreas_ekdosis</property>
    <property name="Top">375</property>
    <property name="Width">107</property>
  </object>
  <object class="Memo" name="field_koinapoiiseis" >
    <property name="Height">185</property>
    <property name="Left">144</property>
    <property name="Lines">a:0:{}</property>
    <property name="Name">field_koinapoiiseis</property>
    <property name="Top">504</property>
    <property name="Width">818</property>
  </object>
  <object class="Label" name="Label_koinapoiiseis" >
    <property name="Caption"><![CDATA[Κοινοποιήσεις]]></property>
    <property name="Height">13</property>
    <property name="Left">143</property>
    <property name="Name">Label_koinapoiiseis</property>
    <property name="Top">486</property>
    <property name="Width">139</property>
  </object>
  <object class="ComboBox" name="field_eidos_apofasis" >
    <property name="Height">18</property>
    <property name="Items"><![CDATA[a:1:{i:1;s:8:"Απόφαση1";}]]></property>
    <property name="Left">144</property>
    <property name="Name">field_eidos_apofasis</property>
    <property name="Top">976</property>
    <property name="Width">817</property>
    <property name="jsOnChange">field_eidos_apofasisJSChange</property>
  </object>
  <object class="Label" name="Label_eidos_apofasis" >
    <property name="Caption"><![CDATA[<h3>Eιδος Πράξης (*)</h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">145</property>
    <property name="Name">Label_eidos_apofasis</property>
    <property name="Top">958</property>
    <property name="Width">139</property>
  </object>
  <object class="Upload" name="field_file" >
    <property name="Accept">*.pdf</property>
    <property name="Height">21</property>
    <property name="Left">144</property>
    <property name="Name">field_file</property>
    <property name="Top">1024</property>
    <property name="Width">553</property>
  </object>
  <object class="Label" name="Label_file" >
    <property name="Caption"><![CDATA[<h3>Επιλέξτε το αρχείο της πράξης σε μορφή pdf (*) </h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">144</property>
    <property name="Name">Label_file</property>
    <property name="Top">1006</property>
    <property name="Width">259</property>
  </object>
  <object class="Button" name="SubmitButton" >
    <property name="Caption"><![CDATA[Υποβολή]]></property>
    <property name="Height">25</property>
    <property name="Left">632</property>
    <property name="Name">SubmitButton</property>
    <property name="Top">1070</property>
    <property name="Width">75</property>
    <property name="jsOnClick">SubmitButtonJSClick</property>
  </object>
  <object class="Memo" name="Memo1" >
    <property name="Height">61</property>
    <property name="Left">473</property>
    <property name="Lines">a:0:{}</property>
    <property name="Name">Memo1</property>
    <property name="Top">48</property>
    <property name="Width">321</property>
  </object>
  <object class="Label" name="Label_debug_messages" >
    <property name="Caption">Debug Messages</property>
    <property name="Height">13</property>
    <property name="Left">809</property>
    <property name="Name">Label_debug_messages</property>
    <property name="Top">72</property>
    <property name="Width">131</property>
  </object>
  <object class="Label" name="Label_tags" >
    <property name="Caption"><![CDATA[Ετικέτες]]></property>
    <property name="Height">13</property>
    <property name="Left">145</property>
    <property name="Name">Label_tags</property>
    <property name="Top">910</property>
    <property name="Width">67</property>
  </object>
  <object class="Edit" name="field_tags" >
    <property name="Height">21</property>
    <property name="Left">144</property>
    <property name="Name">field_tags</property>
    <property name="Top">928</property>
    <property name="Width">817</property>
  </object>
  <object class="Label" name="Label_thematiki" >
    <property name="Caption"><![CDATA[<h3>Eφόσον το αντικείμενο της πράξης είναι σχετικό με κάποιο θεμα, μπορείτε να επιλέξετε μια θεματική περιοχή</h3><br><i></i>]]></property>
    <property name="Height">29</property>
    <property name="Left">147</property>
    <property name="Name">Label_thematiki</property>
    <property name="Top">854</property>
    <property name="Width">487</property>
  </object>
  <object class="ComboBox" name="field_thematiki_enotita" >
    <property name="Height">18</property>
    <property name="Items"><![CDATA[a:1:{i:1;s:8:"Απόφαση1";}]]></property>
    <property name="Left">143</property>
    <property name="Name">field_thematiki_enotita</property>
    <property name="Top">712</property>
    <property name="Width">738</property>
  </object>
  <object class="Memo" name="field_thema" >
    <property name="Height">65</property>
    <property name="Left">145</property>
    <property name="Lines">a:0:{}</property>
    <property name="MaxLength">5000</property>
    <property name="Name">field_thema</property>
    <property name="Top">408</property>
    <property name="Width">817</property>
  </object>
  <object class="Label" name="Label_thema" >
    <property name="Caption"><![CDATA[<h3>Θέμα ή τίτλος Εγγράφου</h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">144</property>
    <property name="Name">Label_thema</property>
    <property name="Top">390</property>
    <property name="Width">139</property>
  </object>
  <object class="ComboBox" name="field_level2_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level2";}</property>
    <property name="Left">145</property>
    <property name="Name">field_level2_text</property>
    <property name="Top">145</property>
    <property name="Width">816</property>
    <property name="jsOnChange">field_level2_textJSChange</property>
  </object>
  <object class="ComboBox" name="field_level3_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level3";}</property>
    <property name="Left">145</property>
    <property name="Name">field_level3_text</property>
    <property name="Top">169</property>
    <property name="Width">816</property>
    <property name="jsOnChange">field_level3_textJSChange</property>
  </object>
  <object class="ComboBox" name="field_level4_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level4";}</property>
    <property name="Left">145</property>
    <property name="Name">field_level4_text</property>
    <property name="Top">193</property>
    <property name="Width">816</property>
    <property name="jsOnChange">field_level4_textJSChange</property>
  </object>
  <object class="ComboBox" name="field_level1_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level1";}</property>
    <property name="Left">146</property>
    <property name="Name">field_level1_text</property>
    <property name="Top">121</property>
    <property name="Width">816</property>
  </object>
  <object class="Label" name="Label_apofasi_date" >
    <property name="Caption"><![CDATA[<h3><h3>Ημερομηνία έκδοσης (*)</h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">404</property>
    <property name="Name">Label_apofasi_date</property>
    <property name="Top">375</property>
    <property name="Width">147</property>
  </object>
  <object class="DateTimePicker" name="field_apofasi_date" >
    <property name="Caption">field_apofasi_date</property>
    <property name="Height">17</property>
    <property name="IfFormat">%Y-%m-%d</property>
    <property name="Left">404</property>
    <property name="Name">field_apofasi_date</property>
    <property name="ShowsTime">0</property>
    <property name="TimeZone">Europe/Athens</property>
    <property name="Top">386</property>
    <property name="Width">200</property>
  </object>
  <object class="ListBox" name="field_thematiki_enotita_values" >
    <property name="Height">80</property>
    <property name="Items">a:0:{}</property>
    <property name="Left">147</property>
    <property name="Name">field_thematiki_enotita_values</property>
    <property name="Top">744</property>
    <property name="Width">810</property>
  </object>
  <object class="Button" name="thematikesAddButton" >
    <property name="ButtonType">btNormal</property>
    <property name="Caption"><![CDATA[Προσθήκη]]></property>
    <property name="Height">25</property>
    <property name="Left">882</property>
    <property name="Name">thematikesAddButton</property>
    <property name="Top">708</property>
    <property name="Width">75</property>
    <property name="jsOnClick">thematikesAddButtonJSClick</property>
  </object>
  <object class="Button" name="thematikesRemoveButton" >
    <property name="ButtonType">btNormal</property>
    <property name="Caption"><![CDATA[Ακύρωση επιλογής θεματικής ενότητας]]></property>
    <property name="Height">25</property>
    <property name="Left">16</property>
    <property name="Name">thematikesRemoveButton</property>
    <property name="Top">787</property>
    <property name="Width">163</property>
    <property name="jsOnClick">thematikesRemoveButtonJSClick</property>
  </object>
  <object class="HiddenField" name="field_thematiki_enotita_values_text" >
    <property name="Height">18</property>
    <property name="Left">24</property>
    <property name="Name">field_thematiki_enotita_values_text</property>
    <property name="Top">832</property>
    <property name="Width">200</property>
  </object>
  <object class="Panel" name="ExtraFieldsContainer" >
    <property name="Height"></property>
    <property name="Left">124</property>
    <property name="Name">ExtraFieldsContainer</property>
    <property name="Top">1056</property>
    <property name="Width">816</property>
  </object>
  <object class="ComboBox" name="field_telikos_ypografwn" >
    <property name="Height">18</property>
    <property name="Items">a:2:{i:1;s:8:"Ypourgos";s:0:"";s:0:"";}</property>
    <property name="Left">144</property>
    <property name="Name">field_telikos_ypografwn</property>
    <property name="Top">1144</property>
    <property name="Width">817</property>
  </object>
  <object class="Label" name="Label_telikos_ypografwn" >
    <property name="Caption"><![CDATA[<h3>Τελικός Υπογράφων της πράξης (*)</h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">145</property>
    <property name="Name">Label_telikos_ypografwn</property>
    <property name="Top">1126</property>
    <property name="Width">227</property>
  </object>
  <object class="Edit" name="field_old_ada" >
    <property name="Height">21</property>
    <property name="Left">145</property>
    <property name="Name">field_old_ada</property>
    <property name="Top">1192</property>
    <property name="Width">225</property>
    <property name="jsOnBlur">field_old_adaJSBlur</property>
  </object>
  <object class="Label" name="field_old_ada_message" >
    <property name="Height">13</property>
    <property name="Left">552</property>
    <property name="Name">field_old_ada_message</property>
    <property name="ParentColor">0</property>
    <property name="ParentFont">0</property>
    <property name="Top">1192</property>
    <property name="Width">179</property>
  </object>
  <object class="CheckBox" name="field_is_orthi_epanalipsi" >
    <property name="Caption"><![CDATA[EINAI OΡΘΗ ΕΠΑΝΑΛΗΨΗ ΑΛΛΗΣ ΑΠΟΦΑΣΗΣ]]></property>
    <property name="Height">21</property>
    <property name="Left">144</property>
    <property name="Name">field_is_orthi_epanalipsi</property>
    <property name="Top">1216</property>
    <property name="Width">563</property>
    <property name="jsOnChange">field_is_orthi_epanalipsiJSChange</property>
  </object>
  <object class="Label" name="Label_old_ada" >
    <property name="Caption"><![CDATA[Συμπληρώστε τον ΑΔΑ Προηγούμενης Απόφασης]]></property>
    <property name="Height">13</property>
    <property name="Left">143</property>
    <property name="Name">Label_old_ada</property>
    <property name="Top">1174</property>
    <property name="Width">403</property>
  </object>
  <object class="Panel" name="is_orthi_epanalipsi_container" >
    <property name="Height">10</property>
    <property name="Left">124</property>
    <property name="Name">is_orthi_epanalipsi_container</property>
    <property name="Top">1240</property>
    <property name="Width">816</property>
  </object>
  <object class="Edit" name="field_FEK" >
    <property name="Height">21</property>
    <property name="Left">11</property>
    <property name="Name">field_FEK</property>
    <property name="Top">1274</property>
    <property name="Width">225</property>
  </object>
  <object class="Label" name="Label_FEK" >
    <property name="Caption"><![CDATA[Αν η προς ανάρτηση πράξη έχει συμπεριληφθεί σε ΦΕΚ, παρακαλούμε συμπληρώστε τα παρακάτω τρία πεδία]]></property>
    <property name="Height">13</property>
    <property name="Left">16</property>
    <property name="Name">Label_FEK</property>
    <property name="Top">1256</property>
    <property name="Width">803</property>
  </object>
  <object class="ComboBox" name="field_level6_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level6";}</property>
    <property name="Left">145</property>
    <property name="Name">field_level6_text</property>
    <property name="Top">241</property>
    <property name="Width">816</property>
    <property name="jsOnChange">field_level6_textJSChange</property>
  </object>
  <object class="ComboBox" name="field_level7_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level7";}</property>
    <property name="Left">146</property>
    <property name="Name">field_level7_text</property>
    <property name="Top">265</property>
    <property name="Width">816</property>
    <property name="jsOnChange">field_level7_textJSChange</property>
  </object>
  <object class="ComboBox" name="field_level8_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:6:"level8";}</property>
    <property name="Left">147</property>
    <property name="Name">field_level8_text</property>
    <property name="Top">289</property>
    <property name="Width">816</property>
  </object>
  <object class="HiddenField" name="isEditForm_h" >
    <property name="Height">18</property>
    <property name="Left">704</property>
    <property name="Name">isEditForm_h</property>
    <property name="Top">1074</property>
    <property name="Width">200</property>
  </object>
  <object class="HiddenField" name="isEditForm_ada" >
    <property name="Height">18</property>
    <property name="Left">704</property>
    <property name="Name">isEditForm_ada</property>
    <property name="Top">1098</property>
    <property name="Width">200</property>
  </object>
  <object class="Edit" name="field_syntaktis_email" >
    <property name="Height">21</property>
    <property name="Left">80</property>
    <property name="Name">field_syntaktis_email</property>
    <property name="Top">1394</property>
    <property name="Width">297</property>
  </object>
  <object class="Label" name="Label_syntaktis_email" >
    <property name="Caption"><![CDATA[<h3>Στοιχεία email εισηγητή </h3> </i>]]></property>
    <property name="Height">30</property>
    <property name="Left">80</property>
    <property name="Name">Label_syntaktis_email</property>
    <property name="Top">1352</property>
    <property name="Width">715</property>
  </object>
  <object class="Edit" name="js_thematiki" >
    <property name="Height">21</property>
    <property name="Left">80</property>
    <property name="Name">js_thematiki</property>
    <property name="Top">1434</property>
    <property name="Width">297</property>
  </object>
  <object class="Edit" name="field_related_ADAs" >
    <property name="Height">21</property>
    <property name="Left">448</property>
    <property name="Name">field_related_ADAs</property>
    <property name="Top">1442</property>
    <property name="Width">297</property>
  </object>
  <object class="Label" name="Label_related_ADAs" >
    <property name="Caption"><![CDATA[Συμπληρώστε τους ΑΔΑ προηγούμενων αποφάσεων, οι οποίες συσχετίζονται
με την τρέχουσα (προαιρ)<br><i>* Συμπληρώστε τους χωρισμένους με κόμμα</i>]]></property>
    <property name="Height">30</property>
    <property name="Left">400</property>
    <property name="Name">Label_related_ADAs</property>
    <property name="Top">1400</property>
    <property name="Width">591</property>
  </object>
  <object class="Label" name="Label_FEK_FEK" >
    <property name="Caption"><![CDATA[Αριθμός ΦΕΚ]]></property>
    <property name="Height">13</property>
    <property name="Left">253</property>
    <property name="Name">Label_FEK_FEK</property>
    <property name="Top">1278</property>
    <property name="Width">110</property>
  </object>
  <object class="Label" name="Label_FEK_tefxos" >
    <property name="Caption"><![CDATA[Τεύχος]]></property>
    <property name="Height">13</property>
    <property name="Left">253</property>
    <property name="Name">Label_FEK_tefxos</property>
    <property name="Top">1302</property>
    <property name="Width">382</property>
  </object>
  <object class="Label" name="Label_FEK_etos" >
    <property name="Caption"><![CDATA[Έτος]]></property>
    <property name="Height">13</property>
    <property name="Left">253</property>
    <property name="Name">Label_FEK_etos</property>
    <property name="Top">1326</property>
    <property name="Width">382</property>
  </object>
  <object class="ComboBox" name="field_FEK_tefxos" >
    <property name="Height">18</property>
    <property name="Items"><![CDATA[a:13:{i:0;s:0:"";i:1;s:1:"Α";i:2;s:1:"Β";i:3;s:1:"Γ";i:4;s:1:"Δ";i:8;s:8:"Δ.Ε.Β.Ι.";i:9;s:7:"Α.ΕΙ.Δ.";i:10;s:8:"Α.Σ.Ε.Π.";i:11;s:6:"ΑΕ-EΠΕ";i:12;s:6:"Δ.Δ.Σ.";i:13;s:6:"Ο.Π.Κ.";i:14;s:8:"Υ.Ο.Δ.Δ.";i:15;s:6:"Α.Α.Π.";}]]></property>
    <property name="Left">11</property>
    <property name="Name">field_FEK_tefxos</property>
    <property name="Top">1299</property>
    <property name="Width">225</property>
  </object>
  <object class="ComboBox" name="field_FEK_etos" >
    <property name="Height">18</property>
    <property name="Items">a:12:{i:0;s:0:"";i:2010;s:4:"2010";i:2011;s:4:"2011";i:2012;s:4:"2012";i:2013;s:4:"2013";i:2014;s:4:"2014";i:2015;s:4:"2015";i:2016;s:4:"2016";i:2017;s:4:"2017";i:2018;s:4:"2018";i:2019;s:4:"2019";i:2020;s:4:"2020";}</property>
    <property name="Left">11</property>
    <property name="Name">field_FEK_etos</property>
    <property name="Top">1326</property>
    <property name="Width">225</property>
  </object>
  <object class="Label" name="Label_UserMessages" >
    <property name="Caption">Label_UserMessages</property>
    <property name="Font">
        <property name="Color">#FF0000</property>
    </property>
    <property name="Height">13</property>
    <property name="Left">80</property>
    <property name="Name">Label_UserMessages</property>
    <property name="ParentColor">0</property>
    <property name="ParentFont">0</property>
    <property name="Top">1472</property>
    <property name="Width">819</property>
  </object>
  <object class="ComboBox" name="field_monades_text" >
    <property name="Height">18</property>
    <property name="Items">a:1:{i:1;s:7:"monades";}</property>
    <property name="Left">147</property>
    <property name="Name">field_monades_text</property>
    <property name="Top">321</property>
    <property name="Width">816</property>
    <property name="jsOnChange">field_monades_textJSChange</property>
  </object>
  <object class="Label" name="Label_monada" >
    <property name="Caption"><![CDATA[<h3>Oργανική Μονάδα ή διοικητική δομή</h3>]]></property>
    <property name="Height">13</property>
    <property name="Left">143</property>
    <property name="Name">Label_monada</property>
    <property name="Top">343</property>
    <property name="Width">445</property>
  </object>
  <object class="FormValidator" name="FormValidator1" >
        <property name="Left">90</property>
        <property name="Top">114</property>
    <property name="Name">FormValidator1</property>
    <property name="Rules"><![CDATA[a:6:{i:0;a:12:{s:7:"Control";s:25:"field_arithmos_protokolou";s:6:"Equals";s:0:"";s:12:"ErrorMessage";s:52:"Παρακαλούμε συμπληρώστε το πεδίο: Αριθμός πρωτοκόλου";s:9:"FieldName";s:18:"Αριθμός πρωτοκόλου";s:9:"MaxLength";s:1:"0";s:8:"MaxValue";s:1:"0";s:9:"MinLength";s:1:"0";s:8:"MinValue";s:1:"0";s:4:"Name";s:39:"ValidationRulefield_arithmos_protokolou";s:8:"Required";s:4:"true";s:14:"ValidationType";s:0:"";s:10:"OnValidate";s:0:"";}i:1;a:12:{s:7:"Control";s:20:"field_eidos_apofasis";s:6:"Equals";s:0:"";s:12:"ErrorMessage";s:39:"Παρακαλούμε επιλέξτε ένα Είδος απόφασης";s:9:"FieldName";s:14:"Είδος απόφασης";s:9:"MaxLength";s:1:"0";s:8:"MaxValue";s:1:"0";s:9:"MinLength";s:1:"0";s:8:"MinValue";s:1:"0";s:4:"Name";s:34:"ValidationRulefield_eidos_apofasis";s:8:"Required";s:4:"true";s:14:"ValidationType";s:0:"";s:10:"OnValidate";s:0:"";}i:2;a:12:{s:7:"Control";s:10:"field_file";s:6:"Equals";s:0:"";s:12:"ErrorMessage";s:31:"Παρακαλούμε επιλέξτε ένα αρχείο";s:9:"FieldName";s:15:"Επιλογή αρχείου";s:9:"MaxLength";s:1:"0";s:8:"MaxValue";s:1:"0";s:9:"MinLength";s:1:"0";s:8:"MinValue";s:1:"0";s:4:"Name";s:24:"ValidationRulefield_file";s:8:"Required";s:4:"true";s:14:"ValidationType";s:0:"";s:10:"OnValidate";s:0:"";}i:3;a:12:{s:7:"Control";s:18:"field_apofasi_date";s:6:"Equals";s:0:"";s:12:"ErrorMessage";s:52:"Παρακαλούμε συμπληρώστε το πεδίο: Ημερομηνία έκδοσης";s:9:"FieldName";s:18:"Ημερομηνία έκδοσης";s:9:"MaxLength";s:1:"0";s:8:"MaxValue";s:1:"0";s:9:"MinLength";s:1:"0";s:8:"MinValue";s:1:"0";s:4:"Name";s:32:"ValidationRulefield_apofasi_date";s:8:"Required";s:4:"true";s:14:"ValidationType";s:0:"";s:10:"OnValidate";s:0:"";}i:4;a:12:{s:7:"Control";s:11:"field_thema";s:6:"Equals";s:0:"";s:12:"ErrorMessage";s:38:"Παρακαλούμε συμπληρώστε το πεδίο: Θέμα";s:9:"FieldName";s:4:"Θέμα";s:9:"MaxLength";s:1:"0";s:8:"MaxValue";s:1:"0";s:9:"MinLength";s:1:"0";s:8:"MinValue";s:1:"0";s:4:"Name";s:25:"ValidationRulefield_thema";s:8:"Required";s:4:"true";s:14:"ValidationType";s:0:"";s:10:"OnValidate";s:0:"";}i:5;a:12:{s:7:"Control";s:21:"field_syntaktis_email";s:6:"Equals";s:0:"";s:12:"ErrorMessage";s:49:"Παρακαλούμε συμπληρώστε το πεδίο: E-mail Συντάκτη";s:9:"FieldName";s:15:"E-mail Συντάκτη";s:9:"MaxLength";s:1:"0";s:8:"MaxValue";s:1:"0";s:9:"MinLength";s:1:"0";s:8:"MinValue";s:1:"0";s:4:"Name";s:28:"ValidationRuleEmail_syntakti";s:8:"Required";s:4:"true";s:14:"ValidationType";s:0:"";s:10:"OnValidate";s:0:"";}}]]></property>
    <property name="ValidateCompleteForm">0</property>
  </object>
</object>
?>
