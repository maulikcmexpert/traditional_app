@include('components.admin.header');
@include('components.admin.bodyheader');
{{-- <section class="page-wrapper"> --}}
@yield('content');
{{-- </section> --}}
@include('components.admin.footer');
@include('components.admin.footerscript');
