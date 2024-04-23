<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/x-icon" href="{{asset('admin/assets/logo/logo.png')}}">
    <title>{{ config('app.name', 'Traditional') }}</title>
    <style>
        label.error {
            color: red;
        }
    </style>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="{{asset('admin/assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admin/assets/js/additional-methods.min.js')}}"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </div>

        <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
            {{ $slot }}
        </div>
    </div>
</body>
<script>
    $.validator.addMethod("customValidation", function(value, element) {
        var thatVal = value.trim();
        // Check if input consists only of digits
        if (/^\d+$/.test(thatVal)) {
            return false;
        }

        return true; // If none of the above conditions are met, input is valid
    }, 'Please enter valid Email');

    $("#loginForm").validate({
        rules: {
            email: {
                required: true,
                email: true,
                customValidation: true
            },
            password: {
                required: true,
                minlength: 8,
            }
        },
        messages: {
            email: {
                required: "Please enter Email",
                email: "Please enter valid Email",
                customValidation: "Please enter vaild Email"
            },
            password: {
                required: "Please enter Password",
                minlength: "Password must be at least 8 characters",
            }
        },


    });
</script>

</html>