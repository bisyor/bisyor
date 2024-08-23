<script>

    $(function(){
        $(".for_cat_list").fancybox({
            closeBtn: false,
            modal: true,
            margin: 0,
            padding: 20,
            maxWidth: 400,
            autoScale: true,
            transitionIn: 'none',
            transitionOut: 'none',
            type: 'inline',
            helpers: {
                overlay: {
                    locked: false
                }
            }
        });
    });

    // $("#items-name").parent('div').parent('div').parent('div').addClass('required');
    var data = $.parseJSON($('#category_list').val());
    var img_site_name = '{!! $img_site_name !!}';
    var button = '<button type="button" data-fancybox-close="" class="fancybox-button fancybox-close-small" title="Close"><svg xmlns="http://www.w3.org/2000/svg" version="1" viewBox="0 0 24 24"><path d="M13 12l5-5-1-1-5 5-5-5-1 1 5 5-5 5 1 1 5-5 5 5 1-1z"></path></svg></button>';
    arr = [];


    // Price bilan bog'liq qismlari



    const onPrice = (value) => {
        const priceContent = $('.price_content');
        if(value === '0'){
            priceContent.show("slow");
        }else{
            priceContent.hide("slow");
            $('#items-price').val('');
            $('#items-price_end').val('');
            $('#hidden-items-price').val('');
            $('#hidden-items-price_end').val('');
            $('#items-currency_id option:first').prop('selected',true);
            $('#items-currency_id').select2();
            $('#hidden-items-currency_id').val('');
            $('#price-ex-checkbox ').prop('checked',false);
            $('#price-ex-checkbox').val(1);
            //const value = parseInt($('#items-price_ex').val()) - 1;
            const value = parseInt($('#items-price_ex').val());
            $('#items-price_ex').val(value);
        }
    }


    // Publicated sanasini ko'rsatish uchun funsksiya
    function publicatedDate(e) {
        let date = new Date();
        let count = e.val();
        date.setMonth(date.getMonth() + parseInt(count));
        let month = date.getMonth() + 1;
        let days = date.getDate();
        if (month < 10) month = '0' + month;
        if (days < 10) days = '0' + days;
        let text = '{{ trans("messages.To date") }}';
        date = days + '.' + month + '.' + date.getFullYear();
        text = '<b>' + text.replace(':date', date) + '</b>';
        $('.publicated_date').html(text);
    }

    const validated = function (el) {
        const div = $('.field-' + el[0].id);
        const label = div.children('label').html();
        let error_message = '<strong>{{ trans('validation.required') }}</strong>';
        error_message = error_message.replace(":attribute", '«' + label + '»');

        const element = $('#' + el[0].id);
        if(el[0].value !== 0 && el[0].localName.toLowerCase() === 'select'){
            element.next().next('.help-block').html('');
        }

        if(el[0].value !== '' && el[0].localName.toLowerCase() === 'input'){
            element.parent().next('.help-block').html('');
            element.removeClass('is-invalid');
        }else if(el[0].localName.toLowerCase() === 'input'){
            element.parent().next('.help-block').html(error_message);
            element.addClass('is-invalid');
        }
    }
    /* Formani validatsiya qilamiz */
    $(document).on('change', '.nativ-required', function (e){
        if($(this).val()){
            $(this).removeClass('is-invalid');
            $(this).parent().children('.help-block').html('');
        }
    });

    const setCheckvalue = (el) => {
        let id = 'hidden-' + el.attr('data-id');
        const tisId = $("#" + id);
        let old_value = 0;

        if (tisId.val() !== '') old_value = parseInt(tisId.val());

        if (el.prop('checked')) old_value += parseInt(el.val());
        else old_value -= parseInt(el.val());

        tisId.val(old_value);

        if ($('.field-' + el.attr('data-id')).hasClass('required')) {
            $('#' + el.attr('data-id')).next('.help-block').html('');
        }
    }

    function phonenumber(inputtxt)
    {
        let pattern = /^[\+]?[0-9]{5}?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{2}?[-\s\.]?[0-9]{2}$/;
        if((inputtxt.match(pattern)))
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    $('#items-form').submit(function () {
        let t = true;
        let valid = false;

        $('input[name^="phones"]').each(function () {
            valid = phonenumber($(this).val());
        });

        if(valid === false){
            if(!$('.add_some .help-block').length){
                $('.add_some').append('<div class="help-block"><strong>{{ trans('validation.required', ['attribute' => trans('messages.Contacts')]) }}</strong></div>');
            }
            t = false;
        }

        const additionalFields = $("#additional-fields [id^='items-']");
        additionalFields.each(function (index, element) {
            const id_input = $(this).attr('id');
            let id = 'hidden-' + id_input;
            const div = $('.field-' + id_input);
            let label = div.children('label').html();
            let error_message = '<strong>{{ trans('validation.required') }}</strong>';
            error_message = error_message.replace(":attribute", '«' + label + '»');

            if (div.hasClass('required') && $(this).attr('role') !== 'checkboxgroup' && $(this).attr('role') !== 'radiogroup') {
                if (div.children('div').children().prop('tagName').toLowerCase() === 'input' && !$(this).val()) {
                    div.children('div').next('.help-block').html(error_message);
                    $(this).addClass('is-invalid');
                    t = false;
                }
                console.log('Slect valuesi', $(this).val());
                if (div.children('div').children().prop('tagName').toLowerCase() == 'select' && !$(this).val()) {
                    $(this).next().next().html(error_message);
                    $(this).next().addClass('is-invalid');
                    t = false;
                }
            }
            if ($(this).attr('role') == 'radiogroup' && div.hasClass('required')) {
                var checked = false;
                $(this).find('input').each(function (index, value) {
                    if (value.checked == true) checked = true;
                });
                if (checked == false) {
                    $(this).children('.help-block').html(error_message);
                    t = false;
                }
            }
            if ($(this).attr('role') == 'checkboxgroup' && div.hasClass('required')) {
                checked = false;
                $(this).find('input').each(function (index, value) {
                    if (value.checked == true) checked = true;
                });
                if (checked == false) {
                    $(this).next('.help-block').html(error_message);
                    t = false;
                }
            }
            if ($(this).attr('role') != 'checkboxgroup' && $(this).attr('role') != 'radiogroup')
                if($(this).hasClass('float_number_input')){
                    const float = parseFloat($(this).val().split(' ').join(''));
                    float && $("#" + id).val(float);
                }else{
                    $("#" + id).val($(this).val());
                }
        });

        if ($('#items-cat_id').val() == '') {
            t = false;
            label = $('#categories label').html();
            error_message = '<strong>{{ trans('validation.required') }}</strong>';
            $('#categories .help-block').html(error_message.replace(":attribute", '«' + label + '»'));
            $('#categories a').addClass('is-invalid');
        }
        $('.nativ-required').each(function (index, element) {
            if ($(this).val() == '') {
                t = false;
                label = $(this).prev('label').html();
                error_message = '<strong>{{ trans('validation.required') }}</strong>';
                $(this).parent().children('.help-block').html(error_message.replace(":attribute", '«' + label + '»'));
                $(this).addClass('is-invalid');
            }
        });
        if (!$('#district_id').val()) {
            t = false;
            label = $('#district_id').prev('label').html();
            error_message = '<strong>{{ trans('validation.required') }}</strong>';
            $('#district_id').next().next('.help-block').html(error_message.replace(":attribute", '«' + label + '»'));
            $('#district_id').select2({
                containerCssClass: "is-invalid"
            });
        }

        const itemsCatType = $('#items-cat_type');
        if (itemsCatType.length > 0 && !itemsCatType.val()) {
            t = false;
            let label = itemsCatType.prev('label').html();
            let error_message = '<strong>{{ trans('validation.required') }}</strong>';
            itemsCatType.next().next('.help-block').html(error_message.replace(":attribute", '«' + label + '»'));
            itemsCatType.select2({
                containerCssClass: "is-invalid"
            });
        }
        if ($('#shop_id').length != 0) {
            if (!$('#shop_id').val()) {
                t = false;
                label = $('#shop_id').prev('label').html();
                error_message = '<strong>{{ trans('validation.required') }}</strong>';
                $('#shop_id').next().next('.help-block').html(error_message.replace(":attribute", '«' + label + '»'));
                $('#shop_id').select2({
                    containerCssClass: "is-invalid"
                });
            }
        }
        if (t === false) {
            $('html, body').animate({
                scrollTop: $('strong').first().offset().top - 60
            }, 2000);
        }else{
            $(".float_number_input");
            $('.prevent-button').attr('disabled', true);
            $('.spinner').removeClass('spinner');
        }

        return t;
    });

    /*  Bu yerdan kategoriyalarni tasnlash mmodal oynasi uchun JS kodlar yozildi */

    const liElement = (value) => {
        return `<li class="cat_icon_left modal_cat_item text-center"><a href="javascript:;" id="cat-${value.id}" data-category="${value.id}"
                   onclick="inCategory($(this))"><img style="max-width:90px;" src="${img_site_name + value.img}" alt="${value.text}"><p>${value.text}</p></a></li>`;
    };

    const back = (catId = 1) => {
        const filtered_data = data.filter(word => word.parent_id === catId);
        let template = '<ul class="cat_icon">';
        for (const value of filtered_data) {
            template += liElement(value);
        }
        template += '</ul>';
        $("#exampleModalCat").html(button + '<h5>{{ trans("messages.Select category") }}</h5><div id="content-modal">' + template + '</div>');
    }

    const request = (val, text_cat_list) => {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.post('{{ route('show-aditional-fields') }}/' + val, function (data) {
            $('#additional-fields').html(data.form);
            $('.limit-list').html(data.limitList);
            $('.for_cat_list').text(text_cat_list);
            const catInput = $('#categories a');
            if(catInput.hasClass('is-invalid')){
                catInput.removeClass('is-invalid');
                catInput.next('.help-block').html('');
            }
            $.fancybox.close();
        });

    };

    const selectButton = (button) => {
        const val = button.val();
        if(!val){
            /*$('#additional-fields').html(data);*/
            return false;
        }else{
            arr = [];
            getParents(val);

            $("#items-cat_id").val(val);
            clrInput();
            request(val, arr.map(value => value.text).join(' > '));
        }
    }

    const removeElement = (el) => {
        const divList = el.parent('div').nextAll('div');
        for(let div of divList)
            div.remove();
    };

    const selectInput = (catId, childCat) => {
        return '<div class="child-cat"><select class="child-' + catId + '" onchange="addSel($(this))"><option selected="" disabled="">{{ trans("messages.Select") }}</option>' +
            childCat.map(cat => `<option value="${cat.id}">${cat.text}</option>`)
                .join('') + '</select></div>';
    }

    const addSel = (element) =>  {
        const catId = element.val();
        const childCat = data.filter(cat => cat.parent_id == catId);

        removeElement(element);
        if(childCat.length === 0){
            $('#exampleModalCat .more_know').removeAttr('disabled').attr('value', catId);
            return;
        }

        $("#content-modal .right-box").append(selectInput(element.val(), childCat));
        $('#exampleModalCat .more_know').attr('disabled', 'disabled').attr('value', '');
        $(".child-" + catId).select2({
            dropdownParent: $('#exampleModalCat'),
            // minimumResultsForSearch: -1,
        });
    }

    const inCategory = (element)=> {
        const catId = element.data('category');
        const parentCat = data.filter(cat => cat.id === catId)[0];

        if(parentCat.parent_id === 1){
            const childCat = data.filter(cat => cat.parent_id === parentCat.id);
            if(childCat.length === 0)
                return;

            let leftBox = `<div class="left-box" onclick="back()"><img src="${img_site_name + parentCat.img}" alt="${parentCat.text}"><p>${parentCat.text}</p></div>`;

            leftBox += `<div class="right-box">${selectInput(catId, childCat)}</div>`;

            $("#content-modal").html(leftBox);
            $("#content-modal").after('<button class="more_know" onclick="selectButton($(this))" disabled>Выбрать</button>');
        }
        $(".child-" + catId).select2({
            dropdownParent: $('#exampleModalCat'),
            // minimumResultsForSearch: -1
        });
    };

    $(document).ready(function () {
        let cat_id = $("#items-cat_id").val();
        if (cat_id === '') {
            cat_id = 1;
        } else {
            getParents(cat_id);
            let filtered_data = data.filter(word => word.parent_id == arr[arr.length - 1].parent_id);
        }

        if (cat_id !== 1) {

            $('.for_cat_list').text(arr.map(value => value.text).join(' > '));

            let leftBox = `<div class="left-box" onclick="back()"><img src="${img_site_name + arr[0].img}" alt="${arr[0].text}"><p>${arr[0].text}</p></div>`;
            arr.shift();
            const slectInput = arr.map(value => {
                return '<div class="child-cat"><select class="child-old" onchange="addSel($(this))"><option selected="" disabled="">{{ trans("messages.Select") }}</option>' +
                    data.filter(word => word.parent_id === value.parent_id)
                        .map(cat => `<option value="${cat.id}" ${cat.id === value.id ? 'selected' : ''}>${cat.text}</option>`)
                        .join('') + '</select></div>';
            }).join('');

            leftBox += `<div class="right-box">${slectInput}</div>`;

            $("#content-modal").html(leftBox)
                .after('<button class="more_know" onclick="selectButton($(this))" value="' + cat_id + '">Выбрать</button>');

            $(".child-old").select2({
                dropdownParent: $('#exampleModalCat'),
                // minimumResultsForSearch: -1
            });

        } else {
            back(cat_id);
        }
    });


    $("#file_inp").on('change', function (e) {
        let count = parseInt($("#max-count-images").val());
        let names = [];
        let idList = [];
        if (!count) count = 5;

        let files = e.target.files;

        const helpBlock = $('.ad_photos .help-block');
        helpBlock.html('');

        const count_file = $('.ad_photos_main .galax').length;

        if (files.length !== 0) {
            if (files.length + count_file > count) {
                helpBlock.html(`<div class="error-count alert alert-danger">Вы можете загрузить только <b>${count}</b> фотографий</div>`);
            } else {
                let is_size = true;

                $.each(files, function (index, file) {
                    if (!file.type.match(/image.*/)) {
                        helpBlock.html('<div class="error-size alert alert-danger">{{ trans('messages.This file not image') }}</div>');
                        is_size = false;
                        return;
                    }
                    const FILE_SIZE = Math.round((file.size / 1024));
                    if (FILE_SIZE > 5120) {
                        helpBlock.append('<div class="error-size alert alert-danger">{{ str_replace(':max', 5, trans('messages.This file big')) }}</div>');
                        is_size = false;
                        return;
                    }
                });

                if (is_size) {
                    let data = new FormData();

                    $.each(files, function (i, file) {
                        const date = new Date();
                        const dateInt = date.getTime()+ '_' + Math.random().toString(36).substring(2);
                        const ext = file.name.split('.').pop();
                        const newName = `bisyor_${dateInt}.${ext}`;
                        data.append('file[]', file);
                        data.append('names[]', newName);
                        names.push(newName);
                        idList.push(dateInt);
                        $('.ad_photos_main label').after('<div class="galax" id="' + dateInt + '"><img src="{{ config("app.zzImg") }}" alt=""></div>');
                    });

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });

                    $.ajax({
                        url: '{{ route('items-upload-image') }}',
                        type: 'POST',
                        data: data,
                        processData: false,
                        contentType: false,
                        success: function (success) {
                            if(success === 'error'){
                                alert('ERR_INTERNET_DISCONNECTED');
                            }else{
                                let img_site_name = "{{ config('app.trashPath') }}";
                                let i = 0;
                                for (let name of names) {
                                    $('#' + idList[i] + ' img').attr('src', img_site_name + name);
                                    $('#' + idList[i]).prepend('<div class="rotate_ad_photo" data-name="' + name + '"></div><div class="close_ad_photo" data-name="' + name + '"></div>');
                                    i++;
                                }
                                let newFiles = '';
                                const container = $("#photo_conteyner");
                                const oldFiles = container.val();
                                if (oldFiles) newFiles = oldFiles + "," + names.join(',');
                                else newFiles = names.join(',');
                                container.val(newFiles);
                            }
                        },
                        error: function (success) {
                            alert("Error occur uploading image. Try again )");
                            idList.forEach(list => {
                                $('#' + list + ' img').attr('src', '{{ config("app.noImage") }}');
                            });
                        },
                        cache: false,

                        xhr: function () {
                            myXhr = $.ajaxSettings.xhr();
                            if (myXhr.upload) {
                                return myXhr;
                            }
                        }
                    });
                }
            }
        }

    });

    /* Rasmlarni o'chirish kerak bo'lganda */
    $(document).on('click', '.close_ad_photo', function (e) {
        var file = $(this).data('name');
        var old_files = $("#photo_conteyner").val().split(',');
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
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    return myXhr;
                }
            }
        });
        $(this).parent().remove();
    });

    // Eski rasmlarni o'chirish
    $(document).on('click', '.close_ad_photo_old', function (e) {
        var file = $(this).data('name');
        old_files = $("#photo_conteyner").val().split(',');
        var index = old_files.indexOf(file);
        if (index !== -1) {
            old_files.splice(index, 1);
            $("#photo_conteyner").val(old_files.join(","));
        }
        $(this).parent().remove();
    });

    /* Rasmni aylantirish */
    $(document).on('click', '.rotate_ad_photo', function (e) {
        var file = $(this).attr('data-name');
        var data = new FormData();
        data.append('name', file);
        var update = 0;
        if ($(this).next().hasClass('close_ad_photo_old')) {
            update = 1;
        }

        data.append('update', update);

        const id = $('#' + $(this).parent().attr('id'));

        $(this).parent().children('img').attr('src', '{{ config("app.zzImg") }}');
        if (update) {
            $(this).parent().children('.rotate_ad_photo').next().attr('class', 'close_ad_photo');
        }
        $(this).parent().children('.rotate_ad_photo').hide();
        $(this).parent().children('.close_ad_photo').hide();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: '{{ route("items-rotate-image") }}',
            type: 'POST',
            data: data,
            processData: false,
            contentType: false,
            success: function (success) {
                res = success.split(".");
                const contayner = $("#photo_conteyner");
                let old_files = contayner.val().split(',');
                var index = old_files.indexOf(file);
                if (index !== -1) {
                    old_files.splice(index, 1);
                }
                old_files.push(success);
                contayner.val(old_files.join(","));


                id.children('img').attr('src', '{{ config('app.trashPath') }}' + success);
                id.children('.rotate_ad_photo').attr('data-name', success).show();
                id.children('.close_ad_photo').attr('data-name', success).show();
            },
            error: function (error) {
               alert(error.responseText );
            },
            cache: false,

            xhr: function () {
                myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    return myXhr;
                }
            }
        });

    });

    var limit = {{ $settings->value }};
    $('span.add_some_contact').on('click', function () {
        var uu = $('.inpt_clones').length
        $('.form-group.add_some').append('<div class="inpt_clones"><input type="tel" placeholder="+998xx-xx-xx-xx" name="phones[]" class="form-control" /><div class="clos_contact"></div></div>');
        if (limit <= uu + 1) {
            $(this).hide();
        }
        if (uu + 1 > 1) {
            $('.inpt_clones').children('.clos_contact').show();
        }
        $('.form-group.add_some input').mask("+998nn-nnn-nn-nn");
        $('.clos_contact').on('click', function () {
            $(this).parent().remove();
            uu = $('.inpt_clones').length;
            if (limit >= uu) {
                $('.add_some_contact').show();
            }
            if (uu == 1) {
                $('.inpt_clones').children('.clos_contact').hide();
            }
        });
    });
    $('.clos_contact').on('click', function () {
        $(this).parent().remove();
        uu = $('.inpt_clones').length;
        if (limit >= uu) {
            $('.add_some_contact').show();
        }
        if (uu == 1) {
            $('.inpt_clones').children('.clos_contact').hide();
        }
        if (uu + 1 > 1) {
            $('.inpt_clones').children('.clos_contact').show();
        }
    });
</script>
