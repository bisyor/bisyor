<?php
use backend\models\items\CategoriesDynprops;
use backend\models\items\Categories;
use backend\models\items\Items;
use kartik\select2\Select2;

$templateInput = '<div class="row"><div class="col-md-2">
                    {label}{hint}</div><div class="col-md-4">{input}{error}</div></div>
                    ';
$currenies = Categories::getCurrency();
$display = null;
?>
<input type="hidden" name=""	id="max-count-images" value="<?=(isset($category) && isset($category->photos)) ? $category->photos : 5 ?>">

<?php if ($category): ?>
	<!-- tip obyevleniya uchun -->
	<?php if ($category->seek == 1): ?>
		<div class="form-group field-items-cat_type">
			<div class="row">
				<div class="col-md-2">
			        <label class="control-label" for="items-cat_type">Тип объявления</label>
			    </div>
			    <div class="col-md-4">
		        	<select id="items-cat_type" class="form-control" aria-invalid="false" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
						<option value="0"><?=($category->type_offer_form != '') ? $category->type_offer_form : 'Предлагаю'?></option>
						<option value="1"><?=($category->type_seek_form != '') ? $category->type_seek_form : 'Ищу'?></option>
					</select>
					<div class="help-block"></div>
				</div>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>
<?php foreach ($fields as $key => $value): ?>
	<div class="form-group field-items-f<?=$value->data_field?> <?=($value->req == 1) ? 'required' : ''?>">
		<div class="row">
			<div class="col-md-2">
				<label class="control-label" for="items-f<?=$value->data_field?>"><?=$value->title?></label>
			</div>
			<!-- textinput uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE1): ?>
				<div class="col-md-4">
					<div class="input-group">
						<input type="text" id="items-f<?=$value->data_field?>" class="form-control" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val());validated($(this));">
						<?php if ($value->description): ?>
							<span class="input-group-addon"><?=$value->description?></span>
						<?php endif ?>
					</div>
					<div class="help-block"></div>
				</div>
			<?php endif; ?>
			<!-- textarea uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE2): ?>
			    <div class="col-md-8">
			    	<div>
			    		<textarea id="items-f<?=$value->data_field?>" onchange="validated($(this));" class="form-control" rows="8" aria-invalid="false"></textarea>
				    </div>
			    	<div class="help-block"></div>
			    </div>
			<?php endif; ?>
			<!-- vibor da/net uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE4): ?>
			    <div class="col-md-8">
					<div id="items-f<?=$value->data_field?>" role="radiogroup">
						<label>
							<input type="radio" name="items-f<?=$value->data_field?>" onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())" value="2"> Да
						</label>
						&nbsp;&nbsp;&nbsp;&nbsp;
						<label>
							<input type="radio" name="items-f<?=$value->data_field?>" onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())" value="1"> Нет
						</label>
					</div>
					<div class="help-block"></div>
			    </div>
			<?php endif; ?>
			<!-- vibor flag uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE5): ?>
			    <div class="col-md-8">
			    	<div class="form-group field-items-f<?=$value->data_field?>">
			    		<label class="checkbox">
							<input type="checkbox" id="items-f<?=$value->data_field?>" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val());validated($(this));" class="form-control">
						</label>
						<div class="help-block"></div>
					</div>
				</div>
			<?php endif; ?>
			<!-- vipadayushiy spisok uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE6): ?>
			    <div class="col-md-4">
			    	<div>
			        	<select id="items-f<?=$value->data_field?>" class="form-control" aria-invalid="false" onchange="validated($(this));">
			        		<?php $variants = $value->getVariants(); foreach ($variants as $key => $variant): ?>
								<option value="<?=$variant->value?>"><?=$variant->name?></option>
			        		<?php endforeach ?>
						</select>
					</div>
					<div class="help-block"></div>
				</div>
			<?php endif; ?>
			<!-- gruppa yedinichnim viborom uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE8): ?>
			    <div class="col-md-8" >
					<div id="items-f<?=$value->data_field?>" role="radiogroup">
		        		<?php $variants = $value->getVariants(); $k = 0; ?>
		        		<?php if ($value->group_one_row_type8 == 0): ?>
							<div style="padding-left: 20px;">
		        			<?php $k=0; foreach ($variants as $key => $variant): ?>
								<?php if ($variant->value == 0)continue; ?>
			        			<?php if($k%2 == 0): ?>
			        				<div class="row">
			        			<?php endif ?>
			        			<div class="col-md-4">
									<label class="radio">
										<input type="radio" name="items-f<?=$value->data_field?>" onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())" value="<?=$variant->value?>"> <?='<span style="font-size:13px;">'.$variant->name.'</span>';?>
									</label>
								</div>
								<?php $k++; if($k%2 == 0): ?>
									<div class="col-md-4 offset-md-4"></div>
			        				</div>
			        			<?php endif ?>
			        		<?php endforeach ?>
			        		<?php if ($k%2== 1): ?>
		        				</div>
		        			<?php endif ?>
			        		</div>

		        		<?php else: ?>

		        			<?php foreach ($variants as $key => $variant): ?>
								<?php if ($variant->value == 0)continue; ?>
		        				<label class="radio-inline">
									<input type="radio" name="items-f<?=$value->data_field?>" onclick="$('#hidden-'+$(this).attr('name')).val($(this).val())" value="<?=$variant->value?>"> <?='<span style="font-size:13px;">'.$variant->name.'</span>';?>
								</label>
		        			<?php endforeach ?>
		        		<?php endif ?>
					</div>
					<div class="help-block"></div>
			    </div>
			<?php endif; ?>
			<!-- gruppa mnogim viborom uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE9): ?>
			    <div class="col-md-8" style="padding-left: 30px;">
					<div id="items-f<?=$value->data_field?>" role="checkboxgroup">
		        		<?php $variants = $value->getVariants(); $k = 0; ?>
		        		<?php if ($value->group_one_row_type9 == 0): ?>
		        			<?php $k=0; foreach ($variants as $key => $variant): ?>
			        			<?php if($k%2 == 0): ?>
			        				<div class="row">
			        			<?php endif ?>
			        			<div class="col-md-4">
									<label class="checkbox">
										<input type="checkbox" data-id="items-f<?=$value->data_field?>" data-type="type9" data-name="<?=$variant->name?>" onchange="setCheckvalue($(this))" value="<?=$variant->value?>"> <?='<span style="font-size:13px;">'.$variant->name.'</span>';?>
									</label>
								</div>
								<?php $k++; if($k%2 == 0): ?>
									<div class="col-md-4 offset-md-4"></div>
			        				</div>
			        			<?php endif ?>
			        		<?php endforeach ?>
			        		<?php if ($k%2== 1): ?>
		        				</div>
		        			<?php endif ?>
		        		<?php else: ?>
							<label class="checkbox-inline">
								<input type="checkbox" data-id="items-f<?=$value->data_field?>" data-type="type9" data-name="<?=$variant->name?>" onchange="setCheckvalue($(this))" value="<?=$variant->value?>"> <?='<span style="font-size:13px;">'.$variant->name.'</span>';?>
							</label>
		        		<?php endif ?>
					</div>
					<div class="help-block"></div>
			    </div>
			<?php endif; ?>

			<!-- vipadayushiy spisok uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE10): ?>
			    <div class="col-md-4">
					<div class="input-group">
						<input type="text" id="items-f<?=$value->data_field?>" class="form-control number_input" onchange="validated($(this));">
						<?php if ($value->description): ?>
							<span class="input-group-addon"><?=$value->description?></span>
						<?php endif ?>
					</div>
					<div class="help-block"></div>
				</div>
			<?php endif; ?>

			<!-- vipadayushiy spisok uchun -->
			<?php if ($value->type == CategoriesDynprops::TYPE11): ?>
				<?php
					$start = 0;
					$end = 0;
					if($value->start > $value->end){
						$start = $value->end;
						$end = $value->start;
					}else{
						$start = $value->start;
						$end = $value->end;
					}
					$step = $value->step;
				?>
			    <div class="col-md-4">
			    	<div>
			        	<select id="items-f<?=$value->data_field?>" onchange="validated($(this));" class="form-control" aria-invalid="false">
			        		<?php for($i = (int)$start; $i <= (int)$end; $i+=(int)$step){ ?>
								<option value="<?=$i?>">
									<?=$i?>
								</option>
			        		<?php } ?>
						</select>
					</div>
					<div class="help-block"></div>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endforeach ?>

