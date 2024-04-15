<?php
require_once 'dompdf/autoload.inc.php';

 use Dompdf\Dompdf;
 $dompdf= new Dompdf;
include'config.php';

if(isset($_GET['order_id'])){
  $order_id = $_GET['order_id'];
  $get_order = mysqli_query($conn, "SELECT * FROM `confirm_order` WHERE order_id = '$order_id'") or die('query failed');
  if (mysqli_num_rows($get_order) > 0){
    $fetch_order = mysqli_fetch_assoc($get_order);
    
  }
  $get_order = mysqli_query($conn, "SELECT * FROM `orders` WHERE id = '$order_id'") or die('query failed');
  if (mysqli_num_rows($get_order) > 0){
    $fetch_details = mysqli_fetch_assoc($get_order);
    
  }
}


$html='<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Chi tiet hoa don</title>
    <style>
   
    .invoice .section-top{
        justify-content: center;
        text-align: center;
    }
    .invoice-title{
      margin: auto;
      font-weight: bold;

    }
    .logo{
        margin: auto;
    }
    .logo a{
        display: flex;
        cursor: pointer;
      }
      
      .logo a span {
        color: brown;
        font-weight: bold;
        padding-right: 5px;
        font-size: 30px;
      }
      .logo a .me {
        color: black;
        font-weight: 500;
      }
      .invoice .section-mid{
        display: flex;
        justify-content: space-between; 
      }
      hr{
       
        color: rgba(0,0,0,0.5);
      }
      tbody th{
        text-align: center;
      }

.section-bott .colspan{
    
}
      </style>
  </head>
  <body>
    <div class="invoice">
          <div class="section-top">
            <div class="logo">
                <a><span>Triple &</span>
                    <span class="me">Trouble</span></a>
            </div>
            <div class="invoice-title">Chi tiet hoa don</div>
          </div>
          <hr>
        <table>
        <tr>
          <th class="details"><div class="section-mid-one">
          <h3>THONG TIN DON HANG:</h3>
          <div class="buyer-details">
              <p class="buyer-name">To   '.$fetch_order['name'].' </p>
              <p class="buyer-add">Dia chi: '.$fetch_details['address'].'</p>
              <p class="buyer-area">TP: '.$fetch_details['city'].'</p>
              <p class="buyer-city">Noi dat: '.$fetch_details['state'].'</p>
              <p class="buyer-STATE">Nguoi dat o: '.$fetch_details['country'].'</p>
              <p class="buyer-STATE">Ma Pin: '.$fetch_details['pincode'].'</p>
          </div>
        </div></th>
          <th class="details"><div class="section-mid-one"><h3>BAN BOI:</h3>
          <div class="buyer-details">
              <p class="buyer-name">By  Triple & Trouble</p>
              <p class="buyer-add"> Duyet don: Admin</p>
              <p class="buyer-area"></p>
              <p class="buyer-city"></p>
              <p class="buyer-STATE"></p>
          </div>
      </div></th>
          <th class="details"><div class="section-mid-one"><h3>Chi Tiet:</h3>
            <div class="buyer-details">
                <p class="buyer-name">Chi tiet hoa don:  '.$fetch_order['date'].'</p>
                <p class="buyer-add">ID Don: '.$fetch_order['order_id'].' </p>
                <p class="buyer-area">Ngay dat don: '.$fetch_order['order_date'].'</p>
                <p class="buyer-city">From: HCM</p>
                <p class="buyer-STATE">Hinh thuc thanh toan: '.$fetch_order['payment_method'].' </p>
            </div>
        </div></th>
        </tr>
      </table>
      </div>
      <hr>
      <div class="section-bott" style="padding: 0 86px;
">
        <table style="width: 100%;">
          <thead>
            <th>S.No.</th>
            <th>TEN SACH</th>
            <th>SL</th>
            <th>GIA TIEN</th>
            <th>THANH TIEN</th>
          </thead>
          <tbody>';
          
          $select_book = mysqli_query($conn, "SELECT * FROM `orders`WHERE id = '$order_id'") or die('query failed');
          $s=1;
          if(mysqli_num_rows($select_book) > 0){
              while($fetch_book = mysqli_fetch_assoc($select_book)){
        
              $html.= '<tr>
                <th> '.$s.' </th>
                <th>'.$fetch_book['book'].'</th>
                <th> '.$fetch_book['quantity'].'</th>
                <th>'.$fetch_book['unit_price'].'</th>
                <th>'.$fetch_book['sub_total'].'</th>
              </tr>';
              $s++;
              }}
              
            
          $html.= '<tr style="margin: 10px 0 0 0;">
          <th></th>
          <th colspan="2" class="colspan">TONG TIEN</th>
          <th colspan="2"class="colspan"> '.$fetch_order['total_price'].'</th>
          
        </tr>';
          $html.= '</tbody>
        </table>
      </div>
      <hr />
      <div>
        <div class="sign">Tripble & Trouble</div>
      </div>
    </div>
  </body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream('invoice',array('Attachment'=>0));
?>