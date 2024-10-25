<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <hr class="sidebar-divider my-0">

    <li class="nav-item active">
        <a class="nav-link" href="index.php"><i class="fas fa-fw fa-tachometer-alt"></i>วสช.กลุ่มเกษตรกรทำสวนผสมผสานแบบยั่งยืนบางท่าข้าม</a>
    </li>

    <hr class="sidebar-divider">


    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>หน้าหลัก</span></a>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseOne"
            aria-expanded="true" aria-controls="collapseOne">
            <i class="fas fa-fw fa-cog"></i>
            <span>จัดการข้อมูล</span>
        </a>
        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="manage_unit.php">1.ข้อมูลหน่วยนับ</a>
                <a class="collapse-item" href="Product.php">2.ข้อมูลสินค้าชุมชน</a>
                <a class="collapse-item" href="Fixed_assets.php">3.ข้อมูลสินทรัพย์ถาวร</a>
                <a class="collapse-item" href="user_regis.php">4.ข้อมูลทะเบียนสมาชิก</a>
                <a class="collapse-item" href="grower_regis.php">5.ข้อมูลทะเบียนลูกสวน</a>
                <a class="collapse-item" href="orderer.php">6.ข้อมูลผู้สั่งซื้อ</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMN"
            aria-expanded="true" aria-controls="collapseMN">
            <i class="fas fa-money-bill"></i>
            <span>การเงิน-การลงทุน</span>
        </a>
        <div id="collapseMN" class="collapse" aria-labelledby="headingMN" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="InEx.php">1.รายรับ-รายจ่าย</a>
                <!-- <a class="collapse-item" href="Cus_credit.php">2.แหล่งเงินทุน - คืนทุน</a>  -->
                <!-- สนับสนุน ยืม คืน -->
                <!-- <a class="collapse-item" href="Cus_credit.php">3.ลูกค้าเครดิต</a> -->
                <!-- <a class="collapse-item" href="Share_regis.php">ข้อมูลหุ้น</a> -->
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePlan"
            aria-expanded="true" aria-controls="collapsePlan">
            <i class="fas fa-map-marked-alt"></i>
            <span>วางแผนและติดตามการผลิต</span></a>
        </a>
        <div id="collapsePlan" class="collapse" aria-labelledby="headingPlan" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="Plant_orderlist.php">1.รายการการสั่งซื้อ</a>
                <a class="collapse-item" href="PlanFollow.php">2.วางแผนแการเพาะปลูก</a>
                <a class="collapse-item" href="Bproduce.php">3.รับซื้อผลผลิต</a>
                <a class="collapse-item" href="Export_products.php">4.ส่งออกผลผลิต</a>
                <!-- <a class="collapse-item" href="Follow_purchase.php">5.ติดตามผลการรับซื้อ</a> -->
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseReport"
            aria-expanded="true" aria-controls="collapseReport">
            <i class="fas fa-solid fa-clipboard-list"></i>
            <span>ออกรายงาน</span></a>
        </a>
        <div id="collapseReport" class="collapse" aria-labelledby="headingReport" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="report_orderplan.php">การขาย/กำไร/ต้นทุน</a>
                <a class="collapse-item" href="report_type.php">ประเภท/ช่องทางการขาย</a>
                <a class="collapse-item" href="report_material.php">ราคาวัตถุดิบ</a>
                <a class="collapse-item" href="report_InEx.php">รายรับ-รายจ่าย</a>
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