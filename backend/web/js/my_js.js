changeChargeType = function(val){
    if(val == 1){
        $("#besplatno_items").show(300);
        $("#platno_items").hide(300);
    }else{
        $("#besplatno_items").hide(300);
        $("#platno_items").show(300);
    }
}
