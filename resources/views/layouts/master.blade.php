<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <title>@yield('page_title', config('redprintUnity.page_title'))</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="{{ config('redprintUnity.page_title') }}" />
    <meta name="keywords" content="{{ config('redprintUnity.page_title') }}" />
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="pragma" content="no-cache" />
    <!--
    <link rel="apple-touch-icon" sizes="32x32" href="{ { asset('frontend/images/favicon-32x32.png') } }" />
    <link rel="apple-touch-icon" sizes="64x64" href="{ { asset('frontend/images/favicon-64x64.png') } }" />
    <link rel="icon" href="images/favicon-32x32.png" type="image/png" sizes="32x32" />
    <link rel="icon" href="images/favicon-64x64.png" type="image/png" sizes="64x64" />
    -->
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" type="text/css" media="screen" />
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/jquery-ui.css') }}" type="text/css" />
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery/jquery-2.2.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/plugin/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/modernizr-custom.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/plugin/perfectscrollbar/perfect-scrollbar.min.js') }}"></script>
</head>
<body class="login-page">
<header>
    <div class="header-wrap">
        <div class="container">
            <div class="logo">
                <a href="/" title="RN MemberSite">
                    <span class="img-logo">
                        <img src="/frontend/images/logo.png" width="73" height="73" alt="RN MemberSite" />
                    </span>
                    <div class="company-name">
                        <h2>起業家実践会</h2>
                        <span>powerd by RN KiCK-StART projects</span>
                    </div>
                </a>
            </div>
        </div>
    </div>
</header>
<div class="account-page-wrappers">
    <div class="account-login-page">
	    @yield('content')
    </div>
</div>

<script type="text/javascript" src="{{ asset('frontend/assets/js/common.js') }}"></script>
<script type="text/javascript" src="{{ asset('frontend/assets/js/scripts.js') }}"></script>
</body>
</html>