<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";


    if (isset($_POST['submit'])) {
        $pdname = $_POST['pdname'];
        $quan = $_POST['quan'];
        $cost = $_POST['cost'];
        $date = $_POST['date'];
        $avgprice = $cost/$quan;

        $mf = $db->prepare("SELECT `mf_name` FROM `mf_data`");
        $mf->execute();

        $check = array();
        while ($row = $mf->fetch(PDO::FETCH_ASSOC)){
            $name = $row["mf_name"];
            array_push($check,$name);
            
        }
        // print_r($check);
        // echo $pdname;

        if(!in_array("$pdname", $check)){
            echo "Match not found";
            $sql = $db->prepare("INSERT INTO `mf_data`(`mf_date`, `mf_name`, `mf_cost`, `mf_quan`, `mf_tocost`)
                                            VALUES ('$date','$pdname','$cost','$quan','$avgprice')");
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
            header("refresh:1; url=manufacture.php");
        } else {
            $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            header("location: manufacture.php");
        }

        }else{
            echo "Match found";

            $mf = $db->prepare("SELECT * FROM `mf_data` WHERE `mf_name` = '$pdname'");
            $mf->execute();
            $row = $mf->fetch(PDO::FETCH_ASSOC);
            extract($row);


            $Nquan = $quan + $mf_quan;
            $Ncost = $cost + $mf_cost;
            $Navgcost = $Ncost/$Nquan;
            
            

            $sql = $db->prepare("UPDATE `mf_data` SET `mf_date`='$date',`mf_name`='$pdname',
                                                      `mf_cost`='$Ncost',`mf_quan`='$Nquan',
                                                      `mf_tocost`='$Navgcost'
                                 WHERE `mf_id`='$mf_id'");
            $sql->execute();

            if ($sql) {
                $_SESSION['success'] = "เพิ่มข้อมูลเรียบร้อย";
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'เพิ่มข้อมูลเรียบร้อย',
                            icon: 'success',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    })
                </script>";
                header("refresh:1; url=manufacture.php");
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: manufacture.php");
            }
            
        } 
    }
?>