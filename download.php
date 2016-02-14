<?php

	require_once("configuration/mysql.php");

	function calculateFileSize($bytes)
	{
		if($bytes >= 1073741824) return round($bytes / 1073741824) . " GB";
		else if($bytes >= 1048576) return round($bytes / 1048576) . " MB";
		else if($bytes >= 1024) return round($bytes / 1024) . " KB";
		else return $bytes . " B";
	}

	$splitURL = explode("?", $_SERVER['REQUEST_URI']);

	if($splitURL[1])
	{
		$mQuery = $mysql->query("SELECT `path`, `name` FROM `files` WHERE `fileid` = '" . escape($splitURL[1]) . "'");
		
		if($mQuery->num_rows)
		{
			$mData = $mQuery->fetch_assoc();

			if($splitURL[2] == "start")
			{
				header("Pragmaes: 0");
			    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
			    header("Cache-Control: private", false);
			    header("Content-type: application/force-download");
			    header("Content-Transfer-Encoding: Binary");
			    header("Content-length: " . filesize($mData['path']));
			    header("Content-disposition: attachment; filename=\"" . $mData['name'] . "\"");

			    readfile($mData['path']);
			}
			else
			{
				$fileExtension = pathinfo($mData['name'], PATHINFO_EXTENSION);
				$fileIcon = (file_exists("images/files/" . $fileExtension . ".png")) ? "images/files/" . $fileExtension . ".png" : "images/files/default.png";

				echo
				"<head>
					<title>
						" . $mData['name'] . "
					</title>

					<link rel='stylesheet' href='css/download.css'>

					<script src='js/jquery.js'></script>
					<script src='js/jquery.zclip.js'></script>
				</head>

				<div align='center'>
					<div align='left' class='downloadContainer'>
						<table width='100%'>
							<tr>
								<td width='120'>
									<img src='$fileIcon'>
								</td>

								<td valign='top' class='downloadTitle'>
									" . $mData['name'] . "

									<a id='downloadButton' href='?" . $splitURL[1] . "?start'>
										Download (" . calculateFileSize(filesize($mData['path'])) . ")
									</a>

									<button class='downloadCopy'>Copy Link</button>
									<button class='downloadCopy'>Copy Direct Link</button>
								</td>
							</tr>
						</table>
					</div>
				</div>";
			}
		}
		else
		{
			echo "<meta http-equiv='Refresh' content='0; url=errors/404.html'>";
		}
	}
	else
	{
		echo "<meta http-equiv='Refresh' content='0; url=errors/404.html'>";
	}

?>

<script>
	$(document).ready(function()
	{
		$('#downloadCopy').zclip(
		{
			path: "js/ZeroClipboard.swf",
			copy: window.location.href
		});

		$('#downloadCopyDirect').zclip(
		{
			path: "js/ZeroClipboard.swf",
			copy: window.location.href + "?start"
		});
	});
</script>