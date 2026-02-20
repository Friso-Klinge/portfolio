<?php
    session_start();
    if(!isSet($_SESSION["role"])){
        header("location: login.php");
    }

    function DBConnect(){
        try{
            $dbHandler = new PDO("mysql:host=mysql;dbname=portfolio;charset=utf8", "root", "qwerty");
        } catch (Exception $E) {
            die($E);    
        }

        return $dbHandler;
    }

    $source = filter_input(INPUT_GET, "source");

    if(is_null($source)){
       $source =  "PVA-Gemorskos.pdf";
    }

    function placeButtons(){
        $stmt = DBConnect() -> query("SELECT * from files");
        $files =  $stmt -> fetchAll(PDO::FETCH_ASSOC);
        for ($i = 0; $i < count($files); $i++){
            echo"
                <a href='index.php?source={$files[$i]['source']}'><button>{$files[$i]['name']}</button></a>
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
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    <div class="grid">
        <div class="colspan2">
            <img src="img/CVface.jpg" alt="profile picture">
            <h1>Portfolio Friso Klinge</h1>
        </div>
    
        <div class="rowspan2">
            <embed src="files/<?php echo $source ?>" type="">
        </div>
        <div class="Semesters">
            <a href="Index.php"><button>Semester 1</button></a>
            <a href="Index.php"><button>Semester 2</button></a>
            <a href="Index.php"><button>Semester 3</button></a>
            <a href="Index.php"><button>Semester 4</button></a>
        </div>
        <div class="Subjects">
            <?php
                placeButtons();
            ?>
        </div>
    </div>
</body>
</html>