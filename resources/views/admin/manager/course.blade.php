@include('admin.includes.header')
@include('admin.includes.navbar')
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{asset('backend/css/css_customer.css')}}">
<style>
    .table{
        margin-top: 20px
    }
    .pagination{
        justify-content: center;
    }
    .row__coin{
        color: red
    }
    .load__img{
        width: 70px;
        height: auto;
    }
</style>
<div class="main">
    <div class="main__control">
{{--        <div class="main__control-search">--}}
{{--            <form action="{{ route('admin.manager.course') }}" method="GET">--}}
{{--                <input value="{{ $keyword }}" type="text" name="keyword" class="input__search" placeholder="Tìm kiếm theo tên khoá học...">--}}
{{--                <img class="img__search" src="icons/search.png" alt="">--}}
{{--            </form>--}}
{{--        </div>--}}
        <h2>Khoá học nhiều người mua nhất</h2>
    </div>
    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên khoá học</th>
            <th scope="col">Học phí</th>
            <th scope="col">Số học viên tham gia</th>
            <th scope="col">Đánh giá</th>
        </tr>
        </thead>
        <tbody>
        @csrf
        @foreach($list_course as $key => $value)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $value['c_name'] }}</td>
                <td>{{ $value['c_coin'] }}</td>
                <td>{{ $value['count_user'] }}</td>
                <td>{{ convertVote($value['avg_star']) }}</td>

            </tr>
        @endforeach

        </tbody>
    </table>
</div>
@include('admin.includes.footer')
