<?php
include 'config.php';
session_start();  
$admin_id = $_SESSION['admin_id'];

if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `book_info` WHERE bid = '$delete_id'") or die('query failed');
  header('location:total_books.php');
}


if(isset($_POST['update_product'])){

  $update_p_id = $_POST['update_p_id'];
  $update_name = $_POST['update_name'];
  $update_title = $_POST['update_title'];
  $update_description = $_POST['update_description'];
  $update_price = $_POST['update_price'];
  $update_category_id = $_POST['update_category']; // Thay đổi tên biến này

  mysqli_query($conn, "UPDATE `book_info` SET name = '$update_name', title='$update_title', description ='$update_description', price = '$update_price', category_id='$update_category_id' WHERE bid = '$update_p_id'") or die('query failed'); // Sửa cột category thành category_id

 

  $update_image = $_FILES['update_image']['name'];
  $update_image_tmp_name = $_FILES['update_image']['tmp_name'];
  $update_image_size = $_FILES['update_image']['size'];
  $update_folder = './added_books/'.$update_image;
  $update_old_image = $_POST['update_old_image'];

  if(!empty($update_image)){
     if($update_image_size > 2000000){
        $message[] = 'kích thước tệp hình ảnh quá lớn';
     }else{
        mysqli_query($conn, "UPDATE `book_info` SET image = '$update_image' WHERE bid = '$update_p_id'") or die('query failed');
        move_uploaded_file($update_image_tmp_name, $update_folder);
        unlink('uploaded_img/'.$update_old_image);
     }
  }
  header('location:total_books.php');
  if($update_query){
      $message[] = 'Sửa sách thành công';
   } else {
      $message[] = 'Sửa sách không thành công';
   }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/register.css">
  <title>Sửa sách</title>
</head>

<body>
  <?php
  include './admin_header.php'
  ?>
  <?php
  if (isset($message)) {
    foreach ($message as $message) {
      echo '
        <div class="message" id="messages"><span>' . $message . '</span>
        </div>
        ';
    }
  }
  ?>
<a class="update_btn" style="position: fixed ; z-index:100;" href="add_books.php">Thêm Sách</a>

<section class="edit-product-form">
   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `book_info` WHERE bid = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
   <div class="container_box">
   <form action="" method="post" enctype="multipart/form-data">
      <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['bid']; ?>">
      <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
      <img src="./added_books/<?php echo $fetch_update['image']; ?>" alt="">
      <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Enter Book Name">
      <input type="text" name="update_title" value="<?php echo $fetch_update['title']; ?>" class="box" required placeholder="Enter Author Name">
      <select name="update_category" class="text_field" required>
         <?php
         // Truy vấn cơ sở dữ liệu để lấy danh sách loại sách
         $category_query = mysqli_query($conn, "SELECT * FROM `category`") or die('category query failed');
         if(mysqli_num_rows($category_query) > 0){
            while($category_row = mysqli_fetch_assoc($category_query)){
               $category_id = $category_row['id'];
               $category_name = $category_row['Name'];
               // Kiểm tra nếu category_id được chọn trùng với category_id trong cơ sở dữ liệu thì đặt thuộc tính selected
               $selected = ($category_id == $fetch_update['category_id']) ? 'selected' : '';
               echo "<option value='$category_id' $selected>$category_name</option>";
            }
         }
         ?>
      </select>
      <input type="text" name="update_description" value="<?php echo $fetch_update['description']; ?>" class="box" required placeholder="Enter product description">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="update_btn">
      <input type="reset" value="cancel" id="close-update" class="delete_btn">
   </form>
      </d>
   <?php
            }
         }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>
</section>


  <section class="show-products">
   <div class="box-container">

      <?php
               $select_book = mysqli_query($conn, "SELECT * FROM `book_info` ORDER BY date DESC") or die('query failed');
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_book = mysqli_fetch_assoc($select_book)){
      ?>
      <div class="box">
         <img class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt="">
         <div class="name">Tên sách: <?php echo $fetch_book['name']; ?></div>
         <div class="name">Tác giả: <?php echo $fetch_book['title']; ?></div>
         <div class="price">Giá: <?php echo number_format($fetch_book['price'], 0, ',', '.') ?>đ</div>
         <a href="update_book.php?update=<?php echo $fetch_book['bid']; ?>" class="update_btn">Cập nhật</a>
         <a href="total_books.php?delete=<?php echo $fetch_book['bid']; ?>" class="delete_btn" onclick="return confirm('Xóa sản phẩm này?');">Xóa</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">Chưa có sản phẩm nào được thêm vào!</p>';
      }
      ?>
   </div>
</section>

<script src="./js/admin.js"></script>
</body>

</html>