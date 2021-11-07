<style>
    .course__item__content-members .fa-users{
        margin-right: 6px;
    }
</style>
<div class="course__list">
    @foreach ($course as $key => $value)
        <div class="course__item col-4 grid">
            <div class="course__item__img">
                <a href="{{ route('detail',$value['c_id']) }}" title="{{ $value['c_name'] }}">
                    <img class="course__img {{ ($check_page != 'index') ? 'page__index' : '' }}" height="255" src="{{ asset('/uploads/'.$value['c_image']) }}">
                </a>
            </div>
            <div class="course__item__content">
                <h3><a href="{{ route('detail',$value['c_id']) }}" title="{{ $value['c_name'] }}">
                        {{ $value['c_name'] }}
                    </a></h3>
                <p class="course__item__content-des">
                    {{ $value['c_description'] }}
                </p>
                <ul class="course__item__content-group">
                    <li class="course__item__content-auth">
                        <a class="auth__course" href="">
                            <img class="course__item__content-avt" src="{{  asset('frontend/img/icons/SkSoEQL3_400x400.jpg')}}">
                            <p class="course__item__content-name">admin</p>
                        </a>
                    </li>
                    <li class="course__item__content-members">
                        <i class="fas fa-users"></i>{{ countUserCourse('course_id', $value['c_id']) }}
                    </li>
                    <li class="course__item__content-btn">
                        <a href="{{ route('detail',$value['c_id']) }}">{!! convertCoin($value['c_coin']) !!}</a>
                    </li>
                </ul>
            </div>
        </div>
    @endforeach
</div>
