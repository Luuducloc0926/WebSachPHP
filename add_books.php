<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if (isset($_POST['add_books'])) {
   $bname = mysqli_real_escape_string($conn, $_POST['book_name']);
   $btitle = mysqli_real_escape_string($conn, $_POST['book_title']);
   $category = mysqli_real_escape_string($conn, $_POST['category_id']);
   $price = $_POST['book_price'];
   $desc = mysqli_real_escape_string($conn, $_POST['book_description']);
   $img = $_FILES["book_image"]["name"];
   $img_temp_name = $_FILES["book_image"]["tmp_name"];
   $img_file = "./added_books/" . $img;

   if (empty($bname)) {
       $message[] = 'Vui lòng nhập tên sách';
   } elseif (empty($btitle)) {
       $message[] = 'Vui lòng nhập tựa đề';
   } elseif (empty($price)) {
       $message[] = 'Vui lòng nhập giá';
   } elseif (empty($category)) {
       $message[] = 'Vui lòng nhập phân loại sách';
   } elseif (empty($desc)) {
       $message[] = 'Vui lòng nhập mô tả sách';
   } elseif (empty($img)) {
       $message[] = 'Vui lòng chọn sách';
   } else {
       $add_book = mysqli_query($conn, "INSERT INTO book_info(`name`, `title`, `price`, `category_id`, `description`, `image`) VALUES('$bname','$btitle','$price','$category','$desc','$img')") or die('Query failed');

       if ($add_book) {
           move_uploaded_file($img_temp_name, $img_file);
           $message[] = 'Thêm sách thành công';
       } else {
           $message[] = 'Thêm sách không thành công';
       }
   }
}


if(isset($_GET['delete'])){
  $delete_id = $_GET['delete'];
  mysqli_query($conn, "DELETE FROM `book_info` WHERE bid = '$delete_id'") or die('query failed');
  header('location:add_books.php');
}


if(isset($_POST['update_product'])){

  $update_p_id = $_POST['update_p_id'];
  $update_name = $_POST['update_name'];
  $update_title = $_POST['update_title'];
  $update_description = $_POST['update_description'];
  $update_price = $_POST['update_price'];

  mysqli_query($conn, "UPDATE `book_info` SET name = '$update_name', title='$update_title', description ='$update_description', price = '$update_price',category='$update_category' WHERE bid = '$update_p_id'") or die('query failed');

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

  header('location:./add_books.php');

}

?>
<?php
// Kết nối đến cơ sở dữ liệu
include 'config.php';

// Truy vấn cơ sở dữ liệu để lấy danh sách loại sách
$category_query = mysqli_query($conn, "SELECT * FROM category");

