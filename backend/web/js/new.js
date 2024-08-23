var handleToggleNavProfile = function() {
        var i = $(".sidebar").attr("data-disable-slide-animation") ? 0 : 250;	
        $('[data-toggle="nav-profile"]').click(function(e) {
                t = $(".sidebar .nav.nav-profile"),
                n = "expanding",
                o = "closing";
            $(t).slideToggle(i, function() {
            	$(t).is(":visible") ? ($(t).removeClass("closed")) : ($(t).removeClass("expand")), 
            	$(t).removeClass(n + " " + o) 
            }) 
        }) 
    };