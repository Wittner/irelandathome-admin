<?php

/**
 * @author Mike Brady
 * @copyright 2009
 */

// Auto properties

// Set up Medius database
/*
$glob_host="mysql242int.cp.blacknight.com";
$db_name="db1036209_iah";
$glob_user="u1036209_visitor";
$glob_pass="d1rekt0r";
$baseref="www.d1036209.cp.blacknight.com";
$filepath="/home/iah/domains/irelandathome.com/public_html";
$connection=mysql_connect("$glob_host", "$glob_user", "$glob_pass")or die(mysql_error());
$db=mysql_select_db($db_name, $connection)or die(mysql_error());
*/

// Set up local database
/**/
$glob_host="localhost";
$db_name="iah_main";
$glob_user="iah_visitor";
$glob_pass="Y8w9Jt5HpAHxsvzs";
$baseref="localhost";
$filepath="/home/iah/domains/irelandathome.com/public_html";
$connection=mysql_connect("$glob_host", "$glob_user", "$glob_pass")or die(mysql_error());
$db=mysql_select_db($db_name, $connection)or die(mysql_error());

// Get incoming query
$q = $_GET[q];

// Get property list
$sql="
   select property_name, property_code
   from properties
   where property_status='LVE'
   and property_name like '$q%'
   order by property_name
	";
$result=mysql_query($sql,$connection)or die(mysql_error());
while ($row =mysql_fetch_array($result))
{
$property_name = $row['property_name'];
$property_code = $row['property_code'];
$autocompleteList .= $property_name . '|' . $property_code . "\n";
}

echo $autocompleteList;
?>