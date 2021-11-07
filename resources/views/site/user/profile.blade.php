<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{asset('frontend/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{asset('/frontend/css/profile_css.css')}}">
    <title>{{ $title_page }}</title>
    <style>
        .pagination{
            justify-content: center;
        }
    </style>
</head>
<body id="body">
    <div class="app">
        @include('layouts.header')
        <div class="profile__content">
            @include('site.user.layouts.sidebar')
            <div class="form__info">
                <div class="info__control">
                    <div class="side__bar-info">
                        <img style="border-radius: 50%;"
                             onerror="this.onerror=null;this.src='{{ asset('images/user-avt.png') }}'"
                             src="{{ getAvatarUser($user->id) }}" alt="">
                        <div class="h__info">
                            <span class="text-muted">{{ $user->name }}</span>
                            <span class="h__info-coin">{{ $user->coin }} coin</span>
                        </div>
                    </div>
                    <div class="info__control-update">
                        <a href="{{ route('user.update') }}" class="list-group-item list-group-item-action list-group-item-dark btn-update">Cập nhật thông tin</a>
                    </div>
                </div>
                <div class="form__content">
                    <h3 class="form__content-title">Thông tin đăng nhập</h3>
                    <div class="form__content-list">
                        <div class="f_item">
                            <span>Email:</span>
                            <span>{{ $user->email }}</span>
                        </div>
                        <div class="f_item">
                            <span>Mật khẩu:</span>
                            <span>*******</span>
                        </div>
                    </div>
                </div>
                <div class="form__content">
                    <h3 class="form__content-title">Thông tin cá nhân</h3>
                    <div class="form__content-list">
                        <div class="f_item">
                            <span>Họ và tên:</span>
                            <span>{{ $user->name }}</span>
                        </div>
                        <div class="f_item">
                            <span>Địa chỉ:</span>
                            <span>{{ ($user->address) ?? 'Chưa cập nhật' }}</span>
                        </div>
                        <div class="f_item">
                            <span>Giới tính:</span>
                            <span>{{ ($user->sex) ?? 'Chưa cập nhật' }}</span>
                        </div>
                        <div class="f_item">
                            <span>Số điện thoại:</span>
                            <span>{{ ($user->phone) ?? 'Chưa cập nhật' }}</span>
                        </div>
                    </div>
                </div>

                <div class="form__content">
                    <h3 class="form__content-title">Yêu cầu nạp tiền</h3>
                    <div class="form__content-list">
                        <table class="table text-center">
                            <thead class="thead-light">
                            <tr>
                                <th scope="col">STT</th>
                                <th scope="col">Thời gian</th>
                                <th scope="col">Nội dung chuyển tiền</th>
                                <th scope="col">Trạng thái</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($notify_recharge as $key => $value)
                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td>{{ date("H:i:s d/m/Y", $value['created_at']) }}</td>
                                    <td>{{ $value['content'] }}</td>
                                    <td class="font-italic">{{ ($value['type']) ? 'Đã nhận' : 'Đang chờ' }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $notify_recharge->links() }}
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
</html>
