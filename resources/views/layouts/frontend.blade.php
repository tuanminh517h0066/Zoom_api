<!DOCTYPE html>
<html lang="en">

  <head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    
    <title>@section('title') Redprint App Builder @show</title>

    @section('css')

      <!-- Google Fonts -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

      <!-- Bootstrap CSS File -->
      <link href="{{ asset('frontend/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">

      <!-- Libraries CSS Files -->
      <link href="{{ asset('frontend/vendor/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/animate/animate.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/ionicons/css/ionicons.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/magnific-popup/magnific-popup.css') }}" rel="stylesheet">
      <link href="{{ asset('frontend/vendor/ionicons/css/ionicons.min.css') }}" rel="stylesheet">

      <!-- <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.8/css/bootstrap.css" /> -->
      <!-- <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.8/css/react-select.css" /> -->
      <!-- Main Stylesheet File -->
      <!-- <link href="{{ asset('frontend/css/style.css') }}" rel="stylesheet"> -->

    @show
    @yield('head-js')

  </head>

  <body id="page-top">





    <main id="main">
      <section id="body" class="wow fadeInUp">
        <div class="container" style="min-height: 800px;">
          @yield('content')
        </div>
      </section>
    </main>
    
    

    @section('js')
      <!-- JavaScript Libraries -->
      <script src="frontend/vendor/jquery/jquery.min.js"></script>
      <script src="frontend/vendor/jquery/jquery-migrate.min.js"></script>
      <script src="frontend/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
      <script src="frontend/vendor/easing/easing.min.js"></script>
      <script src="frontend/vendor/superfish/hoverIntent.js"></script>
      <script src="frontend/vendor/superfish/superfish.min.js"></script>
      <script src="frontend/vendor/wow/wow.min.js"></script>
      <script src="frontend/vendor/owlcarousel/owl.carousel.min.js"></script>
      <script src="frontend/vendor/magnific-popup/magnific-popup.min.js"></script>
      <script src="frontend/vendor/sticky/sticky.js"></script>
      <!-- Template Main Javascript File -->
      <!-- <script src="frontend/js/main.js"></script> -->

      <!-- <script src="https://source.zoom.us/1.9.8/lib/vendor/react.min.js"></script>
      <script src="https://source.zoom.us/1.9.8/lib/vendor/react-dom.min.js"></script>
      <script src="https://source.zoom.us/1.9.8/lib/vendor/redux.min.js"></script>
      <script src="https://source.zoom.us/1.9.8/lib/vendor/redux-thunk.min.js"></script>
      <script src="https://source.zoom.us/1.9.8/lib/vendor/lodash.min.js"></script>
      <script src="https://source.zoom.us/zoom-meeting-1.9.8.min.js"></script>
      <script src="{{ asset('js/tool.js') }}"></script> -->
    @show
    @yield('post-js')
  </body>

</html>
