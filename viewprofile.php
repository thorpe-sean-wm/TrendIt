<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <title>Trend It</title>
    <link href="mainstylesheet.css" rel="stylesheet" type="text/css">
    <link href='https://fonts.googleapis.com/css?family=Muli' rel='stylesheet' type='text/css'>
    <script src="js/jquery-2.2.3.min.js" type="text/javascript"></script>


</head>

<body>
<?php
require_once "header.php";
?>
<div class="container">
    <div class="content">
        <?php
        $dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

        $userQuery = "SELECT * FROM users WHERE userID = '" . $_GET['user'] . "'";

        $ustmt = $dbh->prepare($userQuery);
        $ustmt->execute();
        $pageInfo = $ustmt->fetch();

        ?>
        <div id="profileLeftBar">
            <div id="userphoto" align="center">
                <img style="border: 1px #000 solid;" src="<?php if(isset($pageInfo['profilePicture'])){
                    echo 'profileImages/' . $pageInfo['profilePicture'];
                }
                else {
                    echo 'profileImages/default.png';
                }
                ?>" alt="Default Avatar" width="173" ></div>
            <div class="friend" align="left">
                <h4>Following List
                <?php
                // Retrieve the score data from MySQL
                $query = "SELECT * FROM followers WHERE userID = '" . $pageInfo['userID'] . "'";

                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $results = $stmt->fetchAll();

                echo '(' . count($results) . '):</h4>';

                echo '<ul id="friendslist" class="clearfix" style="list-style-type: none">';

                //Show each follower and display all information.
                foreach($results as $following){

                    $query = "SELECT * FROM users WHERE userID = :userid";

                    $stmt = $dbh->prepare($query);
                    $stmt->execute(array(
                            'userid' => $following['followingID']
                        )
                    );
                    $userinfo = $stmt->fetch();

                    //Grab picture
                    if(isset($userinfo['profilePicture'])){
                        $picture = $userinfo['profilePicture'];
                    }
                    else {
                        $picture =  'default.png';
                    }

                    //Display Picture and create Link
                    echo '<li><a href="?user=' . $userinfo['userID'] . '"><img src="profileImages/' . $picture . '" width="22" height="22">&nbsp;'. $userinfo['username'] .'</a></li>';
                }

                echo '</ul>';
                ?>
            </div>
        </div>
        <div id="userBio">
            <h1 id="viewprofileTitle"><?php echo $pageInfo['username']; ?></h1>
            <?php
            if($_SESSION['userID'] == $pageInfo['userID']){
                echo '<a href="editprofile.php" class="gear"><img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-gear-128.png" height="25" width="25"></a>';
            }
            else if(isset($_SESSION['userID'])){
                $query = "SELECT * FROM followers WHERE userID = '" . $_SESSION['userID'] . "' AND followingID = '" . $_GET['user'] . "'";

                $stmt = $dbh->prepare($query);
                $stmt->execute();
                $results = $stmt->fetchAll();

                //Display follow or Display settings gear
                if(count($results) == 0){
                    echo '<a href="follow.php?userID=' . $_GET['user'] . '"><button>Follow ' . $pageInfo['username'] . '</button></a>';
                }
                else{
                    echo '<a href="unfollow.php?userID=' . $_GET['user'] . '"><button>Unfollow ' . $pageInfo['username'] . '</button></a>';
                }
            }
            ?>
        </div>
        <div class="feed">
            <?php
            $query = "SELECT * FROM posts ORDER BY postTime DESC";

            $stmt = $dbh->prepare($query);
            $stmt->execute();
            $results = $stmt->fetchAll();

            foreach($results as $posts){

                //Grabbing Post information
                $query = "SELECT * FROM users WHERE userID = :userid";

                $stmt = $dbh->prepare($query);
                $stmt->execute(array(
                        'userid' => $posts['userID']
                    )
                );
                $userinfo = $stmt->fetch();

                //Like Amounting
                $query = "SELECT * FROM likes WHERE postID = :postID";

                $stmt = $dbh->prepare($query);
                $stmt->execute(array(
                        'postID' => $posts['postID']
                    )
                );
                $likeAmount = $stmt->fetchAll();

                //Like Check
                $query = "SELECT userID FROM likes WHERE postID = :postID AND userID = :userID";

                $stmt = $dbh->prepare($query);
                $stmt->execute(array(
                        'postID' => $posts['postID'],
                        'userID' => $_SESSION['userID']
                    )
                );
                $likeCheck = $stmt->fetch();

                //Grab picture or default
                if(isset($userinfo['profilePicture'])){
                    $picture = $userinfo['profilePicture'];
                }
                else {
                    $picture =  'default.png';
                }

                //Display Post
                echo '<div class="post">';
                echo '<div class="postUser">';
                echo '<p><a class="postLink" href="viewprofile.php?user= ' . $userinfo['userID'] . '"><img style="vertical-align:middle" src="profileImages/' . $picture . '" width="22" height="22">&nbsp;' . $userinfo['username'] . ':</a></p>';
                echo '</div>';
                echo '<div class="postContent">';
                echo '<p>' . $posts['post'] . '</p>';
                echo '</div>';
                echo '<div class="postUtil">';
                echo '<form action="postutility.php" method="post" class="postUtilities"><input type="hidden" name="viewID" value="' . $_GET['user'] .'"><input type="hidden" name="postID" value="' . $posts['postID'] .'">';
                //Display Delete Post utility
                if($userinfo['userID'] == $_SESSION['userID']){
                    echo '<button type="submit" name="delete" value="1">Delete Post</button>';
                }
                //Check if Logged in user has liked the post
                if($likeCheck['userID'] == $_SESSION['userID']){
                    echo '<button type="submit" name="unlike" value="1">Unlike</button> ' . count($likeAmount);
                }
                else{
                    echo '<button type="submit" name="like" value="1">Like</button> ' . count($likeAmount);
                }
                //echo '<button>Comments</button>0</p>';
                echo '</form>';
                echo '</div>';
                echo '</div>';

            }

            ?>
        </div>
        <div style="clear: both"></div>
    </div>
</div>
<script src="createpost.js" type="text/javascript"></script>
<div id="postBox">
    <form method="post" action="createpost.php">
        <h3>Create a Post:</h3>
        <textarea rows="4" cols="50" maxlength="140" name="post"></textarea>
        <input type="hidden" name="userID" value="<?php echo $_SESSION['userID']?>">
        <input type="hidden" name="view" value="<?php echo $_GET['user']?>">
        <button type="submit" name="submit" value="1">Create Post</button>
    </form>
</div>
<div id="postCreate">
    <p>&nbsp;+</p>
</div>
<?php
require_once "footer.php";
?>





</body>

</html>