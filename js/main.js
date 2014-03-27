
/*Function isValidEmailAdress(String email)*/
function isValidEmailAddress(email) {
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(email);
};

jQuery(document).ready(function(){
    jQuery('#headerCarousel').flexslider({
        slideshow: false,
        controlNav: false,
        directionNav:false
    });
    jQuery('#TemoignageCarousel,#ExperienceEquipeCarousel,#ExperienceJeuneCarousel,#ExperienceAncienCarousel').flexslider({
        slideshow: false,
        controlNav: true,
        directionNav:true
    });
    jQuery('#ExperienceExterneTab a').click(function (e) {
        e.preventDefault();
        jQuery('#ExperienceExterneTab li').removeClass('actived');
        jQuery(this).tab('show');
        jQuery(this).parent().parent().addClass('actived');
    });

    $btnExpendable.each(function() {
        console.log(jQuery(this).prev().height());
        if(jQuery(this).prev().height() < 68)
            jQuery(this).remove();
    });

    //Menu responsive Jpanel
    if($(window).width()<=990){
        jPM = $.jPanelMenu({
            menu: '#MainNavigation',
            direction:'right',
            beforeOpen: function() {
                jQuery("#jPanelMenu-menu").addClass('open');
                jQuery("#Header").css('left','-'+jQuery("#jPanelMenu-menu").css('width'));
                jQuery("#wpadminbar").attr('style','left: -'+jQuery("#jPanelMenu-menu").css('width')+'!important');
                jQuery("#BackToTop").addClass("noDisplay");
            },
            beforeClose: function() {
                jQuery("#Header").css('left','0');
                jQuery("#wpadminbar").attr('style','left: 0 !important');
            },
            afterClose: function(){
                jQuery("#jPanelMenu-menu").removeClass('open');
                jQuery("#BackToTop").removeClass("noDisplay");
            }
        });
        jPM.on();
    }


    //Réglage de quelques items de navigation
    jQuery("#BackToTop").css("bottom",jQuery("footer").height()+40);
    if(jQuery('#wpadminbar').length>0){
        if(jQuery(window).width()<=480) jQuery('#HeaderNavBar').css('margin-top','46px');
        else jQuery('#HeaderNavBar').css('margin-top','32px');
    }
});
//Evenement se déroulant lors du scrolling
jQuery(window).scroll(function() {
    if(jQuery(window).scrollTop() > 0){
        jQuery("#BackToTop").addClass("display");
    }else {
        jQuery("#BackToTop").removeClass("display");
    }
    if(jQuery(window).scrollTop()>jQuery("#Header").height()){
        jQuery("#Header").addClass("fixed");
        jQuery("#Header+.container").css("margin-top",jQuery("#Header").height())
    }else{
        jQuery("#Header").removeClass("fixed");
        jQuery("#Header+.container").css("margin-top",0);
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

var $btnExpendable = jQuery("button[data-expandable]");

//Expandable
$btnExpendable.click(function(){
    if(!jQuery(this).prev().hasClass("expandable")){
        //console.log(jQuery(this));
        jQuery(this).prev().switchClass("","expandable",300);
        jQuery(this).attr("data-expandable",'true');
        jQuery(this).html("Réduire");
    }else{
        jQuery(this).prev().switchClass("expandable","",300);
        jQuery(this).attr("data-expandable",'false');
        jQuery(this).html("En savoir plus...");
    }
});



// News dynamiques
jQuery("#SelSortYearNews").change(function() {
    theYear = jQuery(this).val();
    jQuery('#ListOtherNews').html('<div class="load" style="height: 200px;"><img src="/wp-content/themes/acte13/images/loader.gif" alt="Chargement..."/></div>');
    jQuery('.load').css({'padding-top': '75px', 'text-align': 'center'});
    jQuery.ajax({
        url: '/wordpress/wp-content/themes/acte13/ajax.news.php',
        type: 'post',
        data: { year: theYear },
        success: function(data) {
            jQuery('#ListOtherNews').html(data);
        },
        error: function(a, text, error) {
            console.log(text + " " + error);
        }
    });
});

jQuery("#BtnSubmitContact").click(function() {
    jQuery('#Process').text("Envoi en cours...");
    jQuery.ajax({
        url: '/wp-content/themes/acte13/ajax.contact.php',
        type: 'post',
        data: { nom: jQuery('#TxtNom').val(),
                mail: jQuery('#TxtMail').val(),
                objet: jQuery('#TxtObjet').val(),
                message: jQuery('#TxtMessageRDV').val()
        },
        success: function(data) {
            if(data > 0) {
                jQuery('#Process').text("Message envoyé !");
            }
            else
                jQuery('#Process').text("Une erreur est survenue.").css('color', 'red');
        },
        error: function(a, text, error) {
            jQuery('#Process').text("Une erreur est survenue.");
            console.log(text + " " + error);
        }
    });
});

function backToTop(){
    jQuery('html, body').stop().animate({
        'scrollTop': 0
    }, 900, 'swing');
}

