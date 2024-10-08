<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $rpdate = $_POST['rpdate'];
        $rpname = $_POST['rpname'];
        $rpquan = $_POST['rpquan'];
        $rpprice = $_POST['rpprice'];
        $rpcost = $rpprice/$rpquan;
        $group = $_POST['group'];
        $img = $_FILES['img'];

        $allow = array('jpg', 'jpeg', 'png');
        $extension = explode('.', $img['name']);
        $fileActExt = strtolower(end($extension));
        $fileNew = rand() . "." . $fileActExt; 
        $filePath = 'uploads/receivePD/'.$fileNew;

        $rp = $db->prepare("SELECT `rp_name` FROM `receivepd` WHERE `group_id` = '$group'");
        $rp->execute();

        $check = array();
        while ($row = $rp->fetch(PDO::FETCH_ASSOC)){
            $name = $row["rp_name"];
            array_push($check,$name);
            
        }
        

        if(!in_array("$rpname", $check)){
            // echo "Match not found";
            if (in_array($fileActExt, $allow)) {
                if ($img['size'] > 0 && $img['error'] == 0) {
                    if (move_uploaded_file($img['tmp_name'], $filePath)) {
                                    $sql = $db->prepare("INSERT INTO `receivepd`( `rp_date`, `rp_name`, `rp_quan`,`rp_price`,`rp_cost`, `rp_img`, `group_id`)
                                                    VALUES ('$rpdate','$rpname','$rpquan','$rpprice','$rpcost','$fileNew','$group')");
                                    $sql->execute();

                                    if ($sql) {
                                        $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อยแล้ว";
                                        echo "<script>
                                            $(document).ready(function() {
                                                Swal.fire({
                                                    title: 'สำเร็จ',
                                                    text: 'เพิ่มข้อมูลเรียบร้อยแล้ว',
                                                    icon: 'success',
                                                    timer: 5000,
                                                    showConfirmButton: false
                                                });
                                            })
                                        </script>";
                                        header("refresh:1; url=receivePD.php");
                                    } else {
                                        $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                                        header("location: receivePD.php");
                                    }

                    }
                }
            }

            

        }else{
            // echo "Match found";
            $_SESSION['success'] = "ข้อมูลสินค้านี้มีแล้ว";
            echo "<script>
                $(document).ready(function() {
                    Swal.fire({
                        title: 'ไม่สำเร็จ',
                        text: 'ข้อมูลสินค้านี้มีแล้ว',
                        icon: 'warning',
                        timer: 15000,
                        showConfirmButton: false
                    });
                })
            </script>";
            header("refresh:1; url=receivePD.php");
        } 
    }
?>