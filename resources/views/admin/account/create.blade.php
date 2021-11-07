@include('admin.includes.header')
@include('admin.includes.navbar')
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<style>
    .main{
        padding-bottom: 22%;
    }
    .text-red{
        color: red
    }
</style>
<div class="main">
    @csrf
    @if($account != '')
        <input class="account_id" type="hidden" value="{{ $account['id'] }}">
    @endif
    <div class="row">
        <div class="form-group col-5">
            <label>Tên học viên <span class="text-red">* <span class="error-1"></span></span></label>
            <input type="text" class="form-control name" placeholder="Nhập tên học viên..." value="{{ $account['name'] ?? '' }}">
        </div>
        <div class="form-group col-5">
            <label>Số điện thoại <span class="text-red">* <span class="error-2"></span></span></label>
            <input type="text" class="form-control phone" placeholder="Nhập số điện thoại..." value="{{ $account['phone'] ?? '' }}">
        </div>
    </div>
    <div class="row">
        <div class="form-group col-5">
            <label>Địa chỉ Email <span class="text-red">{{ ($account != '') ? '' : '*' }} <span class="error-3"></span></span></label>
            <input type="text" class="form-control email" {{ ($account != '') ? 'disabled' : '' }} placeholder="Nhập địa chỉ Email..." value="{{ $account['email'] ?? '' }}">
        </div>
        <div class="form-group col-5">
            <label>Mật khẩu <span class="text-red">{{ ($account != '') ? '' : '*' }}<span class="error-4"></span></span></label>
            <input type="password" class="form-control password" {{ ($account != '') ? 'disabled' : '' }} placeholder="{{ ($account != '') ? '******' : 'Nhập mật khẩu...' }}">
        </div>
    </div>
    <div class="row">
        <div class="text-center col-10">
            <button class="btn btn-primary" onclick="{{ ($account != '') ? 'edit_account_ajax()' : 'create_account_ajax()' }}">Submit</button>
        </div>
    </div>

</div>
@include('admin.includes.footer')
<script src="{{asset('js/function.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    var base_url = '<?php echo URL::to('/');?>';
    function create_account_ajax(){
        var name        = $('.name').val();
        var email       = $('.email').val();
        var phone       = $('.phone').val();
        var password    = $('.password').val();
        var _token      = $('input[name=_token]').val();

        if($.trim(name) == ''){
            $(".error-1").html("Tên không được để trống!");
            return false;
        }else{
            $(".error-1").remove();
        }
        if($.trim(phone) == ''){
            $(".error-2").html("SĐT không được để trống!");
            return false;
        }else{
            $(".error-2").remove();
        }
        if(validateEmail(email) == false){
            $(".error-3").html("Email chưa đúng định dạng!");
            return false;
        }else{
            $(".error-3").remove();
        }
        if(password == ''){
            $(".error-4").html("Mật khẩu không được để trống!");
            return false;
        }else{
            $(".error-4").remove();
        }
        var data = new FormData();
        data.append('name', name);
        data.append('phone', phone);
        data.append('email', email);
        data.append('password', password);
        data.append('_token', _token);

        $.ajax({
            url: '{{ route('ajax.admin.account.create') }}',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function(response){
                if(response.status == 1){
                    alert('Thêm mới thành công!');
                    location.reload();
                }else{
                    alert(response.message);
                }
            },
            error: function(xhr){
                alert('Error');
            }
        })
    }
    function edit_account_ajax(){
        var id          = $('.account_id').val();
        var name        = $('.name').val();
        var phone       = $('.phone').val();
        var _token      = $('input[name=_token]').val();

        if($.trim(name) == ''){
            $(".error-1").html("Tên không được để trống!");
            return false;
        }else{
            $(".error-1").remove();
        }
        if($.trim(phone) == ''){
            $(".error-2").html("SĐT không được để trống!");
            return false;
        }else{
            $(".error-2").remove();
        }

        var data = new FormData();
        data.append('id', id);
        data.append('name', name);
        data.append('phone', phone);
        data.append('_token', _token);

        $.ajax({
            url: '{{ route('ajax.admin.account.edit') }}',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function(response){
                if(response.status == 1){
                    alert('Cập nhật thành công!');
                    location.href = '{{ route('admin.account.index') }}';
                }else{
                    alert(response.message);
                }
            },
            error: function(xhr){
                alert('Error');
            }
        })
    }

</script>
