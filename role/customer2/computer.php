<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <?php include "top.php";  

?>
  <title>Inner Page - OnePage Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
 <!-- SweetAlert2 -->

  
  <!-- =======================================================
  * Template Name: OnePage
  * Updated: Aug 30 2023 with Bootstrap v5.3.1
  * Template URL: https://bootstrapmade.com/onepage-multipurpose-bootstrap-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

<?php 
      include "top.php"; 
      include "menumem.php"; ?> 

  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
         
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <section class="inner-page">
      <div class="container">
         <!-- partial -->
            <div class="col-lg-12 grid-margin  text-center">

              <div class="card">
                <div class="card-body">
                  
                  <div class="row-center">
                 
   <!-- partial -->
   <?php
      $mysqli = new mysqli('localhost', 'root', '', 'room');
      $day = $_GET['date'];
      $month = $_GET['month'];
      $year = $_GET['year'];
      $date = "$year-$month-$day";

    
     
$set ="SELECT * FROM settingbook WHERE id = 1";
$set2 = mysqli_query($conn,$set);
$setting = mysqli_fetch_array($set2);



$duration = $setting['duration'];
$cleanup = 0;
$start =  $setting['start'];
$end = $setting['end'];
function timeslots($duration, $cleanup, $start,$end){
$start = new DateTime($start);
$end = new DateTime($end);
$interval = new DateInterval("PT".$duration."M");
$cleanupInterval = new DateInterval("PT".$cleanup."M");
$slots = array();

for($intStart = $start;$intStart<$end;$intStart->add($interval)->add($cleanupInterval)){
  $endPeriod = clone $intStart;
  $endPeriod->add($interval);
  if($endPeriod>$end){
      break;
  }

  $slots[] = $intStart->format("H:iA")." - ".$endPeriod->format("H:iA");

}
return $slots;
}

?>
<style>
 .computer {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }

        .computer-item {
            width: 200px;
            height: 200px;
            border: 1px solid #ccc;
            margin: 10px;
            text-align: center;
            padding: 20px;
            background-color: #f0f0f0;
        }
.button-container {
    margin-top: 50px; /* ปรับระยะห่างด้านบนของปุ่ม */
    /* ปรับระยะห่างด้านขวาของปุ่ม */
  }


</style>
<?php
date_default_timezone_set('asia/bangkok');
$c ="SELECT * FROM comp_state";
$com = mysqli_query($conn,$c);

?>


<div class="text-center row">
<h3 class="text-dark">วันที่ : <b><?php echo $date; ?></b></h3>

        <?php
      $timeslots = timeslots($duration,$cleanup,$start,$end);
       while($comp = mysqli_fetch_array($com)){ 
        $comid = $comp['Id_comp'];
       
        $nco = "SELECT * FROM comroom  WHERE room_id = '$comid'";
        $ncom = mysqli_query($conn,$nco); 
        $numcop = mysqli_num_rows($ncom);
        $re = "SELECT * FROM comroom  WHERE room_id = '$comid' AND status = 1";
        $rea = mysqli_query($conn,$re); 
        $ready = mysqli_num_rows($rea);
        ?>
        <div class="col-lg-4 col-md-6 align-items-stretch" data-aos="zoom-in" data-aos-delay="10">
       <div class="col-md-3 button-container">
            <div class="computer-item">
          <b class="h3 text-primary"><?php echo $comp['comp_name']; ?></b>
       </br>
     
       <?php if($comp['comp_status'] == 0){
        ?>  <b class="text-success h"> <i class="bi bi-check2"> </i> พร้อมใช้งาน</b></br>
        
        <hr>
    <a href="bookings.php?com=<?php echo $comp['Id_comp']; ?>&date=<?php echo $day; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>"> <button type="button" class="btn btn-info" >เลือกห้องนี้</button></a>
        <?php }elseif($comp['comp_status'] == 1){ ?>
          <b class="text-warning"> <i class="bi bi-hammer"> </i> มีปัญหา</b>
     
          <hr>
          <button type="button" class="btn btn-dark" >ไม่พร้อมใช้งาน</button>
       <?php  }elseif($comp['comp_status'] == 2){ ?>
          <b class="text-danger"> <i class="bi bi-exclamation-triangle-fill"></i> เสีย</b>
          <hr>
          <button type="button" class="btn btn-dark" >ไม่พร้อมใช้งาน</button>
       <?php  } ?> </br> </br> 
       <p class="h6"> มีคอม <b class="text-danger"><?php echo $ready; ?></b>/<?php echo $numcop; ?> เครื่อง</p>
      
 
    
      
       </br>
      
       
    
            </div>
            </div>
            </div>
      
       <?php } ?>
    </div>
              
</div>
      

 </div>
                  </div>
                  <a href="calcendal.php"><button type="button" class="btn btn-dark userinfo" ><i class="fas fa-plus"></i>&nbsp;&nbsp;ย้อนกลับ</button></a>
                </div>
                </div>
             
             </div>
           </div>
         </div>

           

  </main><!-- End #main -->
<?php include 'footer.php'; ?>
  
  <div id="preloader"></div>
  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
 

  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>