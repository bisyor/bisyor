<?php

use johnitvn\ajaxcrud\CrudAsset;
use yii\bootstrap\Modal;

$this->title = "Инструкция";
    $this->params['breadcrumbs'][] = $this->title;
    CrudAsset::register($this);
?>
<style>
    body{
        margin: 0;
        padding: 0;
    }
</style>
<div class="panel panel-inverse" data-sortable-id="ui-typography-1">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Инструкция</h4>
    </div>
    <div class="panel-body">
        <?= $this->render('buttons.php')?>
        <h3>
            <b>Mundarija :</b>
        </h3>
        <h3 style="margin-left: 3%;">
            <b>
                <a href="#alls" class="text-primary"> <i class="fa fa-list-ul"></i> Statistika bo'limi</a>
            </b>
        </h3>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="/site/index" class="text-primary"> - Statistika bo'limi uchun havola <i class="fa fa-external-link"></i></a>
                    </b>
                </h4>
               <h4 style="margin-left: 5%">
                   <b>
                       <a href="#alls" class="text-primary"> - Umumiy statistika bo'yicha</a>
                   </b>
               </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#all-items" class="text-primary"> - E'lonlar bo'yicha</a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#all-users" class="text-primary"> - Foydalanuvchilar bo'yicha</a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#all-shops" class="text-primary"> - Magazinlar bo'yicha</a>
                    </b>
                </h4>
        <h3 style="margin-left: 3%">
            <b>
                <a href="#items-sections" class="text-primary"> <i class="fa fa-list-ul"></i> E'lonlar bo'limi</a>
            </b>
        </h3>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="/items/items/index" class="text-primary"> - E'lonlar bo'limi uchun havola <i class="fa fa-external-link"></i></a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-sections" class="text-primary"> - E'lonlar ro'yxati sahifasi</a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-form" class="text-primary"> - E'lon qo'shish ,  o'zgartitish sahifasi</a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-claim" class="text-primary"> - E'lon bo'yicha tushgan shikoyatlar sahifasi</a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-service" class="text-primary"> - E'lonlar uchun xizmatlar </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-search" class="text-primary"> - Qidirilgan so'zlar natijalari </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-packet" class="text-primary"> - Xizmatlar paketi </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-category" class="text-primary"> - Kategoriyalar</a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-settings" class="text-primary"> - Sozlamalar</a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#items-limits" class="text-primary"> - Cheklovlar</a>
                    </b>
                </h4>
        <h3 style="margin-left: 3%">
            <b>
                <a href="#shops-list" class="text-primary"> <i class="fa fa-list-ul"></i> Magazinlar bo'limi</a>
            </b>
        </h3>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="/shops/shops/index" class="text-primary"> - Magazinlar bo'limi uchun havola <i class="fa fa-external-link"></i></a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#shops-list" class="text-primary"> - Magazinlar ro'yxati sahifasi </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#shops-request" class="text-primary"> - So'rovlar </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#shops-claims" class="text-primary"> - Shikoyatlar </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#shops-category" class="text-primary"> - Kategoriyalar </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#shops-services" class="text-primary"> - Xizmatlar </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#shops-period" class="text-primary"> - Tariflar </a>
                    </b>
                </h4>
        <h3 style="margin-left: 3%">
            <b>
                <a href="#users-sections" class="text-primary"> <i class="fa fa-list-ul"></i> Foydalanuvchilar bo'limi</a>
            </b>
        </h3>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="/users/users/index" class="text-primary"> - Foydalanuvchilar bo'limi uchun havola <i class="fa fa-external-link"></i></a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#users-sections" class="text-primary"> - Foydalanuvchilar va Moderatorlar ro'yxati sahifasi </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#users-banlist" class="text-primary"> - Qora ro'yxati sahifasi </a>
                    </b>
                </h4>
                <h4 style="margin-left: 5%">
                    <b>
                        <a href="#users-group" class="text-primary"> - Rollar </a>
                    </b>
                </h4>
        <h3 style="margin-left: 3%">
            <b>
                <a href="#bills-list" class="text-primary"> <i class="fa fa-list-ul"></i> To'lovlar </a>
            </b>
        </h3>

            <h4 style="margin-left: 5%">
                <b>
                    <a href="#bills-list" class="text-primary"> - To'lovlar ro'yxati </a>
                </b>
            </h4>

            <h4 style="margin-left: 5%">
                <b>
                    <a href="#bills-statistic" class="text-primary"> - Statistika </a>
                </b>
            </h4>
            <h4 style="margin-left: 5%">
                <b>
                    <a href="#bills-active_users" class="text-primary"> - Faol foydalanuvchilar </a>
                </b>
            </h4>
        <h3 style="margin-left: 3%">
            <b>
                <a href="#banners-list" class="text-primary"> <i class="fa fa-list-ul"></i> Bannerlar </a>
            </b>
        </h3>

        <h4 style="margin-left: 5%">
            <b>
                <a href="#banners-list" class="text-primary"> - Bannerlar ro'yxati </a>
            </b>
        </h4>
        <h3 style="margin-left: 3%">
            <b>
                <a href="#parser-list" class="text-primary"> <i class="fa fa-list-ul"></i> Parser </a>
            </b>
        </h3>
            <h4 style="margin-left: 5%">
                <b>
                    <a href="#parser-mehnatuz" class="text-primary"> -  Mehnatuz dan ishlarni parser qilish </a>
                </b>
            </h4>
            <h4 style="margin-left: 5%">
                <b>
                    <a href="#parser-olxusers" class="text-primary"> -   Olx dan foydalanuvchilarning e'lonlarini parser qilish </a>
                </b>
            </h4>
            <h4 style="margin-left: 5%">
                <b>
                    <a href="#parser-olxshops" class="text-primary"> -   Olx dan magazinlarni e'lonlarini parser qilish </a>
                </b>
            </h4>

        <!-- # shu yerdan statiskalar boshlanadi    -->
        <div>
            <?= $this->render('statistika/statistika.php')?>
        </div>
        <div>
            <?= $this->render('items/index.php')?>
        </div>
        <div>
            <?= $this->render('shops/index.php')?>
        </div>
        <div>
            <?= $this->render('users/index.php')?>
        </div>
        <div>
            <?= $this->render('bills/index.php')?>
        </div>
        <div>
            <?= $this->render('banners/index.php')?>
        </div>
        <div>
            <?= $this->render('parser/index.php')?>
        </div>

    </div>
</div>

<?php Modal::begin([
    "id"=>"ajaxCrudModal",
    "footer"=>"",// always need it for jquery plugin
])?>
<?php Modal::end(); ?>