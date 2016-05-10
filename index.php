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
                <?php
                $i = 0;
                // Connect to the database
                $dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');
                // Retrieve the score data from MySQL
                $query = "SELECT * FROM posts ORDER BY postTime ASC";

                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $results = $stmt->fetchAll();

                foreach($results as $posts){

                    $query = "SELECT * FROM users WHERE userID = :userid";

                    $stmt = $dbh->prepare($query);
                    $stmt->execute(array(
                            'userid' => $posts['userID']
                        )
                    );
                    $userinfo = $stmt->fetch();

                    echo '<div class="post">';
                    echo '<div class="postUser">';
                    echo '<p>' . $userinfo['username'] . ':</p>';
                    echo '</div>';
                    echo '<div class="postContent">';
                    echo '<p>' . $posts['post'] . '</p>';
                    echo '</div>';
                    echo '<div class="postUtil">';
                    echo '<p><button>Favorite</button> 0 <button>Like</button> 0 <button>Comment</button>0</p>';
                    echo '</div>';
                    echo '</div>';

                }

                ?>
            </div>
        </div>
    </div>
</div>
<?php
require_once "footer.php";
?>
</body>
</html>