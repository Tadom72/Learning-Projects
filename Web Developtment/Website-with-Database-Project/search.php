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

//If User not logged in
if ( ! isset($_SESSION["account"]) ) { 
    header("Location: index.php");
    exit();
}else{
if(isset($_POST['BT'])){//Checks if form is submited

    if($_POST['BT'] == ""){ //Checks if the book bar  is empty
            //checks if Seach bar is empty
            if (!empty($_POST['drop'])){ 
                $c = $_POST['drop'];
                $sqlC = "SELECT ISBN, BookTitle, Author, Reserved FROM book b
                JOIN catagories c ON b.CategoryID = c.CategoryID
                WHERE CategoryDescription = \"$c\"";
                $resultC = $conn->query($sqlC);
                if ($resultC->num_rows > 0){
                    echo "<table border = '1'>";
                    $total_records = $resultC->num_rows;
                    while($rowc = $resultC->fetch_assoc()){
                        echo "<tr><td>";
                        echo (htmlentities($rowc["BookTitle"]));
                        echo "</td><td>";
                        echo (htmlentities($rowc["Author"]));
                        echo "</td><td>";
                        if (htmlentities($rowc["Reserved"]) == "N"){
                            echo ('<a href="reserve_able.php?id='.htmlentities($rowc["ISBN"]).'">No reserve here!</a>');
                        }else{
                            echo "Yes";
                        }
                            echo "</td></tr>";
                        }
                }
         }else{
            echo "Please Enter a search or select a category";
         }

    }else{ //if search bar has a value
        $s = $_POST['BT'];

        //If searchbar has a value and so does the category dropmenu we only list books with a title or author
        //begining with the value in the searchbar that also have the matching the catagory selected
        if (!empty($_POST['drop'])){ 
            $c = $_POST['drop'];
            $sql = "SELECT ISBN, BookTitle, Author, Reserved FROM book b 
            JOIN catagories c ON b.CategoryID = c.CategoryID
             WHERE CategoryDescription = \"$c\" AND (BookTitle LIKE \"$s%\" OR Author LIKE \"$s%\")";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                echo "<table border = '1'>";
                $total_records = $result->num_rows;

                while($row = $result->fetch_assoc()){
                    echo "<tr><td>";
                    echo (htmlentities($row["BookTitle"]));
                    echo "</td><td>";
                    echo (htmlentities($row["Author"]));
                    echo "</td><td>";
                    if (htmlentities($row["Reserved"]) == "N"){
                        echo ('<a href="reserve_able.php?id='.htmlentities($row["ISBN"]).'">No reserve here!</a>');
                    }else{
                        echo "Yes";
                    }
                    echo "</td></tr>";

                }
            }else{
                echo "No Author or Title Begin with ". $s . " and are in the category ". $c;
            }
        }
        
        else{//User submits with no category selected but with value in the search bar
            $sql = "SELECT ISBN, BookTitle, Author, Reserved FROM book WHERE BookTitle LIKE \"$s%\" OR Author LIKE \"$s%\"";
            $result = $conn->query($sql);
            if ($result->num_rows > 0){
                $total_records = $result->num_rows;
                echo "<table border = '1'>";

                while($row = $result->fetch_assoc()){
                    echo "<tr><td>";
                    echo (htmlentities($row["BookTitle"]));
                    echo "</td><td>";
                    echo (htmlentities($row["Author"]));
                    echo "</td><td>";
                    if (htmlentities($row["Reserved"]) == "N"){
                        echo ('<a href="reserve_able.php?id='.htmlentities($row["ISBN"]).'">No reserve here!</a>');
                    }else{
                        echo "Yes";
                    }
                    echo "</td></tr>";

                } 
            }else{
                echo "No Author or Title Begin with ". $s;
            }
        }
    }


}
}//End of else case that checks that the user is logged in 

?>
</table>

<form method = "post">
<p>Book Title Or Author:
<input type="text" name="BT">
<select name = "drop">
    <option value = "">Category</option> <!-- Value set to empty so the if category empty case on line 21 doesnt always trigger-->
    <?php
    $drop = "SELECT * FROM catagories";
    $resultD = $conn->query($drop);

    while ($row = $resultD->fetch_assoc()) {
        //Displaying all the catergorys by description as an option in the dropdown menu
        echo "<option value='" . htmlentities($row["CategoryDescription"]) . "'>";
        echo htmlentities($row["CategoryDescription"]);
        echo "</option>";
    }

?>

</select></p>
<p><input type="submit" value="Search"/> 
<input type="button" value="Home"
onclick="location.href='index.php'; return false "></p>
</form>
</body>
</html>
<?php include 'footer.php'; ?>