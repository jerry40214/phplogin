<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="index.php" method="post" >
        <h2>登入</h2>
        <label>username:</label>
        <input type="text" name="username"><br>
        <label>password:</label>
        <input type="password" name="password"><br>
        <input type="submit" name="login" value="Log in">
        <a href="createaccount.php"> start here</a>
        <br>
    </form>
</body>
</html>

<?php
    session_start();
    include("database.php");
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST["username"];
        $password = $_POST["password"];

        $sql = "SELECT password FROM users WHERE name = ?";
        $stmt = mysqli_prepare($conn,$sql);
        if($stmt){
            mysqli_stmt_bind_param($stmt,"s",$username);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            $row = mysqli_fetch_assoc($result);

            if (empty($row)) {
                echo "帳號不存在！<br>";
                exit;
            }

            if(password_verify($password,$row["password"])){
                $_SESSION["username"] = $username;
                header("Location: mainpage.php");
            }
            else{
                echo "登入失敗!!<br>";
            }
            mysqli_stmt_close($stmt);
        }
    }

    mysqli_close($conn);
?>
