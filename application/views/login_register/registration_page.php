<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>(Carts Page) Shopping Cart | Lashopda</title>
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>" />
	<link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>" />
</head>
<body>
    <header>
        <a href="<?= base_url('#') ?>"><h2>Lashopda</h2></a>
        <a class="nav_end" href="<?= base_url('users/login') ?>"><h3>Login</h3></a>
    </header>
    <main>
        <div class="login_register_page">
            <p class="message_register"></p>
            <form class="form_login_register" action="" method="post">
                <h2>Register</h2>
                <span><p>First Name: </p><input type="text" name="first_name"/></span>
                <span><p>Last Name: </p><input type="text" name="last_name"/></span>
                <span><p>Email Address: </p><input type="text" name="email"/></span>
                <span><p>Contact Number: </p><input type="number" name="contact_number" placeholder="11-digit number"/></span>
                <span><p>Password: </p><input type="password" name="password"/></span>
                <span><p>Confirm Password: </p><input type="password" name="confirm_password"/></span>
                <span class="btn_login_register"><input type="submit" value="Register"/></span>
                <span class="btn_login_register"><a href="">Already have an account? Login</a></span>
            </form>
        </div>
    </main>
</body>
</html>
