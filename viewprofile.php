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
        <div id="w">
            <div id="content" class="clearfix">
                <div id="userphoto"><img src="images/avatar.png" alt="default avatar"></div>
                <h1>Minimal User Profile Layout</h1>

                <nav id="profiletabs">
                    <ul class="clearfix">
                        <li><a href="#bio" class="sel">Bio</a></li>
                        <li><a href="#activity">Activity</a></li>
                        <li><a href="#friends">Friends</a></li>
                        <li><a href="#settings">Settings</a></li>
                    </ul>
                </nav>

                <section id="bio">
                    <?php echo '$username';  ?>

                    <p>Blah bleh blah bleh blah.</p>

                    <p>Woof Woof bark bark wruff wruff.</p>
                </section>

                <section id="activity" class="hidden">
                    <p>Most recent actions:</p>

                    <p class="activity">@10:15PM - Submitted a news article</p>

                    <p class="activity">@9:50PM - Submitted a news article</p>

                    <p class="activity">@8:15PM - Posted a comment</p>

                    <p class="activity">@4:30PM - Added <strong>someusername</strong> as a friend</p>

                    <p class="activity">@12:30PM - Submitted a news article</p>
                </section>

                <section id="friends" class="hidden">
                    <p>Friends list:</p>

                    <ul id="friendslist" class="clearfix">
                        <li><a href="#"><img src="images/avatar.png" width="22" height="22"> Username</a></li>
                        <li><a href="#"><img src="images/avatar.png" width="22" height="22"> SomeGuy123</a></li>
                        <li><a href="#"><img src="images/avatar.png" width="22" height="22"> PurpleGiraffe</a></li>
                    </ul>
                </section>

                <section id="settings" class="hidden">
                    <p>Edit your user settings:</p><a href="editprofile.php"><img src="images/edit.png"></a>

                    <p class="setting"><span>E-mail Address |</span> lolno@gmail.com</p>

                    <p class="setting"><span>Language |</span> English(US)</p>

                    <p class="setting"><span>Profile Status |</span> Public</p>

                    <p class="setting"><span>Update Frequency |</span> Weekly</p>

                    <p class="setting"><span>Connected Accounts |</span> None</p>
                </section>
            </div><!-- @end #content -->
        </div><!-- @end #w -->
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