<?php if ($category): ?>
	<!-- Sena uchun -->
	<?php if ($category->price == 1): ?>
		<div class="form-group">
		 	<div class="row">
		        <div class="col-md-2">
		            <label><?=isset($category->price_title['ru']) && $category->price_title['ru'] != '' ?$category->price_title['ru'] : 'Цена'?></label>
		        </div>
		        <div class="col-md-10">
	            	<input type="hidden" name="" id="items-price_ex">

		        	<?php if ($category->is_exchange == 1): ?>
		        		<div style="height: 30px;">
			                <input type="radio"  id="radio-price-2" data-type="category-price" onclick="$('#items-price_ex').val($(this).val()); setUniver();" name="radio1" onchange="" value="2"> <label for="radio-price-2"> <span style="font-size:13px;">Обмен</span></label>
			            </div>
		        	<?php endif ?>
		        	<?php if ($category->is_free == 1): ?>
		        		<div style="height: 30px;">
			                <input type="radio"  id="radio-price-4" data-type="category-price" onclick="$('#items-price_ex').val($(this).val()); setUniver();" name="radio1" onchange="" value="4"> <label for="radio-price-4"> <span style="font-size:13px;">Бесплатно</span></label>
			            </div>
		        	<?php endif ?>
		            <?php if ($category->is_deal == 1): ?>
		            	<div style="height: 30px;">
			                <input type="radio"  id="radio-price-8" data-type="category-price" onclick="$('#items-price_ex').val($(this).val());setUniver();" name="radio1" onchange="" value="8"> <label for="radio-price-8"> <span style="font-size:13px;">Договорная</span></label>
			            </div>
		            <?php endif ?>
		            <div class="" style="height: 30px;">
		            	<?php $display = $category->is_deal == 1 || $category->is_free == 1 || $category->is_exchange == 1; ?>
		            	<?php if ($display): ?>
		            		<input type="radio"  id="radio-price-0" data-type="category-price" name="radio1"  onclick="val = parseInt($('#items-price_ex').val()); if(value%2 == 1){$('#items-price_ex').val(1);}else{$('#items-price_ex').val(0);}" onchange="setUniver();" value="0"> <label for="radio-price-0" style="margin-right: 10px;"> <span   style="font-size:13px;">Цена</span></label>
		            	<?php endif ?>

		                <input type="" id="items-price" class="" style="
		                	border: 1px solid #ccd0d4;
		                	margin-right: 10px;
							-webkit-box-shadow: none;
							box-shadow: none;
							font-size: 12px;
							border-radius: 3px;
							-webkit-border-radius: 3px;
							height: 30px;
		                	padding-left: 6px;
		                	<?= !isset($model->id) ? 'display:none' : ''?>
						" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
						<input type="" id="items-price_end" class="" style="
		                	border: 1px solid #ccd0d4;
		                	margin-right: 10px;
							-webkit-box-shadow: none;
							box-shadow: none;
							font-size: 12px;
							border-radius: 3px;
							-webkit-border-radius: 3px;
							height: 30px;
		                	padding-left: 6px;
		                	<?= ($category->price_diapazone != true) ? 'display:none' : ''?>
						" placeholder="цена до" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
						<select  onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())" id="items-currency_id" style="
							border: 1px solid #ccd0d4;
		                	margin-left: 10px;
		                	margin-right: 10px;
							-webkit-box-shadow: none;
							box-shadow: none;
							font-size: 12px;
							border-radius: 3px;
							-webkit-border-radius: 3px;
							height: 30px;
							<?= !isset($model->id) ? 'display:none' : ''?>
							">
							<?php foreach ($currenies as $key => $value): ?>
								<option value="<?=$key?>"><?=$value?></option>
							<?php endforeach ?>
						</select>
						<?php if ($category->mod_check == 1): ?>
							<label style="<?= !isset($model->id) ? 'display:none' : ''?>">
								<input type="checkbox" id="price-ex-checkbox" onchange="if($(this).prop('checked')){value = parseInt($('#items-price_ex').val()) + 1;}else{value = parseInt($('#items-price_ex').val()) - 1;}$('#items-price_ex').val(value);" value="1">
								<span id="price-ex-checkbox-label" style="font-size:13px;"><?=($category->mod_title['ru'] == '') ? 'Торг возможен' : $category->mod_title['ru']?></span>
							</label>
						<?php endif ?>
		            </div>
		        </div>
		    </div>
		</div>
	<?php endif ?>
	<!-- Chastnoye litso biznes litso uchun -->
	<?php if ($category->owner_business == 1): ?>
		<?php
			if ($category->owner_private_form == '' && $category->owner_business_form == ''){
				$category->owner_private_form = $category->getAttributeLabel('owner_private_form');
				$category->owner_business_form = $category->getAttributeLabel('owner_business_form');
			}
		?>
		<div class="form-group field-items-owner_type">
			<div class="row">
				<div class="col-md-2">
			        <label class="control-label" for="items-owner_type">
			        	<?= $category->owner_private_form. '/' .$category->owner_business_form ?>
			        </label>
			    </div>
			    <div class="col-md-4">
		        	<select id="items-owner_type" class="form-control" aria-invalid="false" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
						<option value="1"><?=$category->owner_private_form?></option>
						<option value="2"><?=$category->owner_business_form?></option>
					</select>
					<div class="help-block"></div>
				</div>
			</div>
		</div>
	<?php endif ?>
