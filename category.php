<?php
include 'config.php';

session_start();

$admin_id = $_SESSION['admin_id'];

if(!isset($admin_id)){
   header('location:login.php');
};

if (isset($_POST['add_category'])) {
  $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

  if (empty($category_name)) {
    $message[] = 'Vui lòng nhập tên loại sách';
  } else {
    $add_category = mysqli_query($conn, "INSERT INTO category (Name) VALUES ('$category_name')");

    if ($add_category) {
      $message[] = 'Thêm loại sách thành công';
    } else {
      $message[] = 'Thêm loại sách không thành công';
    }
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
  <title>Thêm Loại Sách</title>
</head>

<body>
  <?php include './admin_header.php'; ?>
  
  <?php if (isset($message)) : ?>
    <?php foreach ($message as $msg) : ?>
      <div class="message" id="messages">
        <span><?= $msg ?></span>
      </div>
    <?php endforeach; ?>
  <?php endif; ?>

  <div class="container_box">
    <form action="" method="POST" enctype="multipart/form-data">
      <h3>Add Category To <a href="index.php"><span>Triple & </span><span>Trouble</span></a></h3>
      <input type="text" name="category_name" placeholder="Nhập tên loại sách" class="text_field">
      <input type="submit" value="Thêm loại sách" name="add_category" class="btn text_field">
    </form>
  </div>

  <script src="./js/admin.js"></script>
  <script>
    setTimeout(() => {
      const box = document.getElementById('messages');
      if (box) {
        box.style.display = 'none';
      }
    }, 8000);
  </script>
</body>
</html>
