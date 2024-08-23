<?php
namespace backend\widgets;

use Yii;
use backend\models\items\Categories;


class CategoryWidget extends \yii\bootstrap\Widget
{
    public $tpl;
    public $data;

    public $tree;
    public $menuHtml;


    public function init()
    {
        parent::init();
        if($this->tpl == null){
            $this->tpl = 'category';
        }
        $this->tpl .= '.php';
    }
    
    public function run()
    {
        $this->data = Categories::find()->
                        indexBy('id')->
                        asArray()->
                        // orderBy([
                        //     'id' => SORT_ASC,
                        // ])->
                        orderBy([
                            'sorting' => SORT_ASC
                        ])->
                        all();
        $this->tree = $this->getTree();
        $this->menuHtml = $this->getMenuHtml($this->tree);
        return ($this->tpl == 'categorySelect') ? $this->selectHtml : $this->menuHtml; 
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
        return $tree[1]['childs'];
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
