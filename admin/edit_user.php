<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require ('../config/config.php');
if(empty($_SESSION['user_id']) && empty($_SESSION['logged_in'])){
  header("Location:login.php");
}
if($_POST){
    $id = $_POST['id']; 
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    
        
            $stmt = $pdo->prepare("UPDATE users SET username='$username',email='$email', password='$password',role='$role' WHERE id='$id'");
            $result = $stmt->execute();
            if($result){
                echo "<script>alert('User updated successfully');window.location.href='user_list.php'</script>";
            }
        
  
}
$stmt = $pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt-> execute();
$result = $stmt->fetchAll();
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
                     <form action="" method="post">
                            <div class="form-group">
                                <input type="hidden" name="id" value="<?php echo $result[0]['id']?>">
                                <label for="username">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $result[0]['username']?>" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label><br>
                                <input type="email" class="form-control" name="email" value="<?php echo $result[0]['email']?>" required>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label><br>
                                <input type="password" class="form-control" name="password" value="<?php echo $result[0]['password']?>" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label><br>
                                <input type="text" class="form-control" name="role" value="<?php echo $result[0]['role']?>" required>
                            </div>
                         
                            <div class="form-group">
                                <input type="submit" value="SUBMIT" class="btn btn-success">
                                <a href="/Blog/admin/user_list.php" class="btn btn-warning">Back</a>
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
