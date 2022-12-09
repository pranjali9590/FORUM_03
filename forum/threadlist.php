<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <style>
      #ques{
        min-height: 433px;
      }
    </style>
    <title>iDiscuss-Coding Forum</title>
  </head>
  <body>

    <?php include 'partials/dbconnect.php'; ?>
    <?php include 'partials/_header.php'; ?>
    
    <?php
      $id = $_GET['catid'];
      $sql= "SELECT * FROM `categories` WHERE category_id= $id";
      $result = mysqli_query($conn , $sql); 
      while($row = mysqli_fetch_assoc($result)){
        $catname = $row['category_name'];
        $catdesc = $row['category_discription'];
      
      }
    ?>

    <?php
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method== 'POST'){
      $th_title = $_POST['title'];
      $slno =  $_POST['slno'];
      $th_desc = $_POST['desc'];

      $th_title = str_replace("<", "&lt;", $th_title);
      $th_title = str_replace(">", "&gt;", $th_title);

      $th_desc = str_replace("<", "&lt;", $th_desc);
      $th_desc = str_replace(">", "&gt;", $th_desc);
      
      $sql= "INSERT INTO `threads` (`thread_title`, `thread_desc`, `thread_cat_id`, `thread_user_id`, `timestamp`) VALUES ('$th_title', '$th_desc', '$id', '$slno' , current_timestamp())";
      $result = mysqli_query($conn , $sql); 
      $showalert = true;
      if ($showalert){
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>SUCCESS!!  </strong>Your thread had beed added. Wait for the community to response. 
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>';
      }
    }
    ?>

    <div class="container my-4" >
        <div class ="jumbotron">
            <h1 class="display-4">Welcome to <?php echo $catname;?> formus</h1>
            <p class="lead"> <?php echo $catdesc;?> </p>
            <hr class="display-4">
            <p><strong>Forum rules and posting guidelines:  </strong>Keep it friendly.Be courteous and respectful. Appreciate that others may have an opinion different from yours.Stay on topic. ...Share your knowledge. ...Refrain from demeaning, discriminatory, or harassing behaviour and speech.</p>
            <a class = "btn btn-primary btn-lg" href="#" role="button">Learn More</a>
        </div>       
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo' <div class="container" id= "ques">
      <h1 class= "py-2">Start a Discussion..!!</h1>
    <form action=" ' . $_SERVER["REQUEST_URI"] . ' " method="post" >
      <div class="form-group">
        <label for="exampleInputEmail1" class="form-label">Problem Title</label>
        <input type="text" class="form-control" id="title" aria-describedby="emailHelp" name="title">
        <small id="emailHelp" class="form-text">Keep your title as short and crisp as possible..!!</small>   
      </div>
      <input type="hidden" name="slno" value=" ' . $_SESSION['slno'] . ' ">
      <div class="form-group">
        <lable for="exampleformcontroltextarea1">Ellaborate Your Concern</lable>
        <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    </div>  ';
    }
    else{
      echo '<div class="alert alert-warning" role="alert">
     You are not <b>LOGGED-IN</b> You have to login first to take part in disscussion!!
    </div>';
    }
    ?>

    <div class= "container">
        <h1 class="py-2">BROWSE QUESTIONS..!!</h1>

        <?php
          $id = $_GET['catid'];
          $sql= "SELECT * FROM `threads` WHERE thread_cat_id= $id";
          $result = mysqli_query($conn , $sql);
          $noresult = true; 
          while($row = mysqli_fetch_assoc($result)){
            $noresult = false;
            $title = $row['thread_title'];
            $desc = $row['thread_desc'];
            $id = $row['thread_id'];
            $thread_time = $row['timestamp'];
            $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE slno='$thread_user_id'";
            $result2 = mysqli_query($conn , $sql2);
            $row2 = mysqli_fetch_assoc($result2);
                       
        echo '<div class="media my-3">
            <img src="https://www.nicepng.com/png/detail/115-1150821_default-avatar-comments-sign-in-icon-png.png" width = "55px"alt="Default Avatar Comments - Sign In Icon Png@nicepng.com" alt="...">
        <div class="media-body">'.
            '<h5 class = "mt-0"><a href= "thread.php?threadid=' . $id . '">' . $title . ' </a></h5>
            ' . $desc . ' </div>' . '<div class="font-weight-bold my-0">Asked By: ' . $row2['user_email'] . ' at ' . $thread_time . '</div>'. '</div>';

      }
      //echo var_dump($noresult);
      if($noresult){
        echo '<div class="alert alert-info" role="alert">
        <b>NO QUESTIONS POSTED YET!!<br> Be the first one to post the question!!</b>
      </div>';
      }
      ?>

    <?php include 'partials/_footer.php'; ?>
  <!-- Optional JavaScript -->
  <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
  </body>
</html>
