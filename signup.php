<?php

	require_once("configuration/main.php");

	if($_SESSION['accountid'])
	{
		//redirect("index");
	}

	if($_POST['signup'])
	{
		if(strlen($_POST['username']) >= 3)
		{
			if(strlen($_POST['password']) >= 3)
			{
				if($_POST['password'] == $_POST['confirmpassword'])
				{
					if(strlen($_POST['email']) >= 5 && strpos($_POST['email'], "@") !== false && strpos($_POST['email'], ".") !== false)
					{
						$mysql->query("INSERT INTO `accounts` (`username`, `password`, `email`) VALUES ('" . escape($_POST['username']) . "', '" . password($_POST['password']) . "', '" . escape($_POST['email']) . "')");
					
						$_SESSION['accountid'] = $mysql->insert_id;

						cookie("fm_accountid", $_SESSION['accountid']);
						cookie("fm_username", escape($_POST['username']));
						cookie("fm_password", password($_POST['password']));

						successNotice("You have successfully created an account.");

						redirect("index", 2);
					}
					else errorNotice("You have entered an invalid email address.");
				}
				else errorNotice("Your passwords do not match.");
			}
			else errorNotice("Your password must be at least 3 characters long.");
		}
		else errorNotice("Your username must be at least 3 characters long.");
	}

?>

<div align='center'>
	<div class='signUpContainer left'>
		<div class='loginHeading'>
			Sign Up
		</div>

		<form action='' method='POST' autocomplete='off'>
			<input type='text' name='username' placeholder='Username' value='<?php echo $_POST['username']; ?>' maxlength='32' class='loginInput' autofocus>
			<input type='password' name='password' placeholder='Password' class='loginInput'>
			<input type='password' name='confirmpassword' placeholder='Confirm Password' class='loginInput'>
			<input type='text' name='email' placeholder='Email Address' value='<?php echo $_POST['email']; ?>' class='loginInput'>

			<div align='center'>
				<input type='submit' name='signup' value='Sign Up' class='loginButton'>
			</div>
		</form>
	</div>
</div>