@extends('layouts.layout')
@section('content')
<!-- -----content-page---- -->
<section class="page-wrapper">
    <div class="page-content">
    
            <h2 class="mt-5 mb-4">User Update</h2>
            <div class="card p-4">
              <form>
                <div class="form-group">
                  <label for="name">Name:</label>
                  <input type="text" class="form-control" id="name" placeholder="Enter your name">
                </div>
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" class="form-control" id="email" placeholder="Enter your email">
                </div>
                <div class="form-group">
                  <label for="password">Password:</label>
                  <input type="password" class="form-control" id="password" placeholder="Enter your password">
                </div>
                <div class="form-group">
                  <label for="confirmPassword">Confirm Password:</label>
                  <input type="password" class="form-control" id="confirmPassword" placeholder="Confirm your password">
                </div>
                <div class="form-group">
                  <label for="hobby">Hobby:</label>
                  <input type="text" class="form-control" id="hobby" placeholder="Enter your hobby">
                </div>
                <div class="form-group">
                  <label for="interests">Interests:</label>
                  <textarea class="form-control" id="interests" rows="3" placeholder="Enter your interests"></textarea>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              
              </form>
            
          </div>  
    </div>
</section>
@endsection