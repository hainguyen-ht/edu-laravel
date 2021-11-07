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
</style>
<div class="main">
    <div class="main__control">
        <div class="main__control-search">
            <form action="{{ route('admin.manager.recharge') }}" method="GET">
                <input value="{{ $keyword }}" type="text" name="keyword" class="input__search" placeholder="Tìm kiếm theo tên học viên, email...">
                <img class="img__search" src="icons/search.png" alt="">
            </form>
        </div>
    </div>
    <table class="table table-striped text-center">
        <thead>
        <tr>
            <th scope="col">STT</th>
            <th scope="col">Tên học viên</th>
            <th scope="col">Email</th>
            <th scope="col">Số tiền nạp</th>
            <th scope="col">Thời gian chuyển</th>
            <th scope="col">Trạng thái</th>
            <th scope="col">Xác nhận</th>
        </tr>
        </thead>
        <tbody>
        @csrf
        @foreach($recharge as $key => $value)
            <tr>
                <td>{{ ++$key }}</td>
                <td>{{ $value['name'] }}</td>
                <td>{{ $value['email'] }}</td>
                <td>{{ number_format(filterPrice($value['content'])) }}</td>
                <td>{{ convertDate($value['created_at']) }}</td>
                <td class="font-italic">{{ ($value['status'] == 0) ? 'Chưa nhận được' : 'Đã nhận' }}</td>
                <td>
                @if($value['type'] == 1)
                    <input type="checkbox" disabled checked>
                @else
                    <input data-userid="{{ $value['sender'] }}"
                           data-notifyid="{{ $value['id'] }}"
                           data-price="{{ filterPrice($value['content']) }}"
                           type="checkbox"
                           onclick="confirm_recharge(this)">
                @endif
                </td>
            </tr>
        @endforeach

        </tbody>
    </table>
    {{ $recharge->links() }}
</div>
@include('admin.includes.footer')
<script>
    function confirm_recharge(elm){
        if(confirm('Xác nhận cộng tiền cho học viên này chứ?')){
            var user_id = elm.dataset.userid;
            var notify_id = elm.dataset.notifyid;
            var price = elm.dataset.price;
            var _token = $('input[name=_token]').val();
            var data = new FormData();

            data.append('user_id', user_id);
            data.append('notify_id', notify_id);
            data.append('price', price);
            data.append('_token', _token);

            $.ajax({
                url: '{{ route('ajax.admin.manager.recharge') }}',
                data: data,
                contentType: false,
                dataType: 'JSON',
                processData: false,
                type: 'POST',
                success: function (response) {
                    if(response.status == 1){
                        alert('Xác nhận thành công!');
                        location.reload();
                    }else{
                        alert('Xác nhận thất bại!');
                        location.reload();
                    }
                },
                error: function (xhr) {
                    alert('Error');
                }
            });
        }else{
            event.preventDefault();
        }
    }
</script>
