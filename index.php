<?php
    require_once 'connect.php';
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>ร้านค้ารัฐวิสาหกิจชุมชน</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
  
  <!-- Favicons -->
  <link rel="icon" type="image/png" href="img/home.png">

  <!-- Google Fonts -->
  <!-- <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet"> -->
  <link href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
          rel="stylesheet">  

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="assets/vendor/animate.css/animate.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

</head>

<body>
    <!-- ======= topbar ======= -->
    <?php include('./topbar/topbar.php');?>
    <!-- ======= Header ======= -->
    <?php include('./header/header.php');?>

  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center">
    <div class="container">
      <h1>ยินดีต้อนรับสู่ ร้านค้ารัฐวิสาหกิจชุมชน</h1>
      <a class="appointment-btn nav-link scrollto" href="#services">เลือกดูสินค้า</a>
    </div>
  </section>

  <main id="main">

    <!-- ======= Services Section ======= -->
    <section id="services" class="services">
      <div class="container">
        <div class="section-title">
          <h2>สินค้าภายในร้าน</h2>
        </div>
        <div class="row">
          <div class="menu__container bd-grid">
              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">กะปิขัดน้ำ</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 22.00 </span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>

              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">ซอสกะปิ</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 12.00</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>
              
              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">กุ้งแห้ง</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 9.50</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>

              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">น้ำปลา</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 9.50</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>

              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">น้ำปลา</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 9.50</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>

              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">น้ำปลา</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 9.50</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>

              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">กะปิขัดน้ำ</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 22.00 </span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>

              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">ซอสกะปิ</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 12.00</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>
              
              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">กุ้งแห้ง</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 9.50</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>

              <div class="menu__content">
                  <img src="img/shopping-cart.png" alt="" class="menu__img">
                  <h3 class="menu__name">น้ำปลา</h3>
                  <!-- <span class="menu__detail">Delicious dish</span> -->
                  <span class="menu__preci">฿ 9.50</span>
                  <a href="#" class="btn menu__button btn-success"><i class='bx bx-cart-alt'></i></a>
              </div>
          </div>
          <!-- <div class="col-lg-2 col-md-6 d-flex align-items-stretch"></div>
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-heartbeat"></i></div>
              <h4><a href="">ทันตกรรมทั่วไป</a></h4>
              <p>ถอนฟัน ขูนหินปูน ผ่าฟันขุด อุดฟัน รักษารากฟัน ปรึกษาทันตแพทย์</p>
            </div>
          </div>
          <div class="col-lg-4 col-md-6 d-flex align-items-stretch mt-4 mt-md-0">
            <div class="icon-box">
              <div class="icon"><i class="fas fa-pills"></i></div>
              <h4><a href="">ทันตกรรมความงาม</a></h4>
              <p>ดัดฟัน ครอบฟัน ฟันครอบ เครือบสีฟัน ปรึกษาทันตแพทย์</p>
            </div>
          </div> -->
        </div>
      </div>
    </section>
    <!-- End Services Section -->
    <!-- ======= Doctors Section ======= -->
    <!-- <section id="doctors" class="doctors">
      <div class="container">
        <div class="section-title">
          <h2>ทีมคณะแพทย์</h2>
        </div>
        <div class="row">
          <?php 
            $stmt = $db->query("SELECT * FROM `doctor_data`");
            $stmt->execute();
            $docs = $stmt->fetchAll();
            foreach($docs as $doc) {
              $doc_pre = $doc['doc_pre'];
              $doc_name = $doc['doc_name'];
              $doc_tel = $doc['doc_tel'];
              $doc_passDoc = $doc['doc_passDoctor'];
              $doc_type = $doc['doc_type'];

          ?>
              <div class="col-lg-6 mb-4">
                <div class="member d-flex align-items-start">
                  <div class="pic"><img src="assets/img/doctors/doctors-1.jpg" class="img-fluid" alt=""></div>
                  <div class="member-info">
                    <h4>
                      <?php 
                        if($doc_pre == 1){
                          echo "ทพ.".$doc_name ;
                        }else{
                          echo "ทพญ.".$doc_name ;
                        }
                      ?>
                    </h4>
                    <span>
                      <?php 
                        if($doc_type == 1){
                          echo "ทันตกรรมทั่วไป";
                        }else{
                          echo "ทันตกรรมความงาม";
                        }
                      ?>
                    </span>
                    <p>เบอร์ติดต่อ
                      <?= $doc_tel; ?>
                    </p>
                    <div class="social">
                      <a href=""><i class="ri-twitter-fill"></i></a>
                      <a href=""><i class="ri-facebook-fill"></i></a>
                      <a href=""><i class="ri-instagram-fill"></i></a>
                    </div>
                  </div>
                </div>
              </div>
            <?php 
              }
            ?>
        </div>
      </div>
    </section> -->
    <br><br><br><br><br><br><br><br><br><br><br><br><br>

    <!-- End Doctors Section -->

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container">
        <div class="section-title">
          <h2>การติดต่อ</h2>
        </div>
      </div>
      <div>
        <iframe style="border:0; width: 100%; height: 350px;" src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d3945.8013279471406!2d98.6326831!3d8.518661!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3051059e47a70897%3A0xfdea44c74d815278!2z4LiE4Lil4Li04LiZ4Li04LiB4LiX4Lix4LiZ4LiV4LiB4Lij4Lij4Lih4LiX4Lix4Lia4Lib4Li44LiU!5e0!3m2!1sth!2sth!4v1699038224208!5m2!1sth!2sth" frameborder="0" allowfullscreen></iframe>
      </div>
      <div class="container">
        <div class="row mt-5 center">
          <div class="col-lg-1"></div>
          <div class="col-lg-4">
            <div class="info">
              <div class="address">
                <i class="bi bi-geo-alt"></i>
                <h4>Location:</h4>
                <p>ตรงข้ามตลาดเทศบาลตำบลทับปุด 6/19 หมู่ 1 ต.ทับปุด อ.ทับปุด จ.พังงา รหัสไปรษณีย์ 82180</p>
              </div>
            </div>
          </div>
          
          <div class="col-lg-3">
            <div class="info">
              <div class="email">
                <i class="bi bi-envelope"></i>
                <h4>Email:</h4>
                <p>tubpud_11@gmail.com</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3">
            <div class="info">
              <div class="phone">
                <i class="bi bi-phone"></i>
                <h4>Call:</h4>
                <p>062-375-3324</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- End Contact Section -->
  </main>
  <!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include('./footer/footer.php');?>

  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>