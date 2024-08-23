<script>
    $(document).on('change', 'select[name=type]', function (){
        const value = $(this).val();
        if(value == 2){
            $('#company_name').show();
            $('.gender').hide();
        }else{
            $('#company_name').hide();
            $('.gender').show();
        }
    });

    $.mask.definitions['9'] = '';
    $.mask.definitions['n'] = '[0-9]';
    $('input[name=phone]').mask("+998nn-nnn-nn-nn");
</script>
