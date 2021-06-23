/*prevent href from default action */
$('a.prevhref').click(function(e) {
    return false;
    e.preventDefault();
});

/* class for date fields */

/*side-navigation collapse for sub menus*/
$(function() {
    $('nav').on('click', 'li', function() {
        $(this).children('a').children('i').toggleClass("down");
        $(this).children('ul').slideToggle(function() {
            $(this).toggleClass('in out');
        });
        $(this).siblings().find('ul').slideUp(function() {
            $(this).removeClass('in').addClass('out');
        });
    });
});

/*active classes for navigation*/

$(function() {
    var pgurl = window.location.href.substr(window.location.href
        .lastIndexOf("/") + 1);
    $("#main-nav a").each(function() {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
            $(this).addClass("active-main");
    })
    $("#side-main-nav a").each(function() {
        if ($(this).attr("href") == pgurl || $(this).attr("href") == '')
            $(this).addClass("active-side");
    })
});

/*Home Slider*/
jQuery(document).ready(function($) {

    var jssor_1_SlideoTransitions = [
        [{
            b: -1,
            d: 1,
            o: -1
        }, {
            b: 0,
            d: 1000,
            o: 1
        }],
        [{
            b: 1900,
            d: 2000,
            x: -379,
            e: {
                x: 7
            }
        }],
        [{
            b: 1900,
            d: 2000,
            x: -379,
            e: {
                x: 7
            }
        }],
        [{
            b: -1,
            d: 1,
            o: -1,
            r: 288,
            sX: 9,
            sY: 9
        }, {
            b: 1000,
            d: 900,
            x: -1400,
            y: -660,
            o: 1,
            r: -288,
            sX: -9,
            sY: -9,
            e: {
                r: 6
            }
        }, {
            b: 1900,
            d: 1600,
            x: -200,
            o: -1,
            e: {
                x: 16
            }
        }]
    ];

    var jssor_1_options = {
        $AutoPlay: true,
        $SlideDuration: 800,
        $SlideEasing: $Jease$.$OutQuint,
        $CaptionSliderOptions: {
            $Class: $JssorCaptionSlideo$,
            $Transitions: jssor_1_SlideoTransitions
        },
        $ArrowNavigatorOptions: {
            $Class: $JssorArrowNavigator$
        },
        $BulletNavigatorOptions: {
            $Class: $JssorBulletNavigator$
        }
    };

    var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

    //responsive code begin
    //you can remove responsive code if you don't want the slider scales while window resizing
    function ScaleSlider() {
        var refSize = jssor_1_slider.$Elmt.parentNode.clientWidth;
        if (refSize) {
            refSize = Math.min(refSize, 1920);
            jssor_1_slider.$ScaleWidth(refSize);
        } else {
            window.setTimeout(ScaleSlider, 30);
        }
    }
    ScaleSlider();
    $(window).bind("load", ScaleSlider);
    $(window).bind("resize", ScaleSlider);
    $(window).bind("orientationchange", ScaleSlider);
    //responsive code end
});

/* Know More link */

$('.know-more').click(function() {
    $('.main-tab-link>a.is-active').removeClass('is-active')
    $('.main-tab-link>a[href="#Contact-panel"]').addClass('is-active')
    $('.panel-tab-link>div.is-active').removeClass('is-active')
    $('.panel-tab-link>div[id="Contact-panel"]').addClass('is-active')
});

/* Sign-in Form overlay effect */

$(function() {
    $('#activator-sign-in').click(function(){
        $('#activator-sign-in').hide();
       $('#boxclose-sign-in').show();
        $('#overlay-sign-in').fadeIn('fast',function(){
            $('#box-sign-in').animate({'top':'160px'},500);
        });
    });
    $('#boxclose-sign-in').click(function(){
        $('#box-sign-in').animate({'top':'-200px'},500,function(){
            $('#overlay-sign-in').fadeOut('fast');
        });
        $('#activator-sign-in').show();
        $('#boxclose-sign-in').hide();
    });

});

    function destroy_session() {
    $.ajax({url: "sign-out.php", success: function(result){
              $("#signout").html(result);
          }});
    }

   
/* capitalise name */
function capital(x,y) {
    if(x!='') {
        var capital="";
        var spl = x.split(" ");
        for (i = 0; i < spl.length; i++) {
            capital +=spl[i].charAt(0).toUpperCase()+spl[i].slice(1)+' ';
        }
        capital_trim =$.trim(capital); 
        $('#'+y).val(capital_trim).change();
    }
}

    $("select").on("change keyup", function() {
        if($(this).val() != ''){
            $(this).parent().addClass('is-dirty');
        }
    });
