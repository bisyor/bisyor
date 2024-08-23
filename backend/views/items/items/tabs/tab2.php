<?php

use yii\helpers\Html;
use backend\models\items\Items;

$images = isset($post['uploaded_files']) ? $post['uploaded_files'] : '';

?>
    <div id="error-count"></div>
<?php if (!empty($upload_images)): ?>
    <?= Html::a('<span class="glyphicon glyphicon-sort"></span> Изменить сортировку',
        ['sorting-image', 'id' => $model->id],
        ['data-pjax' => '0', 'title'=> 'Сортировка','class'=>'btn btn-danger']);
    ?>
<?php endif ?>
    <hr>
    <div class="imagesList ui-sortable">
        <?php if (!empty($upload_images)): ?>
            <?php $x = 1; foreach ($upload_images as $key=>$value):  ?>
                <div class="image_preview_class">
                    <a class="rotate-items-img btn btn-info btn-icon btn-circle btn-sm" title="<?=$value?>" data-rotate="<?=$key?>"><i class="fa fa-repeat"></i></a>
                    <a class="img-ads btn btn-danger btn-icon btn-circle btn-sm" title="<?=$value?>" data-id="<?=$key?>"><i class="fa fa-times"></i></a>
                    <span class="preview">
                        <img src="<?=Items::getImageAdress($value,$model->img_prefix)?>">
                    </span>
                </div>
                <?php $x++ ;endforeach ?>
        <?php endif ?>
        <?php if ($images): ?>
            <?php foreach (explode(",",$images) as $key => $value): ?>
                <div class="image_preview_class">
                    <a class="img-ads btn btn-danger btn-icon btn-circle btn-sm" title="<?=$value?>"><i class="fa fa-times"></i></a>
                    <span class="preview">
      		<img src="<?=Items::getImageAdress($value,$model->img_prefix)?>">
      	</span>
                </div>
            <?php endforeach ?>
        <?php endif ?>
    </div>
    <input type="file" name="imagesProba" accept="images/*" max="3" multiple="true" style="display: none" id="inputFile">
    <input type="hidden" name="uploaded_files" id="uploaded_files" value="<?=$images?>">
    <input type="hidden" name="old_uploaded_files" id="old_uploaded_files" value="<?=$model->images?>">
    <div class="attach">
        <div class="row">
            <div class="col-md-12 pull-right">
                <label for="inputFile" style="cursor:pointer;" title="Загрузка изображения" data-toggle="tooltip">
			    <span class="multiple-photos">
			        <div class="fileinput-button dz-clickable"></div>
			        Загрузить
			    </span>
                </label>
            </div>
        </div>
    </div>
