<?php

	require_once("configuration/main.php");

	if(!$_SESSION['accountid'])
	{
		exit;
	}

	$ignoreFiles = explode("|", $_POST['ignore']);

	foreach(array_keys($_FILES) as $arrayIndex)
	{
		foreach($_FILES[$arrayIndex]['name'] as $fileIndex => $fileName)
		{
			if(array_search($fileName, $ignoreFiles) === false)
			{
				$mysql->query("INSERT INTO `files` (`user`, `name`) VALUES ('" . $_SESSION['accountid'] . "', '" . escape($_FILES[$arrayIndex]['name'][$fileIndex]) . "')");

				$insertID = $mysql->insert_id;

				$filePath = "C:/xampp/uploads/" . substr(md5($insertID), 0, 12);

				$mysql->query("UPDATE `files` SET `fileid` = '" . substr(md5($insertID), 0, 12) . "', `path` = '$filePath' WHERE `id` = '$insertID'");

				move_uploaded_file($_FILES[$arrayIndex]['tmp_name'][$fileIndex], $filePath);
			}
		}
	}

?>