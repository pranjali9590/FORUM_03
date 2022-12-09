<?php
$showError = "false" ;
if($_SERVER["REQUEST_METHOD"] == "POST"){
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "idiscuss";

    $conn = mysqli_connect($servername, $username, $password, $database);

    $user_email = $_POST['signupEmail'];
    $pass = $_POST['signuppassword'];
    $cpass = $_POST['signupcpassword'];

    //check whether it already exists or not
    $existSql = "SELECT * FROM `users` WHERE user_email = '$user_email'";
    $result = mysqli_query($conn, $existSql);
    $numRows = mysqli_num_rows($result);
    if($numRows>0){
        $showError="Email already in use";
    }
    else{
        if($pass == $cpass){
            $hash = password_hash($pass, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `users` (`user_email`, `user_pass`, `timestamp`) VALUES ('$user_email', '$hash', current_timestamp())";
            $result =  mysqli_query($conn, $sql);
            if ($result){
                $showAlert = true;
                header("Location: /forum/index.php?signupsuccess=true");
                exit();
            }
        }
        else{
            $showError = "Passwords do not match";
        }
       
    }
    header("Location: /forum/index.php?signupsuccess=false&error=$showError");
    
}

?>