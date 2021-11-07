<header class="header">
    <div id="navBar" class="header__navbar {{ ($check_page != 'index') ? 'index__course' : '' }}">
        <div class="header__content m-w mg-at grid">
            <div class="header__content__logo">
                <a class="logo-link" href="{{route('index')}}">
                    <img src="{{asset('frontend/img/logo.png')}}" width="165" height="50">
                </a>
            </div>
            <div class="header__content__nav hMobile">
                <ul class="header__content__nav-list">
                    <li class="header__content__nav-item">
                        <a class="text-header" href="{{route('index')}}">TRANG CHỦ</a>
                    </li>
                    <li class="header__content__nav-item">
                        <a class="text-header" href="{{route('course')}}">KHOÁ HỌC</a>
                    </li>
                </ul>
            </div>
            <div class="header__content__auth hMobile">
                <ul class="header__content__auth-list">
                    @if(Auth::check())
                        <li class="header__content__auth-item">
                            <img class="image__avatar"
                                 onerror="this.onerror=null;this.src='{{ asset('images/user-avt.png') }}'"
                                 src="{{ asset('uploads/avatar/'.Auth::user()->avatar) }}" alt="">
                        </li>
                        <li class="header__content__auth-item">
                            <a class="text-header" href="{{route('user.profile')}}">
                                {{ Auth::user()->name }}
                            </a>
                        </li>
                    @else
                        <li class="header__content__auth-item">
                            <a class="text-header" href="{{route('login')}}">Đăng nhập</a>
                        </li>
                    @endif

                    <li class="header__content__auth-item item__senpai">
                        |
                    </li>
                    @if(Auth::check())
                        <li class="header__content__auth-item">
                            <a class="text-header" href="{{route('user.logout')}}">Đăng xuất</a>
                        </li>
                    @else
                        <li class="header__content__auth-item">
                            <a class="text-header" href="{{route('register')}}">Đăng ký</a>
                        </li>
                    @endif
                </ul>
            </div>

            <!-- CLICK -->
            <div class="nav__menu">
                <i onclick=openMenu() class="fas fa-bars"></i>
            </div>

        </div>
    </div>
    {!! ($check_page != 'index') ? '' : '<div class="background"></div>'  !!}
</header>
