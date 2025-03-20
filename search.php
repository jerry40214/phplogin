<?php
    session_start();

    if($_SESSION["login"] == true){
        include("database.php");
        echo "<h1>歡迎回來".htmlspecialchars($_SESSION["username"],ENT_QUOTES,"UTF-8")."</h1>";
    }
    else{
        mysqli_close($conn);
        header("Location: index.php");
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
    <form action="search.php" method="get">
        <label>搜尋使用者文章:</label><br>
        <input type="text" name="username">
        <input type="submit" name="search" value="搜尋">
        <br>
    </form>
    <form action = "search.php" method="post">
        <input type="submit" name="back" value="返回">
        <input type="submit" name="logout" value="登出">
    </form>
    
</body>
</html>
<?php
    if($_SESSION["login"] == true){
        if($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["search"])){
            if(!empty($_GET["username"])){

                $username = htmlspecialchars($_GET["username"],ENT_QUOTES,"UTF-8");
                
                $sql = "SELECT content,username,content_date FROM articles where username = ?";
                $stmt = mysqli_prepare($conn,$sql);
                if($stmt){
                    mysqli_stmt_bind_param($stmt,"s",$username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    echo "<h1>搜尋{$username}文章如下:</h1>";
                    while( $row = mysqli_fetch_assoc($result)){
                        echo <<<HTML
                            <div>
                                <h3>作者:{$row["username"]} 發布日期:{$row["content_date"]}</h3>
                                <h3>文章:</h3><br><p>{$row["content"]}</p>
                            </div>
                         HTML;
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            else{
                echo <<<HTML
                <div>搜尋欄不能空白!!</div>
                HTML;
            }
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])){
            mysqli_close($conn);
            header("Location: logout.php");
            exit();
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["back"])){
            mysqli_close($conn);
            header("Location: mainpage.php");
            exit();
        }
        mysqli_close($conn);
    }
?>