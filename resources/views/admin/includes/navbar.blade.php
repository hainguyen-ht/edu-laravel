<div class="app__navbar">
    <div class="navbar__header grid-container">
        <div class="navbar__header-icon">
            <img src="icons/user.png">
        </div>
        <div class="navbar__header-info">
{{--            <p>Hải Nguyễn</p>--}}
            <p>{{ substr(Auth::guard('admin')->user()->email,0,strpos(Auth::guard('admin')->user()->email,'@')) }}</p>
            <p>Quản lý cấp cao</p>
        </div>
    </div>
    <ul class="navbar__group">
        <li class="navbar__item">
            <a href="{{ route('admin') }}" class="navbar__item-link">
                <img src="icons/home.png">
                <span class="navbar__item-title">Trang chủ</span>
            </a>
        </li>
        <li class="navbar__item item__link_parent">
            <a class="navbar__item-link item__link_parent">
                <img src="icons/customer.png">
                <span class="navbar__item-title">Học viên</span>
            </a>
            <ul class="navbar__treeview">
                <li class="navbar__item">
                    <a href="{{ route('admin.account.index')  }}" class="navbar__item-link">
                        Danh sách học viên
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('admin.account.create')  }}" class="navbar__item-link">
                        Thêm mới học viên
                    </a>
                </li>
            </ul>
        </li>
        <li class="navbar__item item__link_parent">
            <a class="navbar__item-link item__link_parent">
                <img src="icons/menu.png">
                <span class="navbar__item-title">Danh mục khoá học</span>
            </a>
            <ul class="navbar__treeview">
                <li class="navbar__item">
                    <a href="{{ route('admin.category.index') }}" class="navbar__item-link">
                        Danh sách danh mục
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('admin.category.create') }}" class="navbar__item-link">
                        Thêm danh mục
                    </a>
                </li>
            </ul>
        </li>
        <li class="navbar__item item__link_parent">
            <a class="navbar__item-link item__link_parent">
                <img src="icons/supplier.png">
                <span class="navbar__item-title">Khoá học</span>
            </a>
            <ul class="navbar__treeview">
                <li class="navbar__item">
                    <a href="{{ route('admin.course.index') }}" class="navbar__item-link">
                        Danh sách khoá học
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('admin.course.create') }}" class="navbar__item-link">
                        Thêm mới khoá học
                    </a>
                </li>
            </ul>
        </li>
        <li class="navbar__item item__link_parent">
            <a class="navbar__item-link item__link_parent">
                <img src="icons/manager.png">
                <span class="navbar__item-title">Quản lý chung</span>
            </a>
            <ul class="navbar__treeview">
                <li class="navbar__item">
                    <a href="{{ route('admin.manager.recharge') }}" class="navbar__item-link">
                        Danh sách yêu cầu nạp tiền
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('admin.manager.course') }}" class="navbar__item-link">
                        Thống kê khoá học
                    </a>
                </li>
            </ul>
        </li>
        <li class="navbar__item item__link_parent">
            <a class="navbar__item-link item__link_parent">
                <img src="icons/lib.png" width="26" height="26">
                <span class="navbar__item-title">Thư viện</span>
            </a>
            <ul class="navbar__treeview">
                <li class="navbar__item">
                    <a href="{{ route('admin.lib.images') }}" class="navbar__item-link">
                        Quản lý ảnh
                    </a>
                </li>
                <li class="navbar__item">
                    <a href="{{ route('admin.lib.videos') }}" class="navbar__item-link">
                        Quản lý video
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</div>
