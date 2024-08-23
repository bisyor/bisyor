<div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
        <div class="modal-body" style="overflow: hidden;">
            <button type="button" class="close" data-dismiss="modal">×</button>
            <form action="#" class="registr niked">
                <a href="{{ route('site-index') }}" class="logo_reg">
                    <img src="{{ Config::get('app.settingsPath') . Config::get('settings.logo') }}" alt="{{ Config::get('settings.logo') }}">
                </a>
                <div class="seccuse">
                    <img src="/images/succes.png" alt="Success">
                </div>
                <h1>{{ trans('messages.Successfully registered') }}</h1
            </form>
        </div>
    </div>
</div>
