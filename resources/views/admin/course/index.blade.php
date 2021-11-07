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
    .h_import label,
    .h_export label{
        cursor: pointer;
        /* Style as you please, it will become the visible UI component. */
    }

    #import, #export {
        opacity: 0;
        position: absolute;
        z-index: -1;
    }
    .group__ie{
        display: flex;
    }
    .h_export{
        margin-left: 20px;
    }
</style>
<div class="main">
    <div class="main__control">

        <div class="main__control-search">
            <form action="{{ route('admin.course.index') }}" method="GET">
                <input value="{{ $keyword }}" type="text" name="keyword" class="input__search" placeholder="Tìm kiếm theo tên khoá học, danh mục...">
                <img class="img__search" src="icons/search.png" alt="">
            </form>
        </div>
        <div class="main__control-new">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadImages">
                Thêm từ CSV
            </button>
            <a href="{{ route('admin.course.create')  }}" class="btn__new">+ Thêm mới</a>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên khoá học</th>
            <th scope="col">Ảnh mô tả</th>
            <th scope="col">Học phí</th>
            <th scope="col">Danh mục</th>
            <th scope="col">Ngày đăng</th>
            <th scope="col" class="text-center">Sửa</th>
        </tr>
        </thead>
        <tbody>
        @foreach($list_course as $key => $value)
            <tr>
                <th scope="row">{{ ++$key  }}</th>
                <td>{{ $value['c_name'] }}</td>
                <td>
                    <img class="load__img" src="{{ asset('/uploads/'.$value['c_image']) }}">
                </td>
                <td>{{ $value['c_coin'] }}  <i class='fas fa-coins row__coin'></i></td>
                <td>{{ $value['cate_name'] }}</td>
                <td>{{ date("d-m-Y",$value['created_at']) }}</td>
                <td class="text-center">
                    <a href="{{ route('admin.course.edit',$value['c_id']) }}"><i class="fa fa-edit"></i></a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $list_course->links() }}
</div>
<div class="modal fade" id="uploadImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm khoá học bằng file csv</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                <input type="file" name="images" id="fileImport">
                <span class="text-error" style="color: red; font-style: italic"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="importcsv()">Lưu</button>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    function importcsv(){
        var file = $('#fileImport')[0].files[0];
        if(file == undefined){
            $(".text-error").html("Vui lòng chọn file csv");
            return false
        }else{
            var _token = $("input[name=_token]").val();
            var data = new FormData;
            data.append('file', file);
            data.append('_token',_token);
            $.ajax({
                url: '{{ route("ajax.course.import") }}',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: data,
                success: function(response){
                    if(response.status == 1){
                        alert('Thêm khoá học thành công!');
                    }else{
                        alert('Thêm khoá học thất bại!');
                    }
                    location.reload();
                },
                error: function(xhr){
                    alert('Error');
                }
            });
        }
    }
    $(document).on("click", "#fileImport", function (){
        $(".text-error").html("");
    });
</script>
