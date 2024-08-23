<div class="modal fade auto_up" id="auto_up" tabindex="-1" role="dialog" aria-labelledby="auto_up" aria-hidden="true">
    <form class="modal-dialog" id="auto_raise_form" role="document">
        @csrf
        <input type="hidden" id="id_item" name="id_item" >
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">{{ trans('messages.Enable Auto Raise') }}</h5>
          <button type="button" class="closes" data-dismiss="modal" aria-label="Close">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="black"/>
              <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="5" y="5" width="14" height="14">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="white"/>
              </mask>
              <g mask="url(#mask0)">
              <rect width="24" height="24" fill="black" fill-opacity="0.4"/>
              </g>
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <div class="auto_up_top">
            <span>{{ trans('messages.Auto raise') }}</span>
            <div class="togg">
              <input checked type="checkbox" id="togg" name="raise_auto" value="1" />
              <label for="togg"></label>
            </div>
          </div>
          <div class="auto_up_selects">
            <div class="form-group">
               <select name="p" class="js-select2"  id="">
                  <option value="1">{{ trans('messages.Every day') }}</option>
                  <option value="3">{{ trans('messages.Every three day') }}</option>
                  <option value="7">{{ trans('messages.Once a week') }}</option>
                  <option value="-1">{{ trans('messages.Every week day') }}</option>
                </select>
            </div>

              <div class="form-group">
                   <select name="t" class="js-select2"  id="change_point">
                      <option value="1">{{ trans('messages.In') }}</option>
                      <option value="2">{{ trans('messages.periodically') }}</option>
                   </select>
              </div>
              <div id="in">
                  <div class="form-group">
                      <select name="h" class="js-select2">
                          <option value="0">00</option>
                          <option value="1">01</option>
                          <option value="2">02</option>
                          <option value="3">03</option>
                          <option value="4">04</option>
                          <option value="5">05</option>
                          <option value="6">06</option>
                          <option value="7">07</option>
                          <option value="8">08</option>
                          <option value="9">09</option>
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                          <option value="13">13</option>
                          <option value="14">14</option>
                          <option value="15">15</option>
                          <option value="16">16</option>
                          <option value="17">17</option>
                          <option value="18">18</option>
                          <option value="19">19</option>
                          <option value="20">20</option>
                          <option value="21">21</option>
                          <option value="22">22</option>
                          <option value="23">23</option>
                      </select>
                  </div>
                  <div class="form-group">
                      <select name="m" class="js-select2">
                          <option value="0">00</option>
                          <option value="10">10</option>
                          <option value="20">20</option>
                          <option value="30">30</option>
                          <option value="40">40</option>
                          <option value="50">50</option>
                      </select>
                  </div>
              </div>
          </div>
            <div id="periodically" style="display: none">
                <div class="form-group">
                    <label>{{ trans('messages.from') }}</label>
                    <div class="d-flex">
                        <select name="fr_h" class="js-select2">
                            <option value="0">00</option>
                            <option value="1">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            <option value="6">06</option>
                            <option value="7">07</option>
                            <option value="8">08</option>
                            <option value="9">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                        </select>
                        <select name="fr_m" class="js-select2 ml-2">
                            <option value="0">00</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                        </select>
                    </div>

                </div>
                <div class="form-group">
                    <label>{{ trans('messages.to') }}</label>
                    <div class="d-flex">
                        <select name="to_h" class="js-select2">
                            <option value="0">00</option>
                            <option value="1">01</option>
                            <option value="2">02</option>
                            <option value="3">03</option>
                            <option value="4">04</option>
                            <option value="5">05</option>
                            <option value="6">06</option>
                            <option value="7">07</option>
                            <option value="8">08</option>
                            <option value="9">09</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                        </select>
                        <select name="to_m" class="js-select2">
                            <option value="0">00</option>
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="40">40</option>
                            <option value="50">50</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label>{{ trans('messages.Per') }}</label>
                    <select name="int" class="js-select2">
                        <option value="30">{{ trans('messages.Half an hour') }}</option>
                        <option value="60">{{ trans('messages.Hour') }}</option>
                        <option value="120">{{ trans('messages.Two hour') }}</option>
                        <option value="180">{{ trans('messages.Three hour') }}</option>
                        <option value="240">{{ trans('messages.Four hour') }}</option>
                        <option value="300">{{ trans('messages.Five hour') }}</option>
                    </select>
                </div>

            </div>
          <p>{{ trans('messages.When activating auto raise') }}</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="more_know lets" data-dismiss="modal">{{ trans('messages.Cancel') }}</button>
          <button type="submit" class="more_know blue">{{ trans('messages.To apply') }}</button>
        </div>
      </div>
    </form>
  </div>


