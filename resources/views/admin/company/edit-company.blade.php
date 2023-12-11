@extends('admin.admin-layouts.master')

@section('title', 'Update Company')

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
                <li class="breadcrumb-item"><a href="{{route('home.companies.index')}}">Company</a></li>
                <li class="breadcrumb-item"><a href="{{route('home.companies.list_companies')}}">List Company</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Comapny</li>
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
                <h2>Edit a Company</h2>
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
                <form action="{{route('home.companies.update_company')}}" method="POST" id="comapny_form">
                    @csrf
                    <input type="hidden" id="company_id" name="company_id" value="{{ $companies->id}}" readonly>
                    <div class="form-group mb-1">
                        <label for="name">Company Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $companies->name }}" placeholder="Enter Your Company Name here:">
                    </div>
                    @error('name')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mb-1">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $companies->email }}" placeholder="Enter Your Company Email here:">
                    </div>
                    @error('email')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <div class="form-group mb-2">
                        <label for="website">Website</label>
                        <input type="url" class="form-control" id="website" name="website" value="{{ $companies->website }}" placeholder="Enter Your Company Website here:">
                    </div>
                    @error('website')
                        <div class="alert alert-danger">{{ $message }}</div>
                    @enderror

                    <button type="submit" class="btn btn-primary">Update Company</button>
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
            $("#comapny_form").submit(function(e){
                $(".alert-danger").remove();

                // To check the company name is empty or not
                let name = $("#name").val();
                if(name.trim()==='' || name===null || name.length==0){
                    e.preventDefault();
                    $("#name").after('<div class="alert alert-danger">Company Name shoud be provided</div>');
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

                // To check if the company website is a valid URL
                let website = $("#website").val();
                if(!(website.trim()==='' || website===null || website.length==0)){
                    if (!isValidURL(website)) {
                        e.preventDefault();
                        $("#website").after('<div class="alert alert-danger">Please provide a valid website URL</div>');
                    }
                }

            });
            //

            // Function to check if the email is valid
            function isValidEmail(email) {
                // Use a regular expression for basic email validation
                let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                return emailRegex.test(email);
            }

            // Function to check if the website is a valid URL
            function isValidURL(url) {
                // Use a regular expression for basic URL validation
                let urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
                return urlRegex.test(url);
            }
            //
        });
    </script>
@endsection
