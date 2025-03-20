
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="createaccount.php" method="post">
        <h2>註冊</h2>
        <label>用戶名:</label><br>
        <input type="text" name="username"><br>
        <label>Email:</label><br>
        <input type="email" name="email"><br>
        <label>密碼:</label><br>
        <input type="password" name="password"><br>
        <input type="submit" name="submit" value="提交">
        <input type="submit" name="back" value="返回">
    </form>
</body>
</html>
<?php
    include("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])){
        $username = htmlspecialchars($_POST["username"],ENT_QUOTES,"UTF-8");
        $email = htmlspecialchars($_POST["email"],ENT_QUOTES,"UTF-8");
        $password = htmlspecialchars($_POST["password"],ENT_QUOTES,"UTF-8");
        $hash = password_hash($password,PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (name,email,password) 
                VALUES (?,?,?)";
        $stmt = mysqli_prepare($conn,$sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"sss",$username,$email,$hash);
            if(mysqli_stmt_execute($stmt)){
                echo "註冊成功!!";
            }
            else{
                echo "註冊失敗!!";
            }
            mysqli_stmt_close($stmt);
        }
    }
    elseif($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["back"])){
        mysqli_close($conn);
        header("Location: index.php");
        exit();
    }

    mysqli_close($conn);
?>
