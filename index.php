<html>
<link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,600" rel="stylesheet" type="text/css">
<!--[if lte IE 8]>
<script src="js/html5shiv.js">
<![endif]-->
<script src="js/jquery.min.js"></script>
<script src="js/jquery.dropotron.js"></script>
<script src="js/skel.min.js"></script>
<script src="js/skel-panels.min.js"></script>
<script src="js/init.js"></script>
<noscript>
    <link rel="stylesheet" href="css/skel-noscript.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/style-n1.css">
</noscript>

<?php
session_start();

if(isset($_SESSION['userID'])){
    $location = 'viewprofile.php?user=' . $_SESSION['userID'];
}
else{
    $location = 'login.php';
}
?>

<body class="homepage">
<div id="header-wrapper">
    <div id="header" class="container">
        <h1 id="logo"><a href="<?php echo $location ?>">TrendIt</a></h1>

    </div>
    <section id="hero" class="container">
        <header>
            <!--TITLE OF PAGE -->
            <h2>Welcome</h2>
        </header>
        <p>Your new favorite social media website</p>
        <ul class="actions">

            <li><a href="<?php echo $location ?>" class="button">#Trending</a></li>

        </ul>
        <div class="log">
            <a href="login.php" class="button">Login</a>

            <a href="signup.php" class="button">Sign Up</a>

        </div>
    </section>

</div>
</body>

</html>



<?php
/**
 * Created by PhpStorm.
 * User: session1
 * Date: 5/10/16
 * Time: 2:04 PM
 */