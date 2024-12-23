<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require 'config/config.php';
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header("Location:login.php");
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id=".$_GET['id']);
$stmt->execute();
$result = $stmt->fetchAll();

$blogId = $_GET['id'];
$stmtcmt = $pdo->prepare("SELECT * FROM comments WHERE post_id=".$blogId);
$stmtcmt->execute();
$resultcmt = $stmtcmt->fetchAll();

$resultauth = [];
if(!empty($resultcmt)){
  $authorId  = $resultcmt[0]['author_id'];

$stmtauth = $pdo->prepare("SELECT * FROM users WHERE id=$authorId");
$stmtauth->execute();
$resultauth = $stmtauth->fetchAll();
}else{

}

if($_POST){
  $comment = $_POST['comment'];
  $stmt = $pdo->prepare("INSERT INTO comments(content,author_id,post_id,created_at)VALUES (:content,:author_id,:post_id,:created_at)");
  $result = $stmt->execute(
    array(':content'=>$comment,':author_id'=>$_SESSION['user_id'],'post_id'=>$blogId,'created_at'=>date('Y-m-d H:i:s')));
   if($result){
    header('Location:blogdetails.php?id='.$blogId);
  }

}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog App</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>
<body class="hold-transition sidebar-mini">

   <div class="row">
  
   
          
   <div class="col-md-12">
            <!-- Box Comment -->
            <div class="card card-widget">
              <div class="card-header">
               <div class="card-title" style="float:none;position:absolute;top: 18%;left: 49%;">
               <h4><?php echo $result[0]['title']?></h4>
               </div>
                <!-- /.user-block -->
                <div class="card-tools">
                  <button type="button" class="btn btn-tool" data-toggle="tooltip" title="Mark as read">
                    <i class="far fa-circle"></i></button>
                  <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-minus"></i>
                  </button>
                  <button type="button" class="btn btn-tool" data-card-widget="remove"><i class="fas fa-times"></i>
                  </button>
                </div>
                <!-- /.card-tools -->
              </div>
              <!-- /.card-header -->
              <div class="card-body" style="display:flex;justify-content:center;align-item:center; flex-direction:column">
                <img class="img-fluid pad" src="admin/images/<?php echo $result[0]['image'] ?>" alt="Photo" width="600px" height="400px">
                <br><br>
                <p><?php echo $result[0]['content'] ?></p>

                
              </div>
              <!-- /.card-body -->
              
              <!-- /.card-footer -->
             <h3>Comments</h3><hr>
             <a href="/Blog" type="button" class="btn btn-default">Go Back</a>

             <div class="card-footer card-comments">
              <?php if(!empty($resultcmt)):?>
              <div class="card-comment">
                <div class="comment-text">
                  <span class="username"><?php echo $resultauth[0]['username'] ?>
                    <span class="text-muted float-right"><?php echo $resultcmt[0]['created_at']?></span>
                  </span>
                    <?php echo $resultcmt[0]['content']?>
                </div>
              </div>
              <?php else: ?>
                <p>No comment Yet</p>
              <?php endif;?>
             </div>
              <!-- /.card-footer -->
               <div class="card-footer">
                <form action="" method="post">

                <img src="dist/img/user4-128x128.jpg" alt="Alt Text">
                <div class="img-push">
                  <input type="text" name="comment" class="form-control form-control-sm" placeholder="Press enter   to post comment">
                </div>
                </form>
               </div>
            </div>
            <!-- /.card -->
    </div>  
    
    
   </div>


<!-- jQuery -->
<script src="../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="dist/js/demo.js"></script>
</body>
</html>
