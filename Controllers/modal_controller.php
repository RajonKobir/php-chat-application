<?php

// starting the session
session_start();

    $is_login = 0;

// logged-in or not
	if (!isset($_SESSION['id']) || (trim ($_SESSION['id']) == '')) {
		echo $is_login;
	}else{
        $is_login = 1;
        echo $is_login;
    }


		
?>