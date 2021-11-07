@include('admin.includes.header')
@include('admin.includes.navbar')
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
                    <span class="box__des-num">10</span>
                </div>
                <div class="box__des-item b__green">
                    <span>Tổng quan khách hàng</span>
                    <span class="box__des-num">10</span>
                </div>
                <div class="box__des-item b__yellow">
                    <span>Tổng quan khách hàng</span>
                    <span class="box__des-num">10</span>
                </div>
            </div>
        </div>
    </div>
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
</script>
</body>
</html>
