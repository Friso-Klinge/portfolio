<?php
session_start();

if($_SERVER['REQUEST_METHOD'] == "POST"){
    function DBConnect(){
        try{
            $dbHandler = new PDO("mysql:host=mysql;dbname=portfolio;charset=utf8", "root", "qwerty");
        } catch (Exception $E) {
            die($E);    
        }

        return $dbHandler;
    }

    $email = filter_input(INPUT_POST, "email");
    $pass = filter_input(INPUT_POST, "pass");

    try{
        $stmt = DBConnect() -> query("SELECT * from user where email = '$email'");
        $users =  $stmt -> fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $E) {
        die($E);    
    }

    if(count($users) == 1){
        if(password_verify($pass, $users[0]["password"])){
            $_SESSION["role"] = $users[0]["role"];
        }
    }

    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
    <div>
    <h2>Login</h2>
        <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post">
            <label for="email">Email</label>
            <input type="text" name="email" id="email">
            <br>
            <label for="pass">Password</label>
            <input type="text" name="pass" id="pass">
            <br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>