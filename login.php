<?php

	require_once("configuration/main.php");

	if($_SESSION['accountid'])
	{
		//redirect("index");
	}

	if($_POST['login'])
	{
		$mQuery = $mysql->query("SELECT `id` FROM `accounts` WHERE `username` = '" . escape($_POST['username']) . "' AND `password` = '" . password($_POST['password']) . "'");

		if($mQuery->num_rows)
		{
			$mData = $mQuery->fetch_assoc();

			$_SESSION['accountid'] = $mData['id'];

			cookie("fm_accountid", $_SESSION['accountid']);
			cookie("fm_username", escape($_POST['username']));
			cookie("fm_password", password($_POST['password']));

			successNotice("You have successfully logged in.");

			redirect("index", 2);
		}
		else
		{
			errorNotice("The account information you have entered is invalid.");
		}
	}

?>

<style>
	body
	{
		background: url(images/login-background.png) #525252 no-repeat;
		background-size: cover;
	}
</style>

<div align='center'>
	<div class='loginContainer left'>
		<table width='100%'>
			<tr>
				<td width='50%' valign='top'>
					<div class='loginHeading'>
						Login
					</div>

					<form action='' method='POST' autocomplete='off'>
						<input type='text' name='username' placeholder='Username' maxlength='32' class='loginInput' autofocus>
						<input type='password' name='password' placeholder='Password' class='loginInput'>

						<div align='right'>
							<input type='submit' name='login' value='Login' class='loginButton'>
						</div>
					</form>
				</td>

				<td width='50%' valign='top'>
					<div class='loginHeading'>
						or Sign Up
					</div>

					<a href='signup'>
						<input type='submit' name='signup' value='Sign Up' class='loginButton loginSignUp'>
					</a>
				</td>
			</tr>
		</table>
	</div>
</div>