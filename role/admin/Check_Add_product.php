<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
    session_start();
    require_once "../../connect.php";

    if (isset($_POST['submit'])) {
        $pdname = $_POST['pdname'];
        // $quan = $_POST['quan'];
        // $cost = $_POST['cost'];
        // $date = $_POST['date'];
        // $avgprice = $cost/$quan;

        $pd = $db->prepare("SELECT `pd_name` FROM `product`");
        $pd->execute();

        $check = array();
        while ($row = $pd->fetch(PDO::FETCH_ASSOC)){
            $name = $row["pd_name"];
            array_push($check,$name);
            
        }
        // print_r($check);
        // echo $pdname;

        if(!in_array("$pdname", $check)){
            // echo "Match not found";
            $sql = $db->prepare("INSERT INTO `product`(`pd_name`)
                             VALUES ('$pdname')");
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
                header("refresh:1; url=Product.php");
            } else {
                $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                header("location: Product.php");
            }

        }else{
            echo "Match found";

            // $pd = $db->prepare("SELECT * FROM `product` WHERE `pd_name` = '$pdname'");
            // $pd->execute();
            // $row = $pd->fetch(PDO::FETCH_ASSOC);
            // extract($row);


            // $Nquan = $quan + $pd_quan;
            // $Ncost = $cost + $pd_cost;
            // $Navgcost = $Ncost/$Nquan;
            
            

            // $sql = $db->prepare("UPDATE `product` SET `pd_name`='$pdname',`pd_date`='$date',
            //                                           `pd_quan`='$Nquan',`pd_cost`='$Ncost',`pd_avgprice`='$Navgcost'
            //                      WHERE `pd_id`='$pd_id'");
            // $sql->execute();

            // if ($sql) {
                $_SESSION['success'] = "ข้อมูลสินค้านี้มีแล้ว";
                echo "<script>
                    $(document).ready(function() {
                        Swal.fire({
                            title: 'สำเร็จ',
                            text: 'ข้อมูลสินค้านี้มีแล้ว',
                            icon: 'warning',
                            timer: 5000,
                            showConfirmButton: false
                        });
                    })
                </script>";
                header("refresh:1; url=Product.php");
            // } else {
            //     $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
            //     header("location: Product.php");
            // }
            
        } 
    }
?>