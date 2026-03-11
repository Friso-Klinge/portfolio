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
    if(!isSet($_SESSION["role"])){
        header("location: login.php");
    } else if(!($_SESSION["role"] == "ADMIN")){
        header("location: index.php");
    }

    function getUsers(){
        $stmt = DBConnect() -> query("SELECT * from user");
        $users =  $stmt -> fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($users); $i++){
            echo"
                <a href='removeUser.php?user={$users[$i]['id']}'>🗑</a>
                {$users[$i]['email']}
                {$users[$i]['role']}
                <br>
                password:
            ";
            if($users[$i]['password'] == "unset"){
                echo "unset <br>";
            } else {
                echo "set <br>";
            }
        }
    }

    function getFiles(){
        $stmt = DBConnect() -> query("SELECT * from files order by semester");
        $files =  $stmt -> fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($files); $i++){
            if($files[$i]["status"] == "GOEDGEKEURD"){
                $status = "✓";
            } else if ($files[$i]["status"] == "AFGEKEURD"){
                $status = "☓";
            } else {
                $status = "o";
            }
            echo"
                <a href='editFile.php?file={$files[$i]['id']}&delete=true'>🗑</a>
                <a href='editFile.php?file={$files[$i]['id']}&delete=false'>✎</a>
                $status
                {$files[$i]['name']}
                {$files[$i]['semester']}
                {$files[$i]['access']}
                <br>
                {$files[$i]['description']}
                <br>
            ";
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/adminPortal.css">
</head>
<body>
    <a href="index.php"><button>Homepage</button></a>
    <h2>Users</h2>
    <form action="addUser.php" method="post">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <label for="role">role</label>
        <select name="role" id="role">
            <option value="ADMIN">Admin</option>
            <option value="PROF_SKILLS">Proffesional skills</option>
            <option value="CODING">Coding</option>
            <option value="PUBLIC">public</option>
        </select>
        <input type="submit" value="Add">
    </form>
    <?php getUsers(); ?>
    <h2>Files</h2> 
    <form action="uploadFile.php" method="post" enctype="multipart/form-data">
        <label for="name">Name</label>
        <input type="text" name="name" id="name">
        <label for="file">File</label>
        <input type="file" name="file" id="file">
        <label for="semester">Semester</label>
        <select name="semester" id="semester">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
        </select>
        <label for="description">Description</label>
        <input type="description" name="description" id="description">
        <label for="access">Access</label>
        <input type="access" name="access" id="access">
        <input type="submit" value="Upload">
    </form>
    <?php getFiles(); ?>
</body>
</html>