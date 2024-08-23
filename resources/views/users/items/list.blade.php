@extends('layouts.app')
@section('title'){{ trans('messages.Ads') }} @endsection
@stack('after-styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.css"
      integrity="sha512-/zs32ZEJh+/EO2N1b0PEdoA10JkdC3zJ8L5FTiQu82LR9S/rOQNfQN7U59U9BC12swNeRAz3HSzIL2vpp4fv3w=="
      crossorigin="anonymous"/>
@section('content')

    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Ads') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8 c_cabinet">
                    <ul class="nav tab_top_cabinet">
                        <li><a data-toggle="tab" class="{{ $active_tab == '#ff1' ? 'active show':'' }}" href="#ff1">{{ trans('messages.Active') }}</a></li>
                        <li><a data-toggle="tab" class="{{ $active_tab == '#ff2' ? 'active show':'' }}"  href="#ff2">{{ trans('messages.On checking') }}</a></li>
                        <li><a data-toggle="tab" class="{{ $active_tab == '#ff3' ? 'active show':'' }}" href="#ff3">{{ trans('messages.No active') }}</a></li>
                        <li><a data-toggle="tab" class="{{ $active_tab == '#ff4' ? 'active show':'' }}" href="#ff4">{{ trans('messages.Block') }}</a></li>
                        <li><a data-toggle="tab" class="{{ $active_tab == '#ff0' ? 'active show':'' }}" href="#ff0">{{ trans('messages.All items') }}</a></li>
                    </ul>
                    @include('users.items.search', ['category_list' =>$category_list])
                    <div class="tab-content">
                        <div id="ff1" class="tab-pane fade {{ $active_tab == '#ff1' ? 'active show':'' }}">
                            <div class="pro_general">
                                @include('users.items.itemschild', ['items' => $activeItems])
                                @if(count($activeItems) == 0)
                                    @include('users.items.ads_not_found', [])
                                @endif
                            </div>
                            <noscript>
                                <div class="row col-12 mb-3">
                                    <a class="btn-success__border mr-auto ml-auto"
                                       href="{{ route('profile-items-list', ['page' => $page, 'a_t' => '#ff1']) }}">{{ trans('messages.More view') }}</a>
                                </div>
                            </noscript>
                        </div>
                        <div id="ff2" class="tab-pane fade {{ $active_tab == '#ff2' ? 'active show':'' }}">
                            <div class="pro_general">
                                @include('users.items.itemschild', ['items' => $moderatingItems])
                                @if(count($moderatingItems) == 0)
                                    @include('users.items.ads_not_found', [])
                                @endif
                            </div>
                            <noscript>
                                <div class="row col-12 mb-3">
                                    <a class="btn-success__border mr-auto ml-auto"
                                       href="{{ route('profile-items-list', ['page' => $page, 'a_t' => '#ff2']) }}">{{ trans('messages.More view') }}</a>
                                </div>
                            </noscript>
                        </div>
                        <div id="ff3" class="tab-pane fade {{ $active_tab == '#ff3' ? 'active show':'' }}">
                            <div class="pro_general">
                                @include('users.items.itemschild', ['items' => $noActiveItems])
                                @if(count($noActiveItems) == 0)
                                    @include('users.items.ads_not_found', [])
                                @endif
                            </div>
                            <noscript>
                                <div class="row col-12 mb-3">
                                    <a class="btn-success__border mr-auto ml-auto"
                                       href="{{ route('profile-items-list', ['page' => $page, 'a_t' => '#ff3']) }}">{{ trans('messages.More view') }}</a>
                                </div>
                            </noscript>
                        </div>
                        <div id="ff4" class="tab-pane fade {{ $active_tab == '#ff4' ? 'active show':'' }}">
                            <div class="pro_general">
                                @include('users.items.itemschild', ['items' => $blockedItems])
                                @if(count($blockedItems) == 0)
                                    @include('users.items.ads_not_found', [])
                                @endif
                            </div>
                            <noscript>
                                <div class="row col-12 mb-3">
                                    <a class="btn-success__border mr-auto ml-auto"
                                       href="{{ route('profile-items-list', ['page' => $page, 'a_t' => '#ff4']) }}">{{ trans('messages.More view') }}</a>
                                </div>
                            </noscript>
                        </div>
                        <div id="ff0" class="tab-pane fade {{ $active_tab == '#ff0' ? 'active show':'' }}">
                            <div class="pro_general">
                                @include('users.items.itemschild', ['items' => $allItems])
                                @if(count($allItems) == 0)
                                    @include('users.items.ads_not_found', [])
                                @endif
                            </div>
                            <noscript>
                                <div class="row col-12 mb-3">
                                    <a class="btn-success__border mr-auto ml-auto"
                                       href="{{ route('profile-items-list', ['page' => $page, 'a_t' => '#ff5']) }}">{{ trans('messages.More view') }}</a>
                                </div>
                            </noscript>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="deleteItems" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">{{ trans('messages.Confirm action') }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        {{ trans('messages.Are you sure you want to delete this item?') }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                                data-dismiss="modal">{{ trans('messages.No') }}</button>
                        <a href="#" id="url" class="btn btn-primary">{{ trans('messages.Yes') }}</a>
                    </div>
                </div>
            </div>
        </div>
        @include('users.items.modal', [])
    </section>
@endsection
@section('extra-js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.min.js"
            integrity="sha512-d9xgZrVZpmmQlfonhQUvTR7lMPtO7NkZMkA0ABN3PHCbKA5nqylQ/yWlFAyY6hYgdF1Qh6nYiuADWwKB4C2WSw=="
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.bundle.min.js"
            integrity="sha512-SuxO9djzjML6b9w9/I07IWnLnQhgyYVSpHZx0JV97kGBfTIsUYlWflyuW4ypnvhBrslz1yJ3R+S14fdCWmSmSA=="
            crossorigin="anonymous"></script>
    <script>
        $(document).on('click', '.btn_modal', function () {
            var id = $(this).data('id');
            $('#url').attr('href', '{{ route('site-index') }}/profile/obyavlenie/items/delete/' + id);
            $('#deleteItems').modal('show');
        });

        const messageContent = $('.message_body');
        $(document).on('click', '.blocker-reason', (event) => {
            const message = event.target.dataset.message;
            messageContent.text('');
            messageContent.text(message);
            $('.error_message').modal('show');
        });


        $(document).on('click', '.open-confirm', (event) => {
            event.preventDefault();
            $('#is_buyed').val('1');
            const link = event.target.href;
            $('.go_deactivate_success').attr('href', link + "&is_buyed=1");
            $('.go_deactivate_failed').attr('href', link + "&is_buyed=0");
            $('.confirm_success_modal').modal();
        });


        $(document).on('click', '#url', function () {
            $('#deleteItems').modal('hide');
        });

        $(document).on('change', '#change_point', (event) => {
            $('#in').toggle();
            $('#periodically').toggle();
        });

        $(document).on('click', '.open_auto_up', function(e) {
            const id = $(this).data('id');
            $('#id_item').val(id);
            $.ajax({
                url: "{{ route('get-item-auto-setting') }}",
                type: 'GET',
                data: {
                    item_id: id,
                },
                success: function (data) {
                    if(data !== 'auto-error') {
                        for (let key in data) {
                            $(`select[name="${key}"]`).val(data[key]).select2();
                        }
                        if(data.t == 2){
                            $('#in').hide();
                            $('#periodically').show();
                        }else{
                            $('#in').show();
                            $('#periodically').hide();
                        }
                        $('#auto_up').modal();
                    }
                    else {
                        //alert('Произошла ошибка сервера. Пожалуйста, свяжитесь с администратором!');
                        $('#auto_up').modal();
                    }
                    //window.location.reload();
                },
                error: function (error) {
                    console.log(error.responseText);
                }
            });

        });

        $(document).on('submit', '#auto_raise_form', function (e) {
            const registerForm = $(this);
            e.preventDefault();
            const formData = registerForm.serialize();

            $.ajax({
                url: "{{ route('profile-items-auto-raise') }}",
                type: 'POST',
                data: formData,
                success: function (data) {
                    //console.log(data);
                    window.location.reload();
                },
                error: function (error) {
                    console.log(error.responseText);
                }
            });
            return false;
        });
        const stat_views_chart_id = 'stat_views';
        const stat_contacts_chart_id = 'stat_contacts';

        function buildChart(statSection, labelsChart, dataChart, label){
            let canvasChart = `<canvas id="${statSection}_chart" height="100"></canvas>`;
            $(`#${statSection}`).html(canvasChart);  // Create new chart canvas

            let ctx = document.getElementById(`${statSection}_chart`);
            let myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labelsChart,
                    datasets: [{
                        label,
                        data: dataChart,
                        backgroundColor: [
                            'rgba(36, 175, 255, 0.1)',
                        ],
                        borderColor: [
                            'rgba(36, 175, 255, 1)',
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true,
                                stepSize: 1,
                            }
                        }]
                    }
                }
            });
        }

        $(document).on('click', '.view_stat', (event) => {
            event.preventDefault();
            $.ajax({
                url: event.target.href,
                type: 'GET',
                success: function (data) {
                    buildChart(stat_views_chart_id, data.labels, data.item_views, "@lang('messages.view_stat')");
                    buildChart(stat_contacts_chart_id, data.labels, data.contacts_views, "@lang('messages.contact_stat')");
                    $('.item_stat').modal('show');
                },
                error: function (error) {
                    console.log(error.responseText);
                }
            });
        });

        /*
        * Elonni o'chirishni bosganda uni tasdiqlashni so'raydi
        * */
        $(document).on('click', '.delete_item', function (event){
            event.preventDefault();
            $('.accept_delete').attr('href', event.target.href);
            $('.confirm_item_delete').modal('show');
        });

    </script>
    <script>
        let page = {
            'ff0': {page: {{ $page && $active_tab == '#ff1' ? $page : 1 }}, flag: false},
            'ff1': {page: {{ $page && $active_tab == '#ff2' ? $page : 1 }}, flag: false},
            'ff2': {page: {{ $page && $active_tab == '#ff3' ? $page : 1 }}, flag: false},
            'ff3': {page: {{ $page && $active_tab == '#ff4' ? $page : 1 }}, flag: false},
            'ff4': {page: {{ $page && $active_tab == '#ff5' ? $page : 1 }}, flag: false}
        };

        function infiniteLoad(id) {
            page[id]['flag'] = false;
        }

        $(window).scroll(function () {
            var id = $('.tab-pane.active').attr('id');
            if (page[id]['flag']) return;
            var footer = $('#footerId').get(0);
            var raznitsa = $(document).height() - $(window).height() - footer.scrollHeight - 250/* - phones.scrollHeight*/;

            if ($(window).scrollTop() > raznitsa) {
                if (['ff0', 'ff1', 'ff2', 'ff3', 'ff4'].includes(id)) {
                    page[id]['flag'] = true;
                    page[id]['page']++;
                    $.ajax({
                        url: "{{ route('user-items-page') }}",
                        type: 'GET',
                        data: {
                            page: page[id]['page'],
                            type: id,
                            {{ request()->input('title') ? "title: '".request()->input('title')."',":'' }}
                            {!! request()->input('category') ? "category: ".request()->input('category').",":'' !!}
                        },
                        dataType: 'JSON',
                        success: function (data) {
                            $('#' + id).children('.pro_general').append(data.msg);
                            if (data.itemCount > 0) infiniteLoad(id);
                            $('.popup_tooltip').popover();
                        }
                    });
                }
            }
        });

        $("#search_items").submit(function(e){
            $('input[name="a_t"]').val($('.active.show').attr('href'));
            const emptyInputs = $(this).find('input').filter(function(){
                return !$.trim(this.value).length;
            }).prop('disabled',true);
        });

        $('.popup_tooltip').popover({
            trigger: "manual",
            html: true,
            animation: false
        })
            .on("mouseenter", function() {
                var _this = this;
                $(this).popover("show");
                $(".popover").on("mouseleave", function() {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function() {
            var _this = this;
            setTimeout(function() {
                if (!$(".popover:hover").length) {
                    $(_this).popover("hide");
                }
            }, 500);
        });

    </script>
@endsection
