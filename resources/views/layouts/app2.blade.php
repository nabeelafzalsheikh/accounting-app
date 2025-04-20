<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Accounting System</title>
    <!-- Bootstrap 4 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.bootstrap4.min.css">
    <!-- Datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

    <style>
        :root {
            --primary-color: #2CA01C;
            --secondary-color: #f8f9fa;
            --sidebar-width: 240px;
            --sidebar-collapsed-width: 70px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f7fa;
            overflow-x: hidden;
        }

        /* Sidebar styling */
        .sidebar {
            height: 100vh;
            width: var(--sidebar-width);
            position: fixed;
            left: 0;
            top: 0;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            z-index: 1000;
            transition: all 0.3s ease;
            overflow-y: auto;
        }

        .sidebar.collapsed {
            width: var(--sidebar-collapsed-width);
        }

        .sidebar.collapsed .sidebar-header h4,
        .sidebar.collapsed .sidebar-menu li a span,
        .sidebar.collapsed .logout-btn span {
            display: none;
        }

        .sidebar.collapsed .sidebar-menu li a {
            text-align: center;
            padding: 12px 5px;
        }

        .sidebar.collapsed .sidebar-menu li a i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .sidebar.collapsed .logout-btn {
            padding: 12px 5px;
            text-align: center;
        }

        .sidebar.collapsed .logout-btn i {
            margin-right: 0;
            font-size: 1.2rem;
        }

        .sidebar-header {
            padding: 20px;
            background-color: var(--primary-color);
            color: white;
            text-align: center;
            position: relative;
            height: 70px;
        }

        .sidebar-header h4 {
            margin: 0;
            white-space: nowrap;
        }

        .collapse-toggle {
            position: absolute;
            right: 10px;
            top: 22px;
            color: white;
            cursor: pointer;
            display: none;
        }

        .sidebar-menu {
            padding: 0;
            list-style: none;
            margin-top: 20px;
        }

        .sidebar-menu li {
            position: relative;
            white-space: nowrap;
        }

        .sidebar-menu li a {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s;
        }

        .sidebar-menu li a:hover, 
        .sidebar-menu li a.active {
            background-color: #f0f0f0;
            border-left: 3px solid var(--primary-color);
            color: var(--primary-color);
        }

        .sidebar-menu li a i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            transition: all 0.3s;
        }

        /* Logout button */
        .logout-btn {
            display: block;
            padding: 12px 20px;
            color: #333;
            text-decoration: none;
            border-left: 3px solid transparent;
            transition: all 0.3s;
            margin-top: 20px;
        }

        .logout-btn:hover {
            background-color: #f0f0f0;
            border-left: 3px solid var(--primary-color);
            color: var(--primary-color);
        }

        .logout-btn i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main content area */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            transition: all 0.3s ease;
            min-height: 100vh;
        }

        .main-content.collapsed {
            margin-left: var(--sidebar-collapsed-width);
        }

        /* Top navbar */
        .top-navbar {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 15px 20px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            width: 300px;
            margin: 10px 0;
        }

        .search-box input {
            padding-left: 35px;
            border-radius: 20px;
            border: 1px solid #ddd;
        }

        .search-box i {
            position: absolute;
            left: 12px;
            top: 10px;
            color: #aaa;
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-menu img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Dashboard cards */
        .dashboard-card {
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.05);
            margin-bottom: 20px;
            border: none;
            transition: all 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 15px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: #fff;
            border-bottom: 1px solid #eee;
            font-weight: 600;
            padding: 15px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .summary-card {
            text-align: center;
            padding: 15px;
        }

        .summary-card .value {
            font-size: 28px;
            font-weight: 700;
            margin: 10px 0;
        }

        .summary-card .label {
            color: #666;
            font-size: 14px;
        }

        .income-card {
            border-left: 4px solid #28a745;
        }

        .expense-card {
            border-left: 4px solid #dc3545;
        }

        .profit-card {
            border-left: 4px solid #17a2b8;
        }

        .invoice-card {
            border-left: 4px solid #ffc107;
        }

        /* Recent activity */
        .activity-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .activity-item:last-child {
            border-bottom: none;
        }

        .activity-date {
            font-size: 12px;
            color: #999;
        }

        /* Tables */
        .table-responsive {
            overflow-x: auto;
        }

        /* Responsive adjustments */
        @media (min-width: 992px) {
            .collapse-toggle {
                display: block;
            }
        }

        @media (max-width: 991.98px) {
            .sidebar {
                left: -100%;
                width: 280px;
            }
            
            .sidebar.active {
                left: 0;
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .search-box {
                width: 100%;
                order: 3;
                margin-top: 10px;
            }
            
            .summary-card .value {
                font-size: 24px;
            }
        }

        @media (max-width: 767.98px) {
            .main-content {
                padding: 15px;
            }
            
            .card-body {
                padding: 15px;
            }
            
            .summary-card {
                padding: 10px;
            }
            
            .summary-card .value {
                font-size: 20px;
            }
        }

        @media (max-width: 575.98px) {
            .top-navbar {
                padding: 10px 15px;
            }
            
            .user-menu .dropdown-toggle {
                padding: 5px 10px;
                font-size: 14px;
            }
            
            .user-menu img {
                width: 30px;
                height: 30px;
            }
            
            .sidebar-header {
                padding: 15px;
                height: 60px;
            }
        }
        /* resources/css/app.css */
.transaction-group {
    border-left: 4px solid #3490dc;
    padding-left: 15px;
    margin-bottom: 30px;
}

.transaction-group h5 {
    color: #3490dc;
    margin-bottom: 15px;
}

.table th {
    background-color: #f8f9fa;
}

.text-right {
    text-align: right;
}

/* Make the date picker form look better on mobile */
@media (max-width: 576px) {
    .form-inline .form-group {
        margin-bottom: 10px;
        width: 100%;
    }
    
    .form-inline .form-control {
        width: 100%;
    }
    
    .form-inline .btn {
        width: 100%;
        margin-bottom: 10px;
    }
}

/* resources/css/app.css */
.table-hover tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.03);
}

