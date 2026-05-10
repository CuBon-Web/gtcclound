
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8" />
    <meta name="theme-color" content="#d70018">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <meta name='revisit-after' content='2 days' />
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    @stack('resource-hints')
    <title>@yield('title')</title>
    <meta name="SKYPE_TOOLBAR" content="SKYPE_TOOLBAR_PARSER_COMPATIBLE" />
    <meta http-equiv="Content-Language" content="vi" />
    <link rel="alternate" href="{{url()->current()}}" hreflang="vi-vn" />
    <meta name="description" content="@yield('description')">
    <meta name="robots" content="index, follow" />
    <meta name="googlebot" content="index, follow">
    <meta name="revisit-after" content="1 days" />
    <meta name="generator" content="@yield('title')" />
    <meta name="rating" content="General">
    <meta name="application-name" content="@yield('title')" />
    <meta name="theme-color" content="#ed3235" />
    <meta name="msapplication-TileColor" content="#ed3235" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-title" content="{{url()->current()}}" />
    <link rel="apple-touch-icon-precomposed" href="@yield('image')" sizes="700x700">
    <meta property="og:url" content="">
    <meta property="og:title" content="@yield('title')">
    <meta property="og:description" content="@yield('description')">
    <meta property="og:image" content="@yield('image')">
    <meta property="og:site_name" content="{{url()->current()}}">
    <meta property="og:image:alt" content="@yield('title')">
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="vi_VN" />
    <meta name="twitter:card" content="summary" />
    <meta name="twitter:site" content="@{{url()->current()}}" />
    <meta name="twitter:title" content="@yield('title')" />
    <meta name="twitter:description" content="@yield('description')" />
    <meta name="twitter:image" content="@yield('image')" />
    <meta name="twitter:url" content="" />
    <meta itemprop="name" content="@yield('title')">
    <meta itemprop="description" content="@yield('description')">
    <meta itemprop="image" content="@yield('image')">
    <meta itemprop="url" content="">
    <link rel="canonical" href="{{\Request::url()}}">
    <!-- <link rel="amphtml" href="amp/" /> -->
    <link rel="image_src" href="@yield('image')" />
    <link rel="image_src" href="@yield('image')" />
    <link rel="shortcut icon" href="{{url(''.$setting->favicon)}}" type="image/x-icon">
    <link rel="icon" href="{{url(''.$setting->favicon)}}" type="image/x-icon">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap" media="print" onload="this.media='all'">
      <noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,600;1,700&display=swap"></noscript>
      <link rel="stylesheet" href="{{asset('frontend/css/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{asset('frontend/css/slick.min.css')}}">
      <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
      <link rel="stylesheet" href="{{asset('frontend/css/fontawesome.min.css')}}" media="print" onload="this.media='all'">
      <noscript><link rel="stylesheet" href="{{asset('frontend/css/fontawesome.min.css')}}"></noscript>
      <link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.min.css')}}" media="print" onload="this.media='all'">
      <noscript><link rel="stylesheet" href="{{asset('frontend/css/magnific-popup.min.css')}}"></noscript>
      <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
    @yield('css')
    @yield('schema')
     <!-- on page load modal -->
  
     @php
        $hotlineValue = $setting->hotline ?? $setting->phone1 ?? '';
        $hotlineDigits = preg_replace('/\D+/', '', (string) $hotlineValue);
        $zaloLink = $hotlineDigits ? 'https://zalo.me/' . $hotlineDigits : '#';
        $messengerLink = $setting->messenger ?? $setting->facebook ?? '#';
    @endphp
</head>
<body>
    @include('layouts.header.index')
    @yield('content')
    @include('layouts.footer.index')
  
    <script defer src="{{asset('frontend/js/slick.min.js')}}"></script>
    <script defer src="{{asset('frontend/js/bootstrap.min.js')}}"></script>
    <script defer src="{{asset('frontend/js/jquery.magnific-popup.min.js')}}"></script>
    <script defer src="{{asset('frontend/js/jquery.counterup.min.js')}}"></script>
    <script defer src="{{asset('frontend/js/jquery-ui.min.js')}}"></script>
    <script defer src="{{asset('frontend/js/main.js')}}"></script>
    @yield('js')
 </body>
</html>




