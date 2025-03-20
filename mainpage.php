<?php
    session_start();
    if($_SESSION["login"] == true){
        include("database.php");
        echo "<h1>歡迎回來".htmlspecialchars($_SESSION["username"],ENT_QUOTES,"UTF-8")."</h1>";

        $success_upload = "";
        if(isset($_SESSION["success_upload"])){
            $success_upload = $_SESSION["success_upload"];
            unset($_SESSION["success_upload"]);
        }
        $error_message = "";
        

        if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
            $content = htmlspecialchars($_POST["content"],ENT_QUOTES,"UTF-8");
            $username = $_SESSION["username"];
            if(!empty($content)){
                $sql = "INSERT INTO articles(content,username) VALUES(?,?)";
                $stmt = mysqli_prepare($conn,$sql);
                if($stmt){
                    mysqli_stmt_bind_param($stmt,"ss",$content,$username);
                    if(mysqli_stmt_execute($stmt)){
                        mysqli_stmt_close($stmt);
                        mysqli_close($conn);
                        $_SESSION["success_upload"] = "成功上傳!!!";
                        header("Location: mainpage.php");
                        exit();
                    }
                    else{
                        $error_message = "上傳失敗!!";
                    }
                    mysqli_stmt_close($stmt);
                }
            }
            else{
                $error_message = "文章不能空白!!";
            }
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])){
            mysqli_close($conn);
            header("Location: search.php");
            exit();
        }
        elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])){
            mysqli_close($conn);
            header("Location: logout.php");
            exit();
        }
        mysqli_close($conn);
    }
    else{
        header("Location: index.php");
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
    <form action="myarticles.php" method="post">
        <input type="submit" name="myarticles" value="我的文章">
    </form>
    <form action="mainpage.php" method="post">
        <label>發表文章</label><br>
        <input type="text" name="content"><br>
        <input type="submit" name="submit" value="上傳">
        <input type="submit" name="search" value="搜尋文章">
        <input type="submit" name="logout" value="登出">
    </form>
    <?php
        if(!empty($success_upload)){
            echo "<div>{$success_upload}</div>";
        }
        if(!empty($error_message)){
            echo "<div>{$error_message}</div>";
        }
    ?>
</body>
</html>
