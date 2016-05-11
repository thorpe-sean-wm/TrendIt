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
        <div id="profileLeftBar">
            <div id="userphoto" align="center"><img src="images/avatar.png" alt="default avatar" width="173" ></div>
            <div class="friend" align="left">
                <p>Friends list:</p>
                <ul id="friendslist" class="clearfix" style="list-style-type: none">
                    <li><a href="#"><img src="images/avatar.png" width="22" height="22"> Username</a></li>
                    <li><a href="#"><img src="images/avatar.png" width="22" height="22"> SomeGuy123</a></li>
                    <li><a href="#"><img src="images/avatar.png" width="22" height="22"> PurpleGiraffe</a></li>
                </ul>
            </div>
        </div>
        <div id="userBio">
            <h1 id="viewprofileTitle"><?php echo $_SESSION['username']; ?></h1>


            <a href="editprofile.php" class="gear"><img src="https://cdn4.iconfinder.com/data/icons/ionicons/512/icon-ios7-gear-128.png" height="25" width="25"></a>
        </div>

        <div class="feed">
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
        <div style="clear: both"></div>


        <script type="text/javascript">
            $(function(){
                $('#profiletabs ul li a').on('click', function(e){
                    e.preventDefault();
                    var newcontent = $(this).attr('href');

                    $('#profiletabs ul li a').removeClass('sel');
                    $(this).addClass('sel');

                    $('#content section').each(function(){
                        if(!$(this).hasClass('hidden')) { $(this).addClass('hidden'); }
                    });

                    $(newcontent).removeClass('hidden');
                });
            });
        </script>
    </div>
</div>
<?php
require_once "footer.php";
?>





</body>

</html>