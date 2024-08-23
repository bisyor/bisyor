<div class="error_lis">
    <p>{{ trans('messages.When filling out the form, the following errors occurred:') }}</p>
    <p>{{ trans('messages.Fill in all marked fields') }}</p>
    <!-- <ul>
        <li>{{ trans('messages.Not found balance')." ".trans('messages.Please top up your balance') }} <a href="{{ route('bills-payment') }}">{{ trans('messages.Continue') }}</a></li>
    </ul> -->
    @if($errors->any())
        <ul>
            @foreach ($errors->all() as $message)
                <li>{{ $message }}</li>
            @endforeach
        </ul>
    @endif
</div>
