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
echo "$u" . " Books";

//Checking the user is loged in
if ( ! isset($_SESSION["account"]) ) { 
    header("Location: index.php");
    exit();
 } else { 
    $sql = "SELECT b.ISBN, BookTitle, Author, Editions, Year, CategoryDescription, ReservedDate FROM book b
    JOIN catagories c ON b.CategoryID = c.CategoryID
    JOIN reservations r ON b.ISBN = r.ISBN 
    WHERE r.UserName = \"$u\""; //WhERE statement makes it so it only shows books that are resevered by the currently logged in  user
    $result = $conn->query($sql);
    //If there are there are no current books regestired by user skips if block and doesnt print anything
    if ($result->num_rows > 0){  
        echo "<table border='1'>";
        echo "<tr>
             <th>ISBN</th>
             <th>Book Title</th>
             <th>Author</th>
             <th>Editions</th>
             <th>Year</th>
             <th>Category</th>
             <th>Reserved Date</th>
          </tr>";
        while($row = $result->fetch_assoc()){
            echo "<tr><td>";
            echo (htmlentities($row["ISBN"]));
            echo "</td><td>";
            echo (htmlentities($row["BookTitle"]));
            echo "</td><td>";
            echo (htmlentities($row["Author"]));
            echo "</td><td>";
            echo (htmlentities($row["Editions"]));
            echo "</td><td>\n";
            echo (htmlentities($row["Year"]));
            echo "</td><td>\n";
            //Using category description from the category table that we joined at line 3
            echo htmlentities($row["CategoryDescription"]);
            echo "</td><td>\n";
            echo (htmlentities($row["ReservedDate"]));
            echo "</td><td>\n";
            //adds link to cancel reservation of book
            echo ('<a href="unreserve.php?id='.htmlentities($row["ISBN"]).'">Cancel Reservation</a>');
            echo "</td></tr>\n";
        }
    }
}
?>
</table><br>
<input type="button" value="Home"
onclick="location.href='index.php'; return false ">
<input type="button" value="Logout"
onclick="location.href='logout.php'; return false "></p>
</body>
</html>
<?php include 'footer.php'; ?>