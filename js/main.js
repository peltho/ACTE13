
/*Function isValidEmailAdress(String email)*/
function isValidEmailAddress(email) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(email);
};

$(document).ready(function(){
    $('#headerCarousel').flexslider({
        slideshow: true,
        controlNav: false,
        directionNav:false
    });
    $('#TemoignageCarousel,#ExperienceEquipeCarousel,#ExperienceJeuneCarousel,#ExperienceAncienCarousel').flexslider({
        slideshow: true,
        controlNav: true,
        directionNav:true
    });
    $('#ExperienceExterneTab a').click(function (e) {
        e.preventDefault();
        $('#ExperienceExterneTab li').removeClass('actived');
        $(this).tab('show');
        $(this).parent().parent().addClass('actived');
    });
    $('#BackToTop').on('click',function (e) {
        $('html, body').stop().animate({
            'scrollTop': 0
        }, 900, 'swing');
    });

    //Menu responsive Jpanel
    jPM = $.jPanelMenu({
        menu: '#MainNavigation',
        direction:'right',
        beforeOpen: function() {
            $("#jPanelMenu-menu").addClass('open');
            $("#Header").css('left','-'+jQuery("#jPanelMenu-menu").css('width'));
            $("#wpadminbar").attr('style','left: -'+jQuery("#jPanelMenu-menu").css('width')+'!important');
            $("#BackToTop").addClass("noDisplay");
        },
        beforeClose: function() {
            $("#Header").css('left','0');
            $("#wpadminbar").attr('style','left: 0 !important');
        },
        afterClose: function(){
            $("#jPanelMenu-menu").removeClass('open');
            $("#BackToTop").removeClass("noDisplay");
        }
    });
    jPM.on();

    //Réglage de quelques items de navigation
    $("#BackToTop").css("bottom",jQuery("footer").height()+40);
    if($('#wpadminbar').length>0){
        if($(window).width()<=480) $('#HeaderNavBar').css('margin-top','46px');
        else $('#HeaderNavBar').css('margin-top','32px');
    }
});
//Evenement se déroulant lors du scrolling
jQuery(window).scroll(function() {
    if($(window).scrollTop() > 0){
        $("#BackToTop").addClass("display");
    }else {
        $("#BackToTop").removeClass("display");
    }
    if($(window).scrollTop()>$("#Header").height()){
        $("#Header").addClass("fixed");
        $("#Header+.container").css("margin-top",$("#Header").height())
    }else{
        $("#Header").removeClass("fixed");
        $("#Header+.container").css("margin-top",0);
    }
});


/* void OpenMenu()
Permet d'ouvrir et fermer le menu "manuellement"
 */
function OpenMenu(){
    if(jPM.isOpen()){
        jPM.open();
    }else{
        jPM.open();
    }
}

//Expandable
$("button[data-expandable]").click(function(){
    if(!$(this).prev().hasClass("expandable")){
        console.log($(this));
        $(this).prev().switchClass("","expandable",300);
        $(this).attr("data-expandable",'true');
        $(this).html("Réduire");
    }else{
        $(this).prev().switchClass("expandable","",300);
        $(this).attr("data-expandable",'false');
        $(this).html("En savoir plus...");
    }
});






