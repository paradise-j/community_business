<?php
  require_once '../../connect.php';
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>จองห้อง</title>
    <meta content="" name="description">
    <meta content="" name="keywords">

    <!-- Favicons -->
    <link href="assets/img/favicon.png" rel="icon">
    <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Kanit:300,300i,400,400i,600,600i,700,700i|Raleway:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

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

    <link id="pagestyle" href="assets/css/argon-dashboard.css?v=2.0.3" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  </head>

  <body>
    <main id="main">
      <section class="breadcrumbs">
        <div class="container">
          <div class="d-flex justify-content-between align-items-center"></div>
        </div>
      </section>
      <section class="inner-page">
        <div class="container">
          <div class="col-lg-20 grid-margin ">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <!-- <?php @session_start(); ?> -->
                  <?php
                    date_default_timezone_set('asia/bangkok');

                    function build_calendar($month, $year)
                    {

                      // Create array containing abbreviations of days of week.
                      $daysOfWeek = array('วันอาทิตย์', 'วันจันทร์', 'วันอังคาร', 'วันพุธ', 'วันพฤหัสบดี', 'วันศุกร์', 'วันเสาร์');

                      // What is the first day of the month in question?
                      $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);

                      // How many days does this month contain?
                      $numberDays = date('t', $firstDayOfMonth);

                      // Retrieve some information about the first day of the
                      // month in question.
                      $dateComponents = getdate($firstDayOfMonth);

                      // What is the name of the month in question?
                      $monthName = $dateComponents['month'];

                      // What is the index value (0-6) of the first day of the
                      // month in question.
                      $dayOfWeek = $dateComponents['wday'];

                      // Create the table tag opener and day headers
                    ?>
                    <center>
                      <?php
                        $datetoday = date('Y-m-d');
                        
                        $calendar = "<table class='table'>";
                      ?>
                      <center>
                        <p class="h2">
                          <?php if ($monthName == 'January') { ?> เดือนมกราคม
                          <?php } elseif ($monthName == 'February') { ?> เดือนกุมภาพันธ์
                          <?php } elseif ($monthName == 'March') { ?> เดือนมีนาคม
                          <?php } elseif ($monthName == 'April') { ?> เดือนเมษายน
                          <?php } elseif ($monthName == 'May') { ?> เดือนพฤษภาคม
                          <?php } elseif ($monthName == 'June') { ?> เดือนมิถุนายน
                          <?php } elseif ($monthName == 'July') { ?> เดือนกรกฎาคม
                          <?php } elseif ($monthName == 'August') { ?> เดือนสิงหาคม
                          <?php } elseif ($monthName == 'September') { ?> เดือนกันยายน
                          <?php } elseif ($monthName == 'October') { ?> เดือนตุลาคม
                          <?php } elseif ($monthName == 'November') { ?> เดือนพฤศจิกายน
                          <?php } elseif ($monthName == 'December') { ?> เดือนธันวาคม

                          <?php } ?>
                        </p>
                        <?php
                        $calendar .= "<center><p class='h2'>$year</p>";

                        $calendar .= " <a class='btn btn-xs btn-primary' href='?month=" . date('m') . "&year=" . date('Y') . "'><i class='bi bi-calendar-event'></i>&nbsp;&nbsp;&nbsp;เดือนปัจจุบัน&nbsp;</a> ";

                        $calendar .= "<a class='btn btn-xs btn-primary' href='?month=" . date('m', mktime(0, 0, 0, $month + 1, 1, $year)) . "&year=" . date('Y', mktime(0, 0, 0, $month + 1, 1, $year)) . "'>&nbsp;เดือนถัดไป&nbsp;&nbsp;&nbsp;<i class='bi bi-chevron-right'></i></a></center><br>";



                        $calendar .= "<tr>";

                        // Create the calendar headers
                      
                        foreach ($daysOfWeek as $day) {
                          $calendar .= "<th  class='heaer'>$day</th>";
                        }

                        // Create the rest of the calendar
                      
                        // Initiate the day counter, starting with the 1st.
                      
                        $currentDay = 1;

                        $calendar .= "</tr><tr>";

                        // The variable $dayOfWeek is used to
                        // ensure that the calendar
                        // display consists of exactly 7 columns.
                      
                        if ($dayOfWeek > 0) {
                          for ($k = 0; $k < $dayOfWeek; $k++) {
                            $calendar .= "<td  class='empty'></td>";

                          }
                        }


                        $month = str_pad($month, 2, "0", STR_PAD_LEFT);

                        while ($currentDay <= $numberDays) {

                          // Seventh column (Saturday) reached. Start a new row.
                      
                          if ($dayOfWeek == 7) {
                            $dayOfWeek = 0;
                            $calendar .= "</tr><tr>";
                          }

                          $currentDayRel = str_pad($currentDay, 2, "0", STR_PAD_LEFT);
                          $date = "$year-$month-$currentDayRel";
                          $date2 = "$currentDayRel";
                          $month = "$month";
                          $year = "$year";

                          ini_set('display_errors', 1);
                          error_reporting(~0);

                          include('../../connect.php');
                          // mysqli_set_charset($conn, "utf8");
                          // date_default_timezone_set("Asia/Bangkok");
                          // $set = ("SELECT * FROM settingbook WHERE id = 1"); 

                          $set = $db->query("SELECT * FROM `settingbook` WHERE `id` = '1'");
                          $set->execute();
                          // print_r($set2);
                          $settings = $set->fetchAll();
                          $dayname = strtolower(date('l', strtotime($date)));
                          $eventNum = 0;
                          $today = $date == date('Y-m-d') ? "today" : "";
                          foreach($settings as $setting){
                            if ($dayOfWeek == $setting['close']) {
                              $calendar .= "<td class='$today'><h4>$currentDay</h4> <button class='btn btn-danger btn-xs'><i class='bi bi-calendar-x'></i>&nbsp;&nbsp;&nbsp;วันหยุด</button>";
  
                            } elseif ($date < date('Y-m-d')) {
                              $calendar .= "<td><h4>$currentDay</h4> <button class='btn btn-dark btn-xs'><i class='bi bi-calendar-x'></i>&nbsp;&nbsp;&nbsp;หมดเวลา</button>";
                            } else {
                              $calendar .= "<td class='$today'><h4>$currentDay</h4> <a href=computer.php?date=" . $date2 . "&&month=" . $month . "&&year=" . $year . " class='btn btn-info btn-xs' ><i class='bi bi-calendar-check-fill'></i>&nbsp;&nbsp;&nbsp;จองได้</a>";
                            }
                          }
                          // print_r($setting );
                          // $set2 = mysqli_query($conn, $set);
                          // $setting = mysqli_fetch_array($set2);
                          






                          

                          $calendar .= "</td>";
                          // Increment counters
                      
                          $currentDay++;
                          $dayOfWeek++;

                        }



                        // Complete the row of the last week in month, if necessary
                      
                        if ($dayOfWeek != 7) {

                          $remainingDays = 7 - $dayOfWeek;
                          for ($l = 0; $l < $remainingDays; $l++) {
                            $calendar .= "<td class='empty'></td>";

                          }

                        }

                        $calendar .= "</tr>";

                        $calendar .= "</table>";

                        echo $calendar;

                  }

                  ?>


                      <head>

                        <style>
                          @media only screen and (max-width: 760px),
                          (min-device-width: 802px) and (max-device-width: 1020px) {

                            /* Force table to not be like tables anymore */
                            table,
                            thead,
                            tbody,
                            th,
                            td,
                            tr {
                              display: block;
                            }
                            .empty {
                              display: none;
                            }

                            /* Hide table headers (but not display: none;, for accessibility) */
                            th {
                              position: absolute;
                              top: -9999px;
                              left: -9999px;
                            }

                            tr {
                              border: 1px solid #ccc;
                            }

                            td {
                              /* Behave  like a "row" */
                              border: none;
                              border-bottom: 1px solid #eee;
                              position: relative;
                              padding-left: 50%;
                            }

                            /* Label the data */
                            td:nth-of-type(1):before {
                              content: "วันอาทิตย์";
                            }

                            td:nth-of-type(2):before {
                              content: "วันจันทร์";
                            }

                            td:nth-of-type(3):before {
                              content: "วันอังคาร";
                            }

                            td:nth-of-type(4):before {
                              content: "วันพุธ";
                            }

                            td:nth-of-type(5):before {
                              content: "วันพฤหัสบดี";
                            }

                            td:nth-of-type(6):before {
                              content: "วันศุกร์";
                            }

                            td:nth-of-type(7):before {
                              content: "วันอาทิตย์";
                            }
                          }
                          /* Smartphones (portrait and landscape) ----------- */

                          @media only screen and (min-device-width: 320px) and (max-device-width: 480px) {
                            body {
                              padding: 0;
                              margin: 0;
                            }
                          }

                          /* iPads (portrait and landscape) ----------- */

                          @media only screen and (min-device-width: 802px) and (max-device-width: 1020px) {
                            body {
                              width: 495px;
                            }
                          }

                          @media (min-width:641px) {
                            table {
                              table-layout: fixed;
                            }

                            td {
                              width: 33%;
                            }
                          }

                          .row {
                            margin-top: 20px;
                          }

                          .today {
                            background: #00CED1;
                          }

                          .Wednesday {
                            background: red;
                          }
                        </style>
                      </head>

                      <?php
                        $dateComponents = getdate();
                        if (isset($_GET['month']) && isset($_GET['year'])) {
                          $month = $_GET['month'];
                          $year = $_GET['year'];
                        } else {
                          $month = $dateComponents['mon'];
                          $year = $dateComponents['year'];
                        }
                        echo build_calendar($month, $year);
                      ?>
                      </br> 
                      <a href="book_list.php"><button type="button" class="btn btn-success userinfo"><i class="bi bi-card-list"></i>&nbsp;&nbsp;ดูประวัติการจอง</button></a> 
                      <a href="home.php"><button type="button" class="btn btn-dark userinfo"><i class="fas fa-plus"></i>&nbsp;&nbsp;ย้อนกลับ</button></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>

    <script type='text/javascript'>
      $(document).ready(function () {
        $('.userinfo').click(function () {
          var userid = $(this).data('id');
          $.ajax({
            url: 'ajax_table.php',
            type: 'post',
            data: { userid: userid },
            success: function (response) {
              $('.modal-body').html(response);
              $('#empModal').modal('show');
            }
          });
        });
      });
    </script>
    
    <div id="preloader"></div>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i
        class="bi bi-arrow-up-short"></i></a>

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