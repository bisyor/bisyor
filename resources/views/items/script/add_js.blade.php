<script>
    $(document).ready(function () {
        $(".js-select2").select2();
        $('.count_imagae_1212').html($('#max-count-images').val());

        function keyUp(e){
            const x = e.charCode || e.keyCode;
            if (
                (isNaN(String.fromCharCode(e.which)) && x !== 46) ||
                x === 32 ||
                x === 13 ||
                (x === 46 && e.currentTarget.value.includes('.'))
            )
                e.preventDefault();
        }
        var model = $('#items-price');
        var priceEnd = $('#items-price_end');
        if (model.length !== 0) {
            model.on({
                keypress: function(e){
                    keyUp(e);
                },
                keyup: function () {
                    formatCurrency($(this));
                }
            });
            formatCurrency(model);
        }
        if (priceEnd.length !== 0) {
            priceEnd.on({
                keypress: function(e){
                    keyUp(e);
                },
                keyup: function () {
                    formatCurrency($(this));
                }
            });
            formatCurrency(priceEnd);
        }
    });

    // var model = $('#items-price');
    // if (model) {
    //     $('#items-price').inputFilter(function (value) {
    //         // return /^[\d ]*$/.test(value);
    //         return /^-?\d*[.]?\d{0,2}$/.test(value);
    //     });
    // }
    var input_float = $(".float_number_input");
    if (input_float.length !== 0) {
        input_float.on({
            keypress: function(e){
                keyUp(e);
            },
            keyup: function () {
                formatCurrency($(this));
            }
        });
        formatCurrency(input_float);
    }
    // if (input_float.length != 0) {
    //     input_float.inputFilter(function (value) {
    //         return /^-?\d*[.]?\d{0,2}$/.test(value);
    //     });
    // }
    var input_num = $(".number_input");
    if (input_num.length != 0) {
        input_num.inputFilter(function (value) {
            return /^\d*$/.test(value);
        });
    }
</script>
