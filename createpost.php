<?php
session_start();

if (isset($_POST['submit'])){
    $dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

    $query = "INSERT INTO posts (userID, post, postTime) VALUES (:userID, :post, NOW())";
    $stmt = $dbh->prepare($query);
    $result = $stmt->execute(array(
        'userID' => $_POST['userID'],
        'post'   => $_POST['post']
    ));
    if($result){
        $successMSG = '<p>Your post has been posted!</p>';
        $location = 'Location: viewprofile.php?user=' . $_POST['view'];
    }
    else{
        echo 'Error';
    }
    header($location);
}