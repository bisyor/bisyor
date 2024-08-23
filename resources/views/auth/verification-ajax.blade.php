@if (!Auth::guest() && !Auth::user()->phone_verified)
    <div class="modal fade" id="verifiyModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true"></div>
@endif

<script>
    var verifyModal = $('#verifiyModal');
    $(document).on('click', '#calModal', function () {
        if (verifyModal.text() === '') {
            $.ajax({
                url: "{{ route('verify-page-ajax') }}",
                type: 'GET',
                success: function (data) {
                    if (data.form) {
                        verifyModal.html(data.form);
                        verifyModal.modal();
                    } else {
                        console.log(data.form);
                    }
                },
                error: function (error) {
                    console.log(error);
                }
            });
        } else {
            verifyModal.modal();
        }
    })

    $(document).on('submit', '#confirm-sms', function (e) {
        let registerForm = $(this);
        let formData = registerForm.serialize();

        $.ajax({
            url: "{{ route('verify-code-post-ajax') }}",
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data.success) {
                    // $('#verifiyModal').html(data.page);
                    window.location.href = "{{ route('create-item') }}";
                } else {
                    const smsCode = $('#sms_code');
                    smsCode.next('.help-block').children('strong').html(data.message);
                    smsCode.addClass('is-invalid');
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
        return false;
    });

    $(document).on('submit', '#confirmForm', function () {
        let registerForm = $(this);
        let formData = registerForm.serialize();
        $.ajax({
            url: "{{ route('verify-code-get-ajax') }}",
            type: 'POST',
            data: formData,
            success: function (data) {
                if (data.form) {
                    verifyModal.html(data.form);
                } else if (data.errors) {
                    console.log(data.errors);
                }
            },
            error: function (error) {
                $( '#phone-error' ).html( "{{ trans('messages.This phone have in other user') }}" );
                //alert(error.status + ':' + error.statusText, error.responseText);
                console.log(error);
            }
        });
        return false;
    });

    $(document).on('click', '.close', function (e) {
        verifyModal.modal();
    });
    const retryVerify = () => {
        $.ajax({
            url: "{{ route('re-verify-code-ajax') }}",
            type: 'GET',
            success: function (data) {
                if (data.form) {
                    verifyModal.html(data.form);
                } else if (data.errors) {
                    if (data.errors.login) {
                        console.log(data.errors);
                    }
                }
            },
            error: function (error) {
                alert(error);
                console.log(error);
            }
        });
    }
</script>
