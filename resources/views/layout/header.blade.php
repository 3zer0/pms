<base href="{{ url('/') }}"/>
<title>Property Management System</title>
<meta charset="utf-8" />
<meta name="description" content="Property Management System" />
<meta name="keywords" content="Property Management System" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta property="og:locale" content="en_PH" />
<meta property="og:type" content="article" />
<meta property="og:title" content="Property Management System" />
<meta property="og:url" content="{{ url('/') }}" />
<meta property="og:site_name" content="PMS" />
<link rel="canonical" href="{{ url('/') }}" />
<link rel="shortcut icon" href="assets/media/logos/dole-logo.png" />
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
@yield('css')
<link href="assets/plugins/custom/datatables/datatables.bundle.css" rel="stylesheet" type="text/css" />
<link href="assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<link href="assets/css/style.bundle.css" rel="stylesheet" type="text/css" />
<script>
    if (window.top != window.self) { window.top.location.replace(window.self.location.href); }
</script>
