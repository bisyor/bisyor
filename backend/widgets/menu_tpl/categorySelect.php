<?php if (isset($category['childs'])): ?>
	<optgroup label="&nbsp;&nbsp;&nbsp;&nbsp;<?=$category['title']?>">
		<?=$this->getMenuHtml($category['childs'])?>
	</optgroup>
<?php else: ?>
	<option value="<?=$category['id']?>">&nbsp;&nbsp;&nbsp;&nbsp;<?=$category['title']?></option>
<?php endif;?>