<?php
$this->registerJs(<<<JS
	var count = parseInt($("#max-count-images").val());
	$("#inputFile").on('change',function(e){
		var namess = [];
		var files = e.target.files;
		var data = new FormData(); 
		$.each(files, function(i,file){	
			var reader = new FileReader();
			var d = new Date();
			var new_name = d.getFullYear() + '-' + d.getMonth() + '-' + d.getDate() + '_' +d.getHours() + '-' + d.getMinutes() + '-' + d.getSeconds();  
			var filename = $( '#inputFile' )[0].files[i].name;
			name = filename.split('.').shift();
			var ext = filename.split('.').pop();
			new_name = name + '(' + new_name + ")." + ext;
			reader.readAsDataURL(file);
			data.append('file[]', $( '#inputFile' )[0].files[i]) ; 
			data.append('names[]', new_name) ; 
			namess.push(new_name);
			template = '<div class="image_preview_class" data-id="'+ new_name +'"><a class="img-ads btn btn-danger btn-icon btn-circle btn-sm" title="'+new_name+'"><i class="fa fa-times"></i></a><span class="preview"><img src="/uploads/zz.gif"></span></div>';
			$(".imagesList").append(template);
		});
		$.ajax({
			url: '/items/items/save-img-storage',
			type: 'POST',
			data: data,
			processData: false,
			contentType: false,
			success: function(success){
				if(success == 'error'){
					alert('ERR_INTERNET_DISCONNECTED');
				}else{
					new_names = "";
				  	for(var i=0; i < namess.length;i++){
				    	if(i != namess.length-1){
				      		new_names += namess[i] + ",";
					    }else{
					      new_names += namess[i];
					    }
					    template = '<a class="img-ads btn btn-danger btn-icon btn-circle btn-sm" title="'+namess[i] +'"><i class="fa fa-times"></i></a><span class="preview"><img src="' + success + namess[i] +'"></span>';
					    $('[data-id="' + namess[i] + '"]').html(template);
					 }
				 	old_files = $("#uploaded_files").val();
					if(old_files)
						new_files = old_files + "," + new_names;
					else
						new_files = new_names;
					$("#uploaded_files").val(new_files);
				}
			},
			cache: false,
			xhr: function() {  // custom xhr
			    myXhr = $.ajaxSettings.xhr();
			    if (myXhr.upload) {
			        return myXhr;
			    }
			}
		});

		c = $('div.image_preview_class').length;
		
		if(c > count){
			$('#error-count').html('Вы можете загрузить только <b>' + count + '</b> фотографий');
			$('#error-count').addClass('alert alert-danger');
			$('#submit').prop('disabled',true);
		}else{
			$('#submit').prop('disabled',false);
			$('#error-count').html('');
			$('#error-count').removeClass('alert alert-danger');
		}
	});
	$(document).on('click', ".img-ads", function(e){
	    element = $(this).attr('title');
	    id = $(this).attr('data-id');
	    files = ($("#uploaded_files").val()).split(",");
	    old_files = ($("#old_uploaded_files").val()).split(",");
	    var index = files.indexOf(element);
	    if (index !== -1) {
	     	files.splice(index, 1);
	    	$("#uploaded_files").val(files.join(","));
	    }
	    index = old_files.indexOf(element);
	    if (index !== -1) {
	    	old_files.splice(index, 1);
	    	$("#old_uploaded_files").val(old_files.join(","));
	    }
	    if(id){
		    $.post('/items/items/delete-image?value='+element+'&id='+id,function(success){});
	    }else{
		    $.post('/items/items/delete-image?value='+element,function(success){});
	    }
	    $(this).parent('div').remove();
	    // e.parent('div').remove();
	    e.preventDefault();
	    // e.target.parentElement.remove();
	    c = $('div.image_preview_class').length;
		
		if(c <= count){
			$('#submit').prop('disabled',false);
			$('#error-count').html('');
			$('#error-count').removeClass('alert alert-danger');
		}
	});
	
	
	$(document).on('click', ".rotate-items-img", function(e){
	    element = $(this).attr('title');
	    id = $(this).attr('data-rotate');
	    files = ($("#uploaded_files").val()).split(",");
	    old_files = ($("#old_uploaded_files").val()).split(",");
	    var index = files.indexOf(element);
	    if (index !== -1) {
	     	files.splice(index, 1);
	    	$("#uploaded_files").val(files.join(","));
	    }
	    index = old_files.indexOf(element);
	    if (index !== -1) {
	    	old_files.splice(index, 1);
	    	$("#old_uploaded_files").val(old_files.join(","));
	    }
	    const rotateImage = $(this).parent(); 
	    if(id){
	         let template = '<div class="image_preview_class" data-id="'+id +'"><a class="img-ads btn btn-danger btn-icon btn-circle btn-sm" title="'+id+'"><i class="fa fa-times"></i></a><span class="preview"><img src="/uploads/zz.gif"></span></div>';
			rotateImage.html(template);
		    $.post('/items/items/rotate-image?id='+element+'&id='+id,function(data){
		        template = '<div class="image_preview_class" data-id="'+id +'"><a class="rotate-items-img btn btn-primary btn-icon btn-circle btn-sm" data-rotate="'+id +'" title="'+element+'"><i class="fa fa-repeat"></i></a><a class="img-ads btn btn-danger btn-icon btn-circle btn-sm" title="'+element+'"><i class="fa fa-times"></i></a><span class="preview"><img src="'+data+'"></span></div>';
		        rotateImage.html(template)
		    });
	    }else{
		    $.post('/items/items/rotate-image?image='+element,function(success){});
	    }
	  
	});

JS
)
?>