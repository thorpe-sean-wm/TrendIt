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

        <div align="center">
            <p>Most recent actions:</p>

                    <p class="activity">@10:15PM - Submitted a news article</p>

                    <p class="activity">@9:50PM - Submitted a news article</p>

                    <p class="activity">@8:15PM - Posted a comment</p>

                    <p class="activity">@4:30PM - Added <strong>someusername</strong> as a friend</p>

                    <p class="activity">@12:30PM - Submitted a news article</p>
                </div>


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