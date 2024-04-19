<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width'>
    <title>{{$title }}</title>
    <!-- Latest compiled and minified CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            padding: 1em;
        }

        .privacy-policy p:nth-child(1){
            font-size: 32px;
            font-weight: 600;
            margin-bottom: 5px;

        }

        .privacy-policy p:nth-child(2){
            font-size: 17px;
            margin: 0 auto 20px;
        }

        .privacy-policy ol p{
            text-align: left !important;
            font-size: 18px !important;
            font-weight: 600 !important;
        }

        .privacy-policy ol ul{
            margin-bottom: 15px;
            padding-left: 15px;
        }

        .privacy-policy ol li{
            margin-bottom: 8px;
        }

        .privacy-policy ol li::marker{
            font-size: 17px;
            font-weight: 600;
        }

        .privacy-policy ol li:last-child{
            margin-bottom: 0px;
        }

    </style>
</head>


<!-- Latest compiled JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<body>
    <div class="p-4">
        <div class="privacy-policy">
            @if($termAndCondition != null)
            {!! $termAndCondition->term_and_condition !!}
            @endif
        </div>
    </div>
</body>

</html>