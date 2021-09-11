<!DOCTYPE html>
<html lang="jp">
<head>
    <meta charset="UTF-8">
    <title>404 Not Found</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
    <meta name="description" content="404 Not Found" />
    <meta name="keywords" content="404 Not Found" />
    <link rel="shortcut icon" href="http://cdn.sstatic.net/superuser/img/favicon.ico">
    <link rel="stylesheet" href="{{ asset('frontend/assets/css/bootstrap.min.css') }}" type="text/css" media="screen" />
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery/jquery-2.2.0.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/jquery/jquery-ui.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/plugin/bootstrap/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('frontend/assets/js/modernizr-custom.js') }}"></script>
</head>
<body>

<div class="main-wrappers notfound-wrappers">
    <div class="container">
        <div class="row">
            <div class="col-sm-12 col-xs-12">
                <div class="block-login-inner">
                    <div class="img-thumb">
                        <img src="/frontend/images/img-404.png" width="955" height="670" />
                    </div>
                    <div class="buttons-set text-center">
                        <a class="btn-back-link pull-left" href="javascript:history.go(-1);"><i class="fa fa-arrow-alt-circle-right"></i> 前のページへ戻る</a>
                        @if(Request::is('backend/*'))
                            <a class="btn-back-link pull-right" href="/backend"><i class="fa fa-arrow-alt-circle-right"></i> このサイトのトップへ戻る</a>
                        @else
                            <a class="btn-back-link pull-right" href="/"><i class="fa fa-arrow-alt-circle-right"></i> このサイトのトップへ戻る</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>