<?php
namespace backend\widgets;

use yii\base\Widget;
use yii\helpers\Html;

class BulkButtonWidget extends Widget{

	public $buttons;
	
	public function init(){
		parent::init();
		
	}
	
	public function run(){
		$content = '<div class="pull-left" style="margin-right:10px;">'.
                   $this->buttons.
                   '</div>';
		return $content;
	}
}
?>
