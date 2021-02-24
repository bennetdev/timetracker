<?php
    require_once "app/db.php";
    session_start();
    if(!isset($_SESSION["user_id"])){
        header("Location: login.php");
    }

    $projectQuery = $db->prepare("
        SELECT * FROM projects WHERE user_id = :user_id;
    ");
    $projectQuery->execute([
            "user_id" => $_SESSION["user_id"]
    ]);

    $projects = $projectQuery->rowCount() ? $projectQuery->fetchAll(\PDO::FETCH_ASSOC) : [];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="js/script.js"></script>
    <title>TimeTracker</title>
</head>
<body>
<div class="center">
    <div class="projects">
        <?php foreach ($projects as $project) { ?>
            <div class="project" id="<?php echo $project["id"]?>">
                <div class="header">
                    <input class="title" type="text" value="<?php echo $project["name"]?>"/>
                    <span class="not_live"></span>
                    <span class="material-icons play">play_arrow</span>
                </div>
                <div class="content">
                    <input class="money total" type="text" value="<?php echo "$".$project["money"]?>"/>
                    <p class="money per_hour"><?php echo "$".$project["money_per_hour"]."/hr"?></p>
                    <div class="watch">
                        <span class="material-icons change_time up hours">keyboard_arrow_up</span>
                        <span class="material-icons change_time up minutes">keyboard_arrow_up</span>
                        <h1 class="time"><?php echo $project["time"]?></h1>
                        <span class="material-icons change_time down hours">keyboard_arrow_down</span>
                        <span class="material-icons change_time down minutes">keyboard_arrow_down</span>
                    </div>
                </div>
            </div>
        <?php } ?>
            <div class="add_project">
                <span class="material-icons add">add</span>
            </div>
    </div>
</div>
</body>
</html>