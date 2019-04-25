<?php

namespace App\Admin\Controllers;
use App\Model\GoodsModel;
use App\Http\Controllers\Controller;
use Encore\Admin\Controllers\HasResourceActions;
use Encore\Admin\Form;
use Encore\Admin\Grid;
use Encore\Admin\Layout\Content;
use Encore\Admin\Show;
class GoodsController extends Controller
{
    use HasResourceActions;

    /**
     * Index interface.
     *
     * @param Content $content
     * @return Content
     */
    public function index(Content $content)
    {
        return $content
            ->header('Index')
            ->description('description')
            ->body($this->grid());
    }

    /**
     * Show interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function show($id, Content $content)
    {
        return $content
            ->header('Detail')
            ->description('description')
            ->body($this->detail($id));
    }

    /**
     * Edit interface.
     *
     * @param mixed $id
     * @param Content $content
     * @return Content
     */
    public function edit($id, Content $content)
    {
        return $content
            ->header('Edit')
            ->description('description')
            ->body($this->form()->edit($id));
    }

    /**
     * Create interface.
     *
     * @param Content $content
     * @return Content
     */
    public function create(Content $content)
    {
        return $content
            ->header('Create')
            ->description('description')
            ->body($this->form());
    }

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new GoodsModel);

        $grid->goods_id('商品id');
        $grid->goods_name('商品名称');
        $grid->self_price('商品价格');
        $grid->goods_num('商品库存');
        $grid->goods_desc('商品描述');
//
//        $grid->goods_img('商品图片')->display(function($img){
//            return '<img src="/uploads/goodsImg/'.$img.'">';
//        });

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(GoodsModel::findOrFail($id));

        $show->goods_id('Goods id');
        $show->goods_name('Goods name');
        $show->self_price('Self price');
        $show->market_price('Market price');
        $show->goods_num('Goods num');
        $show->goods_score('Goods score');
        $show->goods_desc('Goods desc');
        $show->is_up('Is up');
        $show->is_new('Is new');
        $show->is_best('Is best');
        $show->is_hot('Is hot');
        $show->goods_img('Goods img');
        $show->goods_imgs('Goods imgs')->display(function($img){
            return '<img src="/upload/goodsImg/'.$img.'">';
        });
        $show->cate_id('Cate id');
        $show->brand_id('Brand id');
        $show->create_time('Create time');
        $show->is_delete('Is delete');

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new GoodsModel);

        $form->number('goods_id', 'Goods id');
        $form->text('goods_name', 'Goods name');
        $form->decimal('self_price', 'Self price');
        $form->decimal('market_price', 'Market price');
        $form->number('goods_num', 'Goods num');
        $form->number('goods_score', 'Goods score');
        $form->textarea('goods_desc', 'Goods desc');
        $form->switch('is_up', 'Is up');
        $form->switch('is_new', 'Is new')->default(2);
        $form->switch('is_best', 'Is best')->default(2);
        $form->switch('is_hot', 'Is hot')->default(2);
        $form->text('goods_img', 'Goods img');
        $form->text('goods_imgs', 'Goods imgs');
        $form->number('cate_id', 'Cate id');
        $form->number('brand_id', 'Brand id');
        $form->number('create_time', 'Create time');
        $form->switch('is_delete', 'Is delete');

        return $form;
    }
}
