<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Trend It</title>
    <script src="js/jquery-1.10.2.min.js" type="text/javascript"></script>
    <script src="centerScript.js" type="text/javascript"></script>
    <link href="mainstylesheet.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
    <link href="searchStyles.css" rel="stylesheet" type="text/css">

</head>

<body onload="start();" onresize="start()">
<?php
require_once "header.php";
?>
<div class="container">
    <div class="content">
        <!-- The Search Bar will take the information out of the following form -->
        <div id="searchBarContainer">
            <form method="get" action="<?php echo $_SERVER['PHP_SELF']; ?>" style="width: 1080px;">
                <div style="height: 1px;"></div>
                <div class="centerDiv" style="width: 518px; margin-left: 285px; height: 42px; margin-top: 4px">
                    <label for="searchBar"></label>
                    <input id="searchBar" type="text" placeholder="Search" name="searchBar" value="<?php if(!empty($_GET['searchBar'])){echo $_GET['searchBar'];}else{echo'';} ?>">
                    <input type="submit" id="searchSubmit" value="Search" name="submit">
                </div>
                <div class="centerDiv" style="width: 310px; margin-left: 386px; margin-top: 5px;">
                    <label for="userNameSearch" class="OptLabelSearch">User Name:</label>
                    <input type="checkbox" id="userNameSearch" class="OptInputSearch" name="userNameSearch" value="true" <?php if(isset($_GET['userNameSearch'])) echo "checked='checked'"; ?> style="margin-right: 10px;">
                    <label for="firstNameSearch" class="OptLabelSearch">First Name:</label>
                    <input type="checkbox" id="firstNameSearch" class="OptInputSearch" name="firstNameSearch" value="false" <?php if(isset($_GET['firstNameSearch'])) echo "checked='checked'"; ?> style="margin-right: 10px;">
                    <label for="lastNameSearch" class="OptLabelSearch">Last Name:</label>
                    <input type="checkbox" id="lastNameSearch" class="OptInputSearch" name="lastNameSearch" value="false" <?php if(isset($_GET['lastNameSearch'])) echo "checked='checked'"; ?> style="margin-right: 0;">
                </div>
            </form>
            </div>
        <div id="searchResults">
            <?php
            if (isset($_GET['submit']) && !($_GET['searchBar'] == '')) {
                if ((!isset($_GET['userNameSearch'])) && (!isset($_GET['firstNameSearch'])) && (!isset($_GET['lastNameSearch']))) {
                    echo '<p class=error>Please check at least one search category.</p>';
                }
                // The search form is valid, we start the search and connect to the database
                else {
                    // Connect to the database
                    $dbh = new PDO('mysql:host=localhost;dbname=trenditdb', 'root', 'root');

                    // Setting what the value is inside the search bar
                    $searchInput = $_GET['searchBar'];
                    // Set default search options (shouldn't ever be used if everything works as planned)
                    $optUserName = false;
                    $optFirstName = false;
                    $optLastName = false;
                    // fetch the search options for the query
                    if(isset($_GET['userNameSearch'])){$optUserName = true;}else{$optUserName = false;}
                    if(isset($_GET['firstNameSearch'])){$optFirstName = true;}else{$optFirstName = false;}
                    if(isset($_GET['lastNameSearch'])){$optLastName = true;}else{$optLastName = false;}
                    // Writing the correct query to fetch the correct data from the database
                    if ($optUserName == 1) {
                        if ($optFirstName == 1) {
                            if ($optLastName == 1) {
                                $query = "SELECT username, firstname, lastname, status, profilePicture, userID FROM users WHERE username = :searchInput OR firstName = :firstInput OR lastName = :lastInput OR username LIKE :searchInput2 OR firstName LIKE :firstInput2 OR lastName LIKE :lastInput2";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array(
                                    'searchInput' => $searchInput,
                                    'firstInput' => $searchInput,
                                    'lastInput' => $searchInput,
                                    'searchInput2' => '%' . $searchInput . '%',
                                    'firstInput2' => '%' . $searchInput . '%',
                                    'lastInput2' => '%' . $searchInput . '%'
                                ));
                            }
                            else{
                                $query = "SELECT username, firstname, lastname, status, profilePicture, userID FROM users WHERE username = :searchInput OR firstName = :firstInput OR username LIKE :searchInput2 OR firstName LIKE :firstInput2";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array(
                                    'searchInput' => $searchInput,
                                    'firstInput' => $searchInput,
                                    'searchInput2' => '%' . $searchInput . '%',
                                    'firstInput2' => '%' . $searchInput . '%'
                                ));
                            }
                        }
                        else{
                            if ($optLastName == 1) {
                                $query = "SELECT username, firstname, lastname, status, profilePicture, userID FROM users WHERE username = :searchInput OR lastName = :lastInput OR username LIKE :searchInput2 OR lastName LIKE :lastInput2";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array(
                                    'searchInput' => $searchInput,
                                    'lastInput' => $searchInput,
                                    'searchInput2' => '%' . $searchInput . '%',
                                    'lastInput2' => '%' . $searchInput . '%'
                                ));
                            }
                            else{
                                $query = "SELECT username, firstname, lastname, status, profilePicture, userID FROM users WHERE username = :searchInput OR username LIKE :searchInput2";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array(
                                    'searchInput' => $searchInput,
                                    'searchInput2' => '%' . $searchInput . '%'
                                ));
                            }
                        }
                    }
                    else {
                        if ($optFirstName == 1) {
                            if ($optLastName == 1) {
                                $query = "SELECT username, firstname, lastname, status, profilePicture, userID FROM users WHERE firstName = :firstInput OR lastName = :lastInput OR firstName LIKE :firstInput2 OR lastName LIKE :lastInput2";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array(
                                    'firstInput' => $searchInput,
                                    'lastInput' => $searchInput,
                                    'firstInput2' => '%' . $searchInput . '%',
                                    'lastInput2' => '%' . $searchInput . '%'
                                ));
                            }
                            else{
                                $query = "SELECT username, firstname, lastname, status, profilePicture, userID FROM users WHERE firstName = :firstInput OR  firstName LIKE :firstInput2";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array(
                                    'firstInput' => $searchInput,
                                    'firstInput2' => '%' . $searchInput . '%'
                                ));
                            }
                        }
                        else{
                            if ($optLastName == 1) {
                                $query = "SELECT username, firstname, lastname, status, profilePicture, userID FROM users WHERE lastName = :lastInput OR lastName LIKE :lastInput2";
                                $stmt = $dbh->prepare($query);
                                $stmt->execute(array(
                                    'lastInput' => $searchInput,
                                    'lastInput2' => '%' . $searchInput . '%'
                                ));
                            }
                            else {
                                echo '<p class=error>Please check at least one search category.</p>';
                            }
                        }
                    }
                    $results = $stmt->fetchAll();
                    if (empty($results)) {
                        echo '<p>Sorry, no results were found for that search.</p>';
                    }
                    else {
            ?>
            <table>
                <?php
                        foreach ($results as $row) {
                            echo '<tr class="searchResult">';
                            if (!empty($row[4])) {
                                echo '<td class="searchResultPicture"><img src="profileImages/' . $row[4] . '" class="searchResultImg"></td>';
                            }
                            else {
                                echo '<td class="searchResultPicture"><img src="profileImages/avatar.png" class="searchResultImg"></td>';
                            }
                            echo '<td class="searchResultData">';
                            if (!empty($row[0])) {echo '<p style="font-size: 120%"><b><a href="viewprofile.php?user=' . $row[5] . '">' . $row[0] . '</a></b></p>';}
                            echo '</td>';
                            echo '<td><div class="searchResultBarrier"></div></td>';
                            if (!empty($row[3])) {echo '<td class=searchResultData><p style="font-style: italic; font-family: -webkit-body; width: 400px; margin-left: 10px; margin-right: 10px; height: 40px;">' . $row[3] .'</p></td>';}
                            echo '<td><div class="searchResultBarrier"></div></td>';
                            echo '<td>';
                            // echoing the search result(s) first and last name
                            if (!empty($row[1])) {echo '<p>First Name: <b>' . $row[1] . '</b></p>';}
                            if (!empty($row[2])) {echo '<p>Last Name: <b>' . $row[2] . '</b></p>';}
                            echo '</td>';
                            // INSERT a link to their page / sen friend invite option here
                            echo '</tr>';
                        }
                    }
                ?>
            </table>
            <?php
                }
            }
            else {
                echo '<p class="error">Please insert some text into the search bar.</p>';
            }
            ?>
        </div>
    </div>
</div>
<?php
require_once "footer.php";
?>
</body>

</html>