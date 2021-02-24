<?php
require_once "app/db.php";
session_start();
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
    <title>TimeTracker</title>
</head>
<body class="login_page">
<div class="center">
    <div class="login">
        <div class="switch_login">
            <h1>Time is Money</h1>
            <div class="watch">
                <span class="material-icons change_time up hours">keyboard_arrow_up</span>
                <span class="material-icons change_time up minutes">keyboard_arrow_up</span>
                <h1 class="time">1 3 : 3 7</h1>
                <span class="material-icons change_time down hours">keyboard_arrow_down</span>
                <span class="material-icons change_time down minutes">keyboard_arrow_down</span>
            </div>
            <button id="switch_sign_up">Sign up</button>
        </div>
        <div class="credentials">
            <h1>Sign in</h1>
            <form action="app/login.php" id="login-form" method="POST" class="cred_form">
                <input type="text" placeholder="Username" name="username"><br>
                <input type="password" placeholder="Password" name="password" class="password">
                <span class="material-icons toggle_visible">visibility</span>
            </form>
            <button type="submit" id="submit_credentials" class="submit_form">Login</button>
        </div>
        <div class="credentials_register">
            <h1>Sign up</h1>
            <form action="app/register.php" id="register-form" method="POST" class="cred_form">
                <input type="text" placeholder="Username" name="username"><br>
                <input type="password" placeholder="Password" name="password" class="password"><br>
                <input type="password" placeholder="Password" name="password2" class="password">
            </form>
            <button type="submit" id="submit_register" class="submit_form">Register</button>
        </div>
    </div>
</div>
</body>
</html>
<script>

    function toggle_password_visible(selector, visible){
        $(selector).attr("type", visible ? "text" : "password");
    }

    $(document).ready(function (){
        $("#submit_credentials").click(function (){
            $("#login-form").submit()
        });
        $("#submit_register").click(function (){
            $("#register-form").submit()
        });
        $(document).keyup(function(event) {
            if (event.keyCode === 13) {
                if($(".credentials").css("visibility") === "hidden"){
                    $("#submit_register").click();
                }
                else{
                    $("#submit_credentials").click();
                }
            }
        });
        $("#switch_sign_up").click(function (){
            var switch_login = $(".switch_login")
            var credentials = $(".credentials")
            var credentials_register = $(".credentials_register")
            var switch_button = $("#switch_sign_up")
            switch_login.css("width", "100%")
            credentials.css("width", "0")
            credentials_register.css("width", "0")
            setTimeout(function (){
                if(credentials_register.css("visibility") === "hidden"){
                    switch_button.html("Sign in")
                    credentials_register.css("visibility", "visible")
                    credentials.css("visibility", "hidden")
                    credentials_register.css("width", "790px")
                }
                else{
                    switch_button.html("Sign up")
                    credentials_register.css("visibility", "hidden")
                    credentials.css("visibility", "visible")
                    credentials.css("width", "790px")
                }
                if(switch_login.css("order") === "0"){
                    switch_login.css("order", "1");
                } else{
                    switch_login.css("order", "0");
                }
                switch_login.css("width", "410px")
            },1000);
        })
        $(".toggle_visible").click(function (){
            var toggle_visible = $(this);
            if(toggle_visible.html() === "visibility"){
                toggle_visible.html("visibility_off")
                toggle_password_visible(".password", true)
            }
            else{
                toggle_visible.html("visibility")
                toggle_password_visible(".password", false)
            }
        })
    })
</script>