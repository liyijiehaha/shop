<?php

namespace App\Http\Controllers\Order;
use App\Model\CartModel;
use App\Model\OrderModel;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Model\OrderDetailModel;
class IndexController extends Controller
{

  //生成订单
    public function create()
    {
        //echo 'order_sn: '.OrderModel::generateOrderSN(Auth::id());die;
        //计算订单金额
        $goods_info= CartModel::where(['user_id'=>Auth::id(),'session_id'=>Session::getId()])->get()->toArray();
        //echo '<pre>';print_r($goods);echo '</pre>';die;
        $order_amount = 0;
        foreach($goods_info as $k=>$v){
            $order_amount += $v['self_price'];       //计算订单金额
        }
        $order_info = [
            'user_id'               => Auth::id(),
            'order_sn'          => OrderModel::generateOrderSN(Auth::id()),     //订单编号
            'order_amount'      => $order_amount,
            'create_time'          => time()
        ];
        $order_id = OrderModel::insertGetId($order_info);//写入订单表
        //订单详情
        foreach($goods_info as $k=>$v){
            $detail = [
                'order_id'           => $order_id,
                'goods_id'      => $v['goods_id'],
                'goods_name'    => $v['goods_name'],
                'self_price'   => $v['self_price'],
                'user_id'           => Auth::id()
            ];
            //写入订单详情表
            $res=OrderDetailModel::insertGetId($detail);
        }
        header('Refresh:3;url=/order/list');
        echo "生成订单成功";
    }
    /**
     * 订单列表页
     */
    public function List()
    {
        $list = OrderModel::where(['user_id'=>Auth::id()])->orderBy("order_id","desc")->get()->toArray();
        $data = [
            'list'  => $list
        ];
        return view('order.list',$data);
    }
    /**
     * 查询订单支付状态
     */
    public function payStatus()
    {
        $order_id = intval($_GET['order_id']);
        $info = OrderModel::where(['order_id'=>$order_id])->first();
        $response = [];
        if($info){
            if($info->pay_time>0){      //已支付
                $response = [
                    'status'    => 0,       // 0 已支付
                    'msg'       => 'ok'
                ];
            }
//            echo '<pre>';print_r($info->toArray());echo '</pre>';
//            echo '<pre>';print_r($response);echo '</pre>';
        }else{
            die("订单不存在");
        }
        die(json_encode($response));
    }
}
