$(document).ready(function() {
  $('[data-fancybox="images"]').fancybox({
   thumbs : {
    autoStart : true,
    axis      : 'x'
  }
})
   var galleryThumbs = new Swiper('.estete_swiper .gallery-thumbs', {
    spaceBetween: 10,
    slidesPerView: 4,
    freeMode: true,
    watchSlidesVisibility: true,
    watchSlidesProgress: true,
  });

  var galleryTop = new Swiper('.estete_swiper .gallery-top', {
    spaceBetween: 10,
    navigation: {
      nextEl: '.estete_swiper .swiper-button-next',
      prevEl: '.estete_swiper .swiper-button-prev',
    },
    loop: false,
    thumbs: {
      swiper: galleryThumbs
    }
  });

  $.fancybox.defaults.backFocus = false;

  $('.left_head_nav>li>a').on('click',function(){
    $('.left_head_nav>li>a').removeClass('first_top_menu_item')
  });

  var offset = 300,
      duration = 500,
      top_section = $('.to-top'),
      toTopButton = $('a.back-to-top');
  // showing and hiding button according to scroll amount (in pixels)
  $(window).scroll(function () {
    if( $(this).scrollTop() > offset ) {
      $(top_section).fadeIn(duration);
    } else{
      $(top_section).fadeOut(duration);

    }});

  // activate smooth scroll to top when clicking on the button

  $('a.back-to-top, a.back-to-top *').click(function(e) {
    e.preventDefault();
    $('html, body').animate({
      scrollTop: 0
    }, 700);
  });
  // /************************************************category-selected********************/


  $('#clear').on('click', function() {
    $('input#region').val('');
  })

  $('body').click(function(e) {
    if (!$(e.target).is('.subregions, .subregions *,.input-clear-box, .input-clear-box *')) {
      $('.subregions').removeClass('shown');
    }
  })
  //REGIONS POPUP TABLE
  var region = '';
  $('.first-table > ul > li').on('click', function() {
    $('.subregions').toggleClass('opened');
    $('.first-table > ul > li').removeClass('choose');
    $(this).addClass('choose');
    region = $(this).find('a p').text();
    $('#region').val(region);
  })

  $('.back-to-region').on('click', function() {
    $('.subregions').toggleClass('opened');
  })

  $('#minicities > ul > li').on('click', function() {
    region = $(this).find('a').text() + ', ' + region;
    $('#region').val(region);
    $('#minicities > ul > li').removeClass('choose');
    $(this).addClass('choose');

    $('.subregions').removeClass('shown');
    $('.subregions').removeClass('opened');
  });
  $('.subregions .along-region').on('click', function() {
    $('#region').val(region);
    $('.subregions').removeClass('shown');
    $('.subregions').removeClass('opened');
  })
  $('.subregions .close-button').on('click', function() {
    $(this).parent().removeClass('shown');
  })

  $('.whole-country').on('click', function() {
    $('#region').val($(this).text());
    $('.first-table > ul > li').removeClass('choose');
    $('#minicities > ul > li').removeClass('choose');
    $('.subregions').removeClass('shown');
    $('.subregions').removeClass('opened');
  })

  $('#region').focus(function() {
    $('.subregions').addClass('shown');
  });

  // /************************************************category-selected********************/

  //////////////////////////////////////////////// HEADER//////////////////////////////////////////////

  $('.toggle-menu-mobile').on('click', function() {
    $(this).toggleClass('open')
    $('body').toggleClass('open_header')
  })

  $('body').click(function(e) {
    if (!$(e.target).is('.toggle-menu-mobile *, .toggle-menu-mobile, .hdr_top, .hdr_top *')) {
      $('body').removeClass('open_header')
      $('.toggle-menu-mobile').removeClass('open')
    }
  })



  if ($(window).width() < 991) {

    $(document).on('click', '.toggle_category', function(){
      $('.all_categories_btn').trigger('click')
    })

    $('.add_oby').after($('.hdr_bottom_main_right'))

    $('.add_oby').after($('.language.dropdown_popup'))

    $('.hdr_top_right').after($('form.search_form_header')).after($('a.add_ads'))

    // $('.us_drop a.enter_site').on('click', function(e) {
    //   e.preventDefault()
    // })

    $('.hdr_bottom_main_left a.logo').after($('.location_drop_body'))

    $('.hdr_bottom_main_left a.logo').after($('form.search_form_header'))


  }
  //////////////////////////////////////////////// HEADER//////////////////////////////////////////////
  $('.dropdown_popup>a:not(.prevent)').on('click', function(e) {
    e.preventDefault()
  })
  if ($(window).width() < 768) {
    $('.left_head_nav>li>a').on('click', function(e) {
      e.preventDefault()
      $(this).parent().siblings().find('.inner_a').slideUp()
      $(this).parent().find('.inner_a').slideToggle()

      $(this).parent().siblings().find('.inner_a').prev().removeClass('afert_block')
      $(this).parent().find('.inner_a').prev().toggleClass('afert_block')
    })

    $('.form-group.pre_file_right').after($('#metiric'))
  }

  if ($(window).width() > 767) {
     $('span.all_categories_btn').on('click', function() {
        $('body').toggleClass('category_hovered')
        $('.left_head_nav>li>a').removeClass('afert_block')
      })

      $(window).scroll(function() {
        // $('body').removeClass('category_hovered')
      });


      $('body').click(function(e) {
        if (!$(e.target).is('.category_bod_main *, span.all_categories_btn, span.all_categories_btn *')) {
          $('body').removeClass('category_hovered')
          $('.left_head_nav>li>a').removeClass('afert_block')
        }
      })
  }
  if ($(window).width() < 768) {
 $('span.all_categories_btn').on('click', function() {
        $('body').toggleClass('category_hovered')
        $('.left_head_nav>li>a').removeClass('afert_block')
      })


  }


  if ($(window).width() > 767) {
    var max_h_menu = $(window).height() - $('header').height() + 'px'

    $('.category_bod').css('max-height', max_h_menu)

    $('.left_head_nav>li>a').on('click', function(e) {
      e.preventDefault()
      $('.left_head_nav>li>a').removeClass('afert_block')
      $(this).addClass('afert_block')
      $('.inner_a').css('display', 'none')
      $(this).next().css('display', 'block')
    })

  }

  $('img.repl_tog').on('click', function() {
    var name_ans = $(this).parent().parent().parent().find('h5').text()
    var te_ans = $(this).parent().parent().parent().find('p').text()
    $('.answer_letter_name').html(name_ans)
    $('.answer_letter_some').html(te_ans)
    $('.answer_letter').addClass('open')

    $('html, body').animate({
      scrollTop: $(".answer_letter").offset().top - 300
    }, 500);

  })

  $('.close_let').on('click', function() {
    $('.answer_letter').removeClass('open')
  })



  $(".count_max").keyup(function() {

    var chars_t = $(this).val().length

      $(this).next(".count_chars").find('span').text($(this).attr('maxlength') - chars_t);

  });

  $.mask.definitions['9'] = '';
  $.mask.definitions['n'] = '[0-9]';

  var quantity_input = $('.form-group.add_some').attr('data-quantity-input')

  $('span.add_some_cl').on('click', function() {
    var uu = $('.inpt_clones').length
    //if (quantity_input > uu) {
      $('.form-group.add_some').append('<div class="inpt_clones"><input type="tel" placeholder="+998xx-xx-xx-xx" name="phones[]" class="form-control" /><div class="clos"></div></div>')
      $('.form-group.add_some input').mask("+998nn-nnn-nn-nn");
    //}
    $('.clos').on('click', function() {
      $(this).parent().remove()
    })
  })

  $('.clos').on('click', function() {
    $(this).parent().remove()
  })



  var max_vis = $('#visible_clones').attr('data-max-visible-count')

  $('.clone_go').on('click', function() {


    if ($('#visible_clones .clones').filter(function() { return $(this).css('display') !== 'none'; }).length < max_vis) {

      $('#visible_clones .clones').each(function() {
        if ($(this).css('display') == 'none') {
          $(this).css('display', 'flex')
          return false;
        }
      })


      // $('.cl .clones').eq(5 - ind_clo).css('display', 'flex')
    }
  })

  $('.hidden_btn').on('click', function() {
    $(this).parent().css('display', 'none')
  })

  var ttt = $('#visible_clones .clones').filter(function() { return $(this).css('display') !== 'none'; }).length;

  // console.log(ttt)

  $('.form-group.add_some input, input[type="tel"]').mask("+998nn-nnn-nn-nn");

  const readURL = (input) => {
    if (input.files && input.files[0]) {
      const reader = new FileReader()
      reader.onload = (e) => {
        $(input).parent().find('.fead').attr('src', e.target.result)
      }
      reader.readAsDataURL(input.files[0])
    }
  }

 /* $('.choose').on('change', function() {
    readURL(this)
    let i
    if ($(this).val().lastIndexOf('\\')) {
      i = $(this).val().lastIndexOf('\\') + 1
    } else {
      i = $(this).val().lastIndexOf('/') + 1
    }
    const fileName = $(this).val().slice(i)
    $('.label').text(fileName)
  })*/



  // const readURL2 = (input) => {
  //   if (input.files && input.files[0]) {
  //     const reader2 = new FileReader()
  //     reader2.onload = (e) => {
  //       // $('.pre_file_img').css('color', 'red')
  //       $('.pre_file_img').css('background-image', 'url(' + e.target.result + ')');
  //     }
  //     reader2.readAsDataURL(input.files[0])
  //   }
  // }

/*  $('.pre_file_right input').on('change', function() {
    readURL2(this)
    let i
    if ($(this).val().lastIndexOf('\\')) {
      i = $(this).val().lastIndexOf('\\') + 1
    } else {
      i = $(this).val().lastIndexOf('/') + 1
    }
    const fileName2 = $(this).val().slice(i)
    // $('.label').text(fileName2)
  })
*/




  $(".js-select2").select2();

  $(".select22").select2({
    placeholder: "What currency do you use?",
    // selectOnClose: true,

  });

  //  function setCurrency (currency) {
  //   if (!currency.id) { return currency.text; }
  //   var $currency = $('<span class="glyphicon glyphicon-' + currency.element.value + '">' + currency.text + '</span>');
  //   return $currency;
  // };

  $(".templatingSelect2").select2({
    placeholder: "What currency do you use?", //placeholder
    // templateResult: setCurrency,
    // templateSelection: setCurrency
  });

  var swiper1 = new Swiper('.top_swiper_property', {
    slidesPerView: 10,
    spaceBetween: 0,
    // touchRatio: false,
    navigation: {
      nextEl: '.property .swiper-button-next',
      prevEl: '.property .swiper-button-prev',
    },
    loop: false,
    breakpoints: {
      1230: {
        slidesPerView: 8,
      },
      991: {
        slidesPerView: 6,
      },
      767: {
        slidesPerView: 3.5,
      }
    }
  });

  var swiper2 = new Swiper('.premium_swiper', {
    slidesPerView: 4,
    spaceBetween: 24,
    // touchRatio: false,
    navigation: {
      nextEl: '.premium_ads_section .swiper-button-next',
      prevEl: '.premium_ads_section .swiper-button-prev',
    },
    // loop: true,
    breakpoints: {
      991: {
        spaceBetween: 10,
      },
      767: {
        slidesPerView: 2,
        spaceBetween: 10,
        slidesPerColumn: 1,
        loop: false
      }
    }
  });

  var swiper3 = new Swiper('.bren_swiper', {
    slidesPerView: 1,
    spaceBetween: 0,
    navigation: {
      nextEl: '.bren_swiper .swiper-button-next',
      prevEl: '.bren_swiper .swiper-button-prev',
    },
    loop: true,
    pagination: {
      el: '.bren_swiper .swiper-pagination',
      type: 'bullets',
      clickable: true,
    }
  });

  var swiper4 = new Swiper('.partners .swiper-container', {
    slidesPerView: 'auto',
    spaceBetween: 0,
    centeredSlides: true,
    autoWidth: true,
    navigation: {
      nextEl: '.partners .swiper-button-next',
      prevEl: '.partners .swiper-button-prev',
    },
    loop: true,
    pagination: {
      el: '.partners .swiper-pagination',
      type: 'bullets',
      clickable: true,
    },
    breakpoints: {
      767: {

      }
    }
  });

  var swiper5 = new Swiper('.last_prod_swiper', {
    slidesPerView: 5,
    spaceBetween: 14,
    loop: false,
    autoplay: {
      delay: 5000
    },
    breakpoints: {
      1260: {
        slidesPerView: 4,
        spaceBetween: 10,
      },
      767: {
        slidesPerView: 2,
        spaceBetween: 10,
        slidesPerColumn: 2,
        loop: false
      }
    }
  });

  var swiper6 = new Swiper('.most_popular_brands .swiper-container', {
    slidesPerView: 7,
    spaceBetween: 30,
    loop: true,
    autoplay: {
      delay: 5000
    },
    breakpoints: {
      1260: {
        slidesPerView: 6,
        spaceBetween: 10,
      },
      992: {
        slidesPerView: 5,
      },
      767: {
        slidesPerView: 3,
      }
    }
  });


  $('.estete_swiper_right .item-favorite-text span').on('click', function(){
    $(this).prev().trigger('click')
  });

  $('.favoruites_product').on('click', function() {
    $(this).toggleClass('active');
    /*var toggle = $(this).attr('data-toggle');
    if(toggle != 'modal') $(this).toggleClass('active');*/
  })

  $('ul.tabs li').click(function() {
    var tab_id = $(this).attr('data-tab');

    $('ul.tabs li').removeClass('current');
    $('.tab-content').removeClass('current');

    $(this).addClass('current');
    $("#" + tab_id).addClass('current');
  })

  $('a.plan_link, .advertise a.more_know').on('click', function(e) {
    e.preventDefault()
    $("html, body").animate({
      scrollTop: $($(this).attr("href")).offset().top
    }, 1000);
  })

  $('#rating').on('click', function(e) {
    e.preventDefault();
    $('#popups_rating').toggleClass('active');
  });

  $('#op_yet').on('click', function(e) {
    e.preventDefault();
    $('#op_yet_popup').toggleClass('active')
  });
  $('#claim').on('click', function(e) {
      e.preventDefault();
      $('#claim_popup').toggleClass('active')
  })

  $('body').click(function(e) {
    if (!$(e.target).is('#op_yet, #claim, #rating, .popups_es form, .popups_es form *')) {
      $('.popups_es').removeClass('active')
    }
  })

  $('.item_address_class a').on('click', function(e) {
    e.preventDefault();
    $('.item_map_view').toggleClass('active')
  })

  $('body').click(function(e) {
    if (!$(e.target).is('.item_address_class, .item_address_class *')) {
      $('.item_map_view').removeClass('active')
    }
  })

  $('#show_phone').on('click', function() {
    var userPhoneUrl = $(this).attr('data-login');
    $.ajax(
        userPhoneUrl,
        {
            type: 'GET',
            success: function (data) {
                $('#phone_main').html(data);
                $("#phone_main").attr("href", 'tel:' + data);
            }
        }
    );
    $(this).css('display', 'none')
    $('#phone_main').css('display', 'block')
  })

  $('[data-fancybox]').fancybox({
    animationEffect: "zoom",
    transitionEffect: 'slide'
  });

  $.fancybox.defaults.backFocus = false;

  var textarea = document.querySelector('.chat_form textarea');
  if (textarea) {
    textarea.addEventListener('keydown', autosize);

    function autosize() {
      var el = this;
      setTimeout(function() {
        el.style.cssText = 'height:auto;';
        // for box-sizing other than "content-box" use:
        // el.style.cssText = '-moz-box-sizing:content-box';
        el.style.cssText = 'height:' + el.scrollHeight + 'px';
      }, 0);
    }

  }

  function cheks() {
    if ($('input#ber').is(":checked")) {
      $('input#ber').val('1')
    } else {
      $('input#ber').val('0')
    }
  }

  cheks()

  $('input#ber+label').on('click', function() {
  cheks()
    // setTimeout(cheks(), 1000)
  })

  $('.filter-element>span').on('click', function(){
    $(this).parent().siblings().removeClass('yy')
    $(this).parent().toggleClass('yy')
    $(this).parent().siblings().find('span').removeClass('acs')
    $(this).parent().siblings().find('.filter-element-popup').removeClass('active')
    $(this).toggleClass('acs')
    $(this).next().toggleClass('active')
  })

   $('body').click(function(e) {
    if (!$(e.target).is('.filter-element, .filter-element *')) {
      $('.filter-element').removeClass('yy');
      $('.filter-element span').removeClass('acs')
      $('.filter-element-popup').removeClass('active')
    }
  })

$('.prevent-multiple-submitted').on('submit', function(event){
    $('.prevent-button').attr('disabled', true);
    $('.spinner').removeClass('spinner');
});

})
/******************************CAPTCHA**************************************/

