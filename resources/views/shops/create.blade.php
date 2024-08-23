@extends('layouts.app')

@section('title'){{ trans('messages.Open shop') }} @endsection

@section('content')
    <link rel="stylesheet" href="/css/timepicker.min.css">
    <script>
        function getTerm(that) {
            var url = that.getAttribute("data-url");
            $.ajax(url, {
                type: 'GET',
                success: function (data) {
                    $("select#termList").html(data.str);
                    document.getElementById('termDate').innerHTML = data.date;
                    document.getElementById('termSum').innerHTML = data.summary;
                },
            });
        }

        function getSubscribeText(selectObject) {
            var url = "{{ URL('/shops/create/set-term-prices/') }}" + '/' + selectObject.value;
            $.ajax(url, {
                type: 'GET',
                success: function (data) {
                    document.getElementById('termDate').innerHTML = data.date;
                    document.getElementById('termSum').innerHTML = data.summary;
                },
            });
        }
    </script>

    @php
        $currentPeriod = [];
        $termSummary = null;
        $termDate = null;
    @endphp
    <section class="cabinet">
        <div class="container">
            <nav aria-label="breadcrumb" class="my_nav">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
                    </li>
                    <li class="breadcrumb-item"><a
                            href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Open shop') }}</li>
                </ol>
            </nav>
            <div class="row pb-3">
                @include('users.left_sidebar', ['user' => $user])
                <div class="col-xl-9 col-md-8">
                    <form action="{{ route('shops-save') }}" method="POST" autocomplete="off"
                          enctype="multipart/form-data" class="op_marc">
                        @csrf
                        <h2>{{ trans('messages.Rate') }}</h2>
                        <p>{{ trans('messages.Choose one of the proposed tariff plans') }}</p>
                        @if($errors->any())
                            <div class="error_lis">
                                <p>{{ trans('messages.Model error text') }}</p>
                                <ul>
                                    @foreach ($errors->all() as $message)
                                        <li>{{ $message }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="radio_mag">
                            @php $index = 0; @endphp
                            @foreach($abonements as $abonement)
                                <input type="radio" name="tariff" value="{{ $abonement->id }}" id="m{{ ++$index }}"
                                       data-url="{{ route('shops-get-term', ['id' => $abonement->id]) }}"
                                       onclick="getTerm(this)" @php if(old('tariff') == $abonement->id) { echo "checked"; $currentPeriod = $abonement->period; } @endphp >
                                <label for="m{{ $index }}">
                                    <h3>{{ $abonement->title }}</h3>
                                    <div class="ads_rad">
                                        <p>{{ str_replace('{ads_count}', $abonement->ads_count, trans('messages.Items count')) }}</p>
                                        <p>{!! $abonement->import ? trans('messages.Items import') : '<span>'.trans('messages.Items import').'</span>' !!}</p>
                                        <p>{!! $abonement->mark ? trans('messages.Items mark') : '<span>'.trans('messages.Items mark').'</span>' !!}</p>
                                        <p>{!! $abonement->fix ? trans('messages.Items fix') : '<span>'.trans('messages.Items fix').'</span>' !!}</p>
                                    </div>
                                    <b>
                                        @foreach($abonement->period as $period)
                                            @php
                                                $text = str_replace('{sum}', $period->total_price . ' ' . trans('messages.sum'), trans('messages.Price for month'));
                                                $text = str_replace('{month}', $period->month, $text);
                                                echo $text . '<br>';
                                            @endphp
                                        @endforeach
                                    </b>
                                </label>
                            @endforeach
                        </div>
                        @if ($errors->has('tariff'))
                            <span class="help-block">
                            <strong>{{ $errors->first('tariff') }}</strong>
                        </span>
                            <br>
                        @endif
                        <h2>{{ trans('messages.Term') }}</h2>
                        <p>{{ trans('messages.How much do you want to subscribe') }}</p>
                        <div class="sr_mag">
                            <div style="width: 70%">
                                <select name="term" class="js-select2" id="termList" onchange="getSubscribeText(this)">
                                    <option value="">{{ trans('messages.Select') }}</option>
                                    @foreach($currentPeriod as $period)
                                        @php
                                            if($period->id == old('term')) {
                                                $termSummary = str_replace('{term_sum}', $period->total_price, trans('messages.Term summary'));
                                                $termDate = str_replace('{term_date}', date('d.m.Y', strtotime( $period->month ." months", time())), trans('messages.Term date'));
                                            }
                                        @endphp
                                        <option
                                            value="{{ $period->id }}" {{ $period->id == old('term') ? 'selected' : '' }} >{{ $period->month . ' ' . trans('messages.month') }}</option>
                                        ;
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <p id="termDate">{{ $termDate != null ? $termDate : null }}</p>
                                <b id="termSum">{{ $termSummary != null ? $termSummary : null }}</b>
                            </div>
                        </div>
                        @if ($errors->has('term'))
                            <span class="help-block">
                            <strong>{{ $errors->first('term') }}</strong>
                        </span>
                            <br>
                        @endif
                        <h2>{{ trans('messages.All informations') }}</h2>
                        <div class="pre_file">
                            <div class="pre_file_img avatar"
                                 style="background-image: url(@if(old('temp_address')) {{ config('app.trashPath').old('temp_address') }} @else {{ config('app.noImage') }} @endif)"></div>
                            <div class="pre_file_right avatar_right">
                                <p>{{ trans('messages.Logo') }}
                                    <br>{{ trans('messages.Logo shops are highly trusted') }}</p>
                                <input type="file" name="profile_image" accept="image/*" id="file_inp">
                                <input hidden="hidden" type="text" name="temp_address" id="temp_address"
                                       value="{{ old('temp_address') }}">
                                <label for="file_inp">{{ trans('messages.Precode file') }}...</label>
                                <span>{{ str_replace('{mb_count}', 3, trans('messages.Maximum file size')) }}</span>
                                @if ($errors->has('profile_image'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('profile_image') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="pre_file">
                            <div class="pre_file_img cover"
                                 style="background-image: url(@if(old('temp_address_cover')) {{ config('app.trashPath').old('temp_address_cover') }} @else {{ config('app.noImage') }} @endif)"></div>
                            <div class="pre_file_right cover_right">
                                <p>{{ trans('messages.Cover') }}
                                    <br>{{ trans('messages.Cover shops are highly trusted') }}</p>
                                <input type="file" name="cover_image" accept="image/*" id="file_inp_cover">
                                <input hidden="hidden" type="text" name="temp_address_cover" id="temp_address_cover"
                                       value="{{ old('temp_address') }}">
                                <label for="file_inp_cover">{{ trans('messages.Precode file') }}...</label>
                                <span>{{ str_replace('{mb_count}', 3, trans('messages.Maximum file size')) }}</span>
                                @error ('cover_image')
                                    <span class="help-block">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="niked">
                            <div class="form-group">
                                <label for="name">{{ trans('messages.Name') }}*</label>
                                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                       value="{{ old('name') }}">
                                @if ($errors->has('name'))
                                    <span class="help-block">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                                @endif
                            </div>
                            <label for="category">{{ trans('messages.Category') }}</label>
                            <div class="sr_mag">
                                <select name="category[]" class="form-control js-select2" id="category"
                                        multiple="multiple" data-placeholder=" {{ trans('messages.Select') }}...">
                                    @if(old('category'))
                                        @foreach($categories as $category)
                                            <option
                                                value="{{ $category['id'] }}" {{ in_array($category['id'], old('category')) ? 'selected' : '' }} >{{ $category['title'] }}</option>
                                        @endforeach
                                    @else
                                        @foreach($categories as $category)
                                            <option value="{{ $category['id'] }}">{{ $category['title'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description">{{ trans('messages.Description') }}</label>
                                <textarea name="description" id="description"
                                          class="form-control">{{ old('description') }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="district_id">{{ trans('messages.City') }}</label><br>
                                <select name="district_id" class="js-select2" id="district_id">
                                    @foreach($regDistricts as $region)
                                        <optgroup label="{{ $region['name'] }}">
                                            @foreach($region['districtsList'] as $district)
                                                <option
                                                    value="{{ $district['id'] }}" {{ $model->district_id == $district['id'] ? 'selected=' : '' }} >{{ $district['name'] }}</option>
                                            @endforeach
                                        </optgroup>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="address">{{ trans('messages.Store Address') }}</label>
                                <input type="text" class="form-control" id="address" name="address"
                                       value="{{ old('address') }}"
                                       placeholder="{{ trans('messages.Enter store address') }}">
                            </div>
                        </div>
                        <input type="hidden" id="coordinate_x" name="coordinate_x"
                               value="{{ old('coordinate_x') != null ? old('coordinate_x') : $model->coordinate_x }}"/>
                        <input type="hidden" id="coordinate_y" name="coordinate_y"
                               value="{{ old('coordinate_y') != null ? old('coordinate_y') : $model->coordinate_y }}"/>
                        <div id="map"></div>

                        <h2>{{ trans('messages.Contact details') }}</h2>
                        <div class="niked">
                            <div class="form-group add_some">
                                <label for="#">{{ trans('messages.Contacts') }}</label>
                                @if(!empty(old('phones')))
                                    @php $i = 0; @endphp
                                    @foreach( old('phones') as $phone)
                                        @if(++$i == 1)
                                            <input type="text" name="phones[]" value="{{ $phone }}"
                                                   placeholder="+998xx-xx-xx-xx" class="form-control">
                                            <span
                                                class="add_some_contact">{{ trans('messages.+ another phone') }}</span>
                                        @else
                                            <div class="inpt_clones">
                                                <input type="text" name="phones[]" value="{{ $phone }}"
                                                       placeholder="+998xx-xx-xx-xx" class="form-control">
                                                <div class="clos_contact"></div>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <div class="inpt_clones">
                                        <input type="text" name="phones[]" placeholder="+998xx-xx-xx-xx"
                                               class="form-control">
                                    </div>
                                    <span class="add_some_contact">{{ trans('messages.+ another phone') }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="site">{{ trans('messages.Link for site') }}</label>
                                <input type="text" name="site" id="site" value="{{ old('site') }}" class="form-control"
                                       placeholder="www">
                            </div>
                            <div class="form-group">
                                <label for="site">{{ trans('messages.Work time') }}</label>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="">{{trans('messages.from')}}</label>
                                        <input type="text" name="work_time_begin" class="bs-timepicker form-control"
                                        value="{{ old('work_time_begin') }}"/>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="">{{trans('messages.to')}}</label>
                                        <input type="text" name="work_time_end" class="bs-timepicker form-control"
                                               value="{{ old('work_time_end') }}"/>
                                    </div>
                                </div>
                            </div>

                            <div class="cl" id="visible_clones" data-max-visible-count="8">
                                @for($j = 0; $j < 8; $j++)
                                    @php
                                        $class = ''; $style = '';
                                        if(old('socialNetworksValues')){
                                            if(old('socialNetworksValues')[$j] != null) $style = 'display: flex;';
                                        }
                                    @endphp
                                    @php if($j != 1) $class = 'hds_btn'; @endphp
                                    <div class="clones {{ $class }}" style="{{ $style }}">
                                        <div class="form-group">
                                            @if($j == 0) <label
                                                for="#">{{ trans('messages.Social networks') }}</label> @endif
                                            <select name="socialNetworks[]" class="js-select2">
                                                @if(old('socialNetworks'))
                                                    @foreach($socialNetworks as $social)
                                                        <option
                                                            value="{{ $social['id'] }}" {{ old('socialNetworks')[$j] == $social['id'] ? 'selected' : '' }} >
                                                            {{ $social['name'] }}
                                                        </option>
                                                    @endforeach
                                                @else
                                                    @foreach($socialNetworks as $social)
                                                        <option value="{{ $social['id'] }}">
                                                            {{ $social['name'] }}
                                                        </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            @if($j == 0)  <label for="#">{{ trans('messages.Link') }}</label> @endif
                                            <input type="text" name="socialNetworksValues[]"
                                                   value="{{ old('socialNetworksValues') ? old('socialNetworksValues')[$j] : '' }}"
                                                   class="form-control">
                                            <div class="clos"></div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                            <span class="clone_go">{{ trans('messages.+ another social network') }}</span>

                            <div class="btm_cl">
                                <a href="{{ route('profile-settings') }}"
                                   class="cans">{{ trans('messages.Cancel') }}</a>
                                <button class="op_ma">{{ trans('messages.Open shop') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('extra-js')
    @include('inc.yandex-map')
    @include('shops.javascript_code')
    <script src="/js/timepicker.min.js"></script>
    <script>
        $(function () {
            $('.bs-timepicker').timepicker({
                locale: 'ru'
            });
        });
    </script>
@endsection

