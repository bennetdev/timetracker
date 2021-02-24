<?php
if(isset($_POST["username"]) && $_POST["password"]){
    require_once "db.php";
    session_start();
    $username = $_POST["username"];
    $password = $_POST["password"];

    $userQuery = $db->prepare("
		SELECT * FROM users
		WHERE name = :name
	");
    $userQuery->execute([
        'name' => trim($username)
    ]);
    $user = $userQuery->fetch();
    if(!empty($user)){
        if(password_verify($password, $user["password"])){
            $_SESSION['user_id'] = $user['id'];
            echo "right creds";
        }
    }
    header("Location: ../index.php");

}