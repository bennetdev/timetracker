<?php
require_once 'db.php';

if(isset($_POST['username']) && isset($_POST["password"]) && isset($_POST["password2"])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if(strlen($password) !== 0 || $password === $password2 || (strpos($password, " ") == false || strpos($username, " ") == false)) {
        $statement = $db->prepare("SELECT * FROM users WHERE name = :name");
        $result = $statement->execute([
            "name" => $username
        ]);
        $user = $statement->fetch();


        if(empty($user)){
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            $statement = $db->prepare("
		        	INSERT INTO users (name, password)
		        	VALUES (:name, :password)
	        ");
            $result = $statement->execute([
                'name' => $username,
                'password' => $password_hash,
            ]);
        }
    }
}
header("Location: ../index.php");
?>