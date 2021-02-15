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
if($_POST){
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password'])<4 || empty($_POST['phone']) || empty($_POST['address'])) {
    if(empty($_POST['name'])){
      $nameError="Name required";
    }
    if(empty($_POST['email'])){
      $emailError="Email required";
    }
    if(empty($_POST['phone'])){
      $phError="Phone required";
    }
    if(empty($_POST['address'])){
      $addressError="Address required";
    }
    if(empty($_POST['password']) ){
      $pwError="Password required";
    }
    else if(strlen($_POST['password'])<4){
      $pwError="Password must be 4 characters at least.";
    }
  }else{
    $name=$_POST['name'];
    $email=$_POST['email'];
    $password=password_hash($_POST['password'],PASSWORD_DEFAULT);
    $phone=$_POST['phone'];
    $address=$_POST['address'];
    $role=(!empty($_POST['role']))?1:0;

    $stmt=$pdo->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindValue(':email',$email);
    $stmt->execute();
    $result=$stmt->fetch(PDO::FETCH_ASSOC);

    if($result){
        echo("<script>alert('Email already existed.');</script>");
    }else{
      $stmt=$pdo->prepare("INSERT INTO users(name,email,password,phone,address,role) VALUES(:name,:email,:password,:phone,:address,:role)");
      $result=$stmt->execute(
        array(':name'=>$name,':email'=>$email,':password'=>$password,':phone'=>$phone,':address'=>$address,':role'=>$role)

      );

      if($result){
        echo("<script>alert('Succesfully added.');window.location.href='user_list.php'</script>");
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
                <form class="" action="user_add.php" method="post">
                  <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <div class="form-group">
                        <label for="">Name</label><p style="color:red"><?php echo empty($nameError)  ? '':'*'.$nameError;?></p>
                        <input type="text" class="form-control" name="name" value="" >
                    </div>
                    <div class="form-group">
                        <label for="">Email</label><p style="color:red"><?php echo empty($emailError)  ? '':'*'.$emailError;?></p>
                        <textarea name="email" class="form-control" rows="8" cols="80" ></textarea>
                    </div>
                    <div class="form-group">
                        <label for="">Password</label><p style="color:red"><?php echo empty($pwError)  ? '':'*'.$pwError;?></p>
                        <input type="password" class="form-control" name="password" value="" >

                    </div>
                    <div class="form-group">
                        <label for="">Phone</label><p style="color:red"><?php echo empty($phError)  ? '':'*'.$phError;?></p>
                        <input type="text" class="form-control" name="phone" value="" >

                    </div>
                    <div class="form-group">
                        <label for="">Address</label><p style="color:red"><?php echo empty($addressError)  ? '':'*'.$addressError;?></p>
                        <textarea name="address" class="form-control" rows="8" cols="80"></textarea>

                    </div>
                    <div class="form-group">
                        <label for="">Admin</label><br>
                        <input type="checkbox" name="role" value="1">

                    </div>
                    <div class="form-group">
                      <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                      <a href="index.php" class="btn btn-warning">Back</a>
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
