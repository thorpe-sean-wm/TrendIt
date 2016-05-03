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

<body onload="start()">
<?php
require_once "header.php";
?>
<div class="container">
    <div class="content" id="main">
        <!-- The Search Bar will take the  -->
        <div id="searchBarContainer">
            <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <div></div>
                <div class="centerDiv" style="width: 468px;">
                    <label for="searchBar"></label>
                    <input id="searchBar" type="text" placeholder="Search">
                </div>
                <div class="centerDiv" style="width: 307px;">
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