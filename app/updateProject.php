<?php
require_once "db.php";
session_start();

if(isset($_SESSION["user_id"]) && isset($_POST["id"])){
    if(isset($_POST["name"])){
        $nameQuery = $db->prepare("
			UPDATE projects SET name = :name WHERE user_id = :user_id and id = :id
		");
        $nameQuery->execute([
            'name' => $_POST["name"],
            'user_id' => $_SESSION["user_id"],
            'id' => $_POST["id"]
        ]);
    }
    elseif(isset($_POST["money"])){
        $moneyQuery = $db->prepare("
			UPDATE projects SET money = :money WHERE user_id = :user_id and id = :id
		");
        $moneyQuery->execute([
            'money' => floatval(substr($_POST["money"], 1)),
            'user_id' => $_SESSION["user_id"],
            'id' => $_POST["id"]
        ]);
    }
    elseif(isset($_POST["time"])){
        $moneyQuery = $db->prepare("
			UPDATE projects SET time = :time WHERE user_id = :user_id and id = :id
		");
        $moneyQuery->execute([
            'time' => $_POST["time"],
            'user_id' => $_SESSION["user_id"],
            'id' => $_POST["id"]
        ]);
    }
}