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
    @if($category != '')
        <input class="category_id" type="hidden" value="{{ $category['id'] }}">
    @endif
    <div class="row">
        <div class="form-group col-5">
            <label>Tên danh mục<span class="text-red">* <span class="error-1"></span></span></label>
            <input type="text" class="form-control name" placeholder="Nhập tên danh mục..." value="{{ $category['cate_name'] ?? '' }}">
        </div>
    </div>
    <button class="btn btn-primary" onclick="{{ ($category != '') ? 'edit_category_ajax()' : 'create_category_ajax()' }}">Submit</button>

</div>
@include('admin.includes.footer')
<script src="{{asset('js/function.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    var base_url = '<?php echo URL::to('/');?>';
    function create_category_ajax(){
        var name        = $('.name').val();
        var _token      = $('input[name=_token]').val();

        if($.trim(name) == ''){
            $(".error-1").html("Tên danh mục không được để trống!");
            return false;
        }else{
            $(".error-1").remove();
        } $(".error-2").remove();

        var data = new FormData();
        data.append('name', name);
        data.append('_token', _token);

        $.ajax({
            url: base_url + '/ajax/admin/category/create',
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
    function edit_category_ajax(){
        var id          = $('.category_id').val();
        var name        = $('.name').val();
        var _token      = $('input[name=_token]').val();

        if($.trim(name) == ''){
            $(".error-1").html("Tên danh mục không được để trống!");
            return false;
        }else{
            $(".error-1").remove();
        }

        var data = new FormData();
        data.append('id', id);
        data.append('name', name);
        data.append('_token', _token);

        $.ajax({
            url: base_url + '/ajax/admin/category/edit',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function(response){
                if(response.status == 1){
                    alert('Cập nhật thành công!');
                    location.href = '{{ route('admin.category.index') }}';
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
