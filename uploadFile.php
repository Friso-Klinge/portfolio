<?php
try{    
    $dbHandler = new PDO("mysql:host=mysql;dbname=portfolio;charset=utf8", "root", "qwerty");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $stmt = $dbHandler -> prepare("INSERT INTO `files` (`name`,`source`, `uploadDate`, `semester`)
                                                    VALUES (:Fname, :source, :uploadDate, :semester)");

        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $source = $_FILES["file"]["name"];
        $uploadDate = date("Y-m-d");
        $semester = filter_input(INPUT_POST, "semester", FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt -> bindParam("Fname", $name, PDO::PARAM_STR);
        $stmt -> bindParam("source", $source, PDO::PARAM_STR);
        $stmt -> bindParam("uploadDate", $uploadDate, PDO::PARAM_STR);
        $stmt -> bindParam("semester", $semester, PDO::PARAM_STR);
        
        $stmt -> execute();

        move_uploaded_file($_FILES["file"]["tmp_name"], "files/". $_FILES["file"]["name"]);
        }
    } catch(Exception $ex){
    die($ex);
}
header("location: adminportal.php");
exit;
?>