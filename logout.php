<?php

	require_once("configuration/main.php");

	$_SESSION['accountid'] = 0;

	cookie("fm_accountid", 0);
	cookie("fm_username", 0);
	cookie("fm_password", 0);

	redirect("index");

?>