

    <div class="content">
        <ul>
            @foreach($list as $k=>$v)
                <li>
                    {{ $v['order_id']  }} >> {{$v['order_sn']}} >> {{$v['order_amount']}} >> {{date("Y-m-d H:i:s",$v['create_time'])}}
                    <a target="_blank" href="/pay/weixin?order_id={{$v['order_id']}}"> 微信支付 </a>
                    <br>
                </li>
            @endforeach
        </ul>
    </div>
