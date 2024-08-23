<nav aria-label="breadcrumb" class="my_nav">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('site-index') }}">{{ trans('messages.Home') }}</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('profile-settings') }}">{{ trans('messages.User account') }}</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">{{ trans('messages.Crm') }}</li>
    </ol>
</nav>
