<?php
<object class="apAuth" name="apAuth" baseclass="datamodule">
  <property name="Height">600</property>
  <property name="Name">apAuth</property>
  <property name="Width">800</property>
  <object class="ZAuth" name="ZAuth" >
        <property name="Left">144</property>
        <property name="Top">152</property>
    <property name="AuthAdapter">ZAuthDB1</property>
    <property name="Name">ZAuth</property>
    <property name="OnLogin">ZAuthLogin</property>
  </object>
  <object class="ZAuthDB" name="ZAuthDB1" >
        <property name="Left">208</property>
        <property name="Top">152</property>
    <property name="DatabaseName">apofaseis</property>
    <property name="DriverName">mysql</property>
    <property name="Host">localhost</property>
    <property name="Name">ZAuthDB1</property>
    <property name="PasswordFunction">MD5(CONCAT(MD5(?), 'stavsalt'))</property>
    <property name="UserName">root</property>
    <property name="UserNameFieldName">username</property>
    <property name="UserPassword">athena@opengov</property>
    <property name="UserPasswordFieldName">password</property>
    <property name="UserRealmFieldName">realm</property>
    <property name="UserTable">auth</property>
  </object>
  <object class="MySQLQuery" name="Query_General" >
        <property name="Left">33</property>
        <property name="Top">83</property>
    <property name="Active"></property>
    <property name="Database">DB_General</property>
    <property name="Name">Query_General</property>
    <property name="Params">a:0:{}</property>
    <property name="SQL">a:0:{}</property>
  </object>
  <object class="MySQLDatabase" name="DB_General" >
        <property name="Left">42</property>
        <property name="Top">21</property>
    <property name="DatabaseName">apofaseis</property>
    <property name="Dictionary"></property>
    <property name="Host">localhost</property>
    <property name="Name">DB_General</property>
    <property name="UserName">root</property>
    <property name="UserPassword">athena@opengov</property>
  </object>
  <object class="MySQLTable" name="UserTable" >
        <property name="Left">56</property>
        <property name="Top">158</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">UserTable</property>
    <property name="TableName">auth</property>
  </object>
  <object class="MySQLQuery" name="Query_General2" >
        <property name="Left">129</property>
        <property name="Top">83</property>
    <property name="Active"></property>
    <property name="Database">DB_General</property>
    <property name="Name">Query_General2</property>
    <property name="Params">a:0:{}</property>
    <property name="SQL">a:0:{}</property>
  </object>
  <object class="MySQLTable" name="YpografontesTable" >
        <property name="Left">48</property>
        <property name="Top">230</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">YpografontesTable</property>
    <property name="OrderField">type_id,lastname,firstname</property>
    <property name="TableName">ypografontes</property>
  </object>
  <object class="MySQLTable" name="MonadesTable" >
        <property name="Left">136</property>
        <property name="Top">230</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">MonadesTable</property>
    <property name="OrderField">name</property>
    <property name="TableName">monades</property>
  </object>
  <object class="MySQLTable" name="YpografontesTypesTable" >
        <property name="Left">248</property>
        <property name="Top">230</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">YpografontesTypesTable</property>
    <property name="OrderField">name</property>
    <property name="TableName">ypografontes_types</property>
  </object>
  <object class="MySQLTable" name="MonadesTypesTable" >
        <property name="Left">384</property>
        <property name="Top">230</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">MonadesTypesTable</property>
    <property name="OrderField">name</property>
    <property name="TableName">monades_types</property>
  </object>
  <object class="MySQLTable" name="ThematikesTable" >
        <property name="Left">496</property>
        <property name="Top">230</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">ThematikesTable</property>
    <property name="OrderField">name</property>
    <property name="TableName">thematikes</property>
  </object>
  <object class="MySQLTable" name="ForeisAllView" >
        <property name="Left">592</property>
        <property name="Top">230</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">ForeisAllView</property>
    <property name="OrderField">name</property>
    <property name="TableName">foreis_all_editable_VIEW</property>
  </object>
  <object class="MySQLTable" name="oda_masterTable" >
        <property name="Left">688</property>
        <property name="Top">230</property>
    <property name="Database">DB_General</property>
    <property name="LimitCount">20</property>
    <property name="MasterFields">a:0:{}</property>
    <property name="MasterSource"></property>
    <property name="Name">oda_masterTable</property>
    <property name="Order">desc</property>
    <property name="OrderField">ID</property>
    <property name="TableName">oda_members_master</property>
  </object>
</object>
?>
