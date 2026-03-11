<?php
    session_start();

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
       $source =  "intro.pdf";
    }

    function placeButtons(){
        $semester = filter_input(INPUT_GET, "semester");
        if(is_null($semester)){
            $semester =  "1";
        }    
        $stmt = DBConnect() -> query("SELECT * from files where `semester` = $semester");
        $files =  $stmt -> fetchAll(PDO::FETCH_ASSOC);    
        for ($i = 0; $i < count($files); $i++){
            $access = explode(",", $files[$i]["access"]);
            if(in_array($_SESSION["role"], $access)){
                echo"
                    <a href='index.php?source={$files[$i]['source']}&semester=$semester'><button>{$files[$i]['name']}</button></a>
                ";
            }
        }
    }

    function loginSource(){
        if(!isset($_SESSION["role"])){
            echo "img/enter.png";
        } else {
            echo "img/logout.png";
        }
    }

    function loginHref(){
        if(!isset($_SESSION["role"])){
            echo "login.php";
        } else {
            echo "logout.php";
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
        <div class="Semesters">
            <a href="Index.php?semester=1"><button>Semester 1</button></a>
            <a href="Index.php?semester=2"><button>Semester 2</button></a>
            <a href="Index.php?semester=3"><button>Semester 3</button></a>
            <a href="Index.php?semester=4"><button>Semester 4</button></a>
            <a href="<?php loginHref() ?>" id="small_link"><img src="<?php loginSource() ?>" alt="login/out" id="adminPortal"></a>
            <a href="adminPortal.php" id="small_link"><img src="img/Gear.png" alt="adminPortal" id="adminPortal"></a>
        </div>
        <embed src="files/<?php echo $source ?>" type="">
        <div class="Subjects">
            <?php
                placeButtons();
            ?>
        </div>
    </div>
</body>
</html>