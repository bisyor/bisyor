<?php
    $this->title = 'Выгрузки сайта';
    $this->params['breadcrumbs'][] = $this->title;
?>
<div class="panel panel-inverse" data-sortable-id="table-basic-5">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-repeat"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Список</h4>
    </div>
    <div class="panel-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Описание</th>
                    <th>Действие</th>
                    <th>Описание</th>
                    <th>Действие</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Загрузить языковые переводы</td>
                    <td><a href="https://dash.bisyor.uz/references/language/download-language-file" target="_blank" class="btn btn-primary btn-xs">Загрузить <span class="fa fa-external-link"></span></a></td>
                    <td>Загрузить все настройки сайта</td>
                    <td><a href="https://dash.bisyor.uz/settings/site-settings/download-settings-file" target="_blank" class="btn btn-primary btn-xs">Загрузить <span class="fa fa-external-link"></span></a></td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Загрузить регион и районы</td>
                    <td><a href="https://bisyor.uz/static-region" target="_blank" class="btn btn-primary btn-xs">Загрузить <span class="fa fa-external-link"></span></a></td>
                    <td>Загрузить топ категории</td>
                    <td><a href="https://bisyor.uz/static-top-categories" target="_blank" class="btn btn-primary btn-xs">Загрузить <span class="fa fa-external-link"></span></a></td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>Загрузить топ(header) меню</td>
                    <td><a href="https://bisyor.uz/static-header" target="_blank" class="btn btn-primary btn-xs">Загрузить <span class="fa fa-external-link"></span></a></td>
                    <td>#</td>
                    <td>#</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>