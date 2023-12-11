@extends('admin.admin-layouts.master')

@section('title', 'List Employee')

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
                <li class="breadcrumb-item"><a href="{{ route('home.employees.index') }}">Employee</a></li>
                <li class="breadcrumb-item active" aria-current="page">List Employee</li>
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
        @if(session('info'))
            <script>
                Swal.fire({
                    title: 'Warning!',
                    text: "{{ session('info') }}",
                    icon: 'info'
                });
            </script>
        @endif

        <!-- Begin: DataTables Table for Listing Companies -->
        <div class="row">
            <div class="col-md-12">
                <h2 class="text-center">Employee's List</h2>
                <table class="table table-bordered data-table">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company Name</th>
                            <th>Change Comapny</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Id</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Company Name</th>
                            <th>Change Comapny</th>
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
        ajax: "{{ route('home.employees.list_employee') }}",
        columns: [
            {data: 'id'},
            {data: 'fname'},
            {data: 'lname'},
            {data: 'email'},
            // {data: 'phone'},
            {
                data: 'phone',
                render: function (data, type, row) {
                    return '+923'+row.phone;
                }
            },
            // {data: 'company_id'},
            {data: 'company_name'}, // Display the company name here
            {
                data: 'null',
                render: function (data, type, row) {
                    // Populate the dropdown with company names
                    var options = '<option value="" disabled>Select Company</option>';
                    @foreach ($companies as $company)
                        options += '<option value="{{ $company->id }}"' + (row.company_id == {{ $company->id }} ? ' selected' : '') + '>{{ $company->name }}</option>';
                    @endforeach

                    var select = '<select data-id="'+row.id+'" class="form-control form-select-sm selectCompany">' + options + '</select>';
        
                    // Check if company_id is null, then set the "Select Company" option as selected
                    if (row.company_id == null) {
                        select = select.replace('value=""', 'value="" selected');
                    }

                    return select;
                }
            },
            {
                data: 'null',
                render: function (data, type, row) {
                    return '<a href="#" data-id="' + row.id + '" class="btn btn-warning btn-sm editEmployee">Edit</a>' + 
                           '<a href="#" data-id="' + row.id + '" class="btn btn-danger btn-sm deleteEmployee">Delete</a>';
                }
            }
        ]
    });
    // 
    // Begin:   Handle select company change
    $('.data-table').on('change', '.selectCompany', function () {
        var employeeId = $(this).data('id');
        var companyId = $(this).val();
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to change the company!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an Ajax request to delete the company
                $.ajax({
                    url: "/home/employees/list/" + companyId+"/"+employeeId,
                    type: 'get',
                    success: function (data) {
                        table.ajax.reload();
                        if(data == "invalid_company"){
                            Swal.fire("Inavlid", "You are accessing the invalid company. Kindly access the valid company", "info");
                        }
                        if(data == "invalid_employee"){
                            Swal.fire("Inavlid", "You are accessing the invalid employee. Kindly access the valid employee", "info");
                        }
                        if(data == "success"){
                            Swal.fire("Success", "Company changed successfully!", "success");
                        }
                        if(data == "error"){
                            Swal.fire("Error", "There is an error while changing the company. Kindly try again", "error");
                        }
                    },
                    error: function (data) {
                        // Handle error
                        console.log('Error:', data);
                    }
                });
            }
            else{
                table.ajax.reload();
                Swal.fire("Cancelled", "You Pressed cancel!", "info");
            }
        });
    });
    // End:   Handle select company change
    
    // Begin:   Handle delete button click
    $('.data-table').on('click', '.deleteEmployee', function () {
        var employeeId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You will not be able to recover this employee!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Make an Ajax request to delete the employee
                $.ajax({
                    url: "/home/employees/delete/" + employeeId,
                    type: 'get',
                    success: function (data) {
                        table.ajax.reload();
                        if(data == "invalid"){
                            Swal.fire("Inavlid", "You are accessing the invalid employee. Kindly access the valid employee", "info");
                        }
                        if(data == "success"){
                            Swal.fire("Success", "Employee deleted successfully!", "success");
                        }
                        if(data == "error"){
                            Swal.fire("Error", "There is an error while deleting the employee. Kindly try again", "error");
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
    $('.data-table').on('click', '.editEmployee', function () {
        var employeeId = $(this).data('id');
        Swal.fire({
            title: 'Are you sure?',
            text: 'You want to edit this employee!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Redirect to the edit_company route with the companyId parameter
                window.location.href = "/home/employees/" + employeeId + "/edit";
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
