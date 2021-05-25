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
  if (empty($_POST['name']) || empty($_POST['description']) || empty($_POST['category'])
      || empty($_POST['quantity']) || empty($_POST['price']) || empty($_FILES['image']['name'])) {
        if (empty($_POST['name'])) {
          $nameError = 'Category name is required';
        }
        if (empty($_POST['description'])) {
          $descError = 'Description is required';
        }
        if (empty($_POST['category'])) {
          $catError = 'Category is required';
        }
        if (empty($_POST['quantity'])) {
          $qtyError = 'Quantity is required';
        }elseif (is_numeric($_POST['quantity']) != 1) {
          $qtyError = 'Quantity should be integer value';
        }

        if (empty($_POST['price'])) {
          $priceError = 'Price is required';
        }elseif (is_numeric($_POST['price']) != 1) {
          $priceError = 'Price should be integer value';
        }

        if (empty($_FILES['image'])) {
          $imageError = 'Image is required';
        }


  }else{//validation success

        if (is_numeric($_POST['quantity']) != 1) {
          $qtyError = 'Quantity should be integer value';
        }
        if (is_numeric($_POST['price']) != 1) {
          $priceError = 'Price should be integer value';
        }

        if($qtyError=='' && $priceError==''){
          $file='images/'.($_FILES['image']['name']);
          $imgType=pathinfo($file,PATHINFO_EXTENSION);

          if($imgType!='jpg' && $imgType!='jpeg' && $imgType!='png'){
            echo "<script>alert('Image must be jpg,jpeg,png.')</script>";
          }else {
            $name=$_POST['name'];
            $desc=$_POST['description'];
            $category=$_POST['category'];
            $qty=$_POST['quantity'];
            $price=$_POST['price'];
            $image=$_FILES['image']['name'];

            move_uploaded_file($_FILES['image']['tmp_name'],$file);

            $stmt=$pdo->prepare("INSERT INTO products(name,description,category_id,quantity,price,image) VALUES(:name,:description,:category_id,:quantity,:price,:image)");

            $result=$stmt->execute(
                array(':name'=>$name,':description'=>$desc,':category_id'=>$category,':quantity'=>$qty,':price'=>$price,':image'=>$image)

              );
            if($result){
                echo "<script>alert('Product sucessfully added');window.location.href='index.php'</script>";
            }
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
                <form class="" action="product_add.php" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo $_SESSION['_token'];?>">
                    <div class="form-group">
                        <label for="">Product Name</label><p style="color:red"><?php echo empty($nameError)  ? '':'*'.$nameError;?></p>
                        <input type="text" class="form-control" name="name" value="" >
                    </div>
                    <div class="form-group">
                        <label for="">Description</label><p style="color:red"><?php echo empty($descError)  ? '':'*'.$descError; ?></p>
                        <textarea name="description" class="form-control" rows="8" cols="80" ></textarea>
                    </div>
                    <div class="form-group">
                      <?php
                        $catStmt=$pdo->prepare("SELECT * FROM categories");
                        $catStmt->execute();
                        $catResult=$catStmt->fetchAll();
                       ?>
                        <label for="">Cateogries</label><p style="color:red"><?php echo empty($catError)  ? '':'*'.$catError; ?></p>
                        <select class="" name="category">
                            <option value="">"SELECT CATEGORY"</option>
                            <?php foreach ($catResult as $value): ?>
                              <option value="<?php echo $value['id']?>"><?php echo $value['name']?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Quantity</label><p style="color:red"><?php echo empty($qtyError)  ? '':'*'.$qtyError; ?></p>
                        <input type="text" class="form-conrol" name="quantity" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Price</label><p style="color:red"><?php echo empty($priceError)  ? '':'*'.$priceError; ?></p>
                          <input type="text" class="form-conrol" name="price" value="">
                    </div>
                    <div class="form-group">
                        <label for="">Image</label><p style="color:red"><?php echo empty($imgError)  ? '':'*'.$imgError; ?></p>
                        <input type="file" name="image" value="">
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
