jQuery( window ).load( function() {
	setTimeout( function() {
	jQuery( '.pop-up-screen, .overlay' ).fadeIn();
        jQuery( 'iframe.delayed' ).attr( 'src', '//www.youtube.com/embed/gRgZnZz_Tj4?version=3&amp;autoplay=1&amp;showinfo=0&amp;loop=0&amp;controls=0&amp;playlist=gRgZnZz_Tj4' ); 
    }, 2000);
     jQuery( '.close' ).on( 'click', function(){
	  jQuery( '.pop-up-screen, .overlay' ).fadeOut( 600,function(){
        jQuery( 'iframe.delayed' ).attr( 'src', '//www.youtube.com/embed/gRgZnZz_Tj4?version=3&amp;autoplay=0&amp;showinfo=0&amp;loop=0&amp;controls=0&amp;playlist=gRgZnZz_Tj4' ); 	  
	  });
     });
});