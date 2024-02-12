<?php
    require_once '../../connect.php';
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>ติดตามสถานะการจอง</title>

    <!-- Custom fonts for this template -->
    <link rel="icon" type="image/png" href="../../img/edit_pro.png">
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Kanit:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    

</head>
<body id="page-top">
    <!-- <div class="modal fade" id="AddDocModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">เพิ่มข้อมูลพ่อ-แม่พันธุ์</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="Check_Add_fm.php" method="POST">
                        <div class="mb-3">
                            <label class="form-label">คำนำหน้าชื่อ</label>
                            <select class="form-control" aria-label="Default select example" name="pre" style="border-radius: 30px;" required>
                                <option selected>กรุณาเลือก....</option>
                                <option value="ทพ.">ทพ.</option>
                                <option value="ทพญ.">ทพญ.</option>
                            </select>
                        </div>                    
                        <div class="mb-3">
                            <label class="form-label">ชื่อ-สกุล</label>
                            <input type="text" class="form-control" name="name" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">เบอร์ติดต่อ</label>
                            <input type="tel" class="form-control" name="tel" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รหัสแพทย์</label>
                            <input type="text" class="form-control" name="name" style="border-radius: 30px;" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ประเภทการบริการ</label>
                            <input type="text" class="form-control" name="name" style="border-radius: 30px;" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" name="submit" class="btn btn-primary" style="border-radius: 30px;">เพิ่มข้อมูล</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> -->
    <div id="wrapper">
        <?php include('sidebar.php');?>
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <div class="container-fluid mt-5 col-md-11">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h4 class="m-0 font-weight-bold text-primary" align="center">ติดตามสถานะการจอง</h4>
                        </div>
                        <!-- <div class="row mt-4 ml-2">
                            <div class="col">
                                <a class="btn btn-primary" style="border-radius: 30px;" type="submit" data-toggle="modal" data-target="#AddDocModal">เพิ่มข้อมูลแพทย์</a>
                            </div>
                        </div> -->
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead align="center">
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อผู้รับบริการ</th>
                                            <th>ประเภทการบริการ</th>
                                            <th>วันที่จอง</th>
                                            <th>ช่วงเวลา</th>
                                            <th>สถานะ</th>
                                            <th></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td align="center">1</td>
                                            <td>xxxxxxxxxx xxxxxxxxxx</td>
                                            <td>xxxxxxxxxxxxxxxxxxxx</td>
                                            <td align="center">xx xxxxxxxx xxxx</td>
                                            <td align="center">xx.xx น.</td>
                                            <td align="center"><a class="btn btn-success badge">&nbsp&nbspปกติ&nbsp&nbsp</a></td>
                                            <td align="center"><a href="Edit_fm.php?edit_id=<?= $fm['fm_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid bx bxs-edit" style="font-size: 1rem;"></i></a></td>
                                            <td align="center"><a data-id="<?= $gf['gf_id']; ?>" href="?delete=<?= $gf['gf_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid bx bxs-trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td align="center">2</td>
                                            <td>Accountant</td>
                                            <td>ทันตกรรมทั่วไป</td>
                                            <td align="center">12 กุมภาพันธ์ 2566</td>
                                            <td align="center">12.00 น.</td>
                                            <td align="center"><a class="btn btn-danger badge">ยกเลิก</a></td>
                                            <td align="center"><a href="Edit_fm.php?edit_id=<?= $fm['fm_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid bx bxs-edit" style="font-size: 1rem;"></i></a></td>
                                            <td align="center"><a data-id="<?= $gf['gf_id']; ?>" href="?delete=<?= $gf['gf_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid bx bxs-trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td align="center">3</td>
                                            <td>Junior Technical Author</td>
                                            <td>ทันตกรรมความงาม</td>
                                            <td align="center">8 มีนาคม 2566</td>
                                            <td align="center">15.00 น.</td>
                                            <td align="center"><a class="btn btn-danger badge">ยกเลิก</a></td>
                                            <td align="center"><a href="Edit_fm.php?edit_id=<?= $fm['fm_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid bx bxs-edit" style="font-size: 1rem;"></i></a></td>
                                            <td align="center"><a data-id="<?= $gf['gf_id']; ?>" href="?delete=<?= $gf['gf_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid bx bxs-trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td align="center">4</td>
                                            <td>Junior Technical Author</td>
                                            <td>ทันตกรรมความงาม</td>
                                            <td align="center">8 มีนาคม 2566</td>
                                            <td align="center">15.00 น.</td>
                                            <td align="center"><a class="btn btn-success badge">&nbsp&nbspปกติ&nbsp&nbsp</a></td>
                                            <td align="center"><a href="Edit_fm.php?edit_id=<?= $fm['fm_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid bx bxs-edit" style="font-size: 1rem;"></i></a></td>
                                            <td align="center"><a data-id="<?= $gf['gf_id']; ?>" href="?delete=<?= $gf['gf_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid bx bxs-trash"></i></a></td>
                                        </tr>
                                        <tr>
                                            <td align="center">5</td>
                                            <td>Junior Technical Author</td>
                                            <td>ทันตกรรมความงาม</td>
                                            <td align="center">8 มีนาคม 2566</td>
                                            <td align="center">15.00 น.</td>
                                            <td align="center"><a class="btn btn-success badge">&nbsp&nbspปกติ&nbsp&nbsp</a></td>
                                            <td align="center"><a href="Edit_fm.php?edit_id=<?= $fm['fm_id']; ?>" class="btn btn-warning" name="edit_id"><i class="fa-solid bx bxs-edit" style="font-size: 1rem;"></i></a></td>
                                            <td align="center"><a data-id="<?= $gf['gf_id']; ?>" href="?delete=<?= $gf['gf_id']; ?>" class="btn btn-danger delete-btn"><i class="fa-solid bx bxs-trash"></i></a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php include('footer.php');?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

    <script>
        $.extend(true, $.fn.dataTable.defaults, {
            "language": {
                    "sProcessing": "กำลังดำเนินการ...",
                    "sLengthMenu": "แสดง _MENU_ รายการ",
                    "sZeroRecords": "ไม่พบข้อมูล",
                    "sInfo": "แสดงรายการ _START_ ถึง _END_ จาก _TOTAL_ รายการ",
                    "sInfoEmpty": "แสดงรายการ 0 ถึง 0 จาก 0 รายการ",
                    "sInfoFiltered": "(กรองข้อมูล _MAX_ ทุกรายการ)",
                    "sInfoPostFix": "",
                    "sSearch": "ค้นหา:",
                    "sUrl": "",
                    "oPaginate": {
                                    "sFirst": "เริ่มต้น",
                                    "sPrevious": "ก่อนหน้า",
                                    "sNext": "ถัดไป",
                                    "sLast": "สุดท้าย"
                    }
            }
        });
        $('.table').DataTable();
    </script>

</body>

</html>