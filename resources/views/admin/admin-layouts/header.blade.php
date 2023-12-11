<!-- Header Section -->
<header class="bg-primary text-light fixed-top">
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <!-- Sidebar Toggle Button with Cross Icon -->
            <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#sidebar" aria-controls="sidebar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <button class="btn btn-outline-light d-lg-none ms-auto" id="closeSidebar">
                <i class="fas fa-times"></i> <!-- Font Awesome Cross Icon -->
            </button>

            <!-- Website Title/Logo -->
            <a class="navbar-brand" href="{{route('home_dashboard')}}">Your Website</a>

            <!-- Navbar Links (Add your menu items here) -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home_dashboard')}}">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="companyDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Company
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="companyDropdown">
                            <li><a class="dropdown-item" href="{{route('home.companies.index')}}">Add Company</a></li>
                            <li><a class="dropdown-item" href="{{route('home.companies.list_companies')}}">List Company</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="employeeDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Employee
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="employeeDropdown">
                            <li><a class="dropdown-item" href="{{ route('home.employees.index') }}">Add Employee</a></li>
                            <li><a class="dropdown-item" href="{{ route('home.employees.list_employee') }}">List Employee</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- End Header Section -->

<!-- Sidebar (Offcanvas) Section -->
<div class="offcanvas offcanvas-start" tabindex="-1" id="sidebar" aria-labelledby="sidebarLabel">
    <!-- Sidebar Content -->
    <div class="offcanvas-body">
        <ul class="nav flex-column">
            <!-- ... Your existing sidebar menu items ... -->
        </ul>
    </div>
</div>
<!-- End Sidebar Section -->