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
   
        $username = $_POST['username'];   
        $email = $_POST['email'];
        $password = $_POST['password'];
        $role = $_POST['role'];
       $stmt =  $pdo->prepare("INSERT INTO users(username,password,email,role,created_at)VALUES (:username,:password,:email,:role,:created_at)");
       $result = $stmt->execute(
        array(':username'=>$username,':password'=>$password,':email'=>$email,':role'=>$role,':created_at'=>date('Y-m-d H:i:s'))
       );
        if($result){
            echo "<script>alert('User added successfully');window.location.href='user_list.php'</script>";
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
                     <form action="add_user.php" method="post">
                            <div class="form-group">
                                <label for="title">Username</label>
                                <input type="text" class="form-control" name="username" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label><br>
                                <input class="form-control" name="email"  required type="email">
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label><br>
                                <input class="form-control" type="password" name="password" value="" required>
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label><br>
                                <input class="form-control" type="text" name="role" value="" required>
                            </div>
                            <div class="form-group">
                                <input type="submit" value="SUBMIT" class="btn btn-success">
                                <a href="user_list.php" class="btn btn-warning">Back</a>
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
