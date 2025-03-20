<?php
    session_start();
    if($_SESSION["login"] == true){
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
            include("database.php");
            $content = htmlspecialchars($_POST["content"],ENT_QUOTES,"UTF-8");
            $username = $_SESSION["username"];
            $id = htmlspecialchars($_POST["id"],ENT_QUOTES,"UTF-8");

            $sql = "UPDATE articles SET content = ? WHERE username = ? && id = ?";
            $stmt = mysqli_prepare($conn,$sql);
            if($stmt){
                mysqli_stmt_bind_param($stmt,"ssi",$content,$username,$id);
                if(mysqli_stmt_execute($stmt)){
                    mysqli_stmt_close($stmt);
                    mysqli_close($conn);
                    header("Location: myarticles.php");
                    exit();
                }
            }
            mysqli_close($conn);
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["back"])){
            header("Location: myarticles.php");
            exit();
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["id"]) && isset($_POST["content"])){
            $bcontent = htmlspecialchars($_POST["content"],ENT_QUOTES,"UTF-8");
            $id = $_POST["id"];
            echo <<<HTML
                <form action="modify.php" method ="post">
                    <textarea name="content" rows="7" cols="50">$bcontent</textarea><br>
                    <input type="hidden" name="id" value="$id">
                    <input type="submit" name="submit" value ="編輯">
                    <input type="submit" name="back" value ="返回">
                </form>
            HTML;
        }
    }
    else{
        header("Location: myarticles.php");
        exit();
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
    
</body>
</html>
