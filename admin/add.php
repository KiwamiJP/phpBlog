<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require ('../config/config.php');
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header("Location:index.php");
}
if($_POST){
    $file = 'images/'.($_FILES['image']['name']);
    $imageType = pathinfo($file,PATHINFO_EXTENSION);
    if($imageType != 'png' && $imageType != 'jpg' && $imageType != 'jpeg'){
        echo "<script>alert('Image must be png or jpg or jpeg')</script>";

    }else{
        $title = $_POST['title'];   
        $content = $_POST['content'];
        $image = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'],$file);
       $stmt =  $pdo->prepare("INSERT INTO posts(title,content,author_id,image)VALUES (:title,:content,:author_id,:image)");
       $result = $stmt->execute(
        array(':title'=>$title,':content'=>$content,':author_id'=>$_SESSION['user_id'],':image'=>$image)
       );
        if($result){
            echo "<script>alert('Blog added successfully')</script>";
        }
    }
    }
?>
<?php 
 include('header.php');
?>
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                     <div class="card-body">
                     <form action="add.php" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control" name="title" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="">Content</label><br>
                                <textarea class="form-control" name="content" id="" rows="8" cols="80"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Image</label><br>
                                <input type="file" name="image" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="SUBMIT" class="btn btn-success">
                                <a href="index.html" class="btn btn-warning">Back</a>
                            </div>
                        </form>
                     </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php')?>
