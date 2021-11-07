<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow" />
    <link rel="stylesheet" href="{{asset('frontend/css/index.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{asset('/frontend/css/responsive.css')}}">
    <title>{{ $title_page }}</title>
</head>
<body id="body">
    <div class="app">
        @include('layouts.header')
        @yield('main')
        @include('layouts.footer')
        @include('layouts.menu-mobile')
    </div>
    <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
    <script>

        var bgmShow = document.getElementById('bgmShow');
        var menuMobile = document.getElementById('menuMobile');
        var body = document.getElementById('body');
        var navBar = document.getElementById('navBar');
        // open menu
        let openMenu = () => {
            bgmShow.style.display = 'block';
            body.className = 'stop-scrolling';
        }

        // close Menu
        let closeMenu = () => {
            bgmShow.style.display = 'none';
            body.className = '';
        }

        // Scroll Menu -> fixed

        let scrollMenu = (event) => {
            var x = document.documentElement.scrollTop || document.body.scrollTop;
            if(x > 150){
                navBar.style.background = 'black'
                navBar.style.marginTop = '-14px'
            }else{
                navBar.style.background = ''
                navBar.style.marginTop = ''
            }
        }
    </script>
</body>
</html>
