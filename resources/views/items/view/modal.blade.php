<div class="modal fade add_notes" id="auto_up" tabindex="-1" role="dialog" aria-labelledby="auto_up"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <b>{{ trans('messages.Bookmark this ad for yourself') }}</b></h5>
            </div>
            <form action="{{ route('add-note') }}" method="post" id="note-form">
                @csrf
                <input type="hidden" name="item_id" value="{{ $item['id'] }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ trans('messages.Add to notes') }}</label>
                        <textarea name="message" rows="3" class="form-control"
                                  required="">{{ $item_note ? $item_note->message:""  }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="more_know lets"
                            data-dismiss="modal">{{ trans('messages.Close') }}</button>
                    <button type="submit" class="more_know blue">{{ trans('messages.Save') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade success_save" id="auto_up"
     tabindex="-1"
     role="dialog"
     aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog" role="document" style="width: 400px">
        <div class="modal-content">
            <div class="modal-body text-center">
                <p>{{ trans('messages.Successfully saved') }}</p>
            </div>
            <div class="modal-footer" style="justify-content: center">
                <button type="button" class="more_know lets"
                        data-dismiss="modal">{{ trans('messages.Close') }}</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade price_comparison" id="auto_up"
     tabindex="-1"
     role="dialog"
     aria-labelledby="auto_up" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">
                    <b>{{ trans('messages.Price statistics') }}</b></h5>
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
            <div id="content"></div>
        </div>
    </div>
</div>
