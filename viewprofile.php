<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Trend It</title>
    <link href="mainstylesheet.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>

</head>

<body>
<?php
require_once "header.php";
?>
<div class="container">
    <div class="content">

    </div>
</div>
<?php
require_once "footer.php";
?>

<?php

// Insert the page header
$page_title = 'View Profile';
require_once('header.php');

require_once('appvars.php');
require_once('connectvars.php');

// Make sure the user is logged in before going any further.
if (!isset($_SESSION['userID'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
}

// Show the navigation menu
require_once('index.php');

// Connect to the database
$dbh = new PDO('mysql:host=localhost;dbname=trenditdb', 'root', 'root');

// Grab the profile data from the database
if (!isset($_GET['userID'])) {
    $query = "SELECT username, password, email, joinDate, firstName, lastName , birthday , gender, phoneNumber, picture FROM trenditdb.users WHERE user_id = :userID";
}
else {
    $query = "SELECT username, password, email, joinDate, firstName, lastName , birthday , gender, phoneNumber, picture FROM trenditdb.users WHERE user_id = :userID";
}
$stmt = $dbh->prepare($query);
$stmt = $stmt->execute();


if (count($data) == 1) {
    // The user row was found so display the user data
    $row = $data[0];
    echo '<table>';
    if (!empty($row['username'])) {
        echo '<tr><td class="label">Username:</td><td>' . $row['username'] . '</td></tr>';
    }
    if (!empty($row['first_name'])) {
        echo '<tr><td class="label">First name:</td><td>' . $row['firstName'] . '</td></tr>';
    }
    if (!empty($row['last_name'])) {
        echo '<tr><td class="label">Last name:</td><td>' . $row['lastName'] . '</td></tr>';
    }
    if (!empty($row['gender'])) {
        echo '<tr><td class="label">Gender:</td><td>';
        if ($row['gender'] == 'M') {
            echo 'Male';
        }
        else if ($row['gender'] == 'F') {
            echo 'Female';
        }
        else {
            echo '?';
        }
        echo '</td></tr>';
    }
    if (!empty($row['birthday'])) {
        if (!isset($_GET['userID']) || ($_SESSION['userID'] == $_GET['userID'])) {
            // Show the user their own birthdate
            echo '<tr><td class="label">Birthdate:</td><td>' . $row['birthday'] . '</td></tr>';
        }
    }
    if (!empty($row['email'])) {
        echo '<tr><td class="label">Email:</td><td>' . $row['email'] . '</td></tr>';
    }
    if (!empty($row['picture'])) {
        echo '<tr><td class="label">Picture:</td><td><img src="' . MM_UPLOADPATH . $row['picture'] .
            '" alt="Profile Picture" /></td></tr>';
    }
    echo '</table>';
    if (!isset($_GET['userID']) || ($_SESSION['userID'] == $_GET['userID'])) {
        echo '<p>Would you like to <a href="editprofile.php">edit your profile</a>?</p>';
    }
} // End of check for a single row of user results
else {
    echo '<p class="error">There was a problem accessing your profile.</p>';
}

?>

<?php
// Insert the page footer
require_once('footer.php');
?>




</body>

</html>