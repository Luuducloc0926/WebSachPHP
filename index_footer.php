<head>
    <style>
        * {
            text-decoration: none;
            list-style: none;
            color: black;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.2);
        }

        h2 {
            font-size: 20px;
            font-weight: 700
        }

        .flex {
            display: flex;
        }

        ul li:not(:first-child) {
            padding: 5px;
        }

        .short_links ul {
    margin: 0 0px; /* Cách đều 2 bên 30px */
}

.short_links ul:not(:last-child) {
    margin-right: 140px; /* Các cột cách nhau 25px */
}

.sub_main .dropdown .dropbtn {
  border: none;
  cursor: pointer;
}

/* The container <div> - needed to position the dropdown content */
 .sub_main .dropdown {
  position: relative;
  display: inline-block;
}

/* Dropdown Content (Hidden by Default) */
 .sub_main .dropdown .dropdown-content {
  display: none;
  position: absolute;
  background-color: #CCCCCC;
  min-width: 160px;
  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
  z-index: 1;
}

/* Links inside the dropdown */
 .sub_main .dropdown .dropbtn  .dropdown-content a {
  color: black;
  padding: 12px 16px;
  text-decoration: none;
  display: block;
}

/* Change color of dropdown links on hover */
 .sub_main .dropdown .dropbtn .dropdown-content a:hover {background-color: #f1f1f1}

/* Show the dropdown menu on hover */
 .sub_main .dropdown:hover .dropdown-content {
  display: flex;
  flex-direction: column;
}
    </style>
    <link rel="stylesheet" href="./css/hello.css">
</head>

<footer style="margin: 0px auto 0; ">
    <div class="main" style="align-items:center; padding:5px; ">
        <div class="sub_main">
            <div class="short_links flex" style="justify-content:center; ">
                <?php
                if(isset($_SESSION['user_name'])){echo'
                <ul class="account">
                    <h2>Account</h2>
                    <li><a href="">Profile</a></li>
                    <li><a href="cart.php">Cart</a></li>
                    <li><a href="orders.php">Order History</a></li>
                    <li><a href="logout.php">LogOut</a></li>
                </ul>';}
                ?>
                <ul>
                    <h2>Liên hệ </h2>
                    <li><a href="contact-us.php">Đơn liên hệ</a></li>
                    <li>+91 5324851596</li>
                    <li>contact@bookflix.com</li>
                    <li>Address: Mumbai 400065</li>
                </ul>
                <ul>
                    <h2>Truy cập nhanh</h2>
                    
                </ul>
                <ul>
                    <h2>Cửa hàng </h2>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15673.406204299408!2d106.78244315!3d10.8608434!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3175276e7ea103df%3A0xb6cf10bb7d719327!2zSFVURUNIIC0gxJDhuqFpIGjhu41jIEPDtG5nIG5naOG7hyBUUC5IQ00gKFRodSBEdWMgQ2FtcHVzKQ!5e0!3m2!1svi!2s!4v1713118775819!5m2!1svi!2s"
                         width="350" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                       <h2>Fanpage</h2>
                         <iframe src="https://www.facebook.com/plugins/page.php?href=https%3A%2F%2Fwww.facebook.com%2FitHutech&tabs&width=350&height=200&small_header=false&adapt_container_width=true&hide_cover=false&show_facepile=false&appId"
                         width="350" height="200" style="border:none;overflow:hidden" scrolling="no" frameborder="0" allowfullscreen="true" allow="autoplay; clipboard-write; encrypted-media; picture-in-picture; web-share"></iframe>
                    </ul>
            </div>
        </div>
        <div style=" align-items:center; justify-content:center; margin:20px 0 0 ;" class="cmsg flex">
            <p>Thiết kế bởi Triple Trouble  | Copyright &copy; <script>
                    document.write(new Date().getFullYear())
                </script> All Rights are reserved by &nbsp</p>
            <div style="font-size: 30px;" class="logo">
                <a href="index.php"><span style="font-size: 15px;"> Triple & </span>
                    <span class="me" style="font-size: 15px;">Trouble</span></a>
            </div> 
        </div>
    </div>
</footer>