@extends('layouts.app')
@section('title'){!! $seo['mtitle'] !!}@endsection
@section('meta_block')
    <meta name="description" lang="{{ app()->getLocale() }}" content="{!! $seo['mdescription'] !!}">
    <meta name="keywords" lang="{{ app()->getLocale() }}" content="{!! $seo['mkeywords'] !!}">
    <link rel="canonical" href="{{ url()->full() }}" />
    @foreach($langs as $lang)
        <link rel="alternate" hreflang="{{ $lang->url }}" href="{{ URL(($lang->default) ? $segmants : $lang->url . $segmants) }}" />
    @endforeach
@endsection
@section('content')

<section class="advertise shadow_bc" style="background-image: url(/images/reclama.jpg);">
    <div class="container">
      <h1> @lang('messages.Sell where you buy')</h1>
      <div class="d-flex">
        <a href="#planer1" class="plan_link">Тарифные планы</a>
        <a href="#zakaz_t" class="more_know">Заказать рекламу</a>
      </div>
    </div>
</section>

  <section class="advert_numbers">
    <div class="container">
      <div class="row partner_adv">
        <div class="col-4">
          <h2 class="pert1">2000</h2>
          <p>партнеров уже размещают свои товары на Bisyor</p>
        </div>
        <div class="col-4">
          <h2 class="pert2">30 тыс.</h2>
          <p>успешных продаж каждый месяц</p>
        </div>
        <div class="col-4">
          <h2 class="pert3">200 тыс.</h2>
          <p>уникальных пользователей ежемесячно</p>
        </div>
      </div>
      <div class="video_advert">
        <div class="video_advert_left">
          <video src="/video.mp4" controls=""></video>
          <div class="vid_share">
            <a href="#" class="linh_vid">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="13" viewBox="0 0 16 13">
                <g>
                  <g>
                    <path d="M9.667 3.667V.333L15.5 6.167 9.667 12V8.583C5.5 8.583 2.583 9.917.5 12.833 1.333 8.667 3.833 4.5 9.667 3.667z"></path>
                  </g>
                </g>
              </svg>
            </a>
           <!--  <div class=" dropdown_popup">
              <a href="#" class="linh_vid"><i class="fas fa-ellipsis-h"></i></a>
              <div class="dropdown_popup_body">
                <a href="#">Скачать</a>
                <a href="#">Скачать2</a>
              </div>
            </div> -->
          </div>
        </div>
        <div class="video_advert_right">
          <h2>Миллион клиентов для вашего бизнеса</h2>
          <p>Bisyor — крупнейшая по охвату площадка объявлений в Узбекистане, которая входит в ТОП-5 самых популярных ресурсов Узнета. Ежемесячно Bisyor посещают более миллиона активных пользователей, которые ищут новейшие гаджеты, автомобили, бытовую технику, недвижимость. Они заинтересованы в тех товарах и услугах, которые вы предлагаете, и готовы стать вашими клиентами.</p>
        </div>
      </div>
      <div class="row effect_part">
        <div class="col-sm-4">
          <img src="/images/ad1.png" alt="Легкий старт">
          <h3>Легкий старт</h3>
          <p>Всего пара кликов, чтобы перейти от локальных продаж к продажам по всей стране.</p>
        </div>
        <div class="col-sm-4">
          <img src="/images/ad2.png" alt="Оплата Payme и Click">
          <h3>Оплата Payme и Click</h3>
          <p>Продав что-нибудь на Bisyor, пользователь готов вложить полученные деньги в новые покупки и приобретения. В том числе те, которые раньше казались слишком дорогими.</p>
        </div>
        <div class="col-sm-4">
          <img src="/images/ad3.png" alt="Высокая эффективность">
          <h3>Высокая эффективность</h3>
          <p>До 160 заказов в месяц с одного качественного рекламного объявления.</p>
        </div>
        <div class="col-sm-4">
          <img src="/images/ad4.png" alt="Заметное размещение">
          <h3>Заметное размещение</h3>
          <p>На фоне объявлений от физических лиц ваши предложения более заметны и привлекательны.</p>
        </div>
        <div class="col-sm-4">
          <img src="/images/ad5.png" alt="Быстрый результат">
          <h3>Быстрый результат</h3>
          <p>71% наших клиентов получают отклики на объявления в первый же день их размещения.</p>
        </div>
        <div class="col-sm-4">
          <img src="/images/ad6.png" alt="Разумная цена">
          <h3>Разумная цена</h3>
          <p>От 49 рублей в месяц за размещение (при оплате тарифа на 3 месяца) плюс скидки и бонусы.</p>
        </div>
      </div>
      <h3 id="planer1" class="text-center">{{ trans('messages.Tariff Plans') }}</h3>
      <div class="row plane_tarifs_advert">
          @php $index = 0; @endphp
          @foreach($abonements as $abonement)
          <div class="col-lg-3 col-6">
              <div class="plane_tarifs_advert_item ite{{ ++$index }}">
                  <h3>{{ $abonement->title }}</h3>
                  <span>{{ str_replace('{ads_count}', $abonement->ads_count, trans('messages.Items count')) }}</span>
                  {!! $abonement->import ? trans('messages.Items import') : '<u>'.trans('messages.Items import').'</u>' !!}
                  {!! $abonement->mark ? trans('messages.Items mark') : '<u>'.trans('messages.Items mark').'</u>' !!}
                  {!! $abonement->fix ? trans('messages.Items fix') : '<u>'.trans('messages.Items fix').'</u>' !!}
                  <b>
                      @foreach($abonement->period as $period)
                          @php
                              $text = str_replace('{sum}', $period->total_price . ' ' . trans('messages.sum'), trans('messages.Price for month'));
                              $text = str_replace('{month}', $period->month, $text);
                              echo $text . '<br>';
                          @endphp
                      @endforeach
                  </b>
              </div>
          </div>
          @endforeach
      </div>
    </div>
  </section>

  <section class="benefit_adv shadow_bc" id="zakaz_t" style="background-image: url(/images/ben_bc.jpg);">
    <div class="container">
      <div class="row">
        <div class="col-xl-7 col-sm-6">
          <h2>Рассчитайте выгоду размещения на Bisyor</h2>
          <p>Оставьте свой email и узнайте, сколько лидов в месяц приносит объявление в вашей категории.</p>
        </div>
        <div class="col-xl-4 col-sm-6">
          <form action="#" class="niked">
            <div class="form-group">
              <input type="email" class="form-control" placeholder="Email">
            </div>
            <div class="form-group">
              <select name="" class="js-select2" id="">
                <option value="">Сфера деятельности</option>
                <option value="">Сфера деятельности2</option>
                <option value="">Сфера деятельности3</option>
              </select>
            </div>
            <div class="agree_ser">
              <input type="checkbox" id="ber" style="display: none;">
              <label for="ber">Я согласен с <a href="#">Политикой конфиденциальности</a></label>
            </div>
            <button class="more_know blue">Заказать рекламу</button>
          </form>
        </div>
      </div>
    </div>
  </section>

  <section class="partners">
    <div class="container">
      <h3>Наши партнеры</h3>
      <div class="swiper-container">
        <div class="swiper-wrapper">
          <div class="swiper-slide">
            <img src="/images/par1.png" alt="Директор">
            <h4>DAVRON EGAMBERDIEV</h4>
            <span>Директор “NIKE”</span>
            <p>За время сотрудничества с Куфаром наша доля рынка значительно увеличилась. Средства, затраченные на размещение, в достаточной мере оправдали себя.</p>
          </div>
          <div class="swiper-slide">
            <img src="/images/par2.png" alt="Директор">
            <h4>GAVHAR ABDULLAEVA</h4>
            <span>Директор ЧТПУП “13 район”</span>
            <p>За время сотрудничества с Куфаром наша доля рынка значительно увеличилась. Средства, затраченные на размещение, в достаточной мере оправдали себя.</p>
          </div>
          <div class="swiper-slide">
            <img src="/images/par3.png" alt="Маректолог">
            <h4>SEVARA NAZAROVA</h4>
            <span>Маректолог “ADIDAS”</span>
            <p>За время сотрудничества с Куфаром наша доля рынка значительно увеличилась. Средства, затраченные на размещение, в достаточной мере оправдали себя.</p>
          </div>
          <div class="swiper-slide">
            <img src="/images/par2.png" alt="Директор">
            <h4>GAVHAR ABDULLAEVA</h4>
            <span>Директор ЧТПУП “13 район”</span>
            <p>За время сотрудничества с Куфаром наша доля рынка значительно увеличилась. Средства, затраченные на размещение, в достаточной мере оправдали себя.</p>
          </div>
          <div class="swiper-slide">
            <img src="/images/par3.png" alt="Маректолог">
            <h4>SEVARA NAZAROVA</h4>
            <span>Маректолог “ADIDAS”</span>
            <p>За время сотрудничества с Куфаром наша доля рынка значительно увеличилась. Средства, затраченные на размещение, в достаточной мере оправдали себя.</p>
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
      <div class="swiper-button-prev">
        <svg xmlns="http://www.w3.org/2000/svg" width="5.763" height="9.333" viewBox="0 0 5.763 9.333">
        <g  transform="translate(-0.5 -0.333)">
          <path  d="M-1.1,0,0,1.1l-3.562,3.57L0,8.237l-1.1,1.1L-5.763,4.667Z" transform="translate(6.263 0.333)"></path>
        </g>
      </svg>
      </div>
      <div class="swiper-button-next">
        <svg xmlns="http://www.w3.org/2000/svg" width="5.444" height="9.333" viewBox="0 0 5.444 9.333">
        <g  transform="translate(-0.667 -0.333)">
          <path  d="M1.036,0,0,1.1l3.365,3.57L0,8.237l1.036,1.1L5.444,4.667Z" transform="translate(0.667 0.333)"></path>
        </g>
      </svg>
      </div>
    </div>
  </section>
@endsection
