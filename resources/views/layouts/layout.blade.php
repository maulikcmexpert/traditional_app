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

            @include($page)

        </section>
    </div>
    <x-admin.footer />
    <x-admin.footerscript />

    @if(isset($js))
    @include($js)
    @endif
</body>

</html>