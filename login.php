<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="stylelogin.css">
    <link rel="stylesheet" href="loginstyle.php">
</head>
<body>

<div class="login-container">
    <h2>Login</h2>
    <form action="login.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="login" value="Login">
    </form>
    <div class="signup-link">
        <a href="signup.php">Sign up for an account</a>
    </div>
</div>

</body>
</html>
<?php
include("database.php");
if($_SERVER["REQUEST_METHOD"]=="POST")
{ 
    if(isset($_POST["login"]))
    {
    $flag=0;
    $username=$_POST["username"];
    $pass=$_POST["password"];



    $sql= "SELECT * FROM userdetails";
    $result= mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()) {
            $user_id = $row["user"];
            $hash_id = $row["pass"];
            if($user_id==$username){
                $flag=1;
                if(password_verify($pass, $hash_id)) {
                    header("Location: index.html");
                    exit();
                }
                else{
                    echo "<h3>Incorrect Password</h3>";
                } 
        }
    }
    if($flag==0)
    {  
   echo "<h3>Incorrect Username</h3>";
    }
    }         
}
}
mysqli_close($conn);
?>