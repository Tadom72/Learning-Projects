<?php include 'header.php'; ?>
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body style="font-family: sans-serif;">
<h1>Library</h1>


<?php
session_start();
if ( isset($_SESSION["error"]) ) {
echo('<p style="color:red">Error:'.$_SESSION["error"]."</p>\n");
unset($_SESSION["error"]);
}
if ( isset($_SESSION["success"]) ) {
echo('<p style="color:green">'.$_SESSION["success"]."</p>\n");
unset($_SESSION["success"]);
}
// Retrieve data from the session for the view

//If not logged in
if ( ! isset($_SESSION["account"]) ) { ?>
Please <a href="login.php">Log In</a> here
or <a href="regester.php">Regester</a> here.
<?php } 
else { ?>
<h2>How about </h2>
<p>Checking the books within the library Press Library List
<p> or  Search for a book within the library Press Search</p>
<input type="button" value="Library List"
onclick="location.href='show.php'; return false ">
<input type="button" value="Search"
onclick="location.href='search.php'; return false ">
<input type="button" value="Reserved"
onclick="location.href='reserved.php'; return false ">
<input type="button" value="Logout"
onclick="location.href='logout.php'; return false "></p>
</form>
<?php } ?>
</body> 
</html>

<?php include 'footer.php'; ?>