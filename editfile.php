<?php

	require_once("configuration/main.php");

	if(!$_POST['fileid'] || !$_POST['name'])
	{
		exit;
	}

	$mysql->query("UPDATE `files` SET `name` = '" . escape($_POST['name']) . "' WHERE `user` = '" . $_SESSION['accountid'] . "' AND `fileid` = '" . escape($_POST['fileid']) . "'");

?>