<?php endif ?>
<div class="form-group field-items-district_id required">
	<div class="row">
		<div class="col-md-2">
	        <label class="control-label" for="items-district_id">Район</label>
	    </div>
	    <div class="col-md-4">
	    	<?php echo Select2::widget([
			    'name' => 'Items[district_id]',
			    'data' => Items::getDistrictsList(),
			    'value' => ($model) ? $model->district_id : '',
	            'theme' => Select2::THEME_BOOTSTRAP,
			    'options' => [
			    	'id' => 'items-district_id',
			        'placeholder' => 'Адрес',
			    ],
			]); ?>
	    </div>
	</div>
</div>
<?php if ($category): ?>
	<!-- adress uchun -->
	<?php if ($category->address): ?>
		<div class="row">
            <div class="col-md-2">
                <label for="shops-address">Адрес</label>
            </div>
            <div class="col-md-8">
            	<div class="input-group">
	            	<input type="text" class="form-control" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())" id="items-address" placeholder="Введите адрес">
					<span class="input-group-addon"><button type="button" class="btn btn-link btn-xs" id="button">найти на карте</button></span>
				</div>
                <input type="hidden" id="items-coordinate_x" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
                <input type="hidden" id="items-coordinate_y" onchange="$('#hidden-'+$(this).attr('id')).val($(this).val())">
                <p id="notice">Адрес не найден</p>
                <br><br>
                <div id="map" style="height:250px; width:100%; position: relative;"></div>
                <div id="marker"></div>
            </div>
