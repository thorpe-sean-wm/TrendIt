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
require_once "appvars.php";

$dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

if (isset($_POST['submit'])) {
    // Grab the profile data from the POST
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $phoneNumber = $_POST['phoneNumber'];
    $status = $_POST['status'];
    $old_picture = $_POST['old_picture'];
    $new_picture = $_FILES['new_picture']['name'];
    $new_picture_type = $_FILES['new_picture']['type'];
    $new_picture_size = $_FILES['new_picture']['size'];
    list($new_picture_width, $new_picture_height) = getimagesize($_FILES['new_picture']['tmp_name']);
    $error = false;

    // Validate and move the uploaded picture file, if necessary
    if (!empty($new_picture)) {
        if ((($new_picture_type == 'image/gif') || ($new_picture_type == 'image/jpeg') || ($new_picture_type == 'image/pjpeg') ||
                ($new_picture_type == 'image/png')) && ($new_picture_size > 0) && ($new_picture_size <= TI_MAXFILESIZE) &&
            ($new_picture_width <= TI_MAXIMGWIDTH) && ($new_picture_height <= TI_MAXIMGHEIGHT)) {
            if ($_FILES['file']['error'] == 0) {
                // Move the file to the target upload folder
                $target = TI_UPLOADPATH . basename($new_picture);
                if (move_uploaded_file($_FILES['new_picture']['tmp_name'], $target)) {
                    // The new picture file move was successful, now make sure any old picture is deleted
                    if (!empty($old_picture) && ($old_picture != $new_picture)) {
                        @unlink(TI_UPLOADPATH . $old_picture);
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
            echo '<p class="error">Your picture must be a GIF, JPEG, or PNG image file no greater than ' . (TI_MAXFILESIZE / 1024) .
                ' KB and ' . TI_MAXIMGWIDTH . 'x' . TI_MAXIMGHEIGHT . ' pixels in size.</p>';
        }
    }

    // Update the profile data in the database
    if (!$error) {
        if (!empty($firstName) && !empty($lastName) && !empty($gender) && !empty($birthday) && !empty($phoneNumber) && !empty($status)) {
            // Only set the picture column if there is a new picture
            if (!empty($new_picture)) {
                $query = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', gender = '$gender', " .
                    " birthday = '$birthday', phoneNumber = '$phoneNumber', status = '$status', profilePicture = '$new_picture' WHERE userID = '" . $_SESSION['userID'] . "'";
            }
            else {
                $query = "UPDATE users SET firstName = '$firstName', lastName = '$lastName', gender = '$gender', " .
                    " birthday = '$birthday', phoneNumber = '$phoneNumber', status = '$status' WHERE userID = '" . $_SESSION['userID'] . "'";
            }
            echo $new_picture;
            $data = $dbh->prepare($query);
            $data->execute();

            // Confirm success with the user
            echo '<div class="container">';
            echo '<div class="content">';
            echo '<h3>Your profile has been successfully updated. Would you like to <a class="postLink" href="viewprofile.php?user=' . $_SESSION['userID'] . '">view your profile</a>?</h3>';
            echo '</div>';
            echo '</div>';
            exit();
        }
        else {
            echo '<p class="error">You must enter all of the profile data (the picture is optional).</p>';
            echo $firstName . $lastName . $gender . $birthday . $phoneNumber . $status;
        }
    }
} // End of check for form submission
else {
    // Grab the profile data from the database
    $query = "SELECT firstName, lastName, gender, birthday, phoneNumber, status, profilePicture FROM users WHERE userID = '" . $_SESSION['userID'] . "'";
    $data = $dbh->prepare($query);
    $data->execute();
    $row = $data->fetch();

    if ($row != NULL) {
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $gender = $row['gender'];
        $birthday = $row['birthday'];
        $phoneNumber = $row['phoneNumber'];
        $status = $row['status'];
        $old_picture = $row['profilePicture'];
    }
    else {
        echo '<p class="error">There was a problem accessing your profile.</p>';
    }
}

?>
<div class="container">
    <div class="content">

    <div class="form">
        <?php if (!empty($old_picture)) {
            echo '<div class="editPicture"">';
            echo '<p>Current Profile Picture:</p>';
            echo '<img class="currentPic" src="' . TI_UPLOADPATH . $old_picture . '" alt="Profile Picture" width="150px" height="150px" />';
            echo '</div>';
        } ?>
        <h1>Edit Your User Profile</h1>
        <p><b>Please edit any of your user information below:</b></p><br>

        <form enctype="multipart/form-data" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <input type="hidden" name="MAX_FILE_SIZE" value="<?php echo TI_MAXFILESIZE; ?>" />
            <label for="firstname">First Name:</label>
            <input type="text" id="firstname" name="firstName" value="<?php if (!empty($firstName)) echo $firstName; ?>" /><br>
            <label for="lastname">Last Name:</label>
            <input type="text" id="lastname" name="lastName" value="<?php if (!empty($lastName)) echo $lastName; ?>" /><br><br>
            <label for="gender">Gender:</label>
            <select id="gender" name="gender">
                <option value="M" <?php if (!empty($gender) && $gender == 'Male') echo 'selected = "selected"'; ?>>Male</option>
                <option value="F" <?php if (!empty($gender) && $gender == 'Female') echo 'selected = "selected"'; ?>>Female</option>
            </select><br>
            <label for="birthday">Birthday:</label>
            <input type="text" id="birthday" name="birthday" value="<?php if (!empty($birthday)) echo $birthday; else echo 'YYYY-MM-DD'; ?>" /><br><br>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phoneNumber" value="<?php if (!empty($phoneNumber)) echo $phoneNumber; else echo '000-000-0000'?>" /><br><br>
            <label for="status">Status:</label>
            <input type="text" id="status" name="status" value="<?php if (!empty($status)) echo $status; ?>" /><br>
            <input type="hidden" name="old_picture" value="<?php if (!empty($old_picture)) echo $old_picture; ?>" />
            <label for="new_picture">Picture:</label>
            <input type="file" id="new_picture" name="new_picture" />
            <button type="submit" name="submit" value="1">Save Your Profile</button>
        </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
</body>


</html>