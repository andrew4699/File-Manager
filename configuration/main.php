<!DOCTYPE html>

<html lang='en'>
	<head>
		<title>File Manager</title>

		<meta charset='UTF-8'>

		<meta name='keywords' content='Key,Words,Here'>
		<meta name='description' content='This is my site description'>
		<meta name='author' content='Ricky Phelps'>

		<link rel='Shortcut Icon' href='images/favicon.ico'>

		<link rel='stylesheet' href='css/global.css'>

		<link rel='stylesheet' href='css/font-awesome.css'>
		<link rel='stylesheet' href='css/fonts/banda/banda.css'>

		<link rel='stylesheet' href='css/popup.css'>
		<link rel='stylesheet' href='css/login.css'>
		<link rel='stylesheet' href='css/signup.css'>
		<link rel='stylesheet' href='css/leftpanel.css'>
		<link rel='stylesheet' href='css/files.css'>
		<link rel='stylesheet' href='css/uploader.css'>

		<script src='js/jquery.js'></script>
		<script src='js/ui.js'></script>
		<script src='js/jquery.zclip.js'></script>
		<script src='js/jquery.form.js'></script>
	</head>

	<body ontouchstart=''>
		<div id='wrapper'>
			<?php

				require_once("mysql.php");

				function redirect($page, $time = 0)
				{
					echo "<meta http-equiv='Refresh' content='$time; url=$page'>";
					exit;
				}

				function password($text)
				{
					for($hashIndex = 0; $hashIndex < 1000; $hashIndex++)
					{
						$text = hash("whirlpool", $text);
					}

					return $text;
				}

				function cookie($name, $value)
				{
					return setcookie($name, $value, time() + 2592000);
				}

				function successNotice($text)
				{
					echo
					"<div align='center'>
						<div class='popupContainer popupSuccess'>
							<table>
								<tr>
									<td width='25' class='popupInformation'>
										
									</td>

									<td width='10'></td>

									<td>
										$text
									</td>
								</tr>
							</table>
						</div>
					</div>";
				}

				function errorNotice($text)
				{
					echo
					"<div align='center'>
						<div class='popupContainer popupError'>
							<table>
								<tr>
									<td width='25' class='popupInformation'>
										
									</td>

									<td width='10'></td>

									<td>
										$text
									</td>
								</tr>
							</table>
						</div>
					</div>";
				}

				$currentPage = basename($_SERVER['REQUEST_URI']);

				if($currentPage != "login" && $currentPage != "signup")
				{
					if(!$_SESSION['accountid'])
					{
						if($_COOKIE['fm_accountid'] && $_COOKIE['fm_username'] && $_COOKIE['fm_password'])
						{
							$mQuery = $mysql->query("SELECT `id` FROM `accounts` WHERE `id` = '" . escape($_COOKIE['fm_accountid']) . "' AND `username` = '" . escape($_COOKIE['fm_username']) . "' AND `password` = '" . escape($_COOKIE['fm_password']) . "'");

							if($mQuery->num_rows)
							{
								$_SESSION['accountid'] = $_COOKIE['fm_accountid'];
							}
							else
							{
								redirect("login");
							}
						}
						else
						{
							redirect("login");
						}
					}
					
					if($_SESSION['accountid'])
					{
						$mQuery = $mysql->query("SELECT * FROM `accounts` WHERE `id` = '" . escape($_SESSION['accountid']) . "'");
						$user = $mQuery->fetch_assoc();
					}

					echo
					"<table width='100%'>
						<tr>
							<td width='300' class='leftPanelContainer'>
								<div class='leftPanelTitle'>
									File Manager
								</div>

								<div class='leftPanelSearch'>
									<input type='text' name='search' placeholder=' Search' class='leftPanelSearchInput'>
								</div>

								<div class='leftPanelUser'>
									<table>
										<tr>
											<td valign='top' class='leftPanelAvatar'>
												<img src='images/avatar.png'>
											</td>

											<td width='5'></td>

											<td valign='top'>
												<div class='leftPanelUserName'>
													" . $user['username'] . "
												</div>

												<div class='leftPanelUserTitle'>
													User
												</div>
											</td>
										</tr>
									</table>
								</div>

								<div class='leftPanelNavigation'>
									<a href='index' class='leftPanelNavigationItem'>
										<table cellpadding='0' cellspacing='0'>
											<tr>
												<td width='30'>
													
												</td>

												<td width='220'>
													Dashboard
												</td>

												<td class='leftPanelNavigationArrow'>
													
												</td>
											</tr>
										</table>
									</a>

									<a href='logout' class='leftPanelNavigationItem'>
										<table cellpadding='0' cellspacing='0'>
											<tr>
												<td width='30'>
													
												</td>

												<td width='220'>
													Log Out
												</td>

												<td class='leftPanelNavigationArrow'>
													
												</td>
											</tr>
										</table>
									</a>
								</div>
							</td>

							<td width='300'></td>
						
							<td valign='top'>";
				}

			?>

			<script>
				$(document).ready(function()
				{
					$('.leftPanelNavigationItem').each(function()
					{
						if(window.location.href.indexOf($(this).attr("href")) > -1)
						{
							$(this).addClass("leftPanelNavigationItemCurrent");
							return false;
						}
					});
				});
			</script>