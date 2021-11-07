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
    .group__img{
        display: flex;
        flex-direction: column;
    }
</style>
<div class="main">
    @csrf

    @if($course != '')
        <input class="course_id" type="hidden" value="{{ $course['c_id'] }}">
    @endif
    <h4>Thông tin khoá học:</h4>
    <div class="row">
        <div class="form-group col-6">
            <label>Tên khoá học <span class="text-red">* <span class="error-1"></span></span></label>
            <input type="text" class="form-control name" placeholder="Nhập tên khoá học..." value="{{ $course['c_name'] ?? '' }}">
        </div>
        <div class="form-group col-6">
            <label>Danh mục  <span class="text-red">* <span class="error-2"></span></span></label>
            <select class="custom-select category">
                <option selected>Chọn danh mục</option>
                @foreach($category as $key => $value)
                <option value="{{ $value['id'] }}" {{ ($course != '' && $course['cate_id'] == $value['id']) ? 'selected' : '' }}>
                    {{ $value['cate_name'] }}
                </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-6">
            <label>Người đứng lớp <span class="text-red">* <span class="error-3"></span></span></label>
            <input type="text" class="form-control author" placeholder="Nhập tên giáo viên..." value="{{ $course['c_author'] ?? 'Hải Nguyễn' }}" disabled>
        </div>
        <div class="form-group col-6">
            <label>Học phí <span class="text-red">* <span class="error-4"></span></span></label>
            <input type="number" class="form-control coin" placeholder="Nhập học phí..." value="{{ $course['c_coin'] ?? '' }}">
        </div>
    </div>
    <h4>Nội dung bài học:</h4>
    <div class="course__content">
        @if($course == '')
        <div class="row">
            <div class="form-group col-6">
                <label>Tên bài học <span class="text-red">* <span class="error-5"></span></span></label>
                <input required type="text" class="form-control" name="title" placeholder="Nhập tên bài học..." value="{{ $course['name'] ?? '' }}">
            </div>
            <div class="form-group col-6">
                <label>Thời lượng ( giây ) <span class="text-red">* <span class="error-6"></span></span></label>
                <input required type="number" class="form-control" name="durations" placeholder="Nhập thời lượng video..." value="{{ $course['name'] ?? '' }}">
            </div>
            <div class="form-group col-6">
                <label>Link bài học <span class="text-red">* <span class="error-7"></span></span></label>
                <input required type="text" class="form-control" name="link" placeholder="Nhập link video bài học..." value="{{ $course['name'] ?? '' }}">
            </div>
        </div>
        @else
            @foreach(getListVideos($course['c_content']) as $key => $value)
            <div class="row">
                <input type="hidden" class="list_video" value="{{ $value['id'] }}">
                <div class="form-group col-6">
                    <label>Tên bài học {{ ++$key }} <span class="text-red">* <span class="error-5"></span></span></label>
                    <input required type="text" class="form-control" name="title" placeholder="Nhập tên bài học..." value="{{ $value['title'] }}">
                </div>
                <div class="form-group col-6">
                    <label>Thời lượng ( giây ) <span class="text-red">* <span class="error-6"></span></span></label>
                    <input required type="number" class="form-control" name="durations" placeholder="Nhập thời lượng video..." value="{{ $value['durations'] }}">
                </div>
                <div class="form-group col-6">
                    <label>Link bài học {{ $key }}<span class="text-red">* <span class="error-7"></span></span></label>
                    <input required type="text" class="form-control" name="link" placeholder="Nhập link video bài học..." value="{{ $value['link'] }}">
                </div>
            </div>
            @endforeach
        @endif
    </div>

    <div class="row">
        <div class="form-group col-10 text-right">
            <button type="button" onclick="{{ ($course == '') ? 'btn_append()' : 'btn_append2()' }}" class="btn btn-info">+ Thêm bài học</button>
        </div>
    </div>
    @if($course == '')
        <div class="row">
            <div class="form-group col-10 group__img">
                <label>Ảnh mô tả <span class="text-red">* <span class="error-8"></span></span></label>
                <input type="file" class="image">
            </div>
        </div>
    @endif
    <div class="row">
        <div class="form-group col-10">
            <label>Mô tả ngắn  <span class="text-red">* <span class="error-9"></span></span></label>
            <textarea class="form-control descriptions" rows="3">{{ $course['c_description'] ?? '' }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-10">
            <label>Bạn sẽ học được gì? ( cách đoạn bằng dấu | )<span class="text-red">* <span class="error-10"></span></span></label>
            <textarea class="form-control will-learn" rows="3">{{ $course['c_will_learn'] ?? '' }}</textarea>
        </div>
    </div>
    <div class="row">
        <div class="form-group col-10">
            <label>Yêu cầu đối với học viên ( cách đoạn bằng dấu | ) <span class="text-red">* <span class="error-11"></span></span></label>
            <textarea class="form-control want" rows="3">{{ $course['c_want'] ?? '' }}</textarea>
        </div>
    </div>

    <div class="row">
        <div class="text-center col-10">
            <button class="btn btn-primary" onclick="{{ ($course != '') ? 'edit_course_ajax()' : 'create_course_ajax()' }}">Submit</button>
        </div>
    </div>

</div>
@include('admin.includes.footer')
<script src="{{asset('js/function.js')}}"></script>
<script src="{{asset('js/bootstrap.min.js')}}"></script>
<script>
    var base_url = '<?php echo URL::to('/');?>';
    var click = 0;
    var count = 1;
    function btn_append(){
        click++;
        count++;
        var html = `
            <div class="row">
                <div class="form-group col-6">
                    <label>Tên bài học `+ count +`<span class="text-red">* </span></label>
                    <input required type="text" class="form-control" name="title" placeholder="Nhập tên bài học..." value="{{ $course['name'] ?? '' }}">
                </div>
                <div class="form-group col-6">
                    <label>Thời lượng ( giây ) <span class="text-red">* </span></label>
                    <input required type="number" class="form-control" name="durations" placeholder="Nhập thời lượng video..." value="{{ $course['name'] ?? '' }}">
                </div>
                <div class="form-group col-6">
                    <label>Link bài học `+ count +`<span class="text-red">* </span></label>
                    <input required type="text" class="form-control" name="link" placeholder="Nhập link video bài học..." value="{{ $course['name'] ?? '' }}">
                </div>
            </div>`;
        $('.course__content').append(html);
    }
    function btn_append2(){
        var child = $('.course__content').children().length;
        child++;
        var html = `
            <div class="row">
                <input type="hidden" class="list_video" value="null">
                <div class="form-group col-6">
                    <label>Tên bài học `+ child +`<span class="text-red">* </span></label>
                    <input required type="text" class="form-control" name="title" placeholder="Nhập tên bài học..." value="{{ $course['name'] ?? '' }}">
                </div>
                <div class="form-group col-6">
                    <label>Thời lượng ( giây ) <span class="text-red">* </span></label>
                    <input required type="number" class="form-control" name="durations" placeholder="Nhập thời lượng video..." value="{{ $course['name'] ?? '' }}">
                </div>
                <div class="form-group col-6">
                    <label>Link bài học `+ child +`<span class="text-red">* </span></label>
                    <input required type="text" class="form-control" name="link" placeholder="Nhập link video bài học..." value="{{ $course['name'] ?? '' }}">
                </div>
            </div>`;
        $('.course__content').append(html);
    }
    function create_course_ajax(){
        var name       = $('.name').val();
        var category   = $('.category').val();
        var author     = $('.author').val();
        var coin       = $('.coin').val();
        var des        = $('.descriptions').val();
        var will       = $('.will-learn').val();
        var want       = $('.want').val();
        var title      = [];
        var durations  = [];
        var link       = [];
        var image 	   = $('.image')[0].files[0];
        var _token          = $('input[name=_token]').val();


        $("input[name='title']").each(function(){
            title.push($(this).val());
        });
        $("input[name='durations']").each(function(){
            durations.push($(this).val());
        });
        $("input[name='link']").each(function(){
            link.push($(this).val());
        });

        //validate
        if($.trim(name) == ''){
            $('.error-1').html('Tên khoá học không được bỏ trống!');
            return false;
        }else{
            $('.error-1').remove();
        }
        if($.trim(category) == '' || $.trim(category) == 'Chọn danh mục'){
            $('.error-2').html('Vui lòng chọn danh mục cho khoá học!');
            return false;
        }else{
            $('.error-2').remove();
        }
        if($.trim(author) == ''){
            $('.error-3').html('Người đứng lớp không được bỏ trống!');
            return false;
        }else{
            $('.error-3').remove();
        }
        if($.trim(coin) == ''){
            $('.error-4').html('Vui lòng chọn học phí cho khoá học!');
            return false;
        }else{
            $('.error-4').remove();
        }

        if(title[0] == ''){
            $('.error-5').html('Tên bài học không được bỏ trống!');
            return false;
        }else{
            $('.error-5').remove();
        }
        if(durations[0] == ''){
            $('.error-6').html('Nhập thời lượng video!');
            return false;
        }else{
            $('.error-6').remove();
        }
        if(link[0] == ''){
            $('.error-7').html('Link bài học không được bỏ trống!');
            return false;
        }else{
            $('.error-7').remove();
        }
        if(image == undefined){
            $('.error-8').html('Chưa chọn ảnh mô tả!');
            return false;
        }else{
            var extension = image.name.split('.').pop().toUpperCase();

            if(extension == 'PNG' || extension == 'JPG' || extension == 'GIF' || extension == 'JPEG'){
                $('.error-8').remove();
            }else{
                $('.error-8').html('Chỉ chấp nhận các định dạng ảnh: PNG, JPG, GIF, JPEG !');
                return false;
            }
        }
        if($.trim(des) == ''){
            $('.error-9').html('Mô tả ngắn không được bỏ trống!');
            return false;
        }else{
            $('.error-9').remove();
        }
        if($.trim(will) == ''){
            $('.error-10').html('Không được bỏ trống trường này!');
            return false;
        }else{
            $('.error-10').remove();
        }
        if($.trim(want) == ''){
            $('.error-11').html('Không được bỏ trống trường này!');
            return false;
        }else{
            $('.error-11').remove();
        }


        var data = new FormData();
        data.append('name', name);
        data.append('category', category);
        data.append('author', author);
        data.append('coin', coin);
        data.append('title', title);
        data.append('durations', durations);
        data.append('link', link);
        data.append('des', des);
        data.append('will', will);
        data.append('want', want);
        data.append('image', image);
        data.append('_token', _token);

        $.ajax({
            url: base_url + '/ajax/admin/course/create',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function(response){
                if(response.status == 1){
                    alert('Thêm mới thành công!');
                    // location.reload();
                }else{
                    alert(response.message);
                }
            },
            error: function(xhr){
                alert('Error');
            }
        })
    }
    function edit_course_ajax(){
        var id_course  = $('.course_id').val();
        var category   = $('.category').val();
        var coin       = $('.coin').val();
        var des        = $('.descriptions').val();
        var will       = $('.will-learn').val();
        var want       = $('.want').val();
        var title      = [];
        var durations  = [];
        var link       = [];
        var list_video = [];
        var _token          = $('input[name=_token]').val();

        $(".list_video").each(function(){
            list_video.push($(this).val());
        });$("input[name='title']").each(function(){
            title.push($(this).val());
        });
        $("input[name='durations']").each(function(){
            durations.push($(this).val());
        });
        $("input[name='link']").each(function(){
            link.push($(this).val());
        });
        //validate
        if($.trim(category) == '' || $.trim(category) == 'Chọn danh mục'){
            $('.error-2').html('Vui lòng chọn danh mục cho khoá học!');
            return false;
        }else{
            $('.error-2').remove();
        }
        if($.trim(coin) == ''){
            $('.error-4').html('Vui lòng chọn học phí cho khoá học!');
            return false;
        }else{
            $('.error-4').remove();
        }
        if(title[0] == ''){
            $('.error-5').html('Tên bài học không được bỏ trống!');
            return false;
        }else{
            $('.error-5').remove();
        }
        if(durations[0] == ''){
            $('.error-6').html('Nhập thời lượng video!');
            return false;
        }else{
            $('.error-6').remove();
        }
        if(link[0] == ''){
            $('.error-7').html('Link bài học không được bỏ trống!');
            return false;
        }else{
            $('.error-7').remove();
        }
        if($.trim(des) == ''){
            $('.error-9').html('Mô tả ngắn không được bỏ trống!');
            return false;
        }else{
            $('.error-9').remove();
        }
        if($.trim(will) == ''){
            $('.error-10').html('Không được bỏ trống trường này!');
            return false;
        }else{
            $('.error-10').remove();
        }
        if($.trim(want) == ''){
            $('.error-11').html('Không được bỏ trống trường này!');
            return false;
        }else{
            $('.error-11').remove();
        }
        var data = new FormData();
        data.append('id', id_course);
        data.append('category', category);
        data.append('coin', coin);
        data.append('title', title);
        data.append('list_video', list_video);
        data.append('durations', durations);
        data.append('link', link);
        data.append('des', des);
        data.append('will', will);
        data.append('want', want);
        data.append('_token', _token);

        $.ajax({
            url: base_url + '/ajax/admin/course/edit',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function(response){
                if(response.status == 1){
                    alert('Cập nhật thành công!');
                    location.href = '{{ route('admin.course.index') }}';
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
