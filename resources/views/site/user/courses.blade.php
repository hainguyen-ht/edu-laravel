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
                <h3 class="form__content-title">Danh sách khoá học</h3>
                <table class="table text-center">
                    <thead class="thead-light">
                        <tr>
                            <th scope="col">STT</th>
                            <th scope="col">Tên khoá học</th>
                            <th scope="col">Ngày đăng ký</th>
                            <th scope="col">Trạng thái</th>
                            <th scope="col">Đánh giá</th>
                        </tr>
                    </thead>
                    <tbody>
                    @csrf
{{--                    {{ dd($courses) }}--}}
                    @foreach($courses as $key => $value)
                        <tr class="courses__item">
                            <td scope="row">{{ ++$key }}</td>
                            <td>{{ $value['c_name'] }}</td>
                            <td>{{ convertDate($value['created_at']) }}</td>
                            <td>
                                <select class="custom-select" id="course_status" data-course="{{ $value['course_id'] }}" data-user="{{ $value['user_id'] }}">
                                    <option value="0" {{ ($value['status'] == 0) ? 'selected' : 'disabled'}}>Đang học</option>
                                    <option value="1" {{ ($value['status'] == 1) ? 'selected' : ''}}>Đã học xong</option>
                                </select>
                            </td>
                            <td>
                                <ul class="ratings">
                                    <li onclick="readStar(this)" class="star {{ ($value['star'] == 5) ? 'selected' : '' }}"></li>
                                    <li onclick="readStar(this)" class="star {{ ($value['star'] == 4) ? 'selected' : '' }}"></li>
                                    <li onclick="readStar(this)" class="star {{ ($value['star'] == 3) ? 'selected' : '' }}"></li>
                                    <li onclick="readStar(this)" class="star {{ ($value['star'] == 2) ? 'selected' : '' }}"></li>
                                    <li onclick="readStar(this)" class="star {{ ($value['star'] == 1) ? 'selected' : '' }}"></li>
                                </ul>
                                <span class="action__rating"
                                      data-star="{{ $value['star'] }}"
                                      data-status="{{ $value['status'] }}"
                                      data-course="{{ $value['course_id'] }}"
                                      data-user="{{ $value['user_id'] }}">
                                    VOTE
                                </span>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

</body>
<script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script>

    function readStar(elm){
        $(elm).addClass('selected');
    }

    $('.custom-select').on('change',function (){
        if(confirm('Xác nhận học xong khoá học này chứ!')){
            var status = 1;
            var course_id = $(this).data('course');
            var user_id = $(this).data('user');
            var _token = $('input[name=_token]').val();
            var data = new FormData();

            data.append('status', status);
            data.append('course_id', course_id);
            data.append('user_id', user_id);
            data.append('_token', _token);

            $.ajax({
                url: '{{ route('ajax.user.setstatus') }}',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                dataType: 'json',
                enctype: 'multipart/form-data',
                success: function (response) {
                    if(response.status == 1){
                        alert('Xác nhận hoàn thành khoá học thành công!');
                        location.reload();
                    }else{
                        alert(response.message);
                        location.reload();
                    }
                },
                error: function (xhr){
                    alert('Error');
                }
            });
        }else{
            $("option:selected").prop("selected", false);
        }
    });

    $('.action__rating').on('click', function (){

        if($(this).data('status') == 0){
            alert('Bạn phải hoàn thành khoá học trước!');
            return false;
        }
        if($(this).data('star') != ''){
            alert('Bạn đã đánh giá khoá học này rồi!');
            location.reload();
            return false;
        }

        var position = 5;
        $(this).prev().children().each(function (index){
            if($(this).hasClass('selected')){
                position = index;
            }
        });
        var star = 5 - position;
        if(star == 0){
            alert('Vui lòng chọn mức độ đánh giá cho khoá học');
            return false;
        }else{

            var user_id = $(this).data('user');
            var course_id = $(this).data('course');
            var _token = $('input[name=_token]').val();
            var data = new FormData();

            data.append('star', star);
            data.append('user_id', user_id);
            data.append('course_id', course_id);
            data.append('_token', _token);

            $.ajax({
                url: '{{ route('ajax.user.rating') }}',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                dataType: 'json',
                enctype: 'multipart/form-data',
                success: function (response) {
                    if(response.status == 1){
                        alert('Đánh giá thành công!');
                        location.reload();
                    }else{
                        alert('Đánh giá thất bại!');
                        location.reload();
                    }
                },
                error: function (xhr){
                    alert('Error');
                }
            });
        }
    })


</script>
</html>
