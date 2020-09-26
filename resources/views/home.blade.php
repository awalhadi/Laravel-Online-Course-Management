<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    </head>
    <body>
       <!-- Nav tabs -->
       <nav class="navbar navbar-light bg-light">
        <a class="navbar-brand">{{$page_title}}</a>
        <div class="form-inline">
            @if (Route::has('login'))
            <div class="top-right links">
                @auth
                <a class="btn btn-sm btn-info" href="{{ url('/home/home') }}">Profile</a>
                @else
                <a class="btn btn-sm btn-info" href="{{ route('admin.login') }}">Admin Login</a>
                <a class="btn btn-sm btn-info" href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                <a class="btn btn-sm btn-info" href="{{ route('register') }}">Register</a>
                @endif
                @endauth
            </div>
            @endif
        </div>
      </nav>

      <div class="container">
          <div class="course_title">
              <h3>Our courses</h3>
          </div>
          <div class="row">
              @foreach ($courses as $course)
              <div class="col-4 mt-4">
                  <div class="card" style="width: 18rem;">
                      <img class="card-img-top" src="{{asset('images/286x180.png')}}" alt="Card image cap">
                      <div class="card-body">
                          <h5 class="card-title">{{$course->title}}</h5>
                          <p class="card-text">
                              {{description_shortener($course->description, 60)}}
                          </p>
                          <a href="{{route('user.request.course', $course->id)}}" class="btn btn-primary">Enroll now</a>
                      </div>
                  </div>
              </div>

              @endforeach

          </div>
      </div>









      <link href="{{ asset('js/bootstrap.min.js') }}" rel="stylesheet">
    </body>
</html>
