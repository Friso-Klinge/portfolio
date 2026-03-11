<?php
    session_start();
    if($_SESSION["role"] != "ADMIN"){
        header("location: index.php");
    }

    function DBConnect(){
        try{
            $dbHandler = new PDO("mysql:host=mysql;dbname=portfolio;charset=utf8", "root", "qwerty");
        } catch (Exception $E) {
            die($E);    
        }

        return $dbHandler;
    }
    
    if($_SERVER['REQUEST_METHOD'] == "POST"){
        $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_SPECIAL_CHARS);
        $semester = filter_input(INPUT_POST, "semester", FILTER_SANITIZE_SPECIAL_CHARS);
        $description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_SPECIAL_CHARS);
        $access = filter_input(INPUT_POST, "access", FILTER_SANITIZE_SPECIAL_CHARS);
        $status = filter_input(INPUT_POST, "status", FILTER_SANITIZE_SPECIAL_CHARS);
        $update = filter_input(INPUT_POST, "update", FILTER_SANITIZE_SPECIAL_CHARS);
        if(strlen($_POST["file"]) == 0){
            DBConnect() -> query("UPDATE `files` SET `id` = '34.', `name` = '$name', `semester` = '$semester', `description` = '$description', `access` = '$access', `status` = '$status' WHERE `id` = $update");
            header("location: adminportal.php");    
            exit();
        } else {
            var_dump($_POST["file"]);
            exit();
        }
    }

    $delete = filter_input(INPUT_GET, "delete");
    $file = filter_input(INPUT_GET, "file");
    
    if($delete == "true"){
        try{
            DBConnect() -> query('delete from `files` where `id` = ' . $file);
        } catch (Exception $E){
            die($E);
        }
        header("location: adminportal.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="editFile.php" method="post">
        <input type="file" name="file" id="file"><br>
        <?php
        $stmt = DBConnect() -> query("SELECT * from files where id = $file");
        $files =  $stmt -> fetchAll(PDO::FETCH_ASSOC);
        $options = ["name", "access", "description"];
        for($i = 0; $i < count($options); $i++){
            echo "<label for='{$options[$i]}'>{$options[$i]}</label>";
            echo "<input type='text' name='{$options[$i]}' id='{$options[$i]}' value='{$files[0][$options[$i]]}'> <br>";
        }
        ?>
        <select name="semester" id="semester">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <select name="status" id="status">
            <option value="INGEDIEND">o</option>
            <option value="GOEDGEKEURD">✓</option>
            <option value="AFGEKEURD">☓</option>
        </select>
        <input type="text" name="update" id="update" hidden="true" value="<?php echo $file;?>">
        <input type="submit" value="Update">
    </form>
</body>
</html>