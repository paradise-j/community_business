<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.php"><i class="fas fa-fw fa-tachometer-alt"></i>ผูู้ดูแลระบบ</a>
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
                <a class="collapse-item" href="Manage_G_agc.php">ข้อมูลกลุ่มวิสาหกิจ</a>
                <a class="collapse-item" href="Product.php">ข้อมูลสินค้าชุมชน</a>
                <a class="collapse-item" href="Fixed_assets.php">ข้อมูลสินทรัพย์ถาวร</a>
                <a class="collapse-item" href="user_regis.php">ข้อมูลทะเบียนสมาชิก</a>
                <a class="collapse-item" href="grower_regis.php">ข้อมูลทะเบียนลูกสวน</a>
                <a class="collapse-item" href="Travel_package.php">ข้อมูลแพ็คเกจการท่องเที่ยว</a>
                <a class="collapse-item" href="orderer.php">ข้อมูลผู้สั่งซื้อ</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsepd"
            aria-expanded="true" aria-controls="collapsepd">
            <i class="fas fa-seedling"></i>
            <span>คลังสินค้า</span>
        </a>
        <div id="collapsepd" class="collapse" aria-labelledby="headingpd" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="manufacture.php">การผลิตสินค้า</a>
                <a class="collapse-item" href="receivePD.php">การรับสินค้า</a>
            </div>
        </div>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" href="manufacture.php">
            <i class="fas fa-seedling"></i>
            <span>การผลิตสินค้า</span></a>
    </li> -->


    <li class="nav-item">
        <a class="nav-link" href="Sale.php">
            <i class="fas fa-store"></i>
            <span>การซื้อ-ขายสิ้นค้า</span></a>
    </li>



    <li class="nav-item">
        <a class="nav-link" href="Travel.php">
            <i class="fas fa-taxi"></i>
            <span>การท่องเที่ยวและบริการ</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMN"
            aria-expanded="true" aria-controls="collapseMN">
            <i class="fas fa-money-bill"></i>
            <span>การเงิน-การลงทุน</span>
        </a>
        <div id="collapseMN" class="collapse" aria-labelledby="headingMN" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="InEx.php">รายรับ-รายจ่าย</a>
                <a class="collapse-item" href="Cus_credit.php">ลูกค้าเครดิต</a>
                <!-- <a class="collapse-item" href="Share_regis.php">ข้อมูลหุ้น</a> -->
            </div>
        </div>
    </li>

    <!-- <li class="nav-item">
        <a class="nav-link" href="PlanFollow.php">
            <i class="fas fa-map-marked-alt"></i>
            <span>วางแผนและติดตามการผลิต</span></a>
    </li> -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePlan"
            aria-expanded="true" aria-controls="collapsePlan">
            <i class="fas fa-map-marked-alt"></i>
            <span>วางแผนและติดตามการผลิต</span></a>
        </a>
        <div id="collapsePlan" class="collapse" aria-labelledby="headingPlan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="Plant_orderlist.php">รายการการสั่งซื้อ</a>
                <a class="collapse-item" href="PlanFollow.php">วางแผนแการเพาะปลูก</a>
                <a class="collapse-item" href="Bproduce.php">รับซื้อผลผลิต</a>
                <a class="collapse-item" href="Export_products.php">ส่งออกผลผลิต</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Tables -->
    <!-- <li class="nav-item">
        <a class="nav-link" href="Report.php">
        <i class="fas fa-solid fa-clipboard-list"></i>
            <span>ออกรายงาน</span></a>
    </li> -->

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
            aria-expanded="true" aria-controls="collapseReport">
            <i class="fas fa-solid fa-clipboard-list"></i>
            <span>ออกรายงาน</span></a>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingReport" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="report_orderplan.php">สรุปยอดการส่งออกตามเป้า</a>
                <!-- <a class="collapse-item" href="PlanFollow.php">วางแผนแการเพาะปลูก</a> -->
                <!-- <a class="collapse-item" href="Bproduce.php">รับซื้อผลผลิต</a> -->
                <!-- <a class="collapse-item" href="Export_products.php">ส่งออกผลผลิต</a> -->
            </div>
        </div>
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