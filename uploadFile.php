<?php
try{    
    $dbHandler = new PDO("mysql:host=mysql;dbname=portfolio;charset=utf8", "root", "qwerty");
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $stmt = $dbHandler -> prepare("INSERT INTO `files` (`name`,`source`, `uploadDate`, `semester`, `description`, `access`)
                                                    VALUES (:Fname, :source, :uploadDate, :semester, :descr, :access)");

        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $source = explode("/", $_FILES["file"]["tmp_name"]);
        $source = $source[2] . ".pdf";
        $uploadDate = date("Y-m-d");
        $semester = filter_input(INPUT_POST, "semester", FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
        $access = filter_input(INPUT_POST, "access", FILTER_SANITIZE_SPECIAL_CHARS);

        $stmt -> bindParam("Fname", $name, PDO::PARAM_STR);
        $stmt -> bindParam("source", $source, PDO::PARAM_STR);
        $stmt -> bindParam("uploadDate", $uploadDate, PDO::PARAM_STR);
        $stmt -> bindParam("semester", $semester, PDO::PARAM_STR);
        $stmt -> bindParam("descr", $description, PDO::PARAM_STR);
        $stmt -> bindParam("access", $access, PDO::PARAM_STR);

        $mimeType = $_FILES["file"]["type"];

        if($mimeType == "application/msword" || $mimeType == "application/vnd.openxmlformats-officedocument.wordprocessingml.document" || $mimeType == "application/pdf"){
            move_uploaded_file($_FILES["file"]["tmp_name"], "files/". $source);
            $stmt -> execute();
        } else {
            die("File must be doc, docx or pdf");
        }
    }
    } catch(Exception $ex){
    die($ex);
}
header("location: adminportal.php");
exit;
?>