// Kiểm tra xem có bất kỳ lỗi nào xảy ra trong quá trình truy vấn hay không
if (!$category_query) {
    die('Query failed: ' . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./css/register.css">
  <title>Add Books</title>
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
  
<a class="update_btn" style="position: fixed ; z-index:100;" href="total_books.php">Xem tất cả sách</a>
<div class="container_box">
    <form action="" method="POST" enctype="multipart/form-data">
        <h3>Add Books To <a href="index.php"><span>Triple & </span><span>Trouble</span></a></h3>
        <input type="text" name="book_name" placeholder="Tên sách" required class="text_field">
        <input type="text" name="book_title" placeholder="Tên tác giả" required class="text_field">
        <select name="category_id" required class="text_field">
            <?php
            // Lặp qua kết quả của truy vấn và hiển thị từng loại sách dưới dạng tùy chọn trong menu dropdown
            while ($row = mysqli_fetch_assoc($category_query)) {
                // Lấy id của loại sách từ cơ sở dữ liệu
                $category_id = $row['id'];
                // Lấy tên loại sách từ cơ sở dữ liệu
                $category_name = $row['Name'];
                // Hiển thị tùy chọn trong menu dropdown với giá trị category_id là số nguyên
                echo "<option value='$category_id'>$category_name</option>";
            }
            ?>
        </select>
        <input type="text" name="book_description" placeholder="Mô tả" required class="text_field">
        <input type="number" name="book_price" placeholder="Giá sách" required class="text_field">
        <input type="file" name="book_image" accept="image/jpg, image/jpeg, image/png" required class="text_field">
        <input type="submit" name="add_books" value="Thêm sách" class="text_field">
    </form>
</div>

  <?php
   if(isset($_GET['update'])){
      $update_id = $_GET['update'];
      $update_query = mysqli_query($conn, "SELECT * FROM `book_info` WHERE bid = '$update_id'") or die('query failed');
      if(mysqli_num_rows($update_query) > 0){
         while($fetch_update = mysqli_fetch_assoc($update_query)){
?>
<form action="" method="post" enctype="multipart/form-data">
   <input type="hidden" name="update_p_id" value="<?php echo $fetch_update['bid']; ?>">
   <input type="hidden" name="update_old_image" value="<?php echo $fetch_update['image']; ?>">
   <img src="./added_books/<?php echo $fetch_update['image']; ?>" alt="">
   <input type="text" name="update_name" value="<?php echo $fetch_update['name']; ?>" class="box" required placeholder="Nhập tên sách">
   <input type="text" name="update_title" value="<?php echo $fetch_update['title']; ?>" class="box" required placeholder="Nhập tên tác giả">
   <select name="update_category" class="text_field" required>
         <?php
         // Truy vấn cơ sở dữ liệu để lấy danh sách loại sách
         $category_query = mysqli_query($conn, "SELECT * FROM `category`") or die('category query failed');
         if(mysqli_num_rows($category_query) > 0){
            while($category_row = mysqli_fetch_assoc($category_query)){
               $category_name = $category_row['Name'];
               // Kiểm tra nếu loại sách được chọn trùng với loại sách trong cơ sở dữ liệu thì đặt thuộc tính selected
               $selected = ($category_name == $fetch_update['category']) ? 'selected' : '';
               echo "<option value='$category_name' $selected>$category_name</option>";
            }
         }
         ?>
      </select>
   <input type="text" name="update_description" value="<?php echo $fetch_update['description']; ?>" class="box" required placeholder="Mô tả">
   <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Nhập giá sách">
   <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
   <input type="submit" value="update" name="update_product" class="delete_btn" >
   <input type="reset" value="cancel" id="close-update" class="update_btn" >
</form>
<?php
      }
   }
   }else{
      echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
   }
?>

  <section class="show-products">

   <div class="box-container">

      <?php
         $select_book = mysqli_query($conn, "SELECT * FROM book_info ORDER BY date DESC LIMIT 2;") or die('query failed');
         if(mysqli_num_rows($select_book) > 0){
            while($fetch_book = mysqli_fetch_assoc($select_book)){
      ?>
      <div class="box">
         <img class="books_images" src="added_books/<?php echo $fetch_book['image']; ?>" alt="">
         <div class="name">Tác giả: <?php echo $fetch_book['title']; ?></div>
         <div class="name">Tên sách: <?php echo $fetch_book['name']; ?></div>
         <div class="price">Giá: <?php echo number_format($fetch_book['price'], 0, ',', '.') ?>đ</div>
         <a href="add_books.php?update=<?php echo $fetch_book['bid']; ?>" class="update_btn">update</a>
         <a href="add_books.php?delete=<?php echo $fetch_book['bid']; ?>" class="delete_btn" onclick="return confirm('delete this product?');">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>

</section>

<section class="edit-product-form">

   <?php
      if(isset($_GET['update'])){
         $update_id = $_GET['update'];
         $update_query = mysqli_query($conn, "SELECT * FROM `book_info` WHERE bid = '$update_id'") or die('query failed');
         if(mysqli_num_rows($update_query) > 0){
            while($fetch_update = mysqli_fetch_assoc($update_query)){
   ?>
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
               $category_name = $category_row['Name'];
               // Kiểm tra nếu loại sách được chọn trùng với loại sách trong cơ sở dữ liệu thì đặt thuộc tính selected
               $selected = ($category_name == $fetch_update['category']) ? 'selected' : '';
               echo "<option value='$category_name' $selected>$category_name</option>";
            }
         }
         ?>
      </select>
      <input type="text" name="update_description" value="<?php echo $fetch_update['description']; ?>" class="box" required placeholder="Enter product description">
      <input type="number" name="update_price" value="<?php echo $fetch_update['price']; ?>" min="0" class="box" required placeholder="Enter product price">
      <input type="file" class="box" name="update_image" accept="image/jpg, image/jpeg, image/png">
      <input type="submit" value="update" name="update_product" class="delete_btn">
      <input type="reset" value="cancel" id="close-update" class="update_btn">
   </form>
   <?php
            }
         }
      }else{
         echo '<script>document.querySelector(".edit-product-form").style.display = "none";</script>';
      }
   ?>

</section>


<script src="./js/admin.js"></script>
<script>
setTimeout(() => {
  const box = document.getElementById('messages');

  // 👇️ hides element (still takes up space on page)
  box.style.display = 'none';
}, 8000);
</script>
</body>

</html>