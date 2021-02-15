<?php
session_start();
require "../config/config.php";
require "../config/common.php";
if(empty($_SESSION['user_id']) && empty($_SESSION['loggedin'])){
  header("Location:login.php");
}
if($_SESSION['role']!=1){ // if not admin role, back to login
    header('Location:login.php');
  }
//get user by id to show on the form.
$stmt=$pdo->prepare("SELECT * FROM users WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();

if($_POST){
  if (empty($_POST['name']) || empty($_POST['email'])) {
    if(empty($_POST['name'])){
      $nameError="Name required";
    }
    if(empty($_POST['email'])){
      $emailError="Email required";
    }

  }else if(!empty($_POST['password']) && strlen($_POST['password'])<4){
    $pwError="Password must be 4 characters at least.";
  }else{
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);

    if(empty($POST['role'])){
      $role=0;
    }else{
      $role=1;
    }

    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email && id!=:id");
    $stmt->execute(array(':email'=>$email,':id'=>$id));
    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    if($result){
      echo "<script>alert('Email duplicated')</script>";
    }else{
      if($password!=null){
        $stmt=$pdo->prepare("UPDATE users SET name='$name',email='$email',password='$password',role='$role' WHERE id='$id'");

      }else{
        $stmt=$pdo->prepare("UPDATE users SET name='$name',email='$email',role='$role' WHERE id='$id'");

      }
      $result=$stmt->execute();
      if($result){
        echo "<script>alert('Successfully updated.');window.location.href='user_list.php';</script>";
      }
    }
  }


}

?>
<?php
    include('header.php');
 ?>

    <!-- Main content -->
    <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-body">
                <form class="" action="" method="post">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id']?>">
                    <div class="form-group">
                        <label for="">Name</label><p style="color:red"><?php echo empty($nameError)  ? '':'*'.$nameError;?></p>
                        <input type="text" class="form-control" name="name" value="<?php echo escape($result[0]['name'])?>" >
                    </div>
                    <div class="form-group">
                        <label for="">Email</label><p style="color:red"><?php echo empty($emailError)  ? '':'*'.$emailError;?></p>
                        <textarea name="email" class="form-control" rows="8" cols="80" ><?php echo escape($result[0]['email']);?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label><p style="color:red"><?php echo empty($pwError)  ? '':'*'.$pwError;?></p>
                        <span style="font-size:10px">The user already has a password.</span>
                        <input type="text" class="form-control" name="password" value="" >

                    </div>
                    <div class="form-group">
                        <label for="">Admin</label><br>
                        <input type="checkbox" name="role" value="1" <?php if($result[0]['role']==1){echo 'checked';}else{echo '';}?>>

                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-success" name="" value="Update">
                      <a href="user_list.php" class="btn btn-warning">Back</a>
                    </div>
                </form>
              </div>

            </div>
            <!-- /.card -->


          </div>
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->
    <?php
        include('footer.html');
     ?>
