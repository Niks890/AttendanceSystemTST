<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <div class="sidebar-brand-text mx-3 fw-bold text-uppercase text-primary"
             style="letter-spacing: 3px; font-size: 1.4rem; text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);">
            SAMSUNG
        </div>
    </a>


    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="index.html">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Chức năng chính
    </div>

    <!-- Quản lý Nhân viên -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-users text-white"></i>
            <span>Quản lý Nhân viên</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('employee.index')}}">Thông tin nhân viên</a>
                <a class="collapse-item" href="{{route('employee.create')}}">Thêm nhân viên</a>
            </div>
        </div>
    </li>

    <!-- Quản lý Chấm công -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="far fa-calendar text-white"></i>
            <span>Quản lý Chấm công</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="{{route('attendance-time.index')}}">Chấm công theo thời gian</a>
                <a class="collapse-item" href="{{route('attendance-product.index')}}">Chấm công theo sản phẩm</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Khác
    </div>

    <!-- Lịch làm việc -->


    <!-- Nav Item - Tables -->
    <li class="nav-item">
        <a class="nav-link" href="{{route('schedule.index')}}">
            <i class="fas fa-clipboard-list text-white"></i>
            <span>Lịch làm việc</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