<!--            <div class="col-md-12"><br><hr></div>-->
        </div>
	<?php endif ?>
<?php endif ?>

<?php 
$price_dizapazon = isset($category->price_diapazone) ? $category->price_diapazone : 2;
$price_ex = isset($model->price_ex) ? $model->price_ex : 2;
$this->registerJs(<<<JS
	if($price_ex == 2){
		$('#items-price').hide(); 
       	$('#items-currency_id').hide();
		$('#items-price_end').hide();
	}

	$(function() {
	    $('input:radio[name="radio1"]').change(function() {
		       	$('#items-price').hide(); 
		       	$('#items-currency_id').hide();
		       	$('#price-ex-checkbox').hide();
		       	$('#price-ex-checkbox-label').hide();
		       	// $('#items-price_end').hide();

		        if ($(this).val() == 0) {
    				$('#items-price').show(200);
    				$('#items-currency_id').show(200);
    				$('#price-ex-checkbox').show(200);
    				$('#price-ex-checkbox-label').show(200);
    				// $('#items-price_end').show(200);
		        }
		    });
	});

	function setUniver(){
		$('input:radio[name="radio1"]').change(function() {
	       	$('#items-price_end').hide();
	        if ($(this).val() == 0 && $price_dizapazon != 2) {
				$('#items-price_end').show(200);
	        }
	    });
	}
	
	$('#items-price').on({
        keypress: function(e){
             keyUp(e);
        },
             keyup: function () {
             formatCurrency($(this));
        }
    });            
            
    $('#items-price_end').on({
         keypress: function(e){
             keyUp(e);
         },
         keyup: function () {
             formatCurrency($(this));
         }
    });

JS
);
?>

