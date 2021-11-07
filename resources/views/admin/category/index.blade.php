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

</style>
<div class="main">
    <div class="main__control">
        <div class="main__control-search">
            <form action="{{ route('admin.category.index') }}" method="GET">
                <input value="{{ $keyword }}" type="text" name="keyword" class="input__search" placeholder="Tìm kiếm theo tên danh mục...">
                <img class="img__search" src="icons/search.png" alt="">
            </form>
        </div>

        <div class="main__control-new">
            <a href="{{ route('admin.category.create')  }}" class="btn__new">+ Thêm mới</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên danh mục</th>
            <th scope="col">Ngày tạo</th>
            <th scope="col" class="text-center">Kích hoạt</th>
            <th scope="col" class="text-center">Sửa</th>
        </tr>
        </thead>

        <tbody>
        @foreach($list_category as $key => $value)
            <tr>
                <th scope="row">{{ ++$key  }}</th>
                <td>{{ $value['cate_name'] }}</td>
                <td>{{ date("d-m-Y",$value['created_at']) }}</td>
                <td class="text-center">
                    <input type="checkbox">
                </td>
                <td class="text-center">
                    <a href="{{ route('admin.category.edit',$value['id']) }}"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $list_category->links() }}
</div>
@include('admin.includes.footer')
