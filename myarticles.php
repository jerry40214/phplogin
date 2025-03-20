
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="myarticles.php" method="post">
        <input type="submit" name="back" value="返回">
        <input type="submit" name="logout" value="登出">
    </form>
</body>
</html>

<?php
    session_start();
    
    if($_SESSION["login"] == true){
        include("database.php");
        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["back"])){
            mysqli_close($conn);
            header("Location: mainpage.php");
            exit();
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST"  && isset($_POST["logout"])){
            mysqli_close($conn);
            header("Location: logout.php");
            exit();
        }
        echo "<h1>以下是".htmlspecialchars($_SESSION["username"],ENT_QUOTES,"UTF-8")."的文章:</h1>";
        $username = $_SESSION["username"];
        $sql = "SELECT * FROM articles WHERE username = ?";
        $stmt = mysqli_prepare($conn,$sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"s", $username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            while($row = mysqli_fetch_assoc($result)){
                $id = $row["id"];
                $content = $row["content"];
                echo <<<HTML
                    <div>
                        <h3>作者:{$row["username"]} 發布日期:{$row["content_date"]}</h3>
                        <h3>文章:</h3><br><p>{$row["content"]}</p><br>
                        <form action="modify.php" method ="post">
                            <input type="hidden" name="id" value="$id">
                            <input type="hidden" name="content" value="$content">
                            <input type="submit" name="modify" value="編輯文章">
                        </form>
                    </div>
                HTML;
            }
            
        }
        mysqli_stmt_close($stmt);
        mysqli_close($conn);
    }
    else{
        header("Location: index.php");
    }

?>