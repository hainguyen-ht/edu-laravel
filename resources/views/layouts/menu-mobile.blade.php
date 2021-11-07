<div id="bgmShow" class="menu__more">
    <div id="menuMobile" class="menu__mobile">
        <header class="menu__mobile__header">
            <img src="img/logo_black.png">
            <span onclick=closeMenu()>
                        <i class="fas fa-times"></i>
                    </span>
        </header>
        <ul class="menu__mobile__list">
            @if(!Auth::check())
                <li>
                    <span><i class="fas fa-sign-in-alt"></i></span>
                    <a href="{{ route('login') }}">Đăng nhập</a>
                </li>
                <li>
                    <span><i class="fas fa-user-plus"></i></span>
                    <a href="{{ route('register') }}">Đăng ký</a>
                </li>
            @endif
            <li>
                <span><i class="fas fa-home"></i></span>
                <a href="{{ route('home') }}">Trang chủ</a>
            </li>
            <li>
                <span><i class="fas fa-book"></i></span>
                <a href="{{ route('course') }}">Khoá học</a>
            </li>
            @if(Auth::check())
                <li>
                    <span><i class="fas fa-sign-out-alt"></i></span>
                    <a href="{{ route('user.logout') }}">Đăng xuất</a>
                </li>
            @endif
        </ul>
    </div>
</div>
