<?php
session_start();//Creating a session to have variables locally. Local use. 
//Display a message with a red or green. Green is good to go, and red if errors.  
function displayMessage($msg, $color) {
    echo "<hr /><strong style='color:" . $color . ";'>" . $msg . "</strong><hr />";
 }

 $SERVER_NAME    = "localhost";   //Server name 
 $DBF_USER       = "root";        //UserName for the localhost database
 $DBF_PASSWORD   = "";       //Password for the localhost database/ When using XAMPPS, make this value emtpy. Use: $DBF_PASSWORD   = "";
 $DBF_NAME       = "CSPCourseReview";    //DB name for the localhost database
 $connect = mysqli_connect($SERVER_NAME, $DBF_USER, $DBF_PASSWORD);
 
 $dropExisting = "DROP DATABASE IF EXISTS $DBF_NAME"; //making sure that table exists first so that it will not run into errors

 function runQuery($sql, $msg, $echoSuccess) { 
    global $connect;//Creating a global connect variable (so this runQuery function has access to the connect variable on line 12). 
    
    // run the query
    if ($connect->query($sql) === TRUE) {
       if($echoSuccess) {
          echo $msg . " successful.<br />";
       }
    } else {
       echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $connect->error;
    }  
 } // end of runQuery( )

//Checking if database was dropped. 
runQuery($dropExisting, "DROP $DBF_NAME", true);

//Creates the database using the database name, if not exists. 
$sqlCreate = "CREATE DATABASE IF NOT EXISTS $DBF_NAME";

//If statement is checking if database was created successfully. 
if (mysqli_query($connect, $sqlCreate)){
    //Uses displayMessage function above, line 4. 
    displayMessage("You have successfully created and accessed your new database!", "green"); //green = good

} else {
    displayMessage("<b>ERROR:</b> " . mysqli_error($connect), "red"); //red = bad
}

//After creating the database, connectTable will connect to that database specifically using the database name ($DBF_NAME).
$connectTable = mysqli_connect("$SERVER_NAME", "$DBF_USER", "$DBF_PASSWORD", "$DBF_NAME");

/*************************************
        Creation of DB tables
*************************************/
$sqlUserLoginInfo = "CREATE TABLE IF NOT EXISTS userLoginInfo(
    user_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    user_name VARCHAR(25) NOT NULL,
    user_password VARCHAR(20) NOT NULL,
    Is_admin BOOLEAN,
    student_id INT(6)  
    )";

$sqlStudentInfo = "CREATE TABLE IF NOT EXISTS studentInfo(
    student_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY, 
    student_fName     VARCHAR(20) NOT NULL,
    student_lName     VARCHAR(20) NOT NULL
    )";

$sqlStudentCourse = "CREATE TABLE IF NOT EXISTS studentCourse(
   student_id INT(6),
   course_code INT(6),
   review_message	VARCHAR(450)
  )";

$sqlStudentMajor = "CREATE TABLE IF NOT EXISTS studentMajor(
   student_id INT(6),
   major_id INT(6),
   enrollment_status BOOLEAN
)";

$sqlMajor = "CREATE TABLE IF NOT EXISTS major(
   major_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   major_name VARCHAR(25) NOT NULL,
   major_description VARCHAR(50) NOT NULL
)";

$sqlCourse = "CREATE TABLE IF NOT EXISTS course(
   course_code INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   course_description VARCHAR(100) NOT NULL,
   major_id INT(6)
)";

$sqlProfessorCourse = "CREATE TABLE IF NOT EXISTS professorCourse(
   prof_id INT(6),
   course_code INT(6),
   year_taught VARCHAR(20) NOT NULL
)";

$sqlProfessor = "CREATE TABLE IF NOT EXISTS professor(
   pro_id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
   prof_fName VARCHAR(25) NOT NULL,
   prof_lName VARCHAR(25) NOT NULL
)";

