<?php include 'header.php'; ?>
<html>

<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php
require_once "database.php";
$pageLimit = 5;//How many books show per page
//If a certain page number is selected if not defualt is 1
if (isset($_GET["page"])) { 
    $pn  = $_GET["page"]; 
} 
else { 
    $pn=1; 
};  

$start_from = ($pn-1) * $pageLimit;

$sql = "SELECT ISBN, BookTitle, Author, Editions, Year, CategoryDescription, Reserved FROM book b
        JOIN catagories c ON b.CategoryID = c.CategoryID
        LIMIT $start_from, $pageLimit"; //Joining categorys and book so i can show the description of a category 
                                                           //rather then the id 
$result = $conn->query($sql);
if ($result->num_rows > 0){
    echo "<table>";
    //Creating table headers
    echo "<tr>
             <th>ISBN</th>
             <th>Book Title</th>
             <th>Author</th>
             <th>Editions</th>
             <th>Year</th>
             <th>Category</th>
             <th>Reserved</th>
          </tr>";

    //printing all Books within the database
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
        //If not reserved add a link to allow user to resever that book otherwise simply print yes with no link
        if (htmlentities($row["Reserved"]) == "N"){
            echo ('<a href="reserve_able.php?id='.htmlentities($row["ISBN"]).'">No, reserve here!</a>');
        }else{
            echo "Yes";
        }
        echo "</td></tr>\n";
    }
}
else{
    echo"0 results";
}

?>
</table>
<ul class="pagination">
      <?php  
        //Getting the total amount Books in
        $sqlP = "SELECT COUNT(*) AS total FROM book";  
        $resultP = $conn->query($sqlP);  
        $row = $resultP->fetch_assoc(); 
        $total_records = $row['total'];  
        
        // Number of pages required.
        $total_pages = ceil($total_records / $pageLimit);  
        $pagLink = "";                        
        for ($i=1; $i<=$total_pages; $i++) {
          if ($i==$pn) {
              $pagLink .= "<a href='show.php?page=".$i."'>".$i. " ". "</a>";
          }            
          else  {
              $pagLink .= "<a href='show.php?page=".$i."'>".$i. " ". "</a>";  
          }
        };  
        echo $pagLink;  
      ?>
      </ul>
<br>
<input type="button" value="Home"
onclick="location.href='index.php'; return false ">
<input type="button" value="Logout"
onclick="location.href='logout.php'; return false "></p>
</body>
</html>
<?php include 'footer.php'; ?>