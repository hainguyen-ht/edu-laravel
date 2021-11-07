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
                <h3 class="form__content-title">Gửi yêu cầu nạp tiền</h3>
                <form class="form__changepass" onsubmit="ajax_recharge()" method="POST">
                    @csrf
                    <div class="bank-center">
                        <div class="bank-content-center">
                            <div class="bank-content-head">
                                <h3 class="name_bank">THÔNG TIN TÀI KHOẢN TECHCOMBANK</h3>

                                <div class="img_bank" style="width: 120px;margin-left: 10px">
                                    <img src="{{ asset('images/techcombank.png') }}" alt="ngân hàng">
                                </div>
                            </div>
                            <p>Số tài khoản: <span class="stk">19036375154019</span></p>
                            <p>Chủ tài khoản: <span class="name">NGUYEN VAN HAI</span></p>
                            <p>Chi nhánh: <span class="address">Láng Hạ</span></p>
                            <p>Nội dung chuyển khoản: <span>[ Tài khoản email ] + Y/c nap tien</span>
                            </p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Số tiền cần nạp</label>
                        <input type="number" class="form-control price" placeholder="Nhập số tiền cần nạp..">
                        <small class="form-text text-danger error-1"></small>
                    </div>
                    <div class="form-group">
                        <span class="text-danger font-italic text-note">
                            Lưu ý: Khi chuyển tiền ghi đúng nội dung và chuyển đúng số tiền.
                            <p>Tí lệ quy đổi: Mỗi 1000 VNĐ sẽ quy đổi ra 1 coin.</p>
                        </span>
                    </div>

                    <div class="group__btn">
                        <button type="submit" onclick="ajax_recharge()" class="btn btn-info btn-change-pass">GỬI YÊU CẦU</button>
                        <button type="reset" class="btn btn-dark">Huỷ</button>
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
    function ajax_recharge(){
        event.preventDefault();
        var price = $('.price').val();
        var _token = $('input[name=_token]').val();
        var user_id = '{{ $user->id }}';
        var email = '{{ $user->email }}';

        if($.trim(price) == ''){
            $('.error-1').html('Nhập số tiền!');
            return false;
        }else if(price <= 0){
            $('.error-1').html('Số tiền phải > 0');
            return false;
        }else{
            $('.error-1').empty();
        }

        var data = new FormData();
        data.append('price', price);
        data.append('user_id', user_id);
        data.append('email', email);
        data.append('_token', _token);

        $.ajax({
            url: '{{ route('ajax.user.recharge') }}',
            type: 'POST',
            contentType: false,
            processData: false,
            dataType: 'JSON',
            data: data,
            success: function (response){
                if(response.status == 1){
                    alert('Gửi yêu cầu thành công!');
                    location.reload();
                }else{
                    alert('Gửi yêu cầu thất bại');
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