/*Umidning js funksiyalari*/



/*end Umidning js funksiyalari*/




/* loader-44 */


window.onload = function() {
  // alert(150)
  $('body').removeClass('preload-mobile')
};

/********************-- Items view message uchun --************************/
$('#form_ads_message').submit(function(e){
    e.preventDefault();
    let form = $(this);
    let data = new FormData($(this)[0]);

    $.ajax({
        headers: {
            'X-CSRF-TOKEN': form.attr('_token')
        },
        enctype: 'multipart/form-data',
        type: form.attr('method'),
        url: form.attr('action'),
        processData: false,
        contentType: false,
        data: data,
        success: function(success){
            if(success.type === 'error'){
                $('#form_ads_message .error').html('<div class="alert alert-danger">' + success.message + '</div>');
                $('#form_ads_message .error').children('.alert').fadeOut(5000);
            }else{
                $('#form_ads_message .error').html('<div class="alert alert-success">' + success.message + '</div>');
                $('#form_ads_message .error').children('.alert').fadeOut(5000);
                $('#message_ads').val('');
                $('#file_i').val('');
                $('#form_ads_message .file_content').html('').hide();
            }

        },
        error: function(error){
            const response = error.responseJSON;
            $('#form_ads_message .error').html('<div class="alert alert-danger">' + response.message + '</div>');
            $('#form_ads_message .error').children('.alert').fadeOut(5000);
        }

    });
    return false;
});
$('#file_i').on('change', function(){
    $('#form_ads_message .file_content').html('<div class="alert alert-success">' + $(this).val().split('\\').pop() + ' </div>').show();
});

$( ".product_mains" ).each(function() {

  if($(this).find('.premium_item_border').length !== 0){
      $(this).find('>a').wrapAll('<div class="border_premium"></div>')
  }

});

$( ".product_mains" ).each(function() {

  if($(this).find('.premium_item_border').length !== 0){
      $(this).find('>.product_item').wrapAll('<div class="border_premium"></div>')
  }

});

