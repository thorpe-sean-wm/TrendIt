<?php
require_once('authvar.php');
?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en"> <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/> <title>Guitar Wars - Remove a High Score</title>
    <link rel="stylesheet" type="text/css" href="mainstylesheet.css" />
</head>
<?php
require_once 'adminheader.php';
?>
<body>
<div class="container">
    <div class="content">
        <h2>Trend It - Remove User</h2>
        <?php
        require_once('appvars.php');
        if (isset($_GET['userID']) && isset($_GET['joinDate']) && isset($_GET['username']) && isset($_GET['email']) && isset($_GET['picture'])) {
            $id = $_GET['userID'];
            $date = $_GET['joinDate'];
            $name = $_GET['username'];
            $email = $_GET['email'];
            $screenshot = $_GET['picture'];
        }
        else if (isset($_POST['userID']) && isset($_POST['username']) && isset($_POST['email'])) {
            $id = $_POST['userID'];
            $name = $_POST['username'];
            $email = $_POST['email'];
        }
        else {
            echo '<p class="error">Sorry, no user was selected for removal.</p>';
        }

        if (isset($_POST['submit'])) {
            if ($_POST['confirm'] == 'Yes') {

                @unlink(TI_UPLOADPATH . $screenshot);

                $dbh = NEW PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

                $query = "DELETE FROM users WHERE userID = :userID LIMIT 1";
                $stmt = $dbh->prepare($query);
                $stmt->execute(
                    array(
                        'userID' => $id
                    )
                );
                echo '<p>The user, ' . $name . ' was successfully removed.';
            }
            else {
                echo '<p class="error">The high score was not removed.</p>';
            }
        }

        else if (isset($id) && isset($name) && isset($date) && isset($email) && isset($screenshot)) {
            echo '<p>Are you sure you want to permanently remove this user?</p>';
            echo '<p><strong>Name: </strong>' . $name . '<br /><strong>Join Date: </strong>' . $date .
                '<br /><strong>Email: </strong>' . $email . '</p>';
            echo '<form method="post" action="removeUser.php">';
            echo '<input type="radio" name="confirm" value="Yes" /> Yes ';
            echo '<input type="radio" name="confirm" value="No" checked="checked" /> No <br />';
            echo '<input type="submit" value="Submit" name="submit" />';
            echo '<input type="hidden" name="userID" value="' . $id . '" />';
            echo '<input type="hidden" name="username" value="' . $name . '" />';
            echo '<input type="hidden" name="email" value="' . $email . '" />';
            echo '</form>';
        }
        echo '<p><a href=admin.php>Return to admin page</a></p>';
        ?>
    </div>
</div>

</body>
</html>