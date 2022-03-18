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
    user_id INT AUTO_INCREMENT PRIMARY KEY, 
    user_name VARCHAR(25) NOT NULL,
    user_password VARCHAR(20) NOT NULL,
    Is_admin BOOLEAN,
    student_id INT
    )";

$sqlStudentInfo = "CREATE TABLE IF NOT EXISTS studentInfo(
    student_id INT AUTO_INCREMENT PRIMARY KEY, 
    student_fName     VARCHAR(20) NOT NULL,
    student_lName     VARCHAR(20) NOT NULL,
    about_student     VARCHAR(450)
    )";

$sqlStudentCourse = "CREATE TABLE IF NOT EXISTS studentCourse(
   student_id INT NOT NULL,
   course_code INT NOT NULL,
   review_message VARCHAR(450)
  )";

$sqlStudentMajor = "CREATE TABLE IF NOT EXISTS studentMajor(
   student_id INT NOT NULL,
   major_id INT NOT NULL,
   enrollment_status BOOLEAN
)";

$sqlMajor = "CREATE TABLE IF NOT EXISTS major(
   major_id INT AUTO_INCREMENT PRIMARY KEY,
   major_name VARCHAR(25) NOT NULL,
   major_description VARCHAR(150) NOT NULL
)";

$sqlCourse = "CREATE TABLE IF NOT EXISTS course(
   course_code INT AUTO_INCREMENT PRIMARY KEY,
   course_name VARCHAR(50) NOT NULL,
   course_description VARCHAR(1000), 
   major_id INT
)";

$sqlProfessorCourse = "CREATE TABLE IF NOT EXISTS professorCourse(
   prof_id INT NOT NULL,
   course_code INT NOT NULL,
   year_taught VARCHAR(20) NOT NULL
)";

$sqlProfessor = "CREATE TABLE IF NOT EXISTS professor(
   prof_id INT AUTO_INCREMENT PRIMARY KEY,
   prof_fName VARCHAR(25) NOT NULL,
   prof_lName VARCHAR(25) NOT NULL
)";

//'$tableCreate1 =' Assigns queries for each connection type for each table creation... This cleans it up with using AND statements
$tableCreate = mysqli_query($connectTable, $sqlStudentInfo) 
    AND mysqli_query($connectTable, $sqlUserLoginInfo) 
    AND mysqli_query($connectTable, $sqlStudentCourse)
    AND mysqli_query($connectTable, $sqlStudentMajor) 
    AND mysqli_query($connectTable, $sqlMajor) 
    AND mysqli_query($connectTable, $sqlCourse)
    AND mysqli_query($connectTable, $sqlProfessorCourse) 
    AND mysqli_query($connectTable, $sqlProfessor);



