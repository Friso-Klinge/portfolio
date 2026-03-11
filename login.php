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

    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_SPECIAL_CHARS);
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
            header("location: index.php");
        } else if ($users[0]["password"] == "unset"){
            try{
                $stmt = DBConnect() -> prepare("UPDATE `user` SET `password` = '" . password_hash($pass, PASSWORD_BCRYPT) . "' where `email` = '$email'");
                $stmt -> execute();
            } catch (Exception $E) {
                die($E);    
            }
            $_SESSION["role"] = $users[0]["role"];
        }
        header("location: adminPortal.php");
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
            <input type="text" name="email" id="email" placeholder="Email">
            <br>
            <input type="text" name="pass" id="pass" placeholder="Password">
            <br>
            <input type="submit" value="Login">
        </form>
    </div>
</body>
</html>