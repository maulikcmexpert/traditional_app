<!DOCTYPE html>
<html lang="en">

<head>

    <x-admin.header title={{$title}} />

</head>

<body>
    <div class="wrapper">
        <x-admin.sidebar />
        <x-admin.bodyheader />

        <section class="page-wrapper">
            <div class="page-content">
                @include($page)
            </div>
        </section>
    </div>
    <x-admin.footer />
    <x-admin.footerscript />

</body>

</html>