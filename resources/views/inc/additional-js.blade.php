<script>
function itemFavorite(that){
	var url = that.getAttribute("data-url");
	$.ajax(url, { type: 'GET' });
}

function showItemUserPhone(that){
    var url = that.getAttribute("data-url");
    $.ajax(
        url,
        {
            type: 'GET',
            success: function (data) {
                alert(data)
            }
        }
    );
}

function changeRangeParams(div_id, _from, _to, sel) {
    var text = '';
    var from = $("input[name=" + _from + "]").val();
    var to = $("input[name=" + _to + "]").val();
    var mySelect = $('select[name="' + sel + '"]');
    var selectedCurrency = $('option:selected', mySelect).text();

    var from_text = "{{ trans('messages.from summary') }}";
    var to_text = "{{ trans('messages.to summary') }}";
    var not_important = "{{ trans('messages.Not important') }}";

    if(from != '') text += from_text.replace("{summary}", from);
    if(to != '') {
        text += " " + to_text.replace("{summary}", to);
        if(to == from) text = to_text.replace("{summary}", to);
    }

    if(text == '') {
        document.getElementById(div_id).innerHTML = not_important;
        document.getElementById("not_important_checkbox_" + div_id).checked = true;
    }
    else {
        text += ' ' + selectedCurrency;
        document.getElementById(div_id).innerHTML = text;
        document.getElementById("not_important_checkbox_" + div_id).checked = false;
    }
}

function notImportantCheckbox(div_id, id, from, to = null, checkBoxes = null) {
    if (document.getElementById(id).checked) {
        var not_important = "{{ trans('messages.Not important') }}";
        document.getElementById(div_id).innerHTML = not_important;
        $('input[name="' + from +'"]').val('');
        $('input[name="' + to +'"]').val('');
        $('input[name="' + from + '[]"]').each(function() { this.checked = false; });
        if(checkBoxes != null) $('input[name="' + checkBoxes + '[]"]').each(function() { this.checked = false; });
    }
}

function changeDiapazoneParams(div_id, _from, _to = null) {
    var text = '';
    var from = $("input[name='" + _from + "']").val();
    var to = $("input[name='" + _to + "']").val();

    var from_text = "{{ trans('messages.from summary') }}";
    var to_text = "{{ trans('messages.to summary') }}";
    var not_important = "{{ trans('messages.Not important') }}";

    if(from != '') text += from_text.replace("{summary}", from);
    if(to != '' && _to != null) {
        text += " " + to_text.replace("{summary}", to);
        if(to == from) text = to_text.replace("{summary}", to);
        if(from != '') text = from + ' - ' + to;
    }

    if(text == '') {
        document.getElementById(div_id).innerHTML = not_important;
        document.getElementById("not_important_checkbox_" + div_id).checked = true;
    }
    else {
        document.getElementById(div_id).innerHTML = text;
        document.getElementById("not_important_checkbox_" + div_id).checked = false;
    }
}

function setCheckboxMultiple(div_id, checkbox) {
    var text = '';
    selected = $('input:checked[name="' + checkbox + '[]"]').map(function () { return $(this).attr('data-name'); }).get();
    var i;
    for (i = 0; i < selected.length; i++) {
      if(i == 0) text = selected[i];
      else text += ', ' + selected[i];
    }
    if(text != '') {
        document.getElementById(div_id).innerHTML = text;
        document.getElementById("not_important_checkbox_" + div_id).checked = false;
    }
    else {
        document.getElementById(div_id).innerHTML = "{{ trans('messages.Not important') }}";
        document.getElementById("not_important_checkbox_" + div_id).checked = true;
    }
}

function inputWithCheckboxes(div_id, _from, _to, checkbox) {
    var text = '';
    var from = $("input[name='" + _from + "']").val();
    var to = $("input[name='" + _to + "']").val();

    var from_text = "{{ trans('messages.from summary') }}";
    var to_text = "{{ trans('messages.to summary') }}";
    var not_important = "{{ trans('messages.Not important') }}";

    if(from != '') text += from_text.replace("{summary}", from);
    if(to != '') {
        text += " " + to_text.replace("{summary}", to);
        if(to == from) text = to_text.replace("{summary}", to);
        if(from != '') text = from + ' - ' + to;
    }

    selected = $('input:checked[name="' + checkbox + '[]"]').map(function () { return $(this).attr('data-name'); }).get();
    var i;
    for (i = 0; i < selected.length; i++) {
        if(text == '') text += selected[i];
        else text += ', ' + selected[i];
    }
    if(text != '') {
        document.getElementById(div_id).innerHTML = text;
        document.getElementById("not_important_checkbox_" + div_id).checked = false;
    }
    else {
        document.getElementById(div_id).innerHTML = "{{ trans('messages.Not important') }}";
        document.getElementById("not_important_checkbox_" + div_id).checked = true;
    }
}

function getSelectText(sel, div_id)
{
    var SelectedText = $(sel).find(':selected').text();
    document.getElementById(div_id).innerHTML = SelectedText;
    //var SelectedText = $('option:selected', sel).text();
    //var SelectedValue = $('option:selected', sel).val();
}

function changeSortStatus(that, span_id, input_id){
    var value = that.getAttribute("data-value");
    var text = that.getAttribute("data-text");
    document.getElementById(span_id).innerHTML = text;
    $('input[name="' + input_id +'"]').val(value);
}

document.addEventListener("DOMContentLoaded", function() {
    let lazyloadThrottleTimeout;

    function lazyload () {
        if(lazyloadThrottleTimeout) {
        clearTimeout(lazyloadThrottleTimeout);
    }

    lazyloadThrottleTimeout = setTimeout(function() {
        const scrollTop = window.pageYOffset;
        const lazyloadImages = document.querySelectorAll("img.lazy");
        lazyloadImages.forEach(function(img) {
            if(img.offsetTop < (window.innerHeight + scrollTop)) {
                img.src = img.dataset.src;
                img.classList.remove('lazy');
            }
        });
        if(lazyloadImages.length == 0) {
            document.removeEventListener("scroll", lazyload);
            window.removeEventListener("resize", lazyload);
            window.removeEventListener("orientationChange", lazyload);
        }
    }, 20);
}

  document.addEventListener("scroll", lazyload);
  window.addEventListener("resize", lazyload);
  window.addEventListener("orientationChange", lazyload);
});
</script>
