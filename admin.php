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
require_once "adminheader.php";
require_once "authvar.php";

?>
<div class="container">
    <div class="content">
        <h1>Admin Page</h1>
        <p><b>Select an Action:</b></p><br>

        <?php
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

        $query = "SELECT * FROM users ORDER BY joinDate DESC";
        $data = $dbh->prepare($query);
        $data->execute();
        $arrayfetch = $data->fetchAll();

        echo '<table>';
            echo '<tr> <th>NAME</th> <th>JOIN DATE</th> <th>EMAIL</th> <th>ACTION</th> </tr>';
            foreach ($arrayfetch as $row) {
            echo '<tr><td class="scoreinfo">';
                    echo '<tr class="scorerow"><td><strong>' . $row['username'] . '</strong></td>'; echo '<td>' . $row['joinDate'] . '</td>';
                echo '<td>' . $row['email'] . '</td>';
                echo '<td><a href="removeUser.php?userID=' . $row['userID'] . '&amp;joinDate=' . $row['joinDate'] . '&amp;username=' . $row['username'] . '&amp;email=' . $row['email'] . '&amp;picture=' . $row['profilePicture'] . '">Remove User</a>';
                    echo '</td></tr>';
            }
            echo '</table>';

        ?>
    </div>
</div>

<?php
require_once "footer.php";
?>
</body>


</html>