<?php
namespace backend\widgets;

use Yii;
use backend\models\shops\ShopCategories;
use backend\models\items\Categories;


class MenuWidget extends \yii\bootstrap\Widget
{
    public $tpl;
    public $data;
    public $tree;
    public $menuHtml;

    public function init()
    {
        parent::init();
        if($this->tpl == null){
            $this->tpl = 'menu';
        }
        $this->tpl .= '.php';
    }
    
    public function run()
    {
        $this->data = ShopCategories::find()->
                        indexBy('id')->
                        asArray()->
                        orderBy([
                            'sorting' => SORT_ASC,
                        ])->
                        all();

        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        return $this->menuHtml; 
    }

    public function getTree()
    {
        $tree = [];
        foreach ($this->data as $id => &$node) {
            if($node['parent_id'] == 0)
                $tree[$id] = &$node;
            else
                $this->data[$node['parent_id']]['childs'][$node['id']] = &$node;
        }
        return $tree;
    }


    protected function getMenuHtml($tree)
    {
        $i = 1;
        $str = '';
        foreach ($tree as $category) {
            $str .= $this->catToTemplate($category,$i);
            $i++;
        }
        return $str;
    }

    protected function catToTemplate($category,$i)
    {
        ob_start();
        include __DIR__ . '/menu_tpl/' . $this->tpl;
        return ob_get_clean();
    }

}
