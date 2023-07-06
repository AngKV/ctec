jQuery(document).ready(function($){

    $('#login').wrapInner('<div />').children().addClass('gs-body-login');
    
    $('#login').show();

    // if(!$('body').hasClass('gs-form-animated-in')) {

    //     $('.gs-body-login').animate({'opacity': 1}, 500);
    // }

        function ttAnimation() {
            //In Animation
            if( $('body').hasClass('gs-form-animated-in') && typeof gs_object.theme !== 'undefined' ){
                $('.gs-body-login').addClass('animated ' +gs_object.theme);
            }

            if(typeof gs_object.theme !== 'undefined') {
                if(gs_object.theme.indexOf('fadeIn') < 0) {
                    $('.gs-body-login').animate({'opacity': 1}, 500);
                }
            }
        
   
    }

    setTimeout(ttAnimation, 300);

    

});