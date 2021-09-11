<!doctype html>
 <html lang="en">
 <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <meta name="csrf-token" content="{!! csrf_token() !!}">
     <title>@yield('page_title', config('redprintUnity.page_title'))</title>
     <link rel="shortcut icon" href="http://cdn.sstatic.net/superuser/img/favicon.ico">
    @section('css')
    
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/css/bootstrap.min.css') }}" />
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/fonts/icomoon/icomoon.css') }}" />
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/vendor/bootstrap-4-5.0.0-alpha.17/build/css/tempusdominus-bootstrap-4.min.css') }}" />
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/vendor/font-awesome/css/fontawesome-all.min.css') }}" />
     <link rel="stylesheet" href="{{ asset('frontend/assets/css/glyphicons.css')}}" type="text/css" />
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/css/redprint.css') }}" />
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/css/skins/'.config('redprintUnity.skin', 'blue').'.css') }}" />
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/css/main.css') }}" />
     <link rel="stylesheet" href="{{ asset('vendor/redprintUnity/css/stylesheet.css?2020') }}" />
    @show
     
    @yield('head-js')
</head>

 <body>
     <!-- Loading starts -->
     <div class="loading-wrapper">
         <div class="loading">
             <span></span>
         </div>
     </div>
     <!-- Loading ends -->
 
    @yield('body')

 
    @section('js')
        <!-- jQuery first, then Tether, then other JS. -->
        <script src="{{ asset('vendor/redprintUnity/js/jquery.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/js/tether.min.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/vendor/unifyMenu/unifyMenu.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/vendor/onoffcanvas/onoffcanvas.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/js/moment.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/vendor/bootstrap-4-5.0.0-alpha.17/build/js/tempusdominus-bootstrap-4.min.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/vendor/sweetalert-2.1.0/sweetalert.min.js') }}"></script>
        
        <!-- Peity JS -->
        <script src="{{ asset('vendor/redprintUnity/vendor/peity/peity.min.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/vendor/peity/custom-peity.js') }}"></script>
 
        <!-- Circliful js -->
        <script src="{{ asset('vendor/redprintUnity/vendor/circliful/circliful.min.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/vendor/circliful/circliful.custom.js') }}"></script>

 
        <!-- Slimscroll JS -->
        <script src="{{ asset('vendor/redprintUnity/vendor/slimscroll/slimscroll.min.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/vendor/slimscroll/custom-scrollbar.js') }}"></script>

 
        <!-- Common JS -->
        <script src="{{ asset('vendor/redprintUnity/js/ja.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/js/common.js') }}"></script>
        <script src="{{ asset('vendor/redprintUnity/js/redprint.js') }}"></script>
    @show
 
    <script>
    $(document).ready(function(){    
        if(document.URL.match("/backend/members")) {
            $('a[href*="/backend/members"]').parent().find('#unifyMenu > li').addClass('active selected');
        } else if(document.URL.match("/backend/news")) {
            $('a[href*="/backend/news"]').parent().find('#unifyMenu > li').addClass('active selected');
        } 
     });
    </script>
 
    @section('post-js')
    @show

    @section('modals')
    @show

 </body>
 </html>