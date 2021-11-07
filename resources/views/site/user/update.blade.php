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
                <h3 class="form__content-title">Cập nhật thông tin cá nhân</h3>
                <form class="form__update" onsubmit="ajax_update()" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6">

                            <img src="{{ asset('uploads/avatar/'.$user->avatar) }}" onerror="this.onerror=null;this.src='{{ asset('images/user-avt.png') }}'" id="avt-user-flc" class="avt-user">
                            <input type="file"
                                   accept="image/x-png,image/gif,image/jpeg"
                                   name="file" id="file" class="inputfile"
                                   onchange="readURL(this);"
                                   multiple="">
                            <label class="img_change" for="file" class="for-file" style="cursor: pointer">Cập nhật ảnh đại diện</label>
                        </div>
                        <div class="col-md-6 main__update">
                            <div class="form-group">
                                <label>Họ và tên</label>
                                <input type="text" class="form-control name" placeholder="Nhập họ và tên.." value="{{ $user->name }}">
                                <small class="form-text text-danger error-1"></small>
                            </div>
                            <div class="form-group">
                                <label>Số điện thoại</label>
                                <input type="text" class="form-control phone" placeholder="Nhập số điện thoại.." value="{{ $user->phone }}">
                                <small class="form-text text-danger error-2"></small>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="group__btn group__btn-update">
                            <button type="submit" onclick="ajax_update()" class="btn btn-info btn-change-pass">Cập nhật thông tin</button>
                            <button type="button" onclick="location.href='{{ route('user.profile') }}'" class="btn btn-dark">Huỷ</button>
                        </div>
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
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.avt-user')
                    .attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#file').on('change', function (){
        var user_id = '{{ $user->id }}';
        var avt_user	= $('#file')[0].files[0] ?? '';
        var _token = $('input[name=_token]').val();

        if(avt_user != '' && user_id != ''){
            var data = new FormData();

            data.append('avt_user', avt_user);
            data.append('user_id', user_id);
            data.append('_token', _token);

            $.ajax({
                url: '{{ route('ajax.user.update-avt') }}',
                type: 'POST',
                data: data,
                dataType: 'JSON',
                processData: false,
                contentType: false,
                success: function (response){
                    if(response.status == 1){
                        alert('Cập nhật thành công!');
                        location.reload();
                    }else{
                        alert('Upload ảnh thất bại!');
                        location.reload();
                    }
                },
                error: function (xhr){
                    alert('Error');
                }
            });

        }else{
            return false;
        }
    })

    function ajax_update(){
        event.preventDefault();
        var user_id = '{{ $user->id }}';
        var name = $('.name').val();
        var phone = $('.phone').val();
        var _token = $('input[name=_token]').val();
        var regex_phone = /((09|03|07|08|05)+([0-9]{8})\b)/g;
        if($.trim(name) == ''){
            $('.error-1').html('Họ và tên không được để trống!');
            return false;
        }else{
            $('.error-1').empty();
        }
        if($.trim(phone) == ''){
            $('.error-2').html('Số điện thoại không được để trống!');
            return false;
        }else if(!phone.match(regex_phone)){
            $('.error-2').html('Số điện thoại không đúng định dạng!');
            return false;
        }else{
            $('.error-2').empty();
        }

        var data = new FormData();
        data.append('user_id', user_id);
        data.append('name', name);
        data.append('phone', phone);
        data.append('_token', _token);

        $.ajax({
            url: '{{ route('ajax.user.update') }}',
            contentType: false,
            dataType: 'JSON',
            type: 'POST',
            processData: false,
            data: data,
            success: function (response){
                if(response.status == 1){
                    alert('Cập nhật thành công!');
                    location.href = '{{ route('user.profile') }}';
                }else{
                    alert('Cập nhật thất bại!');
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
