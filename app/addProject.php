<?php
    require_once "db.php";
    session_start();
    if(isset($_SESSION["user_id"])){
        $subkategorieQuery = $db->prepare("
			INSERT projects (name, money, user_id)
			VALUES (:name, :money, :user_id)
		");
        $subkategorieQuery->execute([
            'name' => "Project",
            "money" => 0,
            'user_id' => $_SESSION["user_id"],
        ]);
        $lastId = $db->lastInsertId();
        echo '<div class="project" id="'. $lastId. '">
                <div class="header">
                    <input class="title" type="text" value="Project"/>
                    <span class="not_live"></span>
                    <span class="material-icons play">play_arrow</span>
                </div>
                <div class="content">
                    <input class="money total" type="text" value="$0"/>
                    <p class="money per_hour">$0/hr</p>
                    <div class="watch">
                        <span class="material-icons change_time up hours">keyboard_arrow_up</span>
                        <span class="material-icons change_time up minutes">keyboard_arrow_up</span>
                        <h1 class="time">0 0 : 0 0</h1>
                        <span class="material-icons change_time down hours">keyboard_arrow_down</span>
                        <span class="material-icons change_time down minutes">keyboard_arrow_down</span>
                    </div>
                </div>
            </div>';
    }