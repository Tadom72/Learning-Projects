<?php include 'header.php'; ?>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php
require_once "database.php";
if(isset($_POST['delete']) && isset($_POST['ISBN'])){//Once user confirm they wish to unreserve
    $ISBN = $conn->real_escape_string($_POST['ISBN']);
    $sql = "UPDATE book SET Reserved = 'N' WHERE book.ISBN = \"$ISBN\"";//Reset Reserved status of the book to no
    $sql2 = "DELETE FROM reservations WHERE ISBN = \"$ISBN\"";//Remove this books info from reservation database
    $conn->query($sql);
    $conn->query($sql2);
    echo 'Success Please return <a href="index.php">Home</a>  Or back to <a href="reserved.php"> Your reserved Books</a>';
    return;
}

//Confirming User wishes to unreserve book
$ISBN = $conn->real_escape_string($_GET['id']);
$sql3 = "SELECT BookTitle,ISBN FROM book WHERE ISBN = '$ISBN'";
$result = $conn->query($sql3);
$row = $result->fetch_assoc();
echo "<p>Confirm: Deleting ".$row["BookTitle"] . "</p>\n";
echo ('<form method="post"><input type="hidden"');
echo ('name="ISBN" value="'.htmlentities($row["ISBN"]).'">'."\n");
echo('<input type="submit" value="Unreserve" name="delete">');
echo('<a href="index.php">Cancel</a>');
echo("\n</form>\n");
?>
</body>
</html>
<?php include 'footer.php'; ?>