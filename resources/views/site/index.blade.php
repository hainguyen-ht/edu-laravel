<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('frontend/css/index.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend/css/responsive.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('frontend/fonts/all.min.css') }}">
    <title>{{ $title_page }}</title>
</head>
<body id="body" onscroll=scrollMenu(event)>
    <div class="app">
        @include('layouts.header')

        <div class="section m-w mg-at">
            <div class="section__main">
                <div class="section__item col-4 grid">
                    <img src="{{ asset('frontend/img/section/feature-1.png') }}">
                    <h3>Trên 30.000 học viên</h3>
                </div>
                <div class="section__item col-4 grid">
                    <img src="{{ asset('frontend/img/section/feature-2.png') }}">
                    <h3>10+ khoá học dành cho bạn</h3>
                </div>
                <div class="section__item col-4 grid">
                    <img src="{{ asset('frontend/img/section/feature-3.png') }}">
                    <h3>Học bất cứ nơi nào, ở bất cứ đâu</h3>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="app__container m-w mg-at">
                <div class="main__index">
                    <!-- INDEX -->
                    <div class="course__heading">
                        <h2>
                            Khoá học nổi bật
                        </h2>
                        <p>
                            Những khoá học có lượng học viên đăng ký nhiều nhất và có phản hồi tích cực nhất
                        </p>
                    </div>
                    <!-- END -->
                    @include('layouts.item-course')
                </div>
            </div>
        </div>
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
