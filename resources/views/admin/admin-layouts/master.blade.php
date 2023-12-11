<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Your Website Title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.1/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <!-- Font Awesome CSS (for cross icon) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.min.css">

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.17/dist/sweetalert2.all.min.js"></script>


    <!-- Additional CSS Section -->
    @yield('css')
</head>
<body>

    @include('admin.admin-layouts.header')


    @include('admin.admin-layouts.main')

    

    @include('admin.admin-layouts.footer')

    





    <!-- Back to Top Button -->
    <a href="#" class="btn btn-outline-primary back-to-top position-fixed bottom-0 end-0 m-3 d-none" id="backToTop">
        <i class="fas fa-arrow-up"></i> Back to Top
    </a>

    <!-- Back to Top Script -->
    <script>
        $(document).ready(function(){
            // Toggle Sidebar
            $('#closeSidebar').click(function(){
                $('#sidebar').offcanvas('hide');
            });

            // Back to Top Button
            var backToTopButton = $('#backToTop');
            var scrollThreshold = 300; // Adjust this value as needed

            $(window).scroll(function(){
                if ($(this).scrollTop() > scrollThreshold) {
                    backToTopButton.removeClass('d-none');
                } else {
                    backToTopButton.addClass('d-none');
                }
            });

            backToTopButton.click(function(){
                $('html, body').animate({scrollTop : 0}, 800);
                return false;
            });
        });
    </script>

    <!-- Additional Scripts Section -->
    @yield('scripts')

</body>
</html>
