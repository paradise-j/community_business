<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
// $conn = mysqli_connect("localhost","root","","comen_db");

require_once '../../../connect.php';
require_once('php-excel-reader/excel_reader2.php');
require_once('SpreadsheetReader.php');

if (isset($_POST["import"]))
{
       
  $allowedFileType = ['application/vnd.ms-excel','text/xls','text/xlsx','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'];
  
  if(in_array($_FILES["file"]["type"],$allowedFileType)){

        $targetPath = 'uploads/'.$_FILES['file']['name'];
        move_uploaded_file($_FILES['file']['tmp_name'], $targetPath);
        
        $Reader = new SpreadsheetReader($targetPath);
        
        $sheetCount = count($Reader->sheets());
        
        for($i=0;$i<$sheetCount;$i++)
        {
            $Reader->ChangeSheet($i);
            
            foreach ($Reader as $Row)
            {
          
                $gw_name = "";//ฟิว 1
                if(isset($Row[0])) {
                    $gw_name = $Row[0];
                }//ฟิว 1

                $gw_nickn = "";//ฟิว 1
                if(isset($Row[1])) {
                    $gw_nickn = $Row[1];
                }//ฟิว 1
                
                $gw_phone = "";//ฟิว 2
                if(isset($Row[2])) {
                    $gw_phone = $Row[2];
                }//ฟิว 2

                
                if (!empty($gw_name) ||
                    !empty($gw_nickn) || 
                    !empty($gw_phone)) {

                    $sql = $db->prepare("INSERT INTO `grower`(`gw_name`, `gw_nickn`, `gw_phone`)
                                            VALUES ('$gw_name','$gw_nickn','$gw_phone')");
                    $sql->execute();

                
                    if (! empty($sql)) {
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
                
                        // header("refresh:1; url=../grower_regis.php");

                        echo "<script>";
                        echo"alert('เพิ่มข้อมูลเรียบร้อยแล้ว');";
                        echo"window.location ='../grower_regis.php';";
                        echo "</script>";

                    } else {
                        $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
                        header("location: ../grower_regis.php");
                    }
                }
             }
        
         }
  }
  else
  { 
    $_SESSION['error'] = "เพิ่มข้อมูลเรียบร้อยไม่สำเร็จ";
    // header("location: ../grower_regis.php");
  }
}
?>