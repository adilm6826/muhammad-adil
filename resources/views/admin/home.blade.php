@extends('admin.admin-layouts.master')

@section('title', 'Home')

@section('css')

@endsection


@section('content')
    <!-- Main Section -->
    <main class="container mt-5 mb-5 mx-auto">
        <!-- Banner Section with Breadcrumb Navigation -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Company</a></li>
                <li class="breadcrumb-item active" aria-current="page">Post</li>
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
    </main>
    <!-- End Main Section -->
@endsection

@section('scripts')
    <script>
        // Your custom scripts for the home page
    </script>
@endsection
