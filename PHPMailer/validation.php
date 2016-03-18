<?php
@session_start();
//echo session_id();
if (!isset($_SESSION['username'])) {
   //echo "variabili di sessione non settate<br>User_name=".$_SESSION['username']." ".$_SESSION['ruolo']."<br>";
   //include "redir_login.htm";
   exit;
  } else {
  //echo "User_name=".$_SESSION['username']." ".$_SESSION['ruolo']."<br>";
  }
?> 
