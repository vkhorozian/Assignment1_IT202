<?php

include("account.php");
//conntecting to phpMyAdmin
include("A1_function.php");
	($dbh = mysql_connect($hostname, $username, $password)) or die ( "Unable to connect to MySQL database" );
print "Connected to server<br>";

//DB_tables
$t_account="accounts";
$t_trans="transaction";

//this will select the database to work with
$db_name="vjk5";
mysql_select_db($db_name) or die("cannot select database");


//this will take the inputs from the html form
$type = $_GET['type'];
$name =  $_GET['user'];
$pass =  $_GET['password'];
$action = $_GET['amount'];


             //print "user "."$name "." password ". "$pass "."amount "."$action "."type ". "$type <br><br>";

//PHP form validation
$type = get_case($type,$name,$pass,$action);

             //print $type;

if($type != 'admin')
	{
		f_user($type,$name,$pass,$amount);
	}

if($type == 'admin')
	{
		f_admin($name,$pass);
	}
if($type != 'admin')
	{
		f_update($type,$name,$amount);
	}

sql($type, $name, $s1, $s2);
	$r1 = get_A($s1);
	$r2 = get_T($s2);
	echo $r1 . "<br>" . $r2;
	
if (isset($_GET['mail']))
	{
		email($type,$name,$r1.$r2);
	};
	
print "all done"







?>