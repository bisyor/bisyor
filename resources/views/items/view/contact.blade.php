@if (Auth::check() && !$noActualStatus)
    @if (Auth::user()->id != $user->id)
        <div id="message-content" class="robita_estete">
            <form id="form_ads_message" action="{{ route('items-message') }}" method="POST" autocomplete="off" class="vacant_form niked" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="user_id" value="{{ $user->id }}">
                <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                <h6>{{ trans('messages.Contact with author') }}</h6>
                <div class="top_item_comment">
                    <img src="{{ $user->getAvatar() }}" alt="{{ $user->getUserFio() }}">
                    <div class="text">
                        <h5>{{ $user->getUserFio() }}</h5>
                        <!-- <div class="on_of onlines">{{ trans('messages.Online') }}</div> -->
                        @if($user->getOnlineStatus())
                            <div class="on_of onlines">{{ trans('messages.Online') }}</div>
                        @else
                            <div class="on_of">{{ trans('messages.Offline') }}</div>
                        @endif
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-8">
                        <div class="error">
                            @if($errors->has('success'))
                                <div class="alert alert-success">{{ $errors->first('success') }}</div>
                            @elseif ($errors->has('user_id'))
                                <div class="alert alert-dannger">{{ $errors->first('user_id') }}</div>
                            @elseif ($errors->has('message'))
                                <div class="alert alert-danger">{{ $errors->first('message') }}</div>
                            @endif

                        </div>
                        <div class="form-group" id="metiric">
                            <textarea name="message" id="message_ads" class="form-control" placeholder="{{ trans('messages.Message') }}">{{ old('message') }}</textarea>
                        </div>
                        <div class="form-group file_content" style="display: none"></div>
                    </div>
                    <div class="col-lg-4">
                        <!-- <div class="form-group">
                            <label for="#">Ваш e-mail адрес</label>
                            <input type="email" class="form-control" required="" placeholder="Email">
                        </div> -->
                        <div class="form-group pre_file_right">
                            <input type="file" name="file" id="file_i">
                            <label for="file_i">{{ trans('messages.Precode file') }}</label>
                        </div>
                        <button type="submit" class="more_know blue">{{ trans('messages.Send') }}</button>
                    </div>
                </div>
            </form>
        </div>
    @endif
@endif