{{-- Elon sotilgan yoki sotilmagan ekanligini tasdiqlash --}}

<div class="modal fade confirm_success_modal" id="auto_up" tabindex="-1" role="dialog" aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('messages.Deactivation') }}</h5>
                <button type="button" class="closes" data-dismiss="modal" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="black"/>
                        <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="5" y="5" width="14" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0)">
                            <rect width="24" height="24" fill="black" fill-opacity="0.4"/>
                        </g>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="auto_up_top">
                    <span>{{ trans('messages.Is buyed') }}</span>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary more_know lets go_deactivate_failed">{{ trans('messages.No') }}</a>
                <a class="btn btn-secondary more_know blue go_deactivate_success">{{ trans('messages.Yes') }}</a>
            </div>
        </div>
    </div>
</div>


{{-- Elonni o'chirishdan oldin tasdiqlashni so'rash uchun modal--}}

<div class="modal fade confirm_item_delete" id="auto_up" tabindex="-1" role="dialog" aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">{{ trans('messages.Delete') }}</h5>
                <button type="button" class="closes" data-dismiss="modal" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="black"/>
                        <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="5" y="5" width="14" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0)">
                            <rect width="24" height="24" fill="black" fill-opacity="0.4"/>
                        </g>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <div class="auto_up_top">
                    <span>{{ trans('messages.Are you sure you want to delete this item?') }}?</span>
                </div>
            </div>
            <div class="modal-footer">
                <a class="btn btn-secondary more_know lets" data-dismiss="modal">{{ trans('messages.No') }}</a>
                <a class="btn btn-secondary more_know blue accept_delete">{{ trans('messages.Yes') }}</a>
            </div>
        </div>
    </div>
</div>


{{-- Error xabarni modalda ko'rsatish--}}

<div class="modal fade error_message" id="auto_up" tabindex="-1" role="dialog" aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <p class="modal-title" id="exampleModalLabel"><b>{{ trans('messages.Removed from publication') }}</b></h5>
            </div>
            <div class="modal-body">
                <div class="auto_up_top">
                    <p class="message_body"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="more_know lets" data-dismiss="modal">{{ trans('messages.Close') }}</button>
            </div>
        </div>
    </div>
</div>


{{-- Elon statistikasini chiqarish uchun oyna --}}

<div class="modal fade item_stat" id="auto_up" tabindex="-1" role="dialog" aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">@lang('messages.View statistics')</h5>
                <button type="button" class="closes" data-dismiss="modal" aria-label="Close">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="black"/>
                        <mask id="mask0" mask-type="alpha" maskUnits="userSpaceOnUse" x="5" y="5" width="14" height="14">
                            <path fill-rule="evenodd" clip-rule="evenodd" d="M12 10.5858L17.2929 5.29289C17.6834 4.90237 18.3166 4.90237 18.7071 5.29289C19.0976 5.68342 19.0976 6.31658 18.7071 6.70711L13.4142 12L18.7071 17.2929C19.0976 17.6834 19.0976 18.3166 18.7071 18.7071C18.3166 19.0976 17.6834 19.0976 17.2929 18.7071L12 13.4142L6.70711 18.7071C6.31658 19.0976 5.68342 19.0976 5.29289 18.7071C4.90237 18.3166 4.90237 17.6834 5.29289 17.2929L10.5858 12L5.29289 6.70711C4.90237 6.31658 4.90237 5.68342 5.29289 5.29289C5.68342 4.90237 6.31658 4.90237 6.70711 5.29289L12 10.5858Z" fill="white"/>
                        </mask>
                        <g mask="url(#mask0)">
                            <rect width="24" height="24" fill="black" fill-opacity="0.4"/>
                        </g>
                    </svg>
                </button>
            </div>
            <div class="modal-body">
                <ul class="nav tab_top_cabinet">
                    <li><a data-toggle="tab" class="tab_stat_views active show" href="#stat_views">@lang('messages.view_stat')</a></li>
                    <li><a data-toggle="tab" class="tab_stat__contacts" href="#stat_contacts">@lang('messages.contact_stat')</a></li>
                </ul>
                <div class="tab-content">
                    <div id="stat_views" class="tab-pane fade active show">
                    </div>
                    <div id="stat_contacts" class="tab-pane fade ">
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
