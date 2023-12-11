@extends('admin.admin-layouts.master')

@section('title', 'List Company')

@section('css')

@endsection


@section('content')
    <!-- Main Section -->
    <main class="container mt-5 mb-5 mx-auto">
        <!-- Banner Section with Breadcrumb Navigation -->
        <br>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home_dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('home.companies.index') }}">Company</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Company</li>
            </ol>
        </nav>
        <div class="jumbotron">
            <h1 class="display-4">Welcome to Your Website!</h1>
            <p class="lead">This is a simple banner section. You can customize it as needed.</p>
        </div>
    
        <!-- Additional Content -->
        <div class="row">
            <div class="col-md-6">
                <h2>Section 1</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. ...</p>
            </div>
            <div class="col-md-6">
                <h2>Section 2</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. ...</p>
            </div>
        </div>
    
        <div class="row mt-4">
            <div class="col-md-6">
                <h2>Section 3</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. ...</p>
            </div>
            <div class="col-md-6">
                <h2>Section 4</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. ...</p>
            </div>
        </div>

        {{--  --}}
        @if(session('success'))
            <script>
                Swal.fire({
                    title: 'Success!',
                    text: "{{ session('success') }}",
                    icon: 'success'
                });
            </script>
        @endif
        @if(session('error'))
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: "{{ session('error') }}",
                    icon: 'error'
                });
            </script>
        @endif

        <!-- Begin: DataTables Table for Listing Companies -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Comapny Name</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>No</th>
                            <th>Comapny Name</th>
                            <th>Email</th>
                            <th>Website</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <!-- End: DataTables Table for Listing Companies -->

    </main>
    <!-- End Main Section -->
@endsection

@section('scripts')

<!-- DataTables Initialization Script -->
<script type="text/javascript">
  $(function () {
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('home.companies.list_companies') }}",
        columns: [
            {data: 'id'},
            {data: 'name'},
            {data: 'email'},
            {data: 'website'},
            {
                data: 'null',
                render: function (data, type, row) {
                    return '<a href="#" data-id="' + row.id + '" class="btn btn-warning btn-sm editCompany">Edit</a>' + 
                           '<a href="#" data-id="' + row.id + '" class="btn btn-danger btn-sm deleteCompany">Delete</a>';
                }
            }
        ]
    });
    // 
    // Begin:   Handle delete button click
    $('.data-table').on('click', '.deleteCompany', function () {
        var companyId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this company!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an Ajax request to delete the company
                $.ajax({
                    url: "/home/companies/delete/" + companyId,
                    type: 'get',
                    success: function (data) {
                        table.ajax.reload();
                        if(data == "invalid"){
                            Swal.fire("Inavlid", "You are accessing the invalid company. Kindly access the valid company", "info");
                        }
                        if(data == "success"){
                            Swal.fire("Success", "Company deleted successfully!", "success");
                        }
                        if(data == "error"){
                            Swal.fire("Error", "There is an error while deleting the company. Kindly try again", "error");
                        }
                    },
                    error: function (data) {
                        // Handle error
                        console.log('Error:', data);
                    }
                });
            }
            else{
                Swal.fire("Cancelled", "You Pressed cancel!", "info");
            }
        });
    });
    // End:   Handle delete button click
    
    // Begin:   Handle edit button click
    $('.data-table').on('click', '.editCompany', function () {
        var companyId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to edit this company!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the edit_company route with the companyId parameter
                window.location.href = "/home/companies/" + companyId + "/edit";
            }
            else{
                Swal.fire("Cancelled", "You Pressed cancel!", "info")
            }
        });
    });
    // End:   Handle edit button click
    // 
  });
</script>
@endsection
