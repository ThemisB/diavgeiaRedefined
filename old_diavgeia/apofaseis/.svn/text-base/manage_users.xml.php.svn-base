<?php
<object class="manage_users" name="manage_users" baseclass="page">
  <property name="Background"></property>
  <property name="Caption"><![CDATA[Διαχείριση Χρηστών]]></property>
  <property name="DocType">dtNone</property>
  <property name="Encoding">Unicode (UTF-8)            |utf-8</property>
  <property name="Height">752</property>
  <property name="IsMaster">0</property>
  <property name="Layout">
    <property name="Type">XY_LAYOUT</property>
  </property>
  <property name="Name">manage_users</property>
  <property name="TemplateEngine">SmartyTemplate</property>
  <property name="TemplateFilename">manage_users.htm</property>
  <property name="Width">944</property>
  <property name="OnBeforeShow">manage_usersBeforeShow</property>
  <property name="OnCreate">manage_usersCreate</property>
  <object class="Panel" name="Panel1" >
    <property name="BorderColor">#0000A0</property>
    <property name="BorderWidth">2</property>
    <property name="Dynamic"></property>
    <property name="Height">608</property>
    <property name="Layout">
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">4</property>
    <property name="Name">Panel1</property>
    <property name="Top">136</property>
    <property name="Visible">0</property>
    <property name="Width">776</property>
    <property name="OnAfterShow">Panel1AfterShow</property>
    <object class="Button" name="btnPost" >
      <property name="Caption"><![CDATA[Αποθήκευση]]></property>
      <property name="Height">25</property>
      <property name="Left">347</property>
      <property name="Name">btnPost</property>
      <property name="Top">568</property>
      <property name="Width">99</property>
      <property name="OnClick">btnPostClick</property>
      <property name="jsOnClick">btnUpdateJSClick</property>
    </object>
    <object class="Edit" name="username" >
      <property name="DataField">username</property>
      <property name="Datasource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="Left">161</property>
      <property name="Name">username</property>
      <property name="Top">37</property>
      <property name="Width">180</property>
      <property name="OnBeforeShow">usernameBeforeShow</property>
    </object>
    <object class="Label" name="Label4" >
      <property name="Caption"><![CDATA[Χρήστης (Username):]]></property>
      <property name="Height">13</property>
      <property name="Left">24</property>
      <property name="Name">Label4</property>
      <property name="Top">45</property>
      <property name="Width">126</property>
    </object>
    <object class="Label" name="Label14" >
      <property name="Caption"><![CDATA[Ενημέρωση Χρήστη:]]></property>
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
    <object class="Label" name="Label5" >
      <property name="Caption"><![CDATA[Κωδικός (Password):]]></property>
      <property name="Height">13</property>
      <property name="Left">24</property>
      <property name="Name">Label5</property>
      <property name="Top">77</property>
      <property name="Width">132</property>
    </object>
    <object class="Edit" name="password" >
      <property name="DataSource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="IsPassword">1</property>
      <property name="Left">161</property>
      <property name="MaxLength">12</property>
      <property name="Name">password</property>
      <property name="Top">69</property>
      <property name="Width">180</property>
      <property name="jsOnBlur">passwordJSBlur</property>
    </object>
    <object class="Label" name="Label6" >
      <property name="Caption"><![CDATA[Ρόλος (Role):]]></property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label6</property>
      <property name="Top">153</property>
      <property name="Width">75</property>
    </object>
   /* <object class="Label" name="Label8" >
      <property name="Caption"><![CDATA[Φορέας Έκδοσης:]]></property>
      <property name="Height">13</property>
      <property name="Left">26</property>
      <property name="Name">Label8</property>
      <property name="Top">189</property>
      <property name="Width">132</property>
    </object>
    */
    <object class="Edit" name="firstname" >
      <property name="DataField">firstname</property>
      <property name="Datasource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="Left">161</property>
      <property name="Name">firstname</property>
      <property name="Top">401</property>
      <property name="Width">256</property>
    </object>
    <object class="Label" name="Label9" >
      <property name="Caption"><![CDATA[Όνομα:]]></property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label9</property>
      <property name="Top">409</property>
      <property name="Width">75</property>
    </object>
    <object class="Edit" name="comments" >
      <property name="DataField">comments</property>
      <property name="Datasource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="Left">160</property>
      <property name="Name">comments</property>
      <property name="Top">533</property>
      <property name="Width">598</property>
    </object>
    <object class="Edit" name="lastname" >
      <property name="DataField">lastname</property>
      <property name="Datasource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="Left">161</property>
      <property name="Name">lastname</property>
      <property name="Top">437</property>
      <property name="Width">256</property>
    </object>
    <object class="Label" name="Label10" >
      <property name="Caption"><![CDATA[Επώνυμο:]]></property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label10</property>
      <property name="Top">441</property>
      <property name="Width">75</property>
    </object>
    <object class="Label" name="Label11" >
      <property name="Caption"><![CDATA[Σχόλια:]]></property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label11</property>
      <property name="Top">537</property>
      <property name="Width">75</property>
    </object>
    <object class="Button" name="btnUpdate" >
      <property name="Caption"><![CDATA[Ενημέρωση]]></property>
      <property name="Height">25</property>
      <property name="Left">359</property>
      <property name="Name">btnUpdate</property>
      <property name="Top">568</property>
      <property name="Width">75</property>
      <property name="OnClick">btnUpdateClick</property>
      <property name="jsOnClick">btnUpdateJSClick</property>
    </object>
    <object class="ComboBox" name="realm" >
      <property name="Height">18</property>
      <property name="ItemIndex">0</property>
      <property name="Items"><![CDATA[a:4:{i:1;s:20:"Γενικός Διαχειριστής";i:2;s:18:"Διαχειριστής Φορέα";i:3;s:13:"Χρήστης Φορέα";i:4;s:17:"Απενεργοποιημένος";}]]></property>
      <property name="Left">161</property>
      <property name="Name">realm</property>
      <property name="Top">153</property>
      <property name="Width">162</property>
    </object>
    <object class="Label" name="Label18" >
      <property name="Caption">E-mail:</property>
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">Label18</property>
      <property name="Top">473</property>
      <property name="Width">75</property>
    </object>
    <object class="Edit" name="email" >
      <property name="DataField">email</property>
      <property name="Datasource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="Left">161</property>
      <property name="Name">email</property>
      <property name="Top">469</property>
      <property name="Width">256</property>
    </object>
    <object class="HiddenField" name="ypourgeio_table" >
      <property name="Height">18</property>
      <property name="Left">560</property>
      <property name="Name">ypourgeio_table</property>
      <property name="Top">165</property>
      <property name="Width">200</property>
    </object>
    <object class="ListBox" name="field_results" >
      <property name="DataField">start_pb_id</property>
      <property name="DataSource">EditUsersTableDs</property>
      <property name="Height">106</property>
      <property name="Items">a:0:{}</property>
      <property name="Left">159</property>
      <property name="Name">field_results</property>
      <property name="Top">239</property>
      <property name="Width">599</property>
    </object>
    <object class="Edit" name="pb_id_value_label" >
      <property name="DataSource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="Left">159</property>
      <property name="Name">pb_id_value_label</property>
      <property name="ReadOnly">1</property>
      <property name="Top">181</property>
      <property name="Width">599</property>
    </object>
    <object class="Label" name="Label7" >
      <property name="Caption"><![CDATA[Αναζήτηση Φορέα:]]></property>
      <property name="Height">13</property>
      <property name="Left">24</property>
      <property name="Name">Label7</property>
      <property name="Top">213</property>
      <property name="Width">132</property>
    </object>
    <object class="Edit" name="field_search_terms" >
      <property name="Height">21</property>
      <property name="Left">159</property>
      <property name="Name">field_search_terms</property>
      <property name="Top">213</property>
      <property name="Width">267</property>
    </object>
    <object class="Button" name="Button_search" >
      <property name="ButtonType">btNormal</property>
      <property name="Caption"><![CDATA[Αναζήτηση]]></property>
      <property name="Height">25</property>
      <property name="Left">439</property>
      <property name="Name">Button_search</property>
      <property name="Top">207</property>
      <property name="Width">75</property>
      <property name="jsOnClick">Button_searchJSClick</property>
    </object>
    <object class="Button" name="Button2" >
      <property name="ButtonType">btNormal</property>
      <property name="Caption"><![CDATA[Ορισμός επιλεγμένου ως φορέα Χρήστη]]></property>
      <property name="Height">25</property>
      <property name="Left">159</property>
      <property name="Name">Button2</property>
      <property name="Top">359</property>
      <property name="Width">238</property>
      <property name="jsOnClick">Button2JSClick</property>
    </object>
    <object class="Label" name="Label3" >
      <property name="Caption"><![CDATA[<h3>Tηλέφωνο</h3>]]></property>
      <property name="Height">13</property>
      <property name="Left">24</property>
      <property name="Name">Label3</property>
      <property name="Top">505</property>
      <property name="Width">130</property>
    </object>
    <object class="Edit" name="telephone_yp" >
      <property name="DataField">telephone_yp</property>
      <property name="Datasource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="Left">161</property>
      <property name="Name">telephone_yp</property>
      <property name="Top">501</property>
      <property name="Width">256</property>
    </object>
    <object class="HiddenField" name="ID" >
      <property name="Height">18</property>
      <property name="Left">560</property>
      <property name="Name">ID</property>
      <property name="Top">144</property>
      <property name="Width">200</property>
    </object>
    <object class="HiddenField" name="pb_id" >
      <property name="Height">18</property>
      <property name="Left">564</property>
      <property name="Name">pb_id</property>
      <property name="Top">16</property>
      <property name="Width">200</property>
    </object>
    <object class="Edit" name="password_verification" >
      <property name="DataSource">EditUsersTableDs</property>
      <property name="Height">21</property>
      <property name="IsPassword">1</property>
      <property name="Left">510</property>
      <property name="MaxLength">12</property>
      <property name="Name">password_verification</property>
      <property name="Top">69</property>
      <property name="Width">180</property>
      <property name="jsOnBlur">passwordJSBlur</property>
    </object>
    <object class="Label" name="Label16" >
      <property name="Caption"><![CDATA[Επανάληψη Κωδικού:]]></property>
      <property name="Height">13</property>
      <property name="Left">376</property>
      <property name="Name">Label16</property>
      <property name="Top">77</property>
      <property name="Width">132</property>
    </object>
    <object class="Label" name="password_feedback" >
      <property name="Height">13</property>
      <property name="Left">25</property>
      <property name="Name">password_feedback</property>
      <property name="Top">104</property>
      <property name="Width">664</property>
      <property name="jsOnClick">passwordJSBlur</property>
    </object>
    <object class="HiddenField" name="user_id" >
      <property name="Height">18</property>
      <property name="Left">564</property>
      <property name="Name">user_id</property>
      <property name="Top">38</property>
      <property name="Width">200</property>
    </object>
    <object class="Label" name="Label21" >
      <property name="Caption"><![CDATA[<u>Ο κωδικός σας πρέπει να έχει μέγεθος τουλάχιστο 8 χαρακτήρες. Yποχρεωτικά θα πρέπει να περιλαμβάνεται ένα σύμβολο από τα:  !,@,#,$ και ένας αριθμός από το 0 έως το 9 . Οι χαρακτήρες θα  πρέπει να ειναι στα λατινικά</u>]]></property>
      <property name="Height">26</property>
      <property name="Left">35</property>
      <property name="Name">Label21</property>
      <property name="Top">117</property>
      <property name="Width">735</property>
    </object>
  </object>
  <object class="DBRepeater" name="DBRepeater1" >
    <property name="BorderColor">#000040</property>
    <property name="BorderWidth">1</property>
    <property name="DataSource">dsRepeater</property>
    <property name="Dynamic"></property>
    <property name="Height">38</property>
    <property name="Layout">
        <property name="Type">XY_LAYOUT</property>
    </property>
    <property name="Left">22</property>
    <property name="Limit">20</property>
    <property name="Name">DBRepeater1</property>
    <property name="RestartDataset">0</property>
    <property name="Top">69</property>
    <property name="Width">900</property>
    <object class="Label" name="fdClasses" >
      <property name="Caption">auth_username</property>
      <property name="DataField">username</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Font">
            <property name="Size">14px</property>
      </property>
      <property name="Height">14</property>
      <property name="Left">7</property>
      <property name="Name">fdClasses</property>
      <property name="ParentFont">0</property>
      <property name="Top">1</property>
      <property name="Width">135</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
    </object>
    <object class="Label" name="Label17" >
      <property name="Caption"><![CDATA[[Διαγραφή]]]></property>
      <property name="Font">
            <property name="Size">14px</property>
      </property>
      <property name="Height">13</property>
      <property name="Left">808</property>
      <property name="Name">Label17</property>
      <property name="ParentColor">0</property>
      <property name="ParentFont">0</property>
      <property name="Top">12</property>
      <property name="Width">92</property>
      <property name="OnBeforeShow">Label17BeforeShow</property>
      <property name="jsOnClick">Label17JSClick</property>
    </object>
    <object class="Label" name="Label12" >
      <property name="Caption">realm</property>
      <property name="DataField">realm</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Font">
            <property name="Size">14px</property>
      </property>
      <property name="Height">14</property>
      <property name="Left">148</property>
      <property name="Name">Label12</property>
      <property name="ParentFont">0</property>
      <property name="Top">1</property>
      <property name="Width">100</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
    </object>
    <object class="Label" name="Label13" >
      <property name="Caption">firstname</property>
      <property name="DataField">firstname</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Font">
            <property name="Size">14px</property>
      </property>
      <property name="Height">14</property>
      <property name="Left">250</property>
      <property name="Name">Label13</property>
      <property name="ParentFont">0</property>
      <property name="Top">1</property>
      <property name="Width">186</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
    </object>
    <object class="Label" name="Label15" >
      <property name="Caption">lastname</property>
      <property name="DataField">lastname</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Font">
            <property name="Size">14px</property>
      </property>
      <property name="Height">14</property>
      <property name="Left">250</property>
      <property name="Name">Label15</property>
      <property name="ParentFont">0</property>
      <property name="Top">17</property>
      <property name="Width">185</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
    </object>
    <object class="Label" name="Label19" >
      <property name="Caption">telephone_yp</property>
      <property name="DataField">telephone_yp</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Font">
            <property name="Size">14px</property>
      </property>
      <property name="Height">14</property>
      <property name="Left">562</property>
      <property name="Name">Label19</property>
      <property name="ParentFont">0</property>
      <property name="Top">1</property>
      <property name="Width">100</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
    </object>
    <object class="Label" name="Label20" >
      <property name="Caption">email</property>
      <property name="DataField">email</property>
      <property name="Datasource">dsRepeater</property>
      <property name="Font">
            <property name="Size">14px</property>
      </property>
      <property name="Height">14</property>
      <property name="Left">562</property>
      <property name="Name">Label20</property>
      <property name="ParentFont">0</property>
      <property name="Top">17</property>
      <property name="Width">234</property>
      <property name="OnBeforeShow">fdClassesBeforeShow</property>
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
    <property name="Caption"><![CDATA[Νέος Χρήστης]]></property>
    <property name="Height">25</property>
    <property name="Left">231</property>
    <property name="Name">btnAdd</property>
    <property name="Top">40</property>
    <property name="Width">93</property>
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
    <property name="Width">779</property>
  </object>
  <object class="Label" name="LogoutLabel" >
    <property name="Caption">Logout</property>
    <property name="Height">13</property>
    <property name="Left">17</property>
    <property name="Link">login.php?restore_session=1</property>
    <property name="Name">LogoutLabel</property>
    <property name="Top">46</property>
    <property name="Width">75</property>
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
  <object class="Edit" name="field_searchterms" >
    <property name="Height">21</property>
    <property name="Left">703</property>
    <property name="Name">field_searchterms</property>
    <property name="Top">31</property>
    <property name="Width">201</property>
  </object>
  <object class="Label" name="Label_searchterms" >
    <property name="Caption"><![CDATA[Αναζήτείστε πληκτρολογώντας στο παρακάτω πεδίο : <BR><EM>(username, όνομα, επώνυμο ή αφήστε το κενό για να σας εμφανίσει <BR>όλους τους χρήστες και πατήστε προβολή )</EM>]]></property>
    <property name="Height">42</property>
    <property name="Left">514</property>
    <property name="Name">Label_searchterms</property>
    <property name="ParentColor"><![CDATA[<P>Αναζήτείστε πληκτρολογώντας στο παρακάτω πεδίο :&nbsp; <BR><EM>(username, όνομα, επώνυμο ή αφήστε το κενό για να σας εμφανίσει <BR>όλους τους χρήστες και πατήστε προβολή)</EM></P>]]></property>
    <property name="Top">113</property>
    <property name="Width">411</property>
  </object>
  <object class="Button" name="Button_searchterms" >
    <property name="Caption"><![CDATA[Προβολή]]></property>
    <property name="Height">25</property>
    <property name="Left">784</property>
    <property name="Name">Button_searchterms</property>
    <property name="Top">34</property>
    <property name="Width">75</property>
  </object>
  <object class="Datasource" name="dsRepeater" >
        <property name="Left">382</property>
        <property name="Top">151</property>
    <property name="Dataset">apAuth.UserTable</property>
    <property name="Name">dsRepeater</property>
  </object>
  <object class="Datasource" name="EditUsersTableDs" >
        <property name="Left">459</property>
        <property name="Top">143</property>
    <property name="DataSet">EditUsersTable</property>
    <property name="Name">EditUsersTableDs</property>
  </object>
  <object class="MySQLTable" name="EditUsersTable" >
        <property name="Left">530</property>
        <property name="Top">154</property>
    <property name="Database">apAuth.DB_General</property>
    <property name="LimitCount">-1</property>
    <property name="LimitStart">-1</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">EditUsersTable</property>
    <property name="TableName">auth</property>
  </object>
</object>
?>
