<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow" />
    <link rel="stylesheet"href="{{asset('frontend/css/style.css')}}">
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
                    <h1 class="auth__container__form-form__heading">Đăng ký thành viên</h1>
                    <p class="auth__container__form-form_subheading">I-TECH là cộng đồng học lập trình thực tế miễn phí. Đăng nhập để cùng nhau học tập, đóng góp và chia sẻ kiến thức ❤️</p>
                    <div class="heading__login">
                        <button class="btn btn-google">
                            <i class="fab fa-google"></i>
                            <span class="text-btn">Đăng ký với Google</span>
                        </button>
                        <button class="btn btn-facebook">
                            <i class="fab fa-facebook-square"></i>
                            <span class="text-btn">Đăng ký với Facebook</span>
                        </button>
                        <p class="auth__container__form-form_subheading mt-10">Mẹo: Đăng ký nhanh hơn với Google hoặc Facebook!</p>
                        <p class="mt-24 auth__container__form-form_subheading auth__container__form-form_subheading-or">

                            <span class="or-heading">HOẶC</span>
                        </p>
                        @csrf
                        <div class="form__login mt-24">
                            <div class="form-group">
                                <label class="form-label" for="fullname">Họ và tên</label>
                                <input class="form-input name" type="text" name="name" placeholder="VD: Nguyễn Văn Hải">
                                <span class="form-message error-1"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="email">Email</label>
                                <input class="form-input email" type="text" name="email" placeholder="VD: nguyenvanhai@gmail.com">
                                <span class="form-message error-2"></span>
                            </div>
                            <div class="form-group">
                                <label class="form-label" for="password">Mật khẩu</label>
                                <input id="fPass" class="form-input password" type="password" name="password"  placeholder="Nhập mật khẩu">
                                <span class="password-hide"><i onclick=hidePass() class="far fa-eye-slash" id="eHide"></i></span>
                                <span class="form-message error-3"></span>
                            </div>
                            <!-- CHECK -->
                            <div class="form-group box__group">
                                <span class="box__group__item box__group__item-ticker">
                                    <input type="checkbox">
                                </span>
                                <span class="box__group__item box__group__item-text">
                                    Nhận thông báo về các tin tức & sự kiện mới nhất của chúng tôi. (Có thể hủy đăng ký bất cứ lúc nào.)
                                </span>
                            </div>

                            <button onclick="register_submit()" class="btn btn-login">
                                <span class="text-btn">Đăng ký</span>
                            </button>
                            <p class="mt-24 auth__container__form-form_subheading fogot__pass">
                            Bằng cách đăng ký, bạn đồng ý với các
                                <a href="#">điều khoản sử dụng</a>
                            của chúng tôi
                            </p>
                        </div>
                    </div>
                </div>
                <div class="auth__container__help">
                    <p>Bạn đã có tài khoản?
                        <a class="text-relog" href="{{ route('login') }}">Đăng nhập</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <script src="{{asset('js/function.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
    <script>
        var ePass = document.getElementById('fPass')
        var eHide = document.getElementById('eHide');

        var hidePass = function(){
            var status  = ePass.type;
            if(status === 'text'){
                ePass.type = 'password'
                eHide.className = 'far fa-eye-slash'
            }else{
                ePass.type = 'text'
                eHide.className = 'far fa-eye'
            }
        }
        function register_submit(){
            var name = $('.name').val();
            var email = $('.email').val();
            var password = $('.password').val();
            var _token = $('input[name=_token]').val();

            if($.trim(name) == ''){
                $('.error-1').html('Họ và tên không được để trống!');
                return false;
            }else{
                $('.error-1').empty();
            }
            if($.trim(email) == ''){
                $('.error-2').html('Email không được để trống!');
                return false;
            }else if(validateEmail(email) == false){
                $('.error-2').html('Email không đúng định dạng!');
                return false;
            }else{
                $('.error-2').empty();
            }
            if($.trim(password) == ''){
                $('.error-3').html('Mật khẩu không được để trống!');
                return false;
            }else{
                $('.error-3').empty();
            }


            var data = new FormData();
            data.append('name', name);
            data.append('email', email);
            data.append('password', password);
            data.append('_token', _token);

            $.ajax({
                url: '{{ route('ajax.user.register') }}',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                dataType: 'json',
                enctype: 'multipart/form-data',
                success: function (response) {
                    if(response.status == 1){
                        alert('Đăng ký thành công! Đăng nhập ngay!');
                        location.href = '{{ route('login') }}';
                    }else if(response.status == 2){
                        $('.error-2').html('Email này đã được sử dụng!');
                    }else{
                        alert(response.message);
                    }
                },
                error: function (xhr){
                    alert('Error');
                }
            });
        }
    </script>
</body>
</html>
