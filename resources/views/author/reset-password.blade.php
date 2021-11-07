<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <meta name="robots" content="noindex,nofollow" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>{{ $title_page }}</title>
</head>
<body>
    <div class="app">
        <div class="auth__header">
            <div class="auth__header__content">
                <a href="{{ route('index') }}">
                    <img src="{{asset('frontend/img/logo_black.png')}}" alt="I-TECH">
                </a>
            </div>
        </div>
        <div class="auth__container">
            <div class="auth__container__box">
                <div class="auth__container__form">
                    <h1 class="auth__container__form-form__heading">Khôi phục mật khẩu</h1>
                    <div class="heading__login">
                        <div class="form__login mt-24">
                            <div class="form-group mt-10">
                                <label class="form-label" for="email">Email của bạn</label>
                                <input class="form-input" type="text" name="email" placeholder="VD: nguyenvanhai@gmail.com">
                                <span class="form-message"></span>
                            </div>
                            <button class="btn btn-login">
                                <span class="text-btn">Khôi phục mật khẩu</span>
                            </button>
                            <p class="mt-24 rs__text-login">

                                <a class="text-relog" href="{{ route('login') }}">Đăng nhập</a>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="auth__container__help">
                    <p>Bạn cần sự hỗ trợ?
                        <a class="text-relog" href="./login.html">Gửi email cho chúng tôi</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
