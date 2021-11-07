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
</head>
<body id="body">
<div class="app">
    @include('layouts.header')
    <div class="profile__content">
        @include('site.user.layouts.sidebar')
        <div class="form__info">
            <div class="form__content">
                <h3 class="form__content-title">Đổi mật khẩu</h3>
                <form class="form__changepass" onsubmit="ajax_change_pass()">
                    @csrf
                    <div class="form-group">
                        <label>Mật khẩu cũ</label>
                        <input type="password" class="form-control password" placeholder="Nhập mật khẩu cũ..">
                        <small class="form-text text-danger error-1"></small>
                    </div>
                    <div class="form-group">
                        <label>Mật khẩu mới</label>
                        <input type="password" class="form-control newpass" placeholder="Mật khẩu mới..">
                        <small class="form-text text-danger error-2"></small>
                    </div>
                    <div class="form-group">
                        <label>Nhập lại mật khẩu</label>
                        <input type="password" class="form-control renewpass" placeholder="Nhập mật khẩu mới..">
                        <small class="form-text text-danger error-3"></small>
                    </div>
                    <div class="group__btn">
                        <button type="submit" class="btn btn-info btn-change-pass" onclick="ajax_change_pass()">Đổi mật khẩu</button>
                        <button type="button" onclick="location.href='{{ route('user.profile') }}'" class="btn btn-dark">Huỷ</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>

</body>
<script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script>
    function ajax_change_pass(){
        event.preventDefault();
        var password = $('.password').val();
        var newpass  = $('.newpass').val();
        var renew    = $('.renewpass').val();
        var _token = $('input[name=_token]').val();

        if($.trim(password) == ''){
            $('.error-1').html('Điền mật khẩu!');
            return false;
        }else{
            $('.error-1').empty();
        }
        if($.trim(newpass) == '') {
            $('.error-2').html('Điền mật khẩu mới!');
            return false;
        }else if(newpass.length < 6){
            $('.error-2').html('Mật khẩu từ 6 ký tự!');
            return false;
        }else{
            $('.error-2').empty();
        }
        if($.trim(renew) == ''){
            $('.error-3').html('Nhập lại mật khẩu mới!');
            return false;
        }else if(renew != newpass){
            $('.error-3').html('Mật khẩu nhập lại chưa đúng!');
            return false;
        }else{
            $('.error-3').empty();
        }
        var data = new FormData();
        data.append('password', password);
        data.append('new_password', newpass);
        data.append('_token', _token);

        $.ajax({
            url: '{{ route('ajax.user.changepass') }}',
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'JSON',
            data: data,
            success: function (response){
                if(response.status == 1){
                    alert('Đổi mật khẩu thành công!');
                    location.reload();
                }else if(response.status == 2){
                    $('.error-1').html('Mật khẩu không đúng!');
                    return false;
                }else{
                    alert('Đổi mật khẩu thất bại!');
                    location.reload();
                }
            },
            error: function (xhr){
                alert('Error');
            }
        });

    }
</script>
</html>
