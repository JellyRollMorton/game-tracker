
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../../favicon.ico">

    <title>{{env('APP_NAME', 'My Application Name')}}</title>

    <!-- Bootstrap core CSS -->
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/select2.min.css" rel="stylesheet">
    <link href="/css/select2-bootstrap.min.css" rel="stylesheet">
    <link href="/css/datatables.min.css" rel="stylesheet">
  </head>

  <body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="#">{{env('APP_NAME', 'My Application Name')}}</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="#">Dashboard</a></li>
            <li><a href="/about">About</a></li>
          </ul>

          @if(Auth::user())
          <p class="navbar-text pull-right">Logged in as {{Auth::user()->name}}</p> 
          @endif

        </div><!--/.nav-collapse -->
      </div>
    </nav>

    <div class="container">

    <div id="app">
      @yield('content')
      </div>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/js/app.js"></script>
    <script src="/js/datatables.min.js"></script>
  </body>
</html>
