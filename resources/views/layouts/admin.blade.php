<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Star Admin Premium Bootstrap Admin Dashboard Template</title>
    <link rel="stylesheet" href="/adminarea/assets/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="/adminarea/assets/vendors/iconfonts/ionicons/css/ionicons.css">
    <link rel="stylesheet" href="/adminarea/assets/vendors/iconfonts/typicons/src/font/typicons.css">
    <link rel="stylesheet" href="/adminarea/assets/vendors/iconfonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="/adminarea/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="/adminarea/assets/vendors/css/vendor.bundle.addons.css">
    <link rel="stylesheet" href="/adminarea/assets/css/shared/style.css">
    <link rel="stylesheet" href="/adminarea/assets/css/demo_1/style.css">
    <link rel="shortcut icon" href="/adminarea/assets/images/favicon.png"/>
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"
          integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css"/>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.js"></script>
    <script type="text/javascript"
            src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
    <script
        src="https://cdn.tiny.cloud/1/8w5bx5ixlzft2ldtwpkddnpqm4hkhoay02b3c9m0wlazbvda/tinymce/5/tinymce.min.js"></script>
    <script>tinymce.init({selector: '.rich-text'});</script>
    <script src="https://cdn.ckeditor.com/4.12.1/full/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="{{ asset('adminarea/admin.js') }}" type="text/javascript"></script>
</head>
<body>
<div class="container-scroller">

    @include('auth.admin.partials._navbar')

    <div class="container-fluid page-body-wrapper">
        @include('auth.admin.partials._sidebar')
        @yield('main-content')
    </div>

</div>

<script src="/adminarea/assets/vendors/js/vendor.bundle.base.js"></script>
<script src="/adminarea/assets/vendors/js/vendor.bundle.addons.js"></script>

<script src="/adminarea/assets/js/shared/off-canvas.js"></script>
<script src="/adminarea/assets/js/shared/misc.js"></script>

<script src="/adminarea/assets/js/demo_1/dashboard.js"></script>

</body>
</html>
