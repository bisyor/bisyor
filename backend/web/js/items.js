// Priceni summa formatda ko'rsatish funksiyalari

    function formatNumber(n) {
        // format number 1000000 to 1,234,567
        return n.replace(/\D/g, "").replace(/\B(?=(\d{3})+(?!\d))/g, " ")
    }
    function formatCurrency(input, blur) {
        // appends $ to value, validates decimal side
        // and puts cursor back in right position.

        // get input value
        var input_val = input.val();
        // don't validate empty input
        if (!input || input_val === "") { return; }

        // original length
        var original_len = input_val.length;

        // initial caret position
        var caret_pos = input.prop("selectionStart");

        // check for decimal
        if (input_val.indexOf(".") >= 0) {

            // get position of first decimal
            // this prevents multiple decimals from
            // being entered
            var decimal_pos = input_val.indexOf(".");

            // split number by decimal point
            var left_side = input_val.substring(0, decimal_pos);
            var right_side = input_val.substring(decimal_pos);

            // add commas to left side of number
            left_side = formatNumber(left_side);

            // validate right side
            right_side = formatNumber(right_side);

            // On blur make sure 2 numbers after decimal
            if (blur === "blur") {
                right_side += "00";
            }

            // Limit decimal to only 2 digits
            right_side = right_side.substring(0, 2);

            // join number by .
            input_val = left_side + "." + right_side;

        } else {
            // no decimal entered
            // add commas to number
            // remove all non-digits
            input_val = formatNumber(input_val);
            input_val = input_val;

            // final formatting
            if (blur === "blur") {
                input_val += ".00";
            }
        }

        // send updated string to input
        input.val(input_val);

        // put caret back in the right position
        var updated_len = input_val.length;
        caret_pos = updated_len - original_len + caret_pos;
        input[0].setSelectionRange(caret_pos, caret_pos);
    }


	function clrInput() {
	  var input = $("#hidden-additional-fields input");
      if(input.length != 0){
          input.each(function(index,element){
              $(this).val('');
          });
      }
	}

	/* Kategoriyani otasini topadiga funksiya */
    getParents = function (child_id) {
        if (child_id == '') {
            return;
        }
        child = data.filter(word => word.id == child_id)[0];
        while (child.parent_id != null) {
            arr.unshift(child);
            child = data.filter(word => word.id == child.parent_id)[0];
        }
    }
    // Validatsiya funcksiyasi
    // const validated = function (el) {
    //     console.log(el);
    //     if(el.value != 0){
    //         $(this).next().next('.help-block').html('');
    //     }
    //         id_input = el.attr('id');
    //         id = 'hidden-' + id_input;
    //         div = $('.field-' + id_input);
    //         label = div.children('div').eq(0).children('label').html();
    //         if (div.hasClass('required') && el.val() == '') {
    //             div.children('div').eq(1).children('div').eq(1).html(err_message);
    //             div.removeClass('has-success');
    //             div.addClass('is_invalid');
    //         } else {
    //             div.children('div').eq(1).children('div').eq(1).html('');
    //             div.removeClass('is_invalid');
    //             div.addClass('has-success');
    //
    //         }
    //     }
/* Rasmlarni o'chirish kerak bo'lganda */
        $('.close_ad_photo').on('click', function (e) {
            alert($(this).data('name'));
            var file = $(this).data('name');
            old_files = $("#photo_conteyner").val().split(',');
            var index = old_files.indexOf(file);
            if (index !== -1) {
                old_files.splice(index, 1);
                $("#photo_conteyner").val(old_files.join(","));
            }
            var data = new FormData();
            data.append('name', file);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("items-upload-image-delete") }}',
                type: 'POST',
                data: data,
                processData: false,
                contentType: false,
                success: function (success) {
                },
                error: function (success) {
                    /*This error responsive*/
                },
                cache: false,

                xhr: function () {
                    if (myXhr.upload) {
                        return myXhr;
                    }
                }
            });
            $(this).parent().remove();
        });
