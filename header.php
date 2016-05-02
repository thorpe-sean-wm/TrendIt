<?php
session_start();
?>
<div class="headerCont">
    <div class="header">
        <nav class="navbar">
            <a href="index.php"><button class="mButton">Home</button></a>
            <a href="viewprofile.php"><button class="mButton">Profile</button></a>
            <a href="search.php"><button class="mButton">Search</button></a>
            <?php
            if(isset($_SESSION['userId'])){
                echo '<a href="logout.php"><button class="mButton">Log Out</button></a>';
            }
            else{
                echo '<a href="login.php"><button class="mButton">Log In</button></a>';
                echo '<a href="signup.php"><button class="mButton">Sign Up</button></a>';
            }
            ?>
        </nav>
        <img id="logo" src="images/trendit.png" height="100px" alt="Trend It">
    </div>
</div>