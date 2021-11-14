@include('admin.includes.header')
@include('admin.includes.navbar')
<link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
<style>
    .pagination{
        justify-content: center;
    }
</style>
<div class="main">
    <div class="group__box">
        <div class="item__box col-4 mr-box">
            <p class="box__title">Học viên</p>
            <div class="box__des">
                <div class="box__des-item b__blue">
                    <span>Tổng số học viên</span>
                    <span class="box__des-num">{{ $user['all'] }}</span>
                </div>
                <div class="box__des-item b__green">
                    <span>Học viên trung bình mỗi ngày</span>
                    <span class="box__des-num">2</span>
                </div>
            </div>
        </div>
        <div class="item__box col-4 ml-box">
            <p class="box__title">Khoá học và Danh mục</p>
            <div class="box__des">
                <div class="box__des-item b__blue">
                    <span>Khoá học nổi bật</span>
                    <span class="box__des-num">10</span>
                </div>
                <div class="box__des-item b__green">
                    <span>Tất cả khoá học</span>
                    <span class="box__des-num">{{ $course['all'] }}</span>
                </div>
                <div class="box__des-item b__yellow">
                    <span>Tất cả danh mục</span>
                    <span class="box__des-num">{{ $category['all'] }}</span>
                </div>
            </div>
        </div>
        <div class="item__box col-4">
            <p class="box__title">Doanh Thu</p>
            <div class="box__des">
                <div class="box__des-item b__blue">
                    <span>Tổng doanh thu</span>
                    <span class="box__des-num">9.500.000</span>
                </div>
                <div class="box__des-item b__green">
                    <span>Doanh thu tháng cao nhất</span>
                    <span class="box__des-num">4.250.000</span>
                </div>
                <div class="box__des-item b__yellow">
                    <span>Doanh thu tuần này</span>
                    <span class="box__des-num">300.000</span>
                </div>
            </div>
        </div>
    </div>
    <h2 class="mt-3">Học viên tham gia</h2>
    <table class="table table-striped">
        <thead>
            <tr>
                <th scope="col">STT</th>
                <th scope="col">Tên khoá học</th>
                <th scope="col">Giá tiền</th>
                <th scope="col">Người tham gia</th>
                <th scope="col">Thời gian tham gia</th>
            </tr>
        </thead>
        <tbody>
        @foreach($user_course as $index => $item)
            <tr>
                <th scope="row">{{ ++$index }}</th>
                <td>{{ $item->c_name }}</td>
                <td>{{ $item->c_coin }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ date("d/m/Y",$item->created_at) }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    @csrf
    <p onclick="exportExcel()" style="cursor: pointer" class="text-primary">Xuất excel</p>
    {{ $user_course->links() }}
    <div class="overview">
        <div class="overview__heading">
            <p>Báo cáo doanh thu theo tuần</p>
            <select class="overview__select">
                <option>Theo tuần</option>
                <option>Theo tháng</option>
                <option>Theo năm</option>
            </select>
        </div>
        <div id="overview__container">

        </div>
    </div>
</div>
@include('admin.includes.footer');
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script src="https://code.highcharts.com/modules/accessibility.js"></script>
<script>
    Highcharts.chart('overview__container', {
        chart: {
            type: ''
        },
        exporting: {
            enabled: false
        },
        title: {
            text: ''
        },
        xAxis: {
            categories: ['T2', 'T3', 'T4','T5','T6','T7','CN']
        },
        yAxis: {
            title: {
                text: 'Triệu vnđ'
            }
        },
        tooltip: {
            formatter: function () {
                return `<p>Doanh thu </p><br />
							<b>400.000.000 </b> <br />
							<p>Ngày 13/01/2021</p>`;
            }
        },
        credits: {
            enabled: false
        },
        series: [{
            name: 'Doanh thu theo tuần',
            data: [111, 222, 333,444,222,666,155]
        }]

    });
    function exportExcel(){
        var urlParams = new URLSearchParams(window.location.search);
        var _token = $('input[name=_token]').val();
        var start = 0;
        var limit = 10;
        if(urlParams.has('page')){
            if(urlParams.get('page') > 1){
                start = (urlParams.get('page') - 1) * limit;
            }
        }
        var data = new FormData;
        data.append('start', start);
        data.append('limit', limit);
        data.append('_token', _token);

        $.ajax({
            url: '{{ route('ajax.course.export') }}',
            type: 'POST',
            cache: false,
            contentType: false,
            processData: false,
            dataType: 'json',
            data: data,
            success: function (response){
                if(response.status == 1){
                    alert('Export thành công!');
                }else{
                    alert('Export thất bại!');
                }
                location.reload();
            },
            error: function (xhr){
                console.log('error');
            }
        })
    }
</script>
</body>
</html>