<?php
if ($category && $category->address) {
$this->registerJs(<<<JS
    ymaps.ready(init);
    function init() {
        // Подключаем поисковые подсказки к полю ввода.
        var suggestView = new ymaps.SuggestView('items-address'),
            map,
            placemark;

        // При клике по кнопке запускаем верификацию введёных данных.
        $('#button').bind('click', function (e) {
            geocode();
        });

        cord_x = ($("#items-coordinate_x").val()) ? $("#items-coordinate_x").val() : 41.2995;
        cord_y = ($("#items-coordinate_y").val()) ? $("#items-coordinate_y").val() : 69.2401;
        // Указывается идентификатор HTML-элемента.
        map = new ymaps.Map('map', {
            zoom: 15,
            center: [cord_x, cord_y],
            controls: []
        });

        placemark = new ymaps.Placemark(map.getCenter(), {
        },{
            preset: 'islands#redDotIconWithCaption',
            draggable: true
        });

        map.geoObjects.add(placemark);

        placemark.events.add('dragend', function (e) {
            var coordinates = placemark.geometry.getCoordinates();
            var myGeocoder = ymaps.geocode(coordinates,{results: 1});
            myGeocoder.then(
                function (res) {
                    var street = res.geoObjects.get(0);
                    address = street.properties.get('description') + ', ' +street.properties.get('name');
                    $("#items-address").val(address);
                    $("#items-coordinate_x").val(coordinates[0]);
                    $("#items-coordinate_y").val(coordinates[1]);
                }
            );
        });

        map.controls.add('zoomControl');
        map.controls.add('geolocationControl');

        function geocode() {
            // Забираем запрос из поля ввода.
            var request = $('#items-address').val();
            // Геокодируем введённые данные.
            ymaps.geocode(request).then(function (res) {
                var obj = res.geoObjects.get(0),
                    error, hint;

                if (obj) {
                    // Об оценке точности ответа геокодера можно прочитать тут: https://tech.yandex.ru/maps/doc/geocoder/desc/reference/precision-docpage/
                    switch (obj.properties.get('metaDataProperty.GeocoderMetaData.precision')) {
                        case 'exact':
                            break;
                        case 'number':
                        case 'near':
                        case 'range':
                            error = 'Неточный адрес, требуется уточнение';
                            hint = 'Уточните номер дома';
                            break;
                        case 'street':
                            error = 'Неполный адрес, требуется уточнение';
                            hint = 'Уточните номер дома';
                            break;
                        case 'other':
                        default:
                            error = 'Неточный адрес, требуется уточнение';
                            hint = 'Уточните адрес';
                    }
                } else {
                    error = 'Адрес не найден';
                    hint = 'Уточните адрес';
                }

                // Если геокодер возвращает пустой массив или неточный результат, то показываем ошибку.
                if (error) {
                    showError(error);
                    // showMessage(hint);
                } else {
                    showResult(obj);
                }
            }, function (e) {
                console.log(e)
            })
        }

        function showResult(obj) {
            // Удаляем сообщение об ошибке, если найденный адрес совпадает с поисковым запросом.
            $('#items-address').removeClass('input_error');
            $('#notice').css('display', 'none');

            var mapContainer = $('#map'),
                bounds = obj.properties.get('boundedBy'),
            // Рассчитываем видимую область для текущего положения пользователя.
                mapState = ymaps.util.bounds.getCenterAndZoom(
                    bounds,
                    [mapContainer.width(), mapContainer.height()]
                ),
            // Сохраняем полный адрес для сообщения под картой.
                address = [obj.getCountry(), obj.getAddressLine()].join(', '),
            // Сохраняем укороченный адрес для подписи метки.
                shortAddress = [obj.getThoroughfare(), obj.getPremiseNumber(), obj.getPremise()].join(' ');
            // Убираем контролы с карты.
            mapState.controls = [];
            // Создаём карту.
            createMap(mapState, shortAddress);
            // Выводим сообщение под картой.
            showMessage(address);
        }

        function showError(message) {
            $('#notice').text(message);
            $('#items-address').addClass('input_error');
            $('#notice').css('display', 'block');
            // Удаляем карту.
            // if (map) {
            //     map.destroy();
            //     map = null;
            // }
        }

        function createMap(state, caption) {
            // Если карта еще не была создана, то создадим ее и добавим метку с адресом.
            if (!map) {
                map = new ymaps.Map('map', state);
                placemark = new ymaps.Placemark(
                    map.getCenter(), {
                        iconCaption: caption,
                        balloonContent: caption
                    }, {
                        draggable: true,
                        preset: 'islands#redDotIconWithCaption'
                    });
                map.geoObjects.add(placemark);

                var coordinates = placemark.geometry.getCoordinates();
                $("#items-coordinate_x").val(coordinates[0]);
                $("#items-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#items-address").val(address);
                            $("#items-coordinate_x").val(coordinates[0]);
                            $("#items-coordinate_y").val(coordinates[1]);
                        }
                    );
                });
                // Если карта есть, то выставляем новый центр карты и меняем данные и позицию метки в соответствии с найденным адресом.
            } else {
                map.setCenter(state.center, state.zoom);
                placemark.geometry.setCoordinates(state.center);
                placemark.properties.set({iconCaption: caption, balloonContent: caption});

                var coordinates = placemark.geometry.getCoordinates();
                $("#items-coordinate_x").val(coordinates[0]);
                $("#items-coordinate_y").val(coordinates[1]);

                placemark.events.add('dragend', function (e) {
                    var coordinates = placemark.geometry.getCoordinates();
                    var myGeocoder = ymaps.geocode(coordinates,{results: 1});
                    myGeocoder.then(
                        function (res) {
                            var street = res.geoObjects.get(0);
                            address = street.properties.get('description') + ', ' +street.properties.get('name');
                            $("#items-address").val(address);
                            $("#items-coordinate_x").val(coordinates[0]);
                            $("#items-coordinate_y").val(coordinates[1]);
                        }
                    );
                });
            }
        }

        function showMessage(message) {
            $('#messageHeader').text('Данные получены:');
            $('#message').text(message);
        }
    }
JS
);
}
$this->registerJs(<<<JS
  	setCheckvalue = function(el){
		id = 'hidden-' + el.attr('data-id');
		if($("#"+id).val() == '')
			old_value = 0;
		else
			old_value = parseInt($("#"+id).val());

		if(el.prop('checked')){
			old_value += parseInt(el.val());
		}else{
			old_value -= parseInt(el.val());
		}
		$("#"+id).val(old_value);
	}

JS
);
?>