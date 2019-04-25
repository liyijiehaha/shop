
        <ul>
            @foreach ($goods_list as $k=>$v)
            <li>{{$v['goods_name']}} - {{$v['self_price']}}</li>
            @endforeach
        </ul>
        <hr>
        总价：¥{{$total}}<br>
        <form action="/order/create" method="get">
            <input type="submit" value="提交订单">
        </form>

