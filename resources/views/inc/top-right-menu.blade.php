<div class="hdr_top_right">
    @if(!\Auth::check())
        <a href="{{ Route::currentRouteName() == 'noauth-user-favorites-list' ? 'javascript:void(0)' : route('noauth-user-favorites-list') }}">
            <svg xmlns="http://www.w3.org/2000/svg" width="15.269" height="13.488" viewBox="0 0 15.269 13.488">
                <path id="Shape" d="M7.634,13.488a.662.662,0,0,1-.471-.2L1.269,7.4A4.334,4.334,0,0,1,7.4,1.27l.235.235.235-.235a4.334,4.334,0,0,1,7.4,3.064A4.3,4.3,0,0,1,14,7.4L8.105,13.292A.662.662,0,0,1,7.634,13.488ZM4.334,1.334A3,3,0,0,0,2.212,6.457l5.422,5.422,4.715-4.715.707-.707A3,3,0,1,0,8.812,2.213l-.707.706a.666.666,0,0,1-.943,0l-.707-.706A2.981,2.981,0,0,0,4.334,1.334Z"></path>
            </svg>
            <span>{{ trans('messages.Favorites') }}</span>
        </a>
    @endif
    <a href="{{ (Route::currentRouteName() == 'items-list' && Route::getCurrentRoute()->parameters('keyword') == null) ? 'javascript:void(0)' : route('items-list') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="14.667" height="15.687" viewBox="0 0 14.667 15.687">
            <path id="Combined_Shape" data-name="Combined Shape" d="M6.435,15.476,1.1,12.808a2.013,2.013,0,0,1-1.1-1.8V4.666A1.988,1.988,0,0,1,1.109,2.876L3.645,1.608a.669.669,0,0,1,.115-.058L6.443.209a2,2,0,0,1,1.78,0l5.333,2.667a1.99,1.99,0,0,1,1.11,1.79V11.02a1.987,1.987,0,0,1-1.109,1.789L8.225,15.475a2,2,0,0,1-1.79,0Zm-5.1-4.459a.671.671,0,0,0,.365.6L6.667,14.1V7.585L1.333,4.918ZM8,14.1l4.964-2.482a.661.661,0,0,0,.37-.6v-6.1L10.978,6.1l-.026.013L8,7.585Zm-.667-7.67,1.843-.921L4,2.92l-1.843.921Zm3.333-1.667,1.839-.919L7.63,1.4a.666.666,0,0,0-.592,0l-1.544.772Z" transform="translate(0)" />
        </svg>
        <span>{{ trans('messages.Ads') }}</span>
    </a>
    <a href="{{ Route::currentRouteName() == 'shops-list' ? 'javascript:void(0)' : route('shops-list') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16">
            <g><g><path d="M5.4 11.4V11a.6.6 0 0 1 1.2 0v1a.6.6 0 0 1-.6.6H4a.6.6 0 0 1-.6-.6v-1a.6.6 0 0 1 1.2 0v.4zm3.2-.467V14.4h2.8v-3.467zm3.8-9.266a.067.067 0 0 0-.067-.067H3.667a.067.067 0 0 0-.067.067V2.4h8.8zm.85 6.483a1.15 1.15 0 0 0 1.147-1.062l-1.148-3.442a.067.067 0 0 0-.063-.046H2.814a.067.067 0 0 0-.063.046L1.603 7.088A1.15 1.15 0 0 0 3.9 7a.6.6 0 0 1 1.2 0 1.15 1.15 0 1 0 2.3 0 .6.6 0 0 1 1.2 0 1.15 1.15 0 1 0 2.3 0 .6.6 0 0 1 1.2 0c0 .635.515 1.15 1.15 1.15zM.4 7l.03-.19 1.182-3.544c.127-.38.423-.67.788-.797v-.802C2.4.967 2.967.4 3.667.4h8.666c.7 0 1.267.567 1.267 1.267v.802c.365.127.66.416.788.797l1.181 3.544.031.19c0 .795-.395 1.499-1 1.924v5.41c0 .699-.567 1.266-1.267 1.266H2.667c-.7 0-1.267-.567-1.267-1.267v-5.41A2.347 2.347 0 0 1 .4 7zm5.85 2.35c-.695 0-1.32-.302-1.75-.782a2.344 2.344 0 0 1-1.9.777v4.988c0 .037.03.067.067.067H7.4v-4.067a.6.6 0 0 1 .6-.6h4a.6.6 0 0 1 .6.6V14.4h.733c.037 0 .067-.03.067-.067V9.345a2.344 2.344 0 0 1-1.9-.777c-.43.48-1.055.782-1.75.782-.695 0-1.32-.302-1.75-.782-.43.48-1.055.782-1.75.782z" /></g></g>
        </svg>
        <span>{{ trans('messages.Shops') }}</span>
    </a>
    <a href="{{ Route::currentRouteName() == 'services' ? 'javascript:void(0)' : route('services') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="14.666" height="13.333" viewBox="0 0 14.666 13.333">
            <path id="Combined_Shape1" data-name="Combined Shape" d="M10,13.333H2a2,2,0,0,1-2-2V4.667a2,2,0,0,1,2-2H4V2A2,2,0,0,1,6,0H8.666a2,2,0,0,1,2,2v.667h2a2,2,0,0,1,2,2v6.667a2,2,0,0,1-2,2ZM12.667,12a.667.667,0,0,0,.667-.667V4.667A.667.667,0,0,0,12.667,4h-2v8ZM9.334,12V4h-4v8Zm-8-7.333v6.667A.667.667,0,0,0,2,12H4V4H2A.667.667,0,0,0,1.333,4.667Zm8-2V2a.667.667,0,0,0-.667-.667H6A.667.667,0,0,0,5.333,2v.667Z" />
        </svg>
        <span>{{ trans('messages.Services') }}</span>
    </a>
    <a href="{{ Route::currentRouteName() == 'blogs-list' ? 'javascript:void(0)' : route('blogs-list') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="14.663" height="14.672" viewBox="0 0 14.663 14.672">
            <path id="Combined_Shape2" data-name="Combined Shape" d="M.195,14.477a.667.667,0,0,1,0-.943l1.8-1.8V6.339a.663.663,0,0,1,.2-.472l4.5-4.5a4.669,4.669,0,0,1,6.6,6.6L8.805,12.476a.664.664,0,0,1-.472.2H2.943l-1.8,1.8a.667.667,0,0,1-.943,0Zm7.862-3.138,1.329-1.333H5.609L4.276,11.339ZM7.638,2.31l-4.3,4.305V10.4l6.2-6.2a.667.667,0,0,1,.943.943L6.942,8.672h3.724l.047,0,1.641-1.646A3.336,3.336,0,1,0,7.638,2.31Z" />
        </svg>
        <span>{{ trans('messages.Blog') }}</span>
    </a>
    <a href="{{ Route::currentRouteName() == 'help' ? 'javascript:void(0)' : route('help') }}">
        <svg xmlns="http://www.w3.org/2000/svg" width="14.666" height="14.666" viewBox="0 0 14.666 14.666">
            <path id="Combined_Shape3" data-name="Combined Shape" d="M2.148,12.518a7.333,7.333,0,1,1,10.37-10.37,7.333,7.333,0,1,1-10.37,10.37Zm5.185.815a5.972,5.972,0,0,0,3.743-1.314L9.171,10.113a3.327,3.327,0,0,1-3.675,0L3.59,12.019A5.972,5.972,0,0,0,7.333,13.333Zm-6-6a5.972,5.972,0,0,0,1.314,3.743L4.553,9.171a3.328,3.328,0,0,1,0-3.674L2.647,3.59A5.972,5.972,0,0,0,1.333,7.333Zm10.686,3.743a5.989,5.989,0,0,0,0-7.486L10.113,5.5a3.327,3.327,0,0,1,0,3.675ZM5.333,7.333a2,2,0,1,0,2-2A2,2,0,0,0,5.333,7.333ZM5.5,4.553a3.328,3.328,0,0,1,3.674,0l1.906-1.906a5.989,5.989,0,0,0-7.487,0Z" />
        </svg>
        <span>{{ trans('messages.Help') }}</span>
    </a>
</div>  