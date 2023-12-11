@extends('admin.admin-layouts.master')

@section('title', 'Update Employee')

@section('css')

@endsection


@section('content')
    <!-- Main Section -->
    <main class="container mt-5 mb-5 mx-auto">
        <!-- Banner Section with Breadcrumb Navigation -->
        <br>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/home">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('home.employees.index')}}">Employees</a></li>
                <li class="breadcrumb-item"><a href="{{route('home.employees.list_employee')}}">List Employees</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Employee</li>
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

        <!-- Begin: Form to Save Companies -->
        <div class="row">
            <div class="col-md-10">
                <h2>Update An Employee</h2>
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
                            icon: 'warning'
                        });
                    </script>
                @endif
                <form action="{{ route('home.employees.update_employee') }}" method="POST" id="employee_form">
                    @csrf
                    <input type="hidden" name="employee_id" name="employee_id" value="{{$employees->id}}">
                    {{-- Begin: Employee First Name Here --}}
                    <div class="form-group mb-1">
                        <label for="fname">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" value="{{ $employees->fname }}" maxlength="255" placeholder="Enter Your First Name here:">
                    </div>
                    @error('fname')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    {{-- End: Employee First Name Here --}}

                    {{-- Begin: Employee Last Name Here --}}
                    <div class="form-group mb-1">
                        <label for="lname">First Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" value="{{ $employees->lname }}" maxlength="255" placeholder="Enter Your Last Name here:">
                    </div>
                    @error('lname')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    {{-- End: Employee Last Name Here --}}

                    {{-- Begin: Employee email Here --}}
                    <div class="form-group mb-1">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $employees->email }}" placeholder="Enter Your Company Email here:">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    {{-- End: Employee email Here --}}

                    {{-- Begin: Employee Phone Number here --}}
                    <div class="form-group mb-1">
                        <label for="phone">Mobile Number:</label>
                        <div class="input-group" id="phone_div">
                            <div class="input-group-prepend">
                                <span class="input-group-text">+923</span>
                            </div>
                            <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{9}" maxlength="9" minlength="9" value="{{ $employees->phone }}" placeholder="Enter Your Mobile Number Here:" >
                        </div>
                        <small class="form-text text-muted">Please enter a mobile number. Don't add +923</small>
                    </div>
                    @error('phone')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    {{-- End: Employee Phone Number here --}}

                    {{-- Begin: Company Name Here --}}
                    <div class="form-group mb-1">
                        <label for="company_id">Company Name:</label>
                        <select class="form-control" id="company_id" name="company_id">
                            <option value="" selected disabled>Select Company Name</option>
                            @if (count($companies)>0)
                                @foreach($companies as $company)
                                    <option value="{{ $company->id }}" @if ( $employees->company_id==$company->id) selected @endif >
                                        {{ $company->name }}
                                    </option>
                                @endforeach
                            @else
                                <option value="" disabled>No Company Found</option>
                            @endif
                        </select>
                    </div>
                    @error('company_id')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    {{-- End: Company Name Here --}}

                    <button type="submit" class="btn btn-primary">Update Employee</button>
                </form>
            </div>
        </div>
        <!-- Begin: Form to Save Companies -->

    </main>
    <!-- End Main Section -->
@endsection

@section('scripts')
    <script>
        $(document).ready(function(){
            $("#employee_form").submit(function(e){
                $(".alert-danger").remove();

                // To check the employee First name is empty or not
                let fname = $("#fname").val();
                if(fname.trim()==='' || fname===null || fname.length==0){
                    e.preventDefault();
                    $("#fname").after('<div class="alert alert-danger">First Name shoud be provided</div>');
                }
                
                // To check the employee Last name is empty or not
                let lname = $("#lname").val();
                if(lname.trim()==='' || lname===null || lname.length==0){
                    e.preventDefault();
                    $("#lname").after('<div class="alert alert-danger">Last Name shoud be provided</div>');
                }

                // To check the employee mobile number is empty or not
                var phone = $('#phone').val();
                    if(phone.length !== 9){
                        e.preventDefault();
                        $("#phone_div").after('<div class="alert alert-danger">Mobile Number should be provided and completely.</div>');
                    }
                
                // To check if the company email is empty or not and is a valid email
                let email = $("#email").val();
                if(email.trim()==='' || email===null || email.length==0){
                    e.preventDefault();
                    $("#email").after('<div class="alert alert-danger">Company Email should be provided</div>');
                } else if (!isValidEmail(email)) {
                    e.preventDefault();
                    $("#email").after('<div class="alert alert-danger">Please provide a valid company email address</div>');
                }

                // Check the company name is selected or not
                let company_id = $('#company_id').val();
                if(company_id === "" || company_id === null){
                    e.preventDefault();
                    $("#company_id").after('<div class="alert alert-danger">Company Name should be selected.</div>');
                }

            });
            //

            // Function to check if the email is valid
            function isValidEmail(email) {
                // Use a regular expression for basic email validation
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }
            //
        });
    </script>
@endsection
