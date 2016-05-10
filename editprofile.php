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

    <div class="form">
        <h1>Edit Your User Profile</h1>
        <P><B>Please edit any of your user information below:</B></P>

        <form method="POST" action="index.htm">

            <H4>User Name:</H4>
            <p><input type="text" size="20" name="profile_user_name" placeholder="User Name"</p>

            <H4>Name:</H4>
            <P><input type="text" size="20" name="profile_first_name" placeholder="First Name" class="formInput">
                <input type="text" size="20" name="profile_last_name" placeholder="Last Name" class="formInput">

                <H4>Email:</H4>
            <P><input type="text" size="20" name="profile_email" placeholder="Email">

                <H4>Password:</H4>
                <input type="password" size="20" id="password1" name="password1" placeholder="Password" class="formInput" /><br />
                <input type="password" size="20" id="password2" name="password2" placeholder="Confirm Password" class="formInput" /><br />



            <P><input type="submit" name="submitbtn" value="Update" class="mButton">


        </form>
        </div>
    </div>
</div>

<?php
require_once "footer.php";
?>
</body>


</html>