<div id="review_set" class="close_black popup_moto" style="max-width: 500px; display: none;">
    <h3>@lang('messages.Evaluation')</h3>
    <form action="{{ route('shop-rating') }}" class="popup_moto_form" id="form_op" method="POST">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop['id'] }}">
        @auth
            <div class="rait_block">
                <p class="clasificacion">
                    <input id="radio1" type="radio" name="rating" value="5">
                    <!--
                --><label for="radio1">&#9733;</label>
                    <!--
                --><input id="radio2" type="radio" name="rating" value="4">
                    <!--
                --><label for="radio2">&#9733;</label>
                    <!--
                --><input id="radio3" type="radio" name="rating" value="3">
                    <!--
                --><label for="radio3">&#9733;</label>
                    <!--
                --><input id="radio4" type="radio" name="rating" value="2">
                    <!--
                --><label for="radio4">&#9733;</label>
                    <!--
                --><input id="radio5" type="radio" name="rating" value="1">
                    <!--
                --><label for="radio5">&#9733;</label>
                </p>
            </div>
        @endauth
        <div class="form-group">
            <textarea name="message" placeholder="@lang('messages.Comment')"></textarea>
        </div>
        <button type="submit" class="more_know blue" id="send_rating">@lang('messages.Send')</button>
    </form>
</div>

<div id="all_review_view" class="close_black" style="display: none;">
    <h3>@lang('messages.Comments')</h3>
    <div class="rait">
        <div class="rait_left">
            <span>@lang('messages.Rating')</span>
            <div class="ratings">
                <div class="star-rating">
                    <span style="width:{{ 20 * $shop['ratings'] }}%"></span>
                </div>
                <b>{{ $shop['ratings'] }}</b>
            </div>
        </div>
        <div class="rait_right">
            @foreach($shop['rating_count_by_line'] as $key => $rating_count)
                <div class="rait_right__item">
                    <div>
                        @for($i = 1; $i <= 5; $i++)
                            @if($i <= $key)
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 14.4663L14.562 18L13.086 11.34L18 6.85895L11.529 6.28105L9 0L6.471 6.28105L0 6.85895L4.914 11.34L3.438 18L9 14.4663Z" fill="#FACA51"></path>
                                </svg>
                            @else
                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M9 14.4663L14.562 18L13.086 11.34L18 6.85895L11.529 6.28105L9 0L6.471 6.28105L0 6.85895L4.914 11.34L3.438 18L9 14.4663Z" fill="#D8DADE"></path>
                                </svg>
                            @endif
                        @endfor
                    </div>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{ ($shop['rating_count'] != 0 ?$rating_count / $shop['rating_count'] : 0) * 100 }}%;" aria-valuenow="200" aria-valuemin="0" aria-valuemax="800">
                        </div>
                        <span>{{ $rating_count }}</span>
                    </div>
                </div>
            @endforeach
            <div>
            </div>
        </div>
    </div>
    <div class="comments">
        @foreach($shop['comments'] as $comment)
            <div class="item_comment">
                <div class="top_item_comment">
                    <img src="{{ config('app.noImage') }}" alt="">
                    <div class="text">
                        <h5>{{ $comment->fio ?: trans('messages.user_bisyor') }}</h5>
                        {{--<div class="on_of onlines">онлайн</div>--}}
                    </div>
                </div>
                <p>{{ $comment->text }}</p>
            </div>
        @endforeach
    </div>
</div>
