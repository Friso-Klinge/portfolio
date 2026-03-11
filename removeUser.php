<?php
    function DBConnect(){
        try{
            $dbHandler = new PDO("mysql:host=mysql;dbname=portfolio;charset=utf8", "root", "qwerty");
        } catch (Exception $E) {
            die($E);    
        }

        return $dbHandler;
    }

    session_start();
    if($_SESSION["role"] != "ADMIN"){
        header("location: index.php");
    }
    $user = filter_input(INPUT_GET, "user");
    try{
        DBConnect() -> query('delete from `user` where `id` = ' . $user);
    } catch (Exception $E){
        die($E);
    }
    header("location: adminportal.php");
?>