//Store the query (each tables fields) to a certain variable ($tableCreate1...) to clean up the if statement on line 111. 
$tableCreate1 = mysqli_query($connectTable, $sqlStudentInfo);
$tableCreate2 = mysqli_query($connectTable, $sqlUserLoginInfo);
$tableCreate3 = mysqli_query($connectTable, $sqlStudentCourse);
$tableCreate4 = mysqli_query($connectTable, $sqlStudentMajor);
$tableCreate5 = mysqli_query($connectTable, $sqlMajor);
$tableCreate6 = mysqli_query($connectTable, $sqlCourse);
$tableCreate7 = mysqli_query($connectTable, $sqlProfessorCourse);
$tableCreate8 = mysqli_query($connectTable, $sqlProfessor);


//Runs the query of creating the tables and its fields and display if successful or not.
if ($tableCreate1 and $tableCreate2 and $tableCreate3 and $tableCreate4 and $tableCreate5 and $tableCreate6 and $tableCreate7 and $tableCreate8) {
    displayMessage("You have successfully created Tables for your database!", "green"); //green = good
} else {
    displayMessage("<b>ERROR:</b> " . mysqli_error($connectTable), "red"); //red = bad
}



/*************************************
    Insert Sample Data into Tables
*************************************/
//Insert into userLoginInfo table
$insertUserLogin = "INSERT INTO userLoginInfo (user_name, user_password, is_admin, student_id)
    VALUES  ('MillerJ26', 'passwordEx', '0', '1'),
            ('GrantM65', 'exPassword', '1', '0')";

//Insert into studentInfo table
$insertStudentInfo = "INSERT INTO studentInfo (student_fName, student_lName)
    VALUES  ('Jake', 'Miller'),
            ('Mark', 'Grant')";

//Insert into student course composite/join table
$insertStudentCourse = "INSERT INTO studentCourse (student_id, course_code, review_message)
    VALUES  ('1', '1', 'Great course, highly recommended if you are interesting in web designed.'),
            ('0', '0', 'Admin user')";

//Insert into student major composite/join table
$insertStudentMajor = "INSERT INTO studentMajor (student_id, major_id, enrollment_status)
    VALUES  ('1', '0', '1'),
            ('0', '0', '0')";

//Insert into course table
$insertCourse = "INSERT INTO course (course_description, major_id)
    VALUES  ('CSC 450 Capstone', '1'),
            ('CSC 420 Data Structures and Algorithms', '2')";

//Insert into major table 
$insertMajor = "INSERT INTO major (major_name, major_description)
    VALUES  ('Computer Science', 'You learn about computers and problems solving.'),
            ('Communications', 'Learn about effective communication skills and using the different skills in real life.')";

//Insert into professorCourse composite/join table
$insertProfessorCourse = "INSERT INTO professorCourse (prof_id, course_code, year_taught)
    VALUES  ('1', '1', '2019'),
            ('2', '2', '2020')";

//Insert into professor table
$insertProfessor = "INSERT INTO professor (prof_fName, prof_lName)
    VALUES  ('James', 'Tucker'),
            ('Susan', 'Furtney')";

//Store the query (each tables fields) to a certain variable ($tableCreate1...) to clean up the if statement on line 111. 
$insert1 = mysqli_query($connectTable, $insertUserLogin);
$insert2 = mysqli_query($connectTable, $insertStudentInfo);
$insert3 = mysqli_query($connectTable, $insertStudentCourse);
$insert4 = mysqli_query($connectTable, $insertStudentMajor);
$insert5 = mysqli_query($connectTable, $insertCourse);
$insert6 = mysqli_query($connectTable, $insertMajor);
$insert7 = mysqli_query($connectTable, $insertProfessorCourse);
$insert8 = mysqli_query($connectTable, $insertProfessor);

//Runs the query of inserting into tables and then display if inserting was successful or not. 
if ($insert1 and $insert2 and $insert3 and $insert4 and $insert5 and $insert6 and $insert7 and $insert8) {
    displayMessage("You have successfully inserted data into the tables for your database!", "green"); //green = good
} else {
    displayMessage("<b>ERROR:</b> " . mysqli_error($connectTable), "red"); //red = bad
}

?>
<!-- Start of HTML doc -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create the DB</title>
</head>
<body>
    
</body>
</html>