<?php
session_start();

$dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

//Run delete check to code
if (isset($_POST['delete'])){

    $query = "DELETE FROM posts WHERE postID = :postID LIMIT 1";
    $stmt = $dbh->prepare($query);
    $result = $stmt->execute(array(
        'postID' => $_POST['postID'],
    ));
    
    $query = "DELETE FROM likes WHERE postID = :postID LIMIT 1";
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

//Check to run Like code
if (isset($_POST['like'])){

    $query = "INSERT INTO likes (postID, userID, likeTime) VALUES (:postID, :userID, NOW())";
    $stmt = $dbh->prepare($query);
    $result = $stmt->execute(array(
        'postID' => $_POST['postID'],
        'userID' => $_SESSION['userID']
    ));
    if($result){
        $successMSG = '<p>You have liked the post.</p>';
        $location = 'Location: viewprofile.php?user=' . $_POST['viewID'];
    }
    else{
        echo 'Error';
    }
    header($location);
}

//Check to run remove like code
if (isset($_POST['unlike'])){

    $query = "DELETE FROM likes WHERE postID = :postID AND userID = :userID LIMIT 1";
    $stmt = $dbh->prepare($query);
    $result = $stmt->execute(array(
        'postID' => $_POST['postID'],
        'userID' => $_SESSION['userID']
    ));
    if($result){
        $successMSG = '<p>You have unliked the post.</p>';
        $location = 'Location: viewprofile.php?user=' . $_POST['viewID'];
    }
    else{
        echo 'Error';
    }
    header($location);
}