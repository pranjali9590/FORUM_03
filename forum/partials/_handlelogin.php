<?php
$showError = "false" ;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "idiscuss";

    $conn = mysqli_connect($servername, $username, $password, $database);

    $email = $_POST['loginEmail'];
    $pass = $_POST['loginPass'];

    $sql = "SELECT * FROM `users` WHERE user_email = '$email'";
    $result = mysqli_query($conn, $sql);
    $numRows = mysqli_num_rows($result);
    if($numRows==1){
        $row = mysqli_fetch_assoc($result);
        if(password_verify($pass, $row['user_pass'])){
            session_start();
            $_SESSION['loggedin'] = true;
            $_SESSION['slno'] = $row['slno'];
            $_SESSION['useremail'] = $email;
            echo "logged in" . $email;
        }
        header("Location: /forum/index.php");
    }
    header("Location: /forum/index.php");
}
?>