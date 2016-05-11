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
        <div id="trending">
            <div>
                <p class="contentText"><strong>Trending</strong></p>
            </div>
        </div>
        <div id="recentPosts">
            <div>
                <p class="contentText"><strong>Recent</strong></p>
                <div class="post">
                    <div class="postUser">
                        <p>Placeholder:</p>
                    </div>
                    <div class="postContent">
                        <p>Placeholder</p>
                    </div>
                    <div class="postUtil">
                        <p><button>Favorite</button> 0 <button>Like</button> 0 <button>Comment</button>0</p>
                    </div>
                </div>
                <?php
                $i = 0;
                // Connect to the database
                $dbh = new PDO('mysql:host=localhost;dbname=trenditdb', 'root', 'root');
                // Retrieve the score data from MySQL
                $query = "SELECT * FROM posts ORDER BY id ASC";

                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $results = $stmt->fetchall();


                // Loop through the array of score data, formatting it as HTML
                echo '<table style="width: 100%;">';

                $i = 0;
                foreach($results as $row) {
                    if ($i == 0) {
                        echo '<tr><td colspan="2" class="contentText"><strong>Recent Posts</strong></td></tr>';
                    }
                    // Display the score data
                    echo '<tr><td class="subinfo">';
                    echo '<strong>Post</strong><br /> ' . $row['post'] . '<br /></td>';
                    $i++;
                }
                echo '</table>';
                ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once "footer.php";
?>

<a href="welcomeIndex.php">Hello</a>
</body>
</html>