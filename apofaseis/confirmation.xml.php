<?php
<object class="confirmationForm" name="confirmationForm" baseclass="page">
  <property name="Background"></property>
  <property name="Caption"><![CDATA[Επιβεβαίωση Υποβολής]]></property>
  <property name="DocType">dtNone</property>
  <property name="Encoding">Unicode (UTF-8)            |utf-8</property>
  <property name="Height">1136</property>
  <property name="IsMaster">0</property>
  <property name="Name">confirmationForm</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">confirmation.htm</property>
  <property name="Width">1000</property>
  <property name="OnBeforeShow">confirmationFormBeforeShow</property>
  <property name="OnCreate">confirmationFormCreate</property>
  <object class="Button" name="ButtonSubmit" >
    <property name="Caption"><![CDATA[Τελική Επιβεβαίωση και Υποβολή]]></property>
    <property name="Height">25</property>
    <property name="Left">248</property>
    <property name="Name">ButtonSubmit</property>
    <property name="Top">452</property>
    <property name="Width">203</property>
    <property name="jsOnClick">ButtonSubmitJSClick</property>
  </object>
  <object class="Label" name="LogoutLabel" >
    <property name="Caption">Logout</property>
    <property name="Height">13</property>
    <property name="Left">16</property>
    <property name="Link">login.php?restore_session=1</property>
    <property name="Name">LogoutLabel</property>
    <property name="Top">32</property>
    <property name="Width">75</property>
  </object>
  <object class="Label" name="Label2" >
    <property name="Caption"><![CDATA[<P><STRONG>Logged in as</STRONG></P>]]></property>
    <property name="Height">13</property>
    <property name="Left">16</property>
    <property name="Name">Label2</property>
    <property name="Top">16</property>
    <property name="Width">347</property>
  </object>
  <object class="HiddenField" name="id" >
    <property name="Height">18</property>
    <property name="Left">769</property>
    <property name="Name">id</property>
    <property name="Top">39</property>
    <property name="Width">159</property>
  </object>
  <object class="HiddenField" name="form_action" >
    <property name="Height">18</property>
    <property name="Left">769</property>
    <property name="Name">form_action</property>
    <property name="Top">16</property>
    <property name="Width">159</property>
  </object>
  <object class="Label" name="LabelCancel" >
    <property name="Caption"><![CDATA[Ακύρωση και επιστροφή]]></property>
    <property name="Height">13</property>
    <property name="Left">280</property>
    <property name="Name">LabelCancel</property>
    <property name="Top">424</property>
    <property name="Width">179</property>
  </object>
  <object class="Label" name="Label_ada" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_ada</property>
    <property name="Top">112</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_prot" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_prot</property>
    <property name="Top">136</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_date" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_date</property>
    <property name="Top">160</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_koin" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_koin</property>
    <property name="Top">184</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_eidos_apofasis" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_eidos_apofasis</property>
    <property name="Top">208</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_stoixeia" >
    <property name="Caption">Label_stoixeia</property>
    <property name="Height">117</property>
    <property name="Left">128</property>
    <property name="Name">Label_stoixeia</property>
    <property name="Top">296</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_user" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_user</property>
    <property name="Top">264</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_telikos_ypografwn" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_telikos_ypografwn</property>
    <property name="Top">232</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="Label_thema" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">128</property>
    <property name="Name">Label_thema</property>
    <property name="Top">88</property>
    <property name="Width">531</property>
  </object>
  <object class="Label" name="LabelBack" >
    <property name="Caption"><![CDATA[<-- Πίσω]]></property>
    <property name="Height">13</property>
    <property name="Left">496</property>
    <property name="Name">LabelBack</property>
    <property name="Top">424</property>
    <property name="Width">179</property>
  </object>
  <object class="Label" name="Label_syntaktis_email" >
    <property name="Caption">Label_ada</property>
    <property name="Height">21</property>
    <property name="Left">144</property>
    <property name="Name">Label_syntaktis_email</property>
    <property name="Top">496</property>
    <property name="Width">323</property>
  </object>
  <object class="FormValidator" name="FormValidator1" >
        <property name="Left">642</property>
        <property name="Top">18</property>
    <property name="Name">FormValidator1</property>
    <property name="Rules"><![CDATA[a:1:{i:0;a:12:{s:7:"Control";s:14:"confirmationCB";s:6:"Equals";s:0:"";s:12:"ErrorMessage";s:45:"Παρακαλούμε συμπληρώστε το πεδίο: Επιβεβαίωση";s:9:"FieldName";s:11:"Επιβεβαίωση";s:9:"MaxLength";s:1:"0";s:8:"MaxValue";s:1:"0";s:9:"MinLength";s:1:"0";s:8:"MinValue";s:1:"0";s:4:"Name";s:15:"ValidationRule1";s:8:"Required";s:4:"true";s:14:"ValidationType";s:0:"";s:10:"OnValidate";s:0:"";}}]]></property>
    <property name="ValidateCompleteForm">0</property>
  </object>
</object>
?>
