<div class="panel panel-inverse">
    <div class="panel-heading">
        <div class="panel-heading-btn">
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
        </div>
        <h4 class="panel-title">Статистика просмотров контактов в процентах</h4>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-12">
                <br>
                Новые за <a class="dropdown-toggle" data-toggle="dropdown" id="dropdownMenuLinkContact" style="cursor:pointer;">
                    неделю <span class="fa fa-caret-down"></span>
                </a>
                <div class="pull-right">
                    <button id="click_contact_line" class="btn btn-default btn-sm active"><span class="fa fa-line-chart"></button>
                    <button id="click_contact_bar" class="btn btn-default btn-sm"><span class="fa fa-bar-chart"></button>
                </div>
                <ul class="dropdown-menu"  aria-labelledby="dropdownMenuButton">
                    <li><a id="week" class="select_contact" style="cursor:pointer;">неделю</a></li>
                    <li><a id="month" class="select_contact" style="cursor:pointer;">месяц</a></li>
                    <li><a id="kvartal" class="select_contact" style="cursor:pointer;">квартал</a></li>
                    <li><a id="year" class="select_contact" style="cursor:pointer;">год</a></li>
                </ul>
            </div>
        </div>
        <div id="chart_contact" class="row">
            <?= $this->render('chart_contact',[
                'label_contact_chart' => $label_contact_chart,
                'count_contact_chart' => $count_contact_chart,
            ]);?>
        </div>
    </div>
</div>

