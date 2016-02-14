<?php

	require_once("configuration/mysql.php");

	if(!$_POST['user'] || !$_POST['file'])
	{
		exit;
	}

	$mQuery = $mysql->query("SELECT `id` FROM `files` WHERE `name` = '" . escape($_POST['file']) . "'");
	$mData = $mQuery->fetch_assoc();

	echo substr(md5($mData['id']), 0, 12);

?>