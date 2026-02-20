<?php
    session_start();
    if(!isSet($_SESSION["role"])){
        header("location: login.php");
    } else if(!($_SESSION["role"] = "ADMIN")){
        header("location: index.php");
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
    <h2>Add user</h2>
    <form action="addUser.php" method="post">
        <label for="email">Email</label>
        <input type="text" name="email" id="email">
        <label for="pass">Password</label>
        <input type="text" name="pass" id="pass">
        <label for="role">role</label>
        <select name="role" id="role">
            <option value="ADMIN">Admin</option>
            <option value="PROF_SKILLS">Proffesional skills</option>
            <option value="CODING">Coding</option>
            <option value="PUBLIC">public</option>
        </select>
        <input type="submit" value="Add">
    </form>
    <h2>File Upload</h2> 
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
        <input type="submit" value="Upload">
    </form>
</body>
</html>