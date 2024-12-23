<?php
require 'config/config.php';
session_start();
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header("Location:login.php");
}
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>AdminLTE 3 | Widgets</title>
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
<body class="hold-transition sidebar-mini" >
  <div class="content">
  <?php 
$stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
$stmt->execute();
$result=$stmt->fetchAll();
?>
<?php 
              if(!empty($_GET['pageno'])){
                $pageno = $_GET['pageno'];

              }else{
                $pageno = 1;
              }
              $numOfrecs = 6;
              $offset =  ($pageno-1)*$numOfrecs;
                if(empty($_POST['search'])){
                  $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC");
                $stmt->execute();
                $rawResult=$stmt->fetchAll();
                $total_pages = ceil(count($rawResult)/$numOfrecs);
                $stmt = $pdo->prepare("SELECT * FROM posts ORDER BY id DESC LIMIT $offset,$numOfrecs");
                $stmt->execute();
                $result = $stmt->fetchAll();

                }else{
                  $searchKey = $_POST['search'];
                  $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC");
                $stmt->execute();
                $rawResult=$stmt->fetchAll();
                $total_pages = ceil(count($rawResult)/$numOfrecs);
                $stmt = $pdo->prepare("SELECT * FROM posts WHERE title LIKE '%$searchKey%' ORDER BY id DESC LIMIT $offset,$numOfrecs");
                $stmt->execute();
                $result = $stmt->fetchAll();
                }
              ?> 
                <h1 style="text-align:center">Blog App</h1>


   <div class="row">  

   <?php 
                      if($result){
                        $i = 1;
                        foreach($result as $value){
                    ?>
    <div class="col-md-4">
    
    <!-- Box Comment -->
    <div class="card card-widget">
      <div class="card-header">
       <div class="card-title" style="float:none;position:absolute;top: 18%;left: 40%;">
       <h4><?php echo $value['title']?></h4>
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
      <div class="card-body">
        <a href="blogdetails.php?id=<?php echo $value['id'];?>"><img class="img-fluid pad" src="admin/images/<?php echo $value['image'] ?>"></a>

        
      </div>
      <!-- /.card-body -->
     
      <!-- /.card-footer -->
     
      <!-- /.card-footer -->
    </div>
    <!-- /.card -->
 


</div>
                          <?php
                          $i++;
                        }
                      }
                   ?>

                   
  
  </div> 
 <div class="row" style="float:right;margin-right:0px">
 <nav aria-label="Page navigation example" style="float:right">
  <ul class="pagination">
    <li class="page-item"><a class="page-link" href="?pageno=1">First</a></li>
    <li class="page-item <?php if($pageno <= 1){echo 'disabled';} ?>">
      <a class="page-link" href="<?php if($pageno <= 1){echo '#';}else{echo '?pageno='.($pageno-1);}?>">Previous</a>
    </li>
    <li class="page-item"><a class="page-link" href="#"><?php echo $pageno;?></a></li>
    <li class="page-item <?php if($pageno >= $total_pages){echo 'disabled';}?>"><a class="page-link" href="<?php if($pageno >= $total_pages){echo '#';}else{echo '?pageno='.($pageno+1);}?>">Next</a></li>
    <li class="page-item "><a class="page-link" href="?pageno=  <?php echo $total_pages?>">Last</a></li>
  </ul>
</nav>
 </div>

  </div><br><br>

  <?php include('./admin/footer.php')?>

