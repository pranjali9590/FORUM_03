<?php
session_start();

echo '
<nav class="navbar navbar-expand-lg bg-dark ">
  <div class="container-fluid">
    <a class="navbar-brand" href="/forum">iDiscuss</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/forum">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/forum/about.php">About</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true" id="navbarDropdown">
            Top Categories
          </a>
          <ul class="dropdown-menu" aria-labelledby="navbarDropdown">';

          $sql = "SELECT category_name, category_id FROM `categories` LIMIT 5";
          $result = mysqli_query($conn , $sql);
          while($row = mysqli_fetch_assoc($result)){
            echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$row['category_id'].'">' . $row['category_name'] . '</a></li>';
          }  
          echo '</ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="/forum/contact.php">Contact</a>
        </li>
      </ul>
      <div class="row mx-2">';
      if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        echo '<form class="form-inline my-2 my-lg-0" method="get" action="search.php">
          <input class="form-control mr-sm-2" name="search" type="search" actiion="search.php" placeholder="Search" aria-label="Search">
          <button class="btn btn-success my-2 my-sm-0" type="submit">Search</button>
            <p class="text-light my-0 mx-2">Welcome '. $_SESSION['useremail']. ' </p>
            <a href="partials/_logout.php" class="btn btn-outline-success ml-2">Logout</a>
            </form>';
      }
      else {
        echo'<form class="form-inline my-2 my-lg-0" role="search">
        <input class="form-control mr-sm-2" name="search "type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
        <button class="btn btn-primary ml-2" data-toggle="modal" data-target="#loginModal">Login</button>
        <button class="btn btn-primary mx-2" data-toggle="modal" data-target="#signupModal">Sign Up</button>';
      }
      
        
      echo '</div>
      
    </div>
  </div>
</nav>
';

include 'partials/_loginModal.php';
include 'partials/_signupModal.php';

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "true" ){
  echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>SUCCESS!!  </strong>Your account created successfully. 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>';
}

if(isset($_GET['signupsuccess']) && $_GET['signupsuccess'] == "false" ){
  echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>ERROR!!  </strong>Your account cannot be created. Try with different credentials. 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>';
}

?>