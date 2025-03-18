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
        <a href="index.php">返回</a>
    </form>
</body>
</html>

<?php
    include("database.php");

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
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

    mysqli_close($conn);
?>