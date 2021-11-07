@extends('site.layouts')
@section('main')
<style>
    .count__count{
        font-size: 16px;
    }
</style>
<div class="container">
    <div class="app__container container__course m-w mg-at">
        <div class="category grid">
            @foreach($category as $key => $value)
            <div class="category__list">
                <h6 class="category__list-title">{{ $value['cate_name'] }}</h6>
                <ul class="category__list-item">
                    @if(count(getCourseByCate($value['id'])) == 0)
                        <span class="count__count">Chưa có khoá học nào</span>
                    @else
                        @foreach(getCourseByCate($value['id']) as $i => $j)
                            <li><a href="{{route('detail',$j['c_id'])}}" class="i-c-{{ $j['c_id'] }}" title="{{$j['c_name']}}">
                                    {{ $j['c_name'] }}
                                </a></li>
                        @endforeach
                    @endif

                </ul>
            </div>
            @endforeach
        </div>
        <div class="main">
            <ul class="course__menu">
                <li class="course__menu__item">
                    <a href="">Theo lộ trình</a>
                </li>
                <li class="course__menu__item">
                    <a href="">Mới nhất</a>
                </li>
            </ul>
            @include('layouts.item-course')
        </div>
    </div>
</div>
@endsection
