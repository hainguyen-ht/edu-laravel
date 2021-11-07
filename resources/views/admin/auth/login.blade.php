<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex,nofollow" />
    <link rel="stylesheet" href="{{asset('frontend/css/style.css')}}">
    <!-- <link rel="stylesheet" href="assets/fonts/all.min.css"> -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Đăng nhập I-TECH</title>
    <style>
        .error{
            text-align: center!important;
        }
    </style>
</head>
<body>
    <div class="app">
        <div class="auth__container">
            <div class="auth__container__box">
                <div class="auth__container__form">
                    <h1 class="auth__container__form-form__heading">ĐĂNG NHẬP HỆ THỐNG</h1>
                    <div class="heading__login">
                        <div class="form__login mt-24">
                            <form method="POST" onsubmit="login_ajax()">
                                @csrf
                                <div class="form-group">
                                    <label class="form-label" for="email">Tài khoản </label>
                                    <input class="form-input email" type="text" name="email" placeholder="Nhập tài khoản">
                                    <span class="form-message error-1"></span>
                                </div>
                                <div class="form-group">
                                    <label class="form-label" for="password">Mật khẩu</label>
                                    <input id="fPass" class="form-input password" type="password" name="password"  placeholder="Nhập mật khẩu">
                                    <span class="password-hide"><i onclick=hidePass() class="far fa-eye-slash" id="eHide"></i></span>
                                    <span class="form-message error"></span>
                                </div>
                                <button type="submit" class="btn btn-login" onclick="login_ajax()">
                                    <span class="text-btn">Đăng nhập</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>]
    <script src="{{asset('js/function.js')}}"></script>
    <script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
    <script>
        var base_url = '<?php echo URL::to('/');?>';
        function login_ajax(){
            event.preventDefault();
            var email       = $('.email').val();
            var password    = $('.password').val();
            var _token      = $('input[name=_token]').val();
            if(validateEmail(email) == false){
                $(".error-1").html("Email chưa đúng định dạng!");
                return false;
            }else{
                $(".error-1").remove();
            }

            var data = new FormData();
            data.append('email', email);
            data.append('password', password);
            data.append('_token', _token);
            $.ajax({
                url: '{{ route('ajax.admin.login') }}',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: data,
                success: function(response){
                    if(response.status == 1){
                        alert('Đăng nhập thành công!');
                        location.href = '{{ route('admin') }}';
                    }else{
                        $('.error').html(response.message);
                    }
                },
                error: function(xhr){
                    alert('Error');
                }
			})
        }

    </script>
</body>
</html>
