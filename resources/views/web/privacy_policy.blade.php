<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width'>
    <title>{{$title }}</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 1em;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="privacy-policy">
            {!! $privacyPolicy->privacy_policy !!}
        </div>
    </div>
</body>

</html>