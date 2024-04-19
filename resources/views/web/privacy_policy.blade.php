<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width'>
    <title>{{$title}}</title>
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
            @if($privacyPolicy != null)
            {!! $privacyPolicy->privacy_policy !!}
            @endif
        </div>
    </div>
</body>

</html>