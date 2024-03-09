<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html"><i class="fas fa-fw fa-tachometer-alt"></i>ผูู้ดูแลระบบ</a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">


    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>หน้าหลัก</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการข้อมูล</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="Information_G_agc.php">ข้อมูเกษตรกร</a>
                <a class="collapse-item" href="Information_G_agc.php">ข้อมูลกลุ่มวิสาหกิจ</a>
                <a class="collapse-item" href="Product.php">ข้อมูลผลิตภัณฑ์</a>
                <a class="collapse-item" href="Raw_material.php">ข้อมูลวัตถุดิบ</a>
                <a class="collapse-item" href="Fixed_assets.php">ข้อมูลสินทรัพย์ถาวร</a>
                <a class="collapse-item" href="Mem_regis.php">ข้อมูลทะเบียนสมาชิก</a>
                <a class="collapse-item" href="Share_regis.php">ข้อมูลหุ้น</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-store"></i>
            <span>งานขาย</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="Information_G_agc.php">ขายปลีก/ส่ง</a>
                <a class="collapse-item" href="Product.php">จัดบูธออกงาน</a>
                <a class="collapse-item" href="Raw_material.php">ฝากขาย</a>
                <a class="collapse-item" href="Fixed_assets.php">ขายออนไลน์</a>
            </div>
        </div>
    </li>
    

    <li class="nav-item">
        <a class="nav-link" href="Information_G_agc.php">
            <i class="fas fa-seedling"></i>
            <span>การเพาะปลูกสินค้า</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link" href="Product.php">
            <i class="fas fa-map-marked-alt"></i>
            <span>งานบริการการท่องเที่ยว</span></a>
    </li>


    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="tables.html">
        <i class="fas fa-solid fa-clipboard-list"></i>
            <span>ออกรายงาน</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">ออกจากระบบ</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">คุณต้องการที่จะออกระบบหรือไม่</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
                <a class="btn btn-danger" href="logout.php">ออกจากระบบ</a>
            </div>
        </div>
    </div>
</div>