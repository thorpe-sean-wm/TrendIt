<?php

// Start the session
session_start();

// Clear the error message
$error_msg = "";

// If the user isn't logged in, try to log them in
if (!isset($_SESSION['userID'])) {
    if (isset($_POST['submit'])) {
        // Connect to the database
        $dbh = new PDO('mysql:host=localhost;dbname=trenditdb', 'root', 'root');

        // Grab the user-entered log-in data
        $user_username = trim($_POST['username']);
        $user_password = ($_POST['password']);

        if (!empty($user_username) && !empty($user_password)) {
            // Look up the username and password in the database
            $query = "SELECT userID, username FROM users WHERE username = :user_username AND password = SHA(:user_password)";
            $stmt = $dbh->prepare($query);
            $stmt->execute(array(
                'user_username' => $user_username,
                'user_password' => $user_password
            ));
            $data = $stmt->fetchAll();
            if (count($data) == 1) {
                // The log-in is OK so set the user ID and username variables
                $row = $data[0];
                $_SESSION['userID'] = $row['userID'];
                $_SESSION['username'] = $row['username'];
                setcookie('userID', $row['userID'], time() + (60 * 60 * 24 * 30));
                setcookie('username', $row['username'], time() + (60 * 60 * 24 * 30));
                $home_url = 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['PHP_SELF']) . '/index.php';
                header('Location: ' . $home_url);
            }
            else {
                // The username/password are incorrect so set an error message
                $error_msg = 'Sorry, you must enter a valid username and password to log in.';
            }
        }
        else {
            // The username/password weren't entered so set an error message
            $error_msg = 'Sorry, you must enter your username and password to log in.';
        }
    }
}

// Insert the page header
$page_title = 'Log In';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" type="text/css" href="login_style.css" />
</head>
<body>
<div class="headerCont">
    <div class="header">
        <div class="navbar">
            <a href="javascript:history.go(-1)"><button class="mButton">Back</button></a>
        </div>
    </div>
</div>
<div class="container">
    <video autoplay loop muted poster="empty.png" id="bgvid">
        <source src="kiwi1.mp4" type="video/mp4">
    </video>
    <div class="content">
        <?php
        echo '<h2>TrendIt - ' . $page_title . '</h2>';

        // If the session var is empty, show any error message and the log-in form; otherwise confirm the log-in
        if (empty($_SESSION['user_ID'])) {
            echo '<p class="error">' . $error_msg . '</p>';
            ?>

            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="text" name="username" value="<?php if (!empty($user_username)) echo $user_username; ?>" placeholder="Username" class="formInput" /><br />
                    <input type="password" name="password" placeholder="Password" class="formInput" /> <br>
                <input type="submit" value="Log In" name="submit" class="logIn" />
            </form>

            <?php
        }
        else {
            // Confirm the successful log-in
            echo('<p class="login">You are logged in as ' . $_SESSION['username'] . '.</p>');
        }
        ?>
    </div>
</div>
</body>
</html>
