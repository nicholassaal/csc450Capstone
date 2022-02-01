
<!DOCTYPE html>

<html>
<head>
<title>Tester Database</title>
<link rel="stylesheet" href="testDatabase.css">
</head>
<body>

<h1>Welcome To the Tester Database</h1>
<p>Feel Free To Enter Data Below</p>
<!-- the form is using the post method in this case as it is sending data into the database-->
<form action="TestDatabase.php" method="post">
<p>
<!-- the 'name' is what we use to create our variables in the php file -->
<label for="firstName">First Name:</label>
 <input type="text" name="first_name" id="firstName">
</p>
 <p>
 <label for="lastName">Last Name:</label>
<input type="text" name="last_name" id="lastName">
</p>
<p>
<label for="phone_number">Phone Number:</label>
<input type="int" name="phone_number" id="phoneNumber">
</p>
<!-- the input submit button is a built in function that uses the post or get method to communicate to the database-->
<input type="submit">
</form>
<?php
//connecting to the mySQL database
$user = 'root';
$pass = '';
$db = 'myDatabase';

//connecting to the mySQL database created in phpmyadmin
$db = new mysqli ('localhost',$user,$pass,$db) or die ("unable to connect");

echo "<br>";
//creating a php variable to get the name of the input in the html file
$first_name =  $_REQUEST['first_name'];
$last_name = $_REQUEST['last_name'];
$phone_number =  $_REQUEST['phone_number'];

//inserting data from the html form into the database
$sql = "INSERT INTO userdata  VALUES ('$first_name','$last_name','$phone_number')";
if(mysqli_query($db, $sql)){
    echo "data stored in a database successfully"; 
//prints the newly listed data to the bottom of the screen 
    echo nl2br("\n$first_name\n $last_name\n $phone_number\n");
}
  
// Close connection
mysqli_close($db);
?>
</body>
</html>