//Runs the query of creating the tables and its fields and display if successful or not.
if ($tableCreate) {
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
            ('GrantM65', 'exPassword', '0', '2'),
            ('SampleAdmin14', 'adminPassword', '1', NULL)";

//Insert into studentInfo table
$insertStudentInfo = "INSERT INTO studentInfo (student_fName, student_lName, about_student)
    VALUES  ('Jake', 'Miller', 'Enjoys programming and working on side projects. Some hobbies are fishing and hunting.'),
            ('Mark', 'Grant', 'Loves fishing.')";

//Insert into student course composite/join table
$insertStudentCourse = "INSERT INTO studentCourse (student_id, course_code, review_message)
    VALUES  ('1', '1', 'Great course, highly recommended if you are interesting in web designed.'),
            ('1', '2', 'Challenging course, but at the same time enjoyable to learn.'),
            ('1', '2', 'Super Epic Man nice.'),
            ('1', '1', 'Great course, highly recommended if you are interesting in web designed.')"; //added additional reviews for one person to test my idea in profiles.php

//Insert into student major composite/join table
$insertStudentMajor = "INSERT INTO studentMajor (student_id, major_id, enrollment_status)
    VALUES  ('1', '1', '1'),
            ('2', '1', '1')";

//Insert into course table
$insertCourse = "INSERT INTO course (course_name, course_description, major_id)
    VALUES  ('CSC 450 Capstone', 'Provide students realistic hands-on software development experience. Students will work in teams to build a realistic hands-on software development experience.', '1'),
            ('CSC 420 Data Structures And Algorithms', 'Covers both theory and application of data structures such as lists, stacks, queues, sets, maps, binary search trees, and graphs.', '1')";

//Insert into major table 
$insertMajor = "INSERT INTO major (major_name, major_description)
    VALUES  ('Computer Science', 'Focuses on problem solving, computer theory, and design of computing systems.'),
            ('Communications', 'Learn about effective communication skills and using the different skills in real life.')";

//Insert into professorCourse composite/join table
$insertProfessorCourse = "INSERT INTO professorCourse (prof_id, course_code, year_taught)
    VALUES  ('1', '1', '2019'),
            ('1', '2', '2020')";

//Insert into professor table
$insertProfessor = "INSERT INTO professor (prof_fName, prof_lName)
    VALUES  ('James', 'Tucker'),
            ('Susan', 'Furtney')";

//'$insert =' Assigns queries for each connection type for each insert (into) tables... This cleans it up with using AND statements
$insert = mysqli_query($connectTable, $insertUserLogin) 
    AND mysqli_query($connectTable, $insertStudentInfo) 
    AND mysqli_query($connectTable, $insertStudentCourse)
    AND mysqli_query($connectTable, $insertStudentMajor) 
    AND mysqli_query($connectTable, $insertCourse) 
    AND mysqli_query($connectTable, $insertMajor) 
    AND mysqli_query($connectTable, $insertProfessorCourse) 
    AND mysqli_query($connectTable, $insertProfessor);

//Runs the query of inserting into tables and then display if inserting was successful or not. 
if ($insert) {
    displayMessage("You have successfully inserted data into the tables for your database!", "green"); //green = good
} else {
    displayMessage("<b>ERROR:</b> " . mysqli_error($connectTable), "red"); //red = bad
}

/*************************************
    Creating Foreign Keys, Composite Keys. 
*************************************/
$sqlAlterUserLoginInfo = "ALTER TABLE `userlogininfo` ADD CONSTRAINT `fk_student_id` FOREIGN KEY (`student_id`) REFERENCES `studentInfo`(`student_id`) ON DELETE RESTRICT ON UPDATE RESTRICT";

$sqlAlterCourseTable = "ALTER TABLE `course` ADD CONSTRAINT `fk_Major_id` FOREIGN KEY (`major_id`) REFERENCES `major`(`major_id`) ON DELETE RESTRICT ON UPDATE RESTRICT";

$sqlAlterStudentCourse1 = "ALTER TABLE `studentCourse` ADD CONSTRAINT `uk_student_id` FOREIGN KEY (`student_id`) REFERENCES `studentinfo`(`student_id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
$sqlAlterStudentCourse2 = "ALTER TABLE `studentCourse` ADD CONSTRAINT `uk_course_code` FOREIGN KEY (`course_code`) REFERENCES `course`(`course_code`) ON DELETE RESTRICT ON UPDATE RESTRICT";

$sqlAlterStudentMajor1 = "ALTER TABLE `studentMajor` ADD CONSTRAINT `uk_studentMajor_id` FOREIGN KEY (`student_id`) REFERENCES `studentinfo`(`student_id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
$sqlAlterStudentMajor2 = "ALTER TABLE `studentMajor` ADD CONSTRAINT `uk_major_id` FOREIGN KEY (`major_id`) REFERENCES `major`(`major_id`) ON DELETE RESTRICT ON UPDATE RESTRICT";

$sqlAlterProfCourse1 = "ALTER TABLE `professorCourse` ADD CONSTRAINT `uk_prof_id` FOREIGN KEY (`prof_id`) REFERENCES `professor`(`prof_id`) ON DELETE RESTRICT ON UPDATE RESTRICT";
$sqlAlterProfCourse2 = "ALTER TABLE `professorCourse` ADD CONSTRAINT `uk_profCourse_code` FOREIGN KEY (`course_code`) REFERENCES `course`(`course_code`) ON DELETE RESTRICT ON UPDATE RESTRICT";

//Running the queries, assigning runs to a variable to check if successful or not. 
$alterTablesPKFK = mysqli_query($connectTable, $sqlAlterUserLoginInfo) 
    AND mysqli_query($connectTable, $sqlAlterCourseTable)
    AND mysqli_query($connectTable, $sqlAlterStudentCourse1)
    AND mysqli_query($connectTable, $sqlAlterStudentCourse2)
    AND mysqli_query($connectTable, $sqlAlterStudentMajor1)
    AND mysqli_query($connectTable, $sqlAlterStudentMajor2)
    AND mysqli_query($connectTable, $sqlAlterProfCourse1)
    AND mysqli_query($connectTable, $sqlAlterProfCourse2);

//Checking if successful or not when running the queries. 
if ($alterTablesPKFK) {
    displayMessage("You have successfully altered userLoginInfo!", "green"); //green = good
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