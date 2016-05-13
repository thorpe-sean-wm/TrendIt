<?php
session_start();

$dbh = new PDO('mysql:host=127.0.0.1;dbname=trenditdb', 'root', 'root');

$query = "INSERT INTO followers (userID, followingID, followTime) VALUES (:userID, :followingID, NOW())";
$stmt = $dbh->prepare($query);
$result = $stmt->execute(array(
    'userID'      => $_SESSION['userID'],
    'followingID' => $_GET['userID']
));
if($result){
    $successMSG = '<p>You are now following, ' . $pageInfo['username'] . '</p>';
    $location = 'Location: viewprofile.php?user=' . $_GET['userID'];
}
else{
    echo 'Error';
}
header($location);