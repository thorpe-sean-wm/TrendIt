<?php
//Insert the page header
$page_title = 'Sign Up';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <?php
    echo '<title>TrendIt - ' . $page_title . '</title>';
    ?>

    <link rel="stylesheet" type="text/css" href="login_style.css" />
</head>
<body>
<div class="headerCont">
    <div class="header">
        <div class="navbar">
            <a href="index.php"><button class="mButton">Back</button></a>
        </div>
    </div>
</div>
<div class="container">
    <video autoplay loop muted poster="empty.png" id="bgvid">
        <source src="login.mp4" type="video/mp4">
    </video>
    <div class="content">
        <?php

        echo '<h3>TrendIt - ' . $page_title . '</h3>';

        //Connect to the database
        $dbh = new PDO('mysql:host=localhost;dbname=trenditdb', 'root', 'root');

        if (isset($_POST['submit'])) {
            //Grab the data from POST
            $username = trim($_POST['username']);
            $password1 = ($_POST['password1']);
            $password2 = ($_POST['password2']);
            $email = ($_POST['email']);

            if (!empty($username) && !empty($password1) && !empty($password2) && ($password1 == $password2) && !empty($email)) {
                //Check for unique Username
                $query = "SELECT * FROM users WHERE username = :username AND email = :email";
                $stmt = $dbh->prepare($query);
                $stmt->execute(array(
                    'username' => $username,
                    'email' => $email
                ));
                $result = $stmt->fetchAll();

                if (count($result) == 0) {
                    // If username is unique, insert the data into the database
                    $query = "INSERT INTO users (username, password, email, joinDate) VALUES (:username, SHA(:password1), :email, NOW())";
                    $stmt = $dbh->prepare($query);
                    $stmt->execute(array(
                        'username' => $username,
                        'password1' => $password1,
                        'email' => $email
                    ));

                    //Confirm success with the user
                    echo '<p>Your new account has been successfully created. </p><p><a href="login.php">You\'re now ready to log in</a>.</p>';

                    exit();
                }
                else {
                    //Display error message
                    echo '<p class="error">An account already exists for this username. Please use a different address.</p>';
                    $username = "";
                }
            }
            else {
                echo '<p class="error">You must enter all of the sign-up data, including the desired password twice.</p>';
            }
        }

        ?>

        <p>Please enter your username and desired password to sign up to Mismatch.</p>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <input type="text" id="username" name="username" value="<?php if (!empty($username)) echo $username; ?>" placeholder="Username" class="formInput" /><br />
                <input type="password" id="password1" name="password1" placeholder="Password" class="formInput" /><br />
                <input type="password" id="password2" name="password2" placeholder="Confirm Password" class="formInput" /><br />
                <input type="text" id="email" name="email" placeholder="Email" class="formInput" /><br />
            <input type="submit" value="Sign Up" name="submit" class="signUp"/>
        </form>
        <p style="text-align: left; padding-left: 20px"><a style="text-align: left;" href="login.php">&lt;&lt;Already have an account?</a></p>
    </div>
</div>
</body>
</html>
