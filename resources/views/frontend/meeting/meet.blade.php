<!DOCTYPE html>

<head>
    <title>Zoom WebSDK</title>
    <meta charset="utf-8" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.8/css/bootstrap.css" />
    <link type="text/css" rel="stylesheet" href="https://source.zoom.us/1.9.8/css/react-select.css" />
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta http-equiv="origin-trial" content="">
</head>

<body>
    <input type="hidden" name="" id="meeting_json" value="{{ $data }}">
    <script src="https://source.zoom.us/1.9.8/lib/vendor/react.min.js"></script>
    <script src="https://source.zoom.us/1.9.8/lib/vendor/react-dom.min.js"></script>
    <script src="https://source.zoom.us/1.9.8/lib/vendor/redux.min.js"></script>
    <script src="https://source.zoom.us/1.9.8/lib/vendor/redux-thunk.min.js"></script>
    <script src="https://source.zoom.us/1.9.8/lib/vendor/lodash.min.js"></script>
    <script src="https://source.zoom.us/zoom-meeting-1.9.8.min.js"></script>
    <script src="{{ asset('js/tool.js') }}"></script>
    <script src="{{ asset('js/vconsole.min.js') }}"></script>
    <script src="{{ asset('js/meeting.js') }}"></script>

    <script>
        
    </script>
</body>

</html>