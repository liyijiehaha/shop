<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Model\GoodsModel;
use  App\Model\CartModel;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /*添加购物测*/
    public function add($goods_id = 0)
    {
        if (empty($goods_id)) {
            header('Refresh:3;url=/cart');
            die('请选择商品，3秒后自动跳转至购物车');
        }
        //判断商品是否有效
        $goods = GoodsModel::where(['goods_id' => $goods_id])->first();
            if ($goods) {
                if ($goods->is_delete == 1) {       //已被删除
                    header('Refresh:3;url=/');
                    echo "商品已被删除,3秒后跳转至首页";
                    die;
                }
                $cart_info = [
                    //数据字段
                    'goods_id'  => $goods_id,
                    'goods_name'    => $goods->goods_name,
                    'self_price'    => $goods->self_price,
                    'user_id'       =>Auth::id(),
                    'create_time'  => time(),
                    'session_id' => Session::getId()
                ];
                //入库
                $cart_id = CartModel::insertGetId($cart_info);
                if($cart_id){
                    header('Refresh:3;url=/cart');
                    die("添加购物车成功，自动跳转至购物车");
                }else{
                    header('Refresh:3;url=/');
                    die("添加购物车失败");
                }
            }else{
                echo "商品不存在";
            }


    }
    public function index()
    {
        $cart_list = CartModel::where(['user_id'=>Auth::id(),'session_id'=>Session::getId()])->get()->toArray();
        if($cart_list){
            $total_price = 0;
            foreach($cart_list as $k=>$v){
                $g = GoodsModel::where(['goods_id'=>$v['goods_id']])->first()->toArray();
                $total_price += $g['self_price'];
                $goods_list[] = $g;
            }
            //展示购物车
            $data = [
                'goods_list' => $goods_list,
                'total'     => $total_price / 100
            ];
            return view('cart/index',$data);
        }else{
            header('Refresh:3;url=/');
            die("购物车为空,跳转至首页");
        }
    }
}
