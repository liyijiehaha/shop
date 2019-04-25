<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Redis;
use Illuminate\Http\Request;
use App\Model\GoodsModel;
use  Illuminate\Support\Facades\Auth;
class GoodsDetailController extends Controller
{
    //浏览历史
    public function detail($goods_id =0)
    {
        $res=GoodsModel::where(['goods_id'=>$goods_id])->first();
        if($res == NULL){
            header('Refresh:2;url=/');
            die('商品不存在。自动跳转至网站首页');
        }
        $cache_view=Redis::incr($goods_id);//浏览自增量
//        /*浏览量排序*/
//                    $redis_ss_view='redis_goods_view';//浏览量排行
//                    Redis::zAdd($redis_ss_view,$cache_view,$goods_id);//有序集合按浏览量排序
//                    $goods_id=Redis::Zrevrange ($redis_ss_view,0,10000,true);//倒序排行
//                    $res1=[];
//                    foreach ($goods_id as $k=>$v) {
//                        $where=[
//                            'goods_id'=>$k
//                        ];
//                        $res1[]=GoodsModel::where($where)->first();
//                    }
        /*浏览历史记录*/
        $redis_ss_history='redis_goods_history:'.Auth::id();//浏览量排行
        Redis::zAdd($redis_ss_history,time(),$goods_id);//有序集合按浏览量排序
        $goods=Redis::zRevRange($redis_ss_history,0,10000000000000,true);//倒序排行
        $res2=[];
        foreach($goods as $k=>$v) {
            $where=[
                'goods_id'=>$k
            ];
            $res2[]=GoodsModel::where($where)->first();
        }
        $data=[
            'res'=>$res,
            'cache_view'=>$cache_view
        ];
        return view('goods/detail',$data,compact('res2'));
    }

}
