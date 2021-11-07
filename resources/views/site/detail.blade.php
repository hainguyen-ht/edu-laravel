@extends('site.layouts')
@section('main')
<style>
    .row__coin{
        color: red;
    }
</style>
<div class="container detail__main">
    <div class="app__container container__course m-w mg-at">
        <div class="course__detail col-8 grid">
            <ul class="course__navbar">
                <li><a href="{{ route('course') }}">Khoá học</a></li>
                <li><i class="fas fa-arrow-right"></i></li>
                <li><span>{{ $course['cate_name'] }}</span></li>
            </ul>
            <h1>{{ $course['c_name'] }}</h1>
            <p>{{ $course['c_description'] }}</p>
            <h3>Bạn sẽ học được gì?</h3>
            <ul class="course__qa">
                @foreach (explode("|", $course['c_will_learn']) as $value)
                <li class="col-6">
                    <i class="fas fa-check"></i>
                    {{ $value }}
                </li>
                @endforeach
            </ul>

            <h3>Nội dung khoá học</h3>
            <div class="content-detail">
                <span>Số bài học: <span id="sum_videos">1 bài</span></span>
                <span style="display: none">Thời lượng: <span id="sum_durations">12 giờ 40 phút</span></span>
            </div>
            <ul class="course__qa">
                <?php
                    $sum_videos = 0;
                    $sum_durations = 0;
                    $videos = getListVideos($course['c_content']);
                ?>
                    @if(count($videos) == 0)
                        <p style="margin: auto">Chưa có bài học nào!</p>
                    @else
                        @foreach($videos as $key => $value)
                            <li class="v-item">
                                <div><i class="fa fa-play-circle"></i>
                                    @if($user_course)
                                    <a href="{{ route('learning',[$course['c_id'],$value['id']])  }}" class="text-light">
                                        {{ $value['title'] }}
                                    </a>
                                    @else
                                        <a class="text-light">
                                            {{ $value['title'] }}
                                        </a>
                                    @endif
                                </div>
{{--                                <div>{{ date("H:i:s", $value['durations']) }}</div>--}}
                            </li>
                            <?php
                                $sum_videos ++;
                                $sum_durations += $value['durations'];
                            ?>
                        @endforeach
                    @endif
            </ul>

            <h3>Yêu cầu</h3>
            <ul class="course__qa">
                <?php
                    $array = explode("|", $course['c_want']);
                ?>
                @foreach($array as $value)
                <li class="col-12">
                    <i class="fas fa-check"></i>
                    {{ $value }}
                </li>
                @endforeach
            </ul>

            <h3>Đánh giá của học viên</h3>
            <p class="v-margin"></p>
            <div class="c-star-5">
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="vote-process"></i>
                <span>100</span>
            </div>
            <div class="c-star-5">
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-none"></i>
                <i class="vote-process"></i>
                <span>100</span>
            </div>
            <div class="c-star-5">
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-none"></i>
                <i class="fas fa-star star-none"></i>
                <i class="vote-process"></i>
                <span>100</span>
            </div>
            <div class="c-star-5">
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-none"></i>
                <i class="fas fa-star star-none"></i>
                <i class="fas fa-star star-none"></i>
                <i class="vote-process"></i>
                <span>100</span>
            </div>
            <div class="c-star-5">
                <i class="fas fa-star star-yellow"></i>
                <i class="fas fa-star star-none"></i>
                <i class="fas fa-star star-none"></i>
                <i class="fas fa-star star-none"></i>
                <i class="fas fa-star star-none"></i>
                <i class="vote-process"></i>
                <span>100</span>
            </div>
        </div>
        <div class="course__info col-4 grid">
            <div class="course__info__main">
                <img src="{{ asset('/uploads/'.$course['c_image']) }}">
                <h1>{{ convertCoin($course['c_coin']) }}</h1>
                @if($user_course)
                    <a class="btn fixed__fullw cv__elm">Đã đăng ký</a>
                @else
                    <a class="btn fixed__fullw" id="reg-course">Đăng ký học</a>
                @endif
                <ul>
                    <li>
                        <i class="fas fa-tachometer-alt"></i>
                        Trình độ cơ bản</li>
                    <li>
                        <i class="fas fa-film"></i>
                        Tổng số 113 bài học</li>
                    <li>
                        <i class="fas fa-clock"></i>
                        Cần 55.25 giờ để học</li>
                    <li>
                        <i class="fas fa-battery-full"></i>
                        Học mọi lúc, mọi nơi</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@if(Auth::check())
    <input type="hidden" name="user_id" value="{{ Auth::id() }}">
    @csrf
@else
    <input type="hidden" name="user_id" value="">
@endif
<script src="{{asset('frontend/js/jquery-3.6.0.min.js')}}"></script>
<script>
    let sum_videos          = document.getElementById('sum_videos');
    let sum_durations       = document.getElementById('sum_durations');
    sum_videos.innerHTML    = '<?php echo $sum_videos ?>' + ' bài';
    sum_durations.innerHTML = '<?php echo date("H:i:s",$sum_durations) ?>' + ' phút';

    $(document).ready(function (){
       $('#reg-course').click(function (){
          var user_id = $('input[name=user_id]').val();
          if(user_id == ''){
              location.href = '{{ route('login') }}';
          }else{
              var course_id = '{{ $course['c_id'] }}';
              var _token = $('input[name=_token]').val();
              var data = new FormData();

              data.append('user_id', user_id);
              data.append('course_id', course_id);
              data.append('_token', _token);
              $.ajax({
                  url: '{{ route('ajax.user.course') }}',
                  type: 'POST',
                  data: data,
                  dataType: 'json',
                  processData: false,
                  contentType: false,
                  success: function (response) {
                      if(response.status == 1){
                          alert('Đăng ký thành công!');
                          location.reload();
                      }else if(response.status == 2){
                          alert('Bạn đã đăng ký khoá học này rồi!');
                          location.reload();
                      }else{
                          alert('Số coin trong ví không đủ!');
                      }
                  },
                  error: function (xhr){
                      alert('Error');
                  }
              });
          }
       });
    });
</script>
@endsection
