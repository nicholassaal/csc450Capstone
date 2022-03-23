<?php   
        session_start();
        session_destroy();
        header('Location: http://localhost/csc450Capstone/LoginPage/LoginPage.php');
?>