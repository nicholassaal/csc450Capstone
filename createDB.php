<?php
session_start();
function displayMessage($msg, $color) {
    echo "<hr /><strong style='color:" . $color . ";'>" . $msg . "</strong><hr />";
 }

 $SERVER_NAME    = "localhost";   //Server name 
 $DBF_USER       = "root";        //UserName for the localhost database
 $DBF_PASSWORD   = "mysql";       //Password for the localhost database
 $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
 $connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
 
 $dropExisting = "DROP DATABASE IF EXISTS $DBF_NAME"; //making sure that table exists first so that it will not run into errors

 function runQuery($sql, $msg, $echoSuccess) { 
    global $connect;
    
    // run the query
    if ($connect->query($sql) === TRUE) {
       if($echoSuccess) {
          echo $msg . " successful.<br />";
       }
    } else {
       echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $connect->error;
    }  
 } // end of runQuery( )

runQuery($dropExisting, "DROP $DBF_NAME", true);

$sqlCreate = "CREATE DATABASE IF NOT EXISTS $DBF_NAME";

if (mysqli_query($connect, $sqlCreate)){
    displayMessage("You have successfully created and accessed your new database!", "green"); //green = good

} else {
    displayMessage("<b>ERROR:</b> " . mysqli_error($connect), "red"); //red = bad

}

$connectTable = mysqli_connect("$SERVER_NAME", "$DBF_USER", "$DBF_PASSWORD", "$DBF_NAME");

/*************************************
        Creation of DB tables
*************************************/









$tableCreate1 = mysqli_query($connectTable, $sqlUserLoginInfo);
$tableCreate2 = mysqli_query($connectTable, $sqlStudentInfo);
$tableCreate3 = mysqli_query($connectTable, $sqlStudentCourse);
$tableCreate4 = mysqli_query($connectTable, $sqlStudentMajor);
$tableCreate5 = mysqli_query($connectTable, $sqlMajor);
$tableCreate6 = mysqli_query($connectTable, $sqlCourse);
$tableCreate7 = mysqli_query($connectTable, $sqlProfessorCourse);
$tableCreate8 = mysqli_query($connectTable, $sqlProfessor);



if ($tableCreate1 and $tableCreate2 and $tableCreate3 and $tableCreate4 and $tableCreate5 and $tableCreate6 and $tableCreate7 and $tableCreate8) {
    displayMessage("You have successfully created Tables for your database!", "green"); //green = good
} else {
    displayMessage("<b>ERROR:</b> " . mysqli_error($connectTable), "red"); //red = bad
}



/*************************************
    Insert Sample Data into Tables
*************************************/

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create DB</title>
</head>
<body>
    
</body>
</html>