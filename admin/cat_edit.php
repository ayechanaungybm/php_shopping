<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

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
  if (empty($_POST['name']) || empty($_POST['description'])) {
    if(empty($_POST['name'])){
      $nameError="Category name required";
    }
    if(empty($_POST['description'])){
      $descError="Description required";
    }

  }else{
      $id=$_POST['id'];
      $name=$_POST['name'];
      $desc=$_POST['description'];

      $stmt=$pdo->prepare("UPDATE categories SET name=:name , description=:description WHERE id=:id");
      $result=$stmt->execute(
        array(':id'=>$id,':name'=>$name,':description'=>$desc)
      );
      if($result){
        echo "<script>alert('Succesfully updated category.');window.location.href='category.php';</script>";

      }
    }

}
$stmt=$pdo->prepare("SELECT * FROM categories WHERE id=".$_GET['id']);
$stmt->execute();
$result=$stmt->fetchAll();
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
                <form class="" action="cat_edit.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <input type="hidden" name="id" value="<?php echo $result[0]['id']?>">
                    <div class="form-group">
                        <label for="">Category Name</label><p style="color:red"><?php echo empty($nameError)  ? '':'*'.$nameError;?></p>
                        <input type="text" class="form-control" name="name" value="<?php echo $result[0]['name'];?>" >
                    </div>
                    <div class="form-group">
                        <label for="">Description</label><p style="color:red"><?php echo empty($descError)  ? '':'*'.$descError; ?></p>
                        <textarea name="description" class="form-control" rows="8" cols="80" ><?php echo $result[0]['description'];?></textarea>
                    </div>

                    <div class="form-group">
                      <input type="submit" class="btn btn-success" name="" value="SUBMIT">
                      <a href="category.php" class="btn btn-warning">Back</a>
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
