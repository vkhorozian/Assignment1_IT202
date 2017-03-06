<?php

function get_case($type,$name,$pass,$amount)
	{
		if ($type != "withdraw" && $type != "deposit" && $type != "admin")
			{
				exit ('You did not select an action');
			}
		elseif ($name == "" || $pass == "")
			{
				exit ("Password and Username must be filled in");
			}
		elseif ($amount != "" && $type == "admin")
			{
				exit ("Admin don't enter amounts");
			}
		elseif ($type != "admin" && $amount == "")
			{
				exit ("User must add amount");
			}
		elseif ($type != "admin" && $amount < 0)
			{
				exit ("No negitive numbers");
			}
		elseif ($type != "admin" && $amount != is_numeric($amount))
			{
				exit ("You must enter a number in amount field");
			}
		// if everything works return the type (withdraw, deposit, or admin)
		else 
			{
				return $type;
			}
	}
function f_user($type,$name,$pass,$amount)
	{
		$invalid = 0;
		$select = "SELECT * FROM accounts WHERE user = '$name' AND pass = '$pass'";
		$j = mysql_query($select);
		if(mysql_num_rows($j) == $invalid)
			{
				die("Please retry, Invalid login credentials");
			}
		if($type == "withdraw")
			{
				$v = mysql_fetch_array($j);
				$money = $v["current_balance"];
				if($amount > $money)
					{
						die("Not enough money in your account");
					}
			}
	}	
function f_admin($name,$pass)
	{
		// using a pdo object I access my database so I can print all users in accounts
		require('database.php');
		$query = 'SELECT * FROM accounts ';
		$statement = $db->prepare($query);
		$statement->execute();
		$users = $statement->fetchAll();
		$statement->closeCursor();
		
	
		$invalid = 0;
		$select = "SELECT * FROM admin WHERE user = '$name' AND pass = '$pass'";
		$j = mysql_query($select);
		if(mysql_num_rows($j) == $invalid)
			{
				die("Please retry, Invalid login credentials");
			}
		else
			{
				foreach ($users as $user) :
				print $user['user'];
				endforeach;
			}
	}
function f_update($type,$name,$amount)
	{
		$j = "INSERT into transaction values ('$name', '$type', '$amount', NOW())";
		if($type == "deposit")
			{
				$select = "UPDATE accounts SET current_balance = current_balance + $amount WHERE user = '$name'";
			}
		elseif($type == "withdraw")
			{
				$select = "UPDATE accounts SET current_balance = current_balance - $amount WHERE user = '$name'";
			}
			
		print("<br><br> s for update is:<br>");
		print("$s<br><br>");
		
		mysql_query($select);
		($j = mysql_query($j)) or die (mysql_error());
		
		return;
	
	}		
function get_A($s1)
	{
		($j = mysql_query($s1)) or die (mysql_error());
		while($v = mysql_fetch_array($j))
			{
				$user = $r["user"];
				$address = $r["address"];
				$mail  = $r["email"];    //used from notes from week04.txt
				$current_balance = $r["current_balance"];
				$out .= "Username: $user<br>";
				$out .= "Address: $address<br>";
				$out .= "Email: $mail<br>";
				$out .= "Current Balance: $current_balance<br>";
			}return $out;
				
	}
function get_T($s2)
	{
		($j = mysql_query($s1)) or die (mysql_error());
		while($v = mysql_fetch_array($j))
			{
				$user = $r["user"];
				$type = $r["type"];
				$amount = $r["amount"];    //obtained from notes from week04.txt
				$date = $r["date"];
				$out .= "Username: $user<br>";
				$out .= "$type amount: $amount<br>";
				$out .= "Timestamp: $date<br>";
			}return $out;
	}
function sql($type,$name,&$s1,&$s2) //this will print the data
	{
		if($type == 'admin')
			{
				$s1 = "SELECT * FROM acounts";
			};				
		if($type != 'admin')
			{
				$s1 = "SELECT * FROM accounts WHERE user = '$name'";
			};
		if($type == 'admin')
			{
				$s2 = "SELECT * FROM transaction";
			};
		if($type != 'admin')
			{
				$s2 = "SELECT * FROM transaction WHERE user = '$name'";
			};
	}
// this will retreieve the email from phpMyAdmin
function retrieve_email($type,$name)
	{ 
		if($type == 'admin') //admins default email
			{
				return 'vjk5@njit.edu';
			}
		elseif($type != 'admin') //users email search
			{
				$email = "SELECT email FROM accounts WHERE user = '$name' AND pass = '$pass'";
				
				($j = mysql_query($email) or die(mysql_error()));
				$v = mysql_fetch_array($j);
				$email_addr = $v["email"];
				return $email_addr;
			}
	}	
function email($type,$name,$message)
	{
		$to = retrieve_email($type,$name);
		$subject = "user account and transaction";
		$message = "Email header" . "\n";
		$heasers.= "Thank you" . "\r\n" //google helped me with this one
		
		mail($to,$subject,$message,$headers);
	}

	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	




?>