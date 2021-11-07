<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="robots" content="noindex,nofollow" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="{{asset('frontend/css/index.css')}}">
    <link rel="stylesheet" href="{{asset('frontend/css/learning_css.css')}}">
    <title>{{ $title_page }}</title>
</head>
<style>
    .show_nav_learning{
        position: fixed;
        top: 135px;
        right: 20px;
        display:  none;
        cursor:  pointer;
        color:  blue;
    }
    .show_nav_learning:hover{
        color: darkgrey;
    }
</style>
<body>
    <div class="c-m-learning">
        <div class="header-learning">
            <div class="header-learning__logo">
                <i style="cursor: pointer;" class="fa fa-angle-left" id="to_back"></i>
                <img id="to_home" style="cursor: pointer;" src="{{asset('frontend/img/logo.png')}}">&emsp;|&emsp;
                <span class="header-learning__title">{{ $course['c_name'] }}</span>
            </div>
            <div class="header-learning__help">Hướng dẫn</div>
        </div>
        <div class="main-learning">
            <div class="vmain">
                <div class="content__frame">
                    <iframe id="emmed-video" width="560" height="315"
                            src="{{ $video['link'] }}"
                            title="YouTube video player"
                            frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen>
                    </iframe>
                </div>

                <div class="content-learning">
                    <div class="tab">
                      <button class="tablinks" onclick="openTab(event, 'tongquan')" id="tab__default">Tổng quan</button>
                      <button class="tablinks" onclick="openTab(event, 'ghichu')">Ghi chú</button>
                      <button class="tablinks" onclick="openTab(event, 'lienquan')">Liên quan</button>
                      <button class="tablinks" onclick="openTab(event, 'danhgia')">Đánh giá</button>
                    </div>

                    <div id="tongquan" class="tabcontent">
                      <div class="main__comment">
                          <div class="comment__header">
                              <h3>100 Hỏi đáp</h3>
                              <ul class="social">
                                  <li>Chia sẻ</li>
                                  <li class="fb">
                                      <a href=""><i class="fab fa-facebook"></i></a>
                                  </li>
                                  <li class="email">
                                      <a href=""><i class="fas fa-envelope"></i></a>
                                  </li>
                                  <li class="link">
                                      <a href=""><i class="fas fa-link"></i></a>
                                  </li>
                              </ul>
                          </div>
                          <div class="post__comment">
                              <form method="post" onsubmit="comment(); return false">
                              <div class="user_comment">
                                  <img
                                      style="border-radius: 50%"
                                      onerror="this.onerror=null;this.src='{{ asset('images/user-avt.png') }}'"
                                      src="{{ getAvatarUser(Auth::id()) }}" alt="">
                                  <div class="comment__control">
                                      @csrf
                                      <input type="text" class="form__comment comment__item" placeholder="Bạn có thắc mắc gì?">
                                      <button type="submit" onclick="comment()" class="comment__item btn action__comment">Bình luận</button>
                                  </div>
                              </div>
                              </form>
                          </div>

                          <div class="all__comment">
                              @foreach($comments as $key => $value)
                              <div class="comment">
                                  <img
                                      style="border-radius: 50%"
                                      onerror="this.onerror=null;this.src='{{ asset('images/user-avt.png') }}'"
                                      src="{{ getAvatarUser($value['user_id']) }}" alt="">
                                  <div class="container__comment">
                                      <div class="container__comment-content">
                                          <h6 class="cm_name">{{ $value['name'] }}</h6>
                                          <p class="cm_content">{{ $value['content'] }}</p>
                                      </div>
                                      <div class="container__comment-control">
                                          <span class="cm_like">Thích</span>
                                          <span class="cm_reply">Trả lời</span>
                                          <span class="cm_time">{{ timeComment($value['created_at']) }} trước</span>
                                      </div>
                                  </div>
                              </div>
                              @endforeach
                          </div>
                      </div>
                    </div>
                    <div id="ghichu" class="tabcontent">
                      <h3>Ghi chú</h3>
                      <p>Chưa có ghi chú.</p>
                    </div>
                    <div id="lienquan" class="tabcontent">
                      <h3>Liên quan</h3>
                      <p>Chưa có liên quan.</p>
                    </div>
                    <div id="danhgia" class="tabcontent">
                      <h3>Đánh giá</h3>
                      <p>Chưa có đánh giá.</p>
                    </div>
                </div>
            </div>

        </div>
        <div class="nav-learning">
            <ul class="nav-l-course">
                <li class="v-item v-title">
                    <div>
                        {{ $course['c_name'] }}
                    </div>
                    <div class="hide-nav-course" onclick="click_nav()"><i class="fas fa-angle-double-right"></i></div>
                </li>
                <?php
                    foreach ($list_video as $key => $value) {
                ?>
                <li class="v-item detail-item">
                    <div><i class="fa fa-play-circle"></i>
                        <a href="{{ route('learning', [$course['c_id'], $value['id']]) }}" class="text-light">
                            {{ $value['title'] }}
                        </a>
                    </div>
                    <div><?= date("H:i:s",$value['durations']) ?></div>
                </li>
                <?php } ?>
            </ul>
        </div>
        <div class="show_nav_learning" onclick="click_show_nav()"><i class="fas fa-angle-double-left"></i></div>
    </div>
