<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Trend It</title>
    <link href="mainstylesheet.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
    <link href="searchStyles.css" rel="stylesheet" type="text/css">
    <script src="centerScript.js" type="text/javascript"></script>

</head>

<body onload="start()" onresize="start()">
<?php
require_once "header.php";
?>
<div class="container">
    <div class="content">
        <!-- The Search Bar will take the  -->
        <div id="searchBarContainer">
            <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="width: 1080px;">
                <div style="height: 1px;"></div>
                <div class="centerDiv" style="width: 518px; margin-left: 285px; height: 42px; margin-top: 4px">
                    <label for="searchBar"></label>
                    <input id="searchBar" type="text" placeholder="Search">
                    <input type="submit" id="searchSubmit" value="Search">
                </div>
                <div class="centerDiv" style="width: 307px; margin-left: 386px; margin-top: 5px;">
                    <label for="userNameSearch" class="OptLabelSearch">User Name:</label>
                    <input type="checkbox" id="userNameSearch" class="OptInputSearch" checked="true">
                    <label for="firstNameSearch" class="OptLabelSearch">First Name:</label>
                    <input type="checkbox" id="firstNameSearch" class="OptInputSearch">
                    <label for="lastNameSearch" class="OptLabelSearch">Last Name:</label>
                    <input type="checkbox" id="lastNameSearch" class="OptInputSearch">
                </div>
            </form>
            </div>
        <div id="searchResults">
            <?php
            $dbh = new PDO ('mysql:host=localhost;dbname=trenditdb', 'root', 'root');


            ?>
            <table>
                <?php



                ?>
            </table>
        </div>
    </div>
</div>
<?php
require_once "footer.php";
?>
</body>

</html>