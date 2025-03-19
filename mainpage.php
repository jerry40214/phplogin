<?php
    session_start();
    include("database.php");
    echo "<h1>歡迎回來{$_SESSION["username"]}</h1>"
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="mainpage.php" method="post">
        <label>發表文章</label><br>
        <input type="text" name="content"><br>
        <input type="submit" name="submit" value="上傳">
        <a href="search.php">搜尋文章</a>
    </form>
    
</body>
</html>
<?php
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $content = $_POST["content"];
        $username = $_SESSION["username"];

        $sql = "INSERT INTO articles(content,username) VALUES(?,?)";
        $stmt = mysqli_prepare($conn,$sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"ss",$content,$username);
            if(mysqli_stmt_execute($stmt)){
                echo "上傳成功!!";
                header("Location: search.php");
            }
            else{
                echo "上傳失敗!!";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($conn);
?>