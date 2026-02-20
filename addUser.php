<?php
try{    
    $dbHandler = new PDO("mysql:host=mysql;dbname=portfolio;charset=utf8", "root", "qwerty");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $stmt = $dbHandler -> prepare("INSERT INTO `user` (`email`,`password`, `role`)
                                                    VALUES (:email, :pass, :role_)");

        $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
        $pass = password_hash(filter_input(INPUT_POST, "pass", FILTER_SANITIZE_SPECIAL_CHARS), PASSWORD_BCRYPT);
        $role = filter_input(INPUT_POST, "role", FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt -> bindParam("email", $email, PDO::PARAM_STR);
        $stmt -> bindParam("pass", $pass, PDO::PARAM_STR);
        $stmt -> bindParam("role_", $role, PDO::PARAM_STR);
        
        $stmt -> execute();
        }
    } catch(Exception $ex){
    die($ex);
}
header("location: adminportal.php");
exit;
?>