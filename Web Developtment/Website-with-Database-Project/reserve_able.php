<?php include 'header.php'; ?>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once "database.php";
session_start();
$u = $_SESSION["account"];
if ( ! isset($_SESSION["account"]) ) { 
    header("Location: index.php");
    exit();
 } else{
        if(isset($_POST['reserve']) && isset($_POST['ISBN'])){//If user confirms they want to resver book
            $ISBN = $conn->real_escape_string($_POST['ISBN']);
            $sql = "UPDATE book SET Reserved = 'Y' WHERE book.ISBN = \"$ISBN\""; //Updates the reseravtion status of the book to being resevered
            $sql2 = "INSERT INTO reservations (ISBN, UserName, ReservedDate) 
                VALUES (\"$ISBN\", \"$u\", CURDATE())"; //Enters the details needed into regestration database
            $conn->query($sql);
            $conn->query($sql2);
            echo 'Success Please return <a href="index.php">Home</a>  Or to <a href="show.php"> Book list Books</a>';
            return;
        }   
}

//Confirming users wants to reserve book
$ISBN = $conn->real_escape_string($_GET['id']);
$sql3 = "SELECT BookTitle,ISBN FROM book WHERE ISBN = '$ISBN'";
$result = $conn->query($sql3);
$row = $result->fetch_assoc();
echo "<p>Confirm: Reserve ".$row["BookTitle"] . "</p>\n";
echo ('<form method="post"><input type="hidden"');
echo ('name="ISBN" value="'.htmlentities($row["ISBN"]).'">'."\n");
echo('<input type="submit" value="Reserve" name="reserve">');
echo('<a href="index.php">Cancel</a>');
echo("\n</form>\n");
?>
</body>
</html>
<?php include 'footer.php'; ?>