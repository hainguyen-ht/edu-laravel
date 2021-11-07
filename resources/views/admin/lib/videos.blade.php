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
    .lib-images{
        margin: 20px 5px 10px 5px;
        border: 2px solid #d5d4d4;
        padding: 10px;
    }
    .lib-image-item{
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        box-shadow: 0 1px 2px rgb(0 0 0 / 8%);
        max-width: 100%;
        height: auto;
        margin: 0 10px 10px 10px;
    }
    .lib-images img {
        padding-bottom: 10px;
        display: block;
        max-width: 100%;
        max-height: 120px;
        width: auto;
        height: auto;
        margin-right: auto;
        margin-left: auto;
        margin-top: 5px;
    }

</style>
<div class="main">
    <div class="main__control">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadImages">
            Nhúng video
        </button>
    </div>
    <div class="row lib-images">
        @foreach($videos as $video)
            <div class="col-2 lib-image-item">
                <p class="text-center" data-img="{{ $video->link }}" onclick="copy_text_fun(this)">Sao chép link</p>
                <iframe src="{{ $video->link }}"></iframe>
            </div>
        @endforeach
    </div>
</div>
<div class="modal fade" id="uploadImages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tải ảnh lên</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @csrf
            <div class="modal-body">
                <div class="form-group">
                    <label>Tiêu đề:</label>
                    <input class="form-control" type="text" id="title">
                    <span class="text-error1" style="color: red; font-style: italic"></span>
                </div>
                <div class="form-group">
                    <label>Đường dẫn nhúng:</label>
                    <input class="form-control" type="text" id="url_video">
                    <span class="text-error2" style="color: red; font-style: italic"></span>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" onclick="save_embed()">Lưu</button>
            </div>
        </div>
    </div>
</div>
@include('admin.includes.footer')
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    function copy_text_fun(elm) {
        var copyText = $(elm).data("img");
        var textArea = document.createElement( "textarea" );
        textArea.value = copyText;
        document.body.appendChild( textArea );
        textArea.select();
        document.execCommand('copy');
        alert("Sao chép thành công!");
        textArea.remove();
    }
    function save_embed(){
        var title = $('#title').val();
        var url = $("#url_video").val();
        var _token = $("input[name=_token]").val();
        if($.trim(title) == ''){
            $(".text-error1").html("Vui lòng nhập tiêu đề!");
            return false;
        }else if($.trim(url) == ''){
            $(".text-error1").html('');
            $(".text-error2").html("Vui lòng nhập đường dẫn video!");
            return false;
        }else{
            $(".text-error2").html('');
            var data = new FormData;
            data.append('title', title);
            data.append('url', url);
            data.append('_token',_token);
            $.ajax({
                url: '{{ route("ajax.admin.lib.videos") }}',
                type: 'POST',
                cache: false,
                contentType: false,
                processData: false,
                dataType: 'json',
                data: data,
                success: function(response){
                    if(response.status == 1){
                        alert('Lưu thành công!');
                    }else{
                        alert('Lưu thất bại! Vui lòng thử lại');
                    }
                    location.reload();
                },
                error: function(xhr){
                    alert('Error');
                }
            });
        }

    }
    $(document).on("click", "#imageUpload", function (){
        $(".text-error").html("");
    });

</script>
