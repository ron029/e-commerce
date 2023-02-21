<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login Page</title>
    <script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/normalize.css") ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css") ?>" />
    <script>
        // $(document).ready(function(){
        //     $(document).on("submit", "form", function(){
        //         window.location = "../../../application/views/admin/admin_orders_dashboard_page.html";
        //         return false;
        //     });
        // });
    </script>
</head>
<body>
    <header>
        <a href="<?= base_url('products') ?>"><h2>Lashopda</h2></a>
        <!-- <a class="nav_end" href=""><h3>Register</h3></a> -->
    </header>
    <main>
	    <?php
		    if ($this->session->flashdata('login_error')) {
			    ?>
			    <p class="danger">Log in failed.</p>
			    <?php
		    }
	    ?>
	    <div class="login_register_page">
            <p class="message_login"></p>
            <form class="form_login_register" action="../users/process_login" method="post">
                <h2>Login</h2>
                <span><p>Contact Number/Email: </p><input type="text" name="email_contact_number"/></span>
                <span><p>Password: </p><input type="password" name="password"/></span>
                <span class="btn_login_register"><input type="submit" value="Login"/></span>
	            <span class="btn_login_register"><a href="<?= base_url('users/register') ?>">Don't have an account? Register</a></span>
            </form>
        </div>
    </main>
</body>
</html>
