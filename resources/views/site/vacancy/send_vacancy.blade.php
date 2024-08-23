<form action="{{ route('send-resume', ['id' => $vacancy['id']]) }}" class="vacant_form niked" method="post" enctype="multipart/form-data">
    @csrf
    <h5>{{ trans('messages.Apply for job') }}</h5>
    <div class="row">
        <div class="col-lg-4">
            <div class="form-group">
                <label for="#">{{ trans('messages.Your name') }}</label>
                <input type="text" class="form-control" name="name" value="{{ old('name') }}">
                <span class="help-block">
                    @if ($errors->has('name'))
                        <strong>{{ $errors->first('name') }}</strong>
                    @endif
                </span>
            </div>
            <div class="form-group">
                <label for="#">{{ trans('messages.Your phone') }}</label>
                <input type="tel" class="form-control" placeholder="+998 " name="phone" value="{{ old('phone') }}">
                <span class="help-block">
                    @if ($errors->has('phone'))
                        <strong>{{ $errors->first('phone') }}</strong>
                    @endif
                </span>
            </div>
            <div class="form-group pre_file_right">
                <input type="file" id="file_i" name="file">
                <div id="fileNameArea"></div>
                <label for="file_i">{{ trans('messages.Resume') }}</label>
                <span class="help-block">
                    @if ($errors->has('file'))
                        <strong>{{ $errors->first('file') }}</strong>
                    @endif
                </span>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="form-group">
                <textarea name="description" id="" class="form-control" placeholder="{{ trans('messages.Message') }}"
                          style="min-height: 230px"
                >{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <strong>{{ $errors->first('description') }}</strong>
                @endif
            </div>
        </div>
    </div>
    <div class="text-right">
        <button class="more_know blue">{{ trans('messages.Send') }}</button>
    </div>
</form>
