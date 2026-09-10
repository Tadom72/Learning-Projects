<?php include 'header.php'; ?>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once "database.php"; 



if ( isset($_POST['UserName']) && isset($_POST['FirstName']) && isset($_POST['LastName']) && isset($_POST['Password']) 
    && isset($_POST['AddressLine1'])&& isset($_POST['AddressLine2']) && isset($_POST['City']) && isset($_POST['Telephone']) 
    && isset($_POST['Mobile']) ) {
        //Pulling the username from the form to check if its been used
        $test = $_POST['UserName'];
        $sql2 = "SELECT UserName FROM user WHERE UserName = \"$test\"";
        $result = $conn->query($sql2);
    //If username is already taken
    if($result->num_rows > 0){
        echo('<p style="color:red">Error Username Exists</p>');
        echo 'Please Try again with new Username';
    }
    else{
        $n = $conn -> real_escape_string($_POST['UserName']);
        $f = $conn -> real_escape_string($_POST['FirstName']);
        $l = $conn -> real_escape_string($_POST['LastName']);
        $p = $conn -> real_escape_string($_POST['Password']);
        $cp = $conn -> real_escape_string($_POST['ConfirmPassword']);
        $a1 = $conn -> real_escape_string($_POST['AddressLine1']);
        $a2 = $conn -> real_escape_string($_POST['AddressLine2']);
        $c = $conn -> real_escape_string($_POST['City']);
        $t = $conn -> real_escape_string($_POST['Telephone']);
        $m  = $conn -> real_escape_string($_POST['Mobile']);
        //checking if pasword and confirm password are identical
        if($p === $cp){
            //Inserting new user with the users details
            $sql = "INSERT INTO user (UserName, Password, FirstName, LastName, Telephone, Mobile, AddressLine1, AddressLine2, City )
            VALUES ('$n', '$p', '$f', '$l', '$t', '$m', '$a1', '$a2', '$c')"; 
            $conn->query($sql);
            echo 'Success <a href="login.php"> Continue...</a>';
        $conn->close();
        }else{
            echo('<p style="color:red">Error Password and Confirm Password Not the same</p>');
            echo 'Please Try again with new Username';
        } 
    }

}


?>

<!--Registration Form-->
<p>Regester</p>
<form method="post">
<p>UserName:
<input type="text" name="UserName"></p>
<p>FirstName:
<input type="text" name="FirstName"></p>
<p>LastName:
<input type="text" name="LastName"></p>
<p>Password:
<input type="password" name="Password"></p>
<p>Confirm password:
<input type="password" name="ConfirmPassword"></p>
<p>Telephone Number:
<input type="number" name="Telephone"></p>
<p>Mobile Number:
<input type="number" name="Mobile"></p>
<p>Address Line 1:
<input type="text" name="AddressLine1"></p> 
<p>Address Line 2:
<input type="text" name="AddressLine2"></p>
<p>City:
<input type="text" name="City"></p>

<p><input type="submit" value="Add New"/></p>
</form>
</body>
</html>
<?php include 'footer.php'; ?>