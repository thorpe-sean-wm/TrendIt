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
</body>

<?php
// Start the session
require_once('startsession.php');

// Insert the page header
$page_title = 'Edit Profile';
require_once('header.php');

require_once('appvars.php');
require_once('connectvars.php');

// Make sure the user is logged in before going any further.
if (!isset($_SESSION['user_id'])) {
    echo '<p class="login">Please <a href="login.php">log in</a> to access this page.</p>';
    exit();
}

// Show the navigation menu
require_once('index.php');

// Connect to the database
$dbh = new PDO('mysql:host=localhost;dbname=mismatchdb','root', 'root');


if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $username = trim($_POST['username']);
    $first_name = trim($_POST['firstName']);
    $last_name = trim($_POST['lastName']);
    $gender = trim($_POST['gender']);
    $birthdate = trim($_POST['birthday']);
    $old_picture = trim($_POST['old_picture']);
    $new_picture = trim($_FILES['new_picture']['name']);
    $new_picture_type = $_FILES['new_picture']['type'];
    $new_picture_size = $_FILES['new_picture']['size'];
    list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
        if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
                ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= MM_MAXFILESIZE) &&
            ($new_picture_width <= MM_MAXIMGWIDTH) && ($new_picture_height <= MM_MAXIMGHEIGHT)) {
            if ($_FILES['file']['error'] == 0) {
                // Move the file to the target upload folder
                $target = MM_UPLOADPATH . basename($new_picture);
                if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
                    // The new picture file move was successful, now make sure any old picture is deleted
                    if (!empty($old_picture) && ($old_picture != $new_picture)) {
                        @unlink(MM_UPLOADPATH . $old_picture);
                    }
                }
                else {
                    // The new picture file move failed, so delete the temporary file and set the error flag
                    @unlink($_FILES['new_picture']['tmp_name']);
                    $error = true;
                    echo '<p class="error">Sorry, there was a problem uploading your picture.</p>';
                }
            }
        }
        else {
            // The new picture file is not valid, so delete the temporary file and set the error flag
            @unlink($_FILES['new_picture']['tmp_name']);
            $error = true;
            echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (MM_MAXFILESIZE / 1024) .
                ' KB and ' . MM_MAXIMGWIDTH . 'x' . MM_MAXIMGHEIGHT . ' pixels in size.</p>';
        }
    }

    // Update the profile data in the database
    if (!$error) {
        if (!empty($first_name) && !empty($last_name) && !empty($gender) && !empty($birthdate) && !empty($city) && !empty($state)) {
            // Only set the picture column if there is a new picture
            if (!empty($new_picture)) {
                $query = "UPDATE trenditdb.users SET username = :username, password = :password, email = :email, joinDate = :joinDate, firstName = :firstName, lastName = :lastName,  " .
                    " birthday = :birthday, gender = :gender, phoneNumber = :phoneNumber, picture = :new_picture WHERE userID = :userID ";
                $stmt = $dbh->prepare($query);
                $stmt->execute(array(
                    'username' =>$username,
                    'firstName' =>$first_name,
                    'lastName' =>$last_name,
                    'gender' =>$gender,
                    'birthday' =>$birthdate,
                    'new_picture' =>$new_picture,
                    'userID' =>$_SESSION['userID']
                ));
            }
            else {
                $query = "UPDATE trenditdb.users SET username = :username, password = :password, email = :email, joinDate = :joinDate, firstName = :firstName, lastName = :lastName,  " .
                    " birthday = :birthday, gender = :gender, phoneNumber = :phoneNumber, picture = :new_picture WHERE userID = :userID ";
            }
            $stmt = $dbh->prepare($query);
            $stmt->execute(array(
                'username' =>$username,
                'firstName' =>$first_name,
                'lastName' =>$last_name,
                'gender' =>$gender,
                'birthday' =>$birthdate,
                'userID' =>$_SESSION['userID']
            ));

            // Confirm success with the user
            echo '<p>Your profile has been successfully updated. Would you like to <a href="viewprofile.php">view your profile</a>?</p>';


            exit();
        }
        else {
            echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
        }
    }
} // End of check for form submission
else {
    // Grab the profile data from the database
    $query = "SELECT firstName, lastName, gender, birthday, email, picture FROM mismatch_user WHERE userID = :userID";
    $stmt = $dbh->prepare($query);
    $stmt->execute();

    $data = $stmt->fetchAll();
    $row = $results[0];

    if ($row != NULL) {
        $first_name = $row['firstName'];
        $last_name = $row['lastName'];
        $gender = $row['gender'];
        $birthdate = $row['birthday'];
        $old_picture = $row['picture'];
    }
    else {
        echo '<p class="error">There was a problem accessing your profile.</p>';
    }
}

?>

<form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo MM_MAXFILESIZE; ?>" />
    <fieldset>
        <legend>Personal Information</legend>
        <label for="firstName">First name:</label>
        <input type="text" id="firstName" name="firstName" value="<?php if (!empty($first_name)) echo $first_name; ?>" /><br />
        <label for="lastName">Last name:</label>
        <input type="text" id="lastName" name="lastName" value="<?php if (!empty($last_name)) echo $last_name; ?>" /><br />
        <label for="gender">Gender:</label>
        <select id="gender" name="gender">
            <option value="M" <?php if (!empty($gender) && $gender == 'M') echo 'selected = "selected"'; ?>>Male</option>
            <option value="F" <?php if (!empty($gender) && $gender == 'F') echo 'selected = "selected"'; ?>>Female</option>
        </select><br />
        <label for="birthday">Birthdate:</label>
        <input type="text" id="birthday" name="birthday" value="<?php if (!empty($birthdate)) echo $birthdate; else echo 'YYYY-MM-DD'; ?>" /><br />
        <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
        <label for="new_picture">Picture:</label>
        <input type="file" id="new_picture" name="new_picture" />
        <?php if (!empty($old_picture)) {
            echo '<img class="profile" src="' . MM_UPLOADPATH . $old_picture . '" alt="Profile Picture" />';
        } ?>
    </fieldset>
    <input type="submit" value="Save Profile" name="submit" />
</form>

<?php
// Insert the page footer
require_once('footer.php');
?>

</html>