.thead-light th {
    background-color: #f8f9fa;
    font-weight: 600;
}

.table-active {
    background-color: rgba(0, 0, 0, 0.05);
}

.font-weight-bold {
    font-weight: 600 !important;
}

@media (max-width: 768px) {
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
}
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <h4>
                <i class="fas fa-chart-line"></i> FinTrack
            </h4>
            <div class="collapse-toggle" id="collapseToggle">
                <i class="fas fa-chevron-left"></i>
            </div>
        </div>
        <ul class="sidebar-menu">
            <li class="nav-item {{ Request::is('dashboard/*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="{{ Request::is('transactions/*') ? 'active' : '' }}">
                <a href="{{ route('transactions.index') }}">
                    <i class="fas fa-exchange-alt"></i>
                    <span>Transactions</span>
                </a>
            </li>
            
            <li class="{{ Request::is('journal/*') ? 'active' : '' }}">
                <a href="{{ route('journal.index') }}">
                    <i class="fas fa-book"></i>
                    <span>Journal</span>
                </a>
            </li>
            <li class="{{ Request::is('ledger/*') ? 'active' : '' }}">
                <a href="{{ route('ledger.index') }}">
                    <i class="fas fa-file-invoice-dollar"></i>
                    <span>Ledger</span>
                </a>
            </li>
            <li class="{{ Request::is('trial-balance/*') ? 'active' : '' }}">
                <a href="{{ route('trial-balance.index') }}">
                    <i class="fas fa-balance-scale"></i>
                    <span>Trial Balance</span>
                </a>
            </li>
           
            
            
            <li class="{{ Request::is('settings*') ? 'active' : '' }}">
                <a href="#">
                    <i class="fas fa-cog"></i>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
        {{--  <a href="" class="logout-btn" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt"></i>
            <span>Log Out</span>
        </a>
        <form id="logout-form" action="" method="POST" style="display: none;">
            @csrf
        </form>  --}}
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Top Navbar -->
        <div class="top-navbar">
            <div class="d-flex align-items-center">
                <button class="btn btn-link d-lg-none mr-2" id="mobileMenuToggle">
                    <i class="fas fa-bars"></i>
                </button>
                <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
            </div>
            
            <div class="search-box">
                <i class="fas fa-search"></i>
                <input type="text" class="form-control" placeholder="Search...">
            </div>
            
            <div class="user-menu">
                <form id="logout-form" action="admin/logout" method="POST" style="display: none;">
                    @csrf
                </form>
            
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Logout">
                    <i class="fas fa-sign-out-alt mr-1"></i> Logout
                </a>
            </div>
            
        </div>

        <!-- Page Content -->
        @yield('content')
    </div>

    <!-- Modal -->
    <div class="modal fade" id="ajaxModel" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modelHeading"></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="ajaxForm" class="row g-3">
                        @csrf
                        <input type="hidden" name="id" id="id">
                        <div id="formFields"></div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveBtn">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery and Bootstrap 4 JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap4.min.js"></script>
    <!-- Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        // Toggle sidebar collapse
        $(document).ready(function() {
            // Check localStorage for collapsed state
            const isCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
            
            if (isCollapsed) {
                $('#sidebar').addClass('collapsed');
                $('#mainContent').addClass('collapsed');
                $('#collapseToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
            }
            
            // Toggle sidebar collapse
            $('#collapseToggle').click(function() {
                $('#sidebar').toggleClass('collapsed');
                $('#mainContent').toggleClass('collapsed');
                
                if ($('#sidebar').hasClass('collapsed')) {
                    $('#collapseToggle i').removeClass('fa-chevron-left').addClass('fa-chevron-right');
                    localStorage.setItem('sidebarCollapsed', 'true');
                } else {
                    $('#collapseToggle i').removeClass('fa-chevron-right').addClass('fa-chevron-left');
                    localStorage.setItem('sidebarCollapsed', 'false');
                }
            });
            
            // Mobile menu toggle
            $('#mobileMenuToggle').click(function() {
                $('#sidebar').toggleClass('active');
            });
            
            // Close sidebar when clicking outside on mobile
            $(document).click(function(e) {
                if ($(window).width() <= 991.98 && 
                    !$(e.target).closest('#sidebar').length && 
                    !$(e.target).is('#mobileMenuToggle')) {
                    $('#sidebar').removeClass('active');
                }
            });
            
            // Update active menu item
            $('.sidebar-menu li a').filter(function() {
                return this.href === location.href;
            }).addClass('active').parent().addClass('active');
        });
    </script>

    @stack('scripts')
</body>
</html>