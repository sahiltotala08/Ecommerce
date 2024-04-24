<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="stylesignup.css">
    <link rel="stylesheet" href="signupstyle.php">
</head>
<body>

<div class="signup-container">
    <h2>Sign Up</h2>
    <form action="signup.php" method="post">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="tel" name="phone" placeholder="Phone Number" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" name="signup" value="Sign Up">
    </form>
    <div class="login-link">
        <a href="login.php">Already have an account? Login</a>
    </div>
</div>

</body>
</html>

<?php
include("database.php");
if($_SERVER["REQUEST_METHOD"]=="POST")
{ 
    if(isset($_POST["signup"]))
    {
    $flag=0;
    $username=$_POST["username"];
    $email= filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $phone= $_POST["phone"];
    $pass=$_POST["password"];
    $hash=password_hash($pass, PASSWORD_DEFAULT);
    if(strlen($phone)!=10)
    {
        echo "<h3>Enter 10 digit Phone number</h3>";
        $flag=1;
    }
    $sql= "SELECT * FROM userdetails";
    $result= mysqli_query($conn, $sql);
    if(mysqli_num_rows($result)>0){
    while($row = $result->fetch_assoc()) {
            $user_id = $row["user"];
            $email_id = $row["email"];
            $phone_no = $row["phone"];
            if($user_id==$username){
                echo "<h3>Username already taken</h3>";
                $flag=1;
                break;
            }
            else if($email_id==$email){
                echo "<h3>Email already taken</h3>";
                $flag=1;
                break;
            }
            else if($phone_no==$phone){
                echo "<h3>Phone number already taken</h3>";
                $flag=1;
                break;
            }
        }
    }

    if($flag==0)
    {
    $sql= "INSERT INTO userdetails (user, email, phone, pass) values ('$username', '$email' , '$phone' , '$hash')";
    try{
        // if(strlen($phone)!=10){
        //     throw new Exception();
        // }
     mysqli_query($conn, $sql);
     echo "<h3>Inserted succesfully</h3>";
     header("Location: login.php");
  exit();
    }
    // catch(Exception $e){
    //     echo"Enter 10 digit Phone number";
    // }
    catch(mysqli_sql_exception)
    {   
       
            echo "<h3>Some error occured</h3>";  
           
}
}
}
}

mysqli_close($conn);
?>