</body>
<script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
<script>
    $(document).ready(function (){
        $('#tab__default').addClass('active');
        $('#tongquan').css('display','block');
        $('.cm_like').click(function (){
            if($(this).hasClass('active__control')){
                $(this).removeClass('active__control');
            }else{
                $(this).addClass('active__control');
            }
        });
        $('.cm_reply').click(function (){
            if($(this).hasClass('active__control')){
                $(this).removeClass('active__control');
            }else{
                $(this).addClass('active__control');
            }
        });
    });
    function comment(){
        event.preventDefault();
        var comment     = $('.form__comment').val();
        var user_id     = '{{ Auth::id() }}';
        var video_id    = '{{ $video['id'] }}';
        var _token      = $('input[name=_token]').val();
        var data        = new FormData();

        if($.trim(comment) == ''){
            $('.form__comment').focus();
            return false;
        }

        data.append('user_id', user_id);
        data.append('video_id', video_id);
        data.append('comment', comment);
        data.append('_token', _token);

        var html =
            `<div class="comment">
                <img style="border-radius:50%" src="{{ getAvatarUser(Auth::id()) }}" onerror="this.onerror=null;this.src='{{ asset('images/user-avt.png') }}'" alt="">
                <div class="container__comment">
                    <div class="container__comment-content">
                        <h6 class="cm_name">{{ Auth::user()->name }}</h6>
                        <p class="cm_content">`+comment+`</p>
                    </div>
                    <div class="container__comment-control">
                        <span class="cm_like">Thích</span>
                        <span class="cm_reply">Trả lời</span>
                        <span class="cm_time">vài giây trước</span>
                    </div>
                </div>
            </div>`;
        $('.all__comment').prepend(html);
        $.ajax({
            url: '{{ route('ajax.user.comment') }}',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            dataType: 'json',
            enctype: 'multipart/form-data',
            success: function (response) {
                if(response.status == 1){
                    $('.form__comment').focus();
                    $('.form__comment').val('');
                }else{
                    console.log(response.message);
                    location.reload();
                }
            },
            error: function (xhr){
                alert('Error');
            }
        });
    }
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
<script>
    let to_home = document.getElementById('to_home');
    let to_back = document.getElementById('to_back');
    to_home.onclick = function(){
        location.href = "{{ route('index') }}";
    }
    to_back.onclick = function(){
        location.href = "{{ route('detail',$course['c_id']) }}";
    }
    function click_nav(){
        $('.vmain').css('width', '100%');
        $('.nav-learning').css('display', 'none');
        $('.show_nav_learning').css('display', 'block');
    }
    function click_show_nav(){
        $('.vmain').css('width', '75%');
        $('.nav-learning').css('display', 'block');
        $('.show_nav_learning').css('display', 'none');
    }
    let path = location.pathname;
    let arr_path = path.split("/");
    let v_id = arr_path[arr_path.length - 1];
    let c_id = arr_path[arr_path.length - 2];
    let re_video = document.getElementById('emmed-video');

</script>
</html>
