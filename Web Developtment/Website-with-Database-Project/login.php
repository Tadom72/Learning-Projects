<?php include 'header.php'; ?>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<?php 
session_start();
require_once "database.php";
//$sql = "SELECT Username, Password FROM user";
//$result = $conn->query($sql);



//Once User has submitted login form with a username and password
if ( isset($_POST["account"]) && isset($_POST["pw"]) ){ 
    $pw = $_POST['pw'];
    $account = $_POST['account'];
    //Getting all usernames and passwords that match the input of user
    $query = "SELECT * FROM user WHERE UserName = '$account' AND Password = '$pw'";
    $result = $conn->query($query);
    //If the query returns a row (the username and password match one within the database)
    if ($result->num_rows > 0){
        $_SESSION["account"] = $_POST["account"];
        $_SESSION["success"] = "Logged in.";
        header( 'Location: index.php' ) ;
        return;
    }else{
        $_SESSION["error"] = "Incorrect password.";
        header( 'Location: login.php' ) ;
        return;
}
}

?>


<?php
//if theres a session error
if ( isset($_SESSION["error"]) ) {
echo('<p style="color:red">Error:'.
$_SESSION["error"]."</p>\n");
unset($_SESSION["error"]);
}
?>
<form method="post">
<p>Account: <input type="text" name="account" value=""></p>
<p>Password: <input type="password" name="pw" value=""></p>
<p><input type="submit" value="Log In">
 <input type="button" value="Home" onclick="location.href='index.php'; return false "></p>
</form>
</body>
</html>
<?php include 'footer.php'; ?>