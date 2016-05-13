<?php
session_start();

if (isset($_POST['submit'])){
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

    $query = "DELETE FROM posts WHERE postID = :postID LIMIT 1";
    $stmt = $dbh->prepare($query);
    $result = $stmt->execute(array(
        'postID' => $_POST['postID'],
    ));
    if($result){
        $successMSG = '<p>You have deleted the post.</p>';
        $location = 'Location: viewprofile.php?user=' . $_SESSION['userID'];
    }
    else{
        echo 'Error';
    }
    header($location);
}