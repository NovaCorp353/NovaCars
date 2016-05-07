<?php
   session_start();
   if(!isset($_SESSION["user"])){
   	echo 0;
     //header("location:../index.html");
     //die();
   }
   else
   		echo 1;
?>