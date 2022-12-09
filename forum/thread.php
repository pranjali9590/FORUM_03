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
      $id = $_GET['threadid'];
      $sql= "SELECT * FROM `threads` WHERE thread_id= $id";
      $result = mysqli_query($conn , $sql); 
      while($row = mysqli_fetch_assoc($result)){
        $title = $row['thread_title'];
        $desc = $row['thread_desc'];
        $thread_user_id = $row['thread_user_id'];
            $sql2 = "SELECT user_email FROM `users` WHERE slno='$thread_user_id'";
            $result2 = mysqli_query($conn , $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $posted_by = $row2['user_email'];
      }
    
    ?>
     
     <?php
    $showalert = false;
    $method = $_SERVER['REQUEST_METHOD'];
    if($method== 'POST'){
      $comment = $_POST['comment'];
      $slno =  $_POST['slno'];

      $comment = str_replace("<", "&lt;", $comment);
      $comment = str_replace(">", "&gt;", $comment);

      $sql= "INSERT INTO `comments` (`comment_content`, `thread_id`, `comment_time`, `comment_by`) VALUES ('$comment', '$id', current_timestamp(), '$slno')";
      $result = mysqli_query($conn , $sql); 
      $showalert = true;
      if ($showalert){
        echo '<div class="alert alert-primary alert-dismissible fade show" role="alert">
        <strong>SUCCESS!!  </strong>Your comment had beed added..!!
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>';
      }
    }
    ?>
    
    <div class="container my-4" id="ques">
        <div class ="jumbotron">
            <h1 class="display-4"><?php echo $title;?></h1>
            <p class="lead"> <?php echo $desc;?> </p>
            <hr class="display-4">
            <p><strong>Forum rules and posting guidelines:  </strong>Keep it friendly.Be courteous and respectful. Appreciate that others may have an opinion different from yours.Stay on topic. ...Share your knowledge. ...Refrain from demeaning, discriminatory, or harassing behaviour and speech.</p>
            <p> <strong>POSTED BY- <?php echo $posted_by; ?></strong></p>
        </div>       
    </div>

    <?php
    if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    echo' <div class="container" >
    <h1 class= "py-2">Post a Comment..!!</h1>
  <form action=" ' . $_SERVER['REQUEST_URI'] . ' " method="post" >
    <div class="form-group">
      <lable for="exampleformcontroltextarea1">Type Your Comment</lable>
      <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
      <input type="hidden" name="slno" value=" ' . $_SESSION['slno'] . ' ">
      </div>
    <button type="submit" class="btn btn-primary">Post Comment</button>
  </form>
  </div> ';
    }
    else{
      echo '<div class="alert alert-warning" role="alert">
     You are not <b>LOGGED-IN</b> You have to login first to post a comment!!
    </div>';
    }
?>

    <div class= "container">
        <h1 class="py-2">!!..DISCUSSION..!!</h1>

        <?php
          $noresult = true;
          $id = $_GET['threadid'];
          $sql= "SELECT * FROM `comments` WHERE thread_id = $id";
          $result = mysqli_query($conn , $sql); 
          while($row = mysqli_fetch_assoc($result)){
            $content = $row['comment_content'];
            $id = $row['comment_id'];
            $comment_time = $row['comment_time'];
            $noresult = false;
            $thread_user_id = $row['comment_by'];
            $sql2 = "SELECT user_email FROM `users` WHERE slno='$thread_user_id'";
            $result2 = mysqli_query($conn , $sql2);
            $row2 = mysqli_fetch_assoc($result2);
            
        echo '<div class="d-flex align-items-center my-3">
        <div class="flex-shrink-0 my-3">
            <img src="https://www.nicepng.com/png/detail/115-1150821_default-avatar-comments-sign-in-icon-png.png" width = "55px"alt="Default Avatar Comments - Sign In Icon Png@nicepng.com" alt="...">
        </div>
        <div class="flex-grow-1 ms-3 my-3">
        <p class="font-weight-bold my-0"> ' . $row2['user_email'] . ' at ' . $comment_time . '</p>
            ' . $content . '
        </div>
        </div>';

      }

      if($noresult){
        echo '<div class="alert alert-info" role="alert">
        <b>NO COMMENTS POSTED YET!!<br> Be the first one to post the comment!!</b>
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