<?php

namespace App\Http\Controllers\Contab;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\OrderModel;
class ContabController extends Controller
{
    public function del_order(){
        echo __METHOD__."\n";
        $all=OrderModel::all()->toArray();
        foreach ($all as $k=>$v){
            if(time()-$v['create_time']>1800 && $v['pay_time']==0){
                OrderModel::where(['order_id'=>$v['order_id']])->update(['is_detele'=>1]);
            }
        }
        echo '<pre>';print_r($all);echo '</pre>';
    }
}
