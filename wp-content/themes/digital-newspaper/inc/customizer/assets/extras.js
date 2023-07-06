jQuery(document).ready(function($) {
    var ajaxurl = customizerExtrasObject.ajaxUrl, _wpnonce = customizerExtrasObject._wpnonce;
    $( ".customize-info-box-action-control" ).each(function() {
        $(this).find( ".info-box-button" ).on( "click", function() {
            var _this = $(this), action = _this.data("action"), html = _this.html();
            $.ajax({
                method: 'post',
                url: ajaxurl,
                data: ({
                    'action': action,
                    '_wpnonce': _wpnonce,
                }),
                beforeSend: function(response) {
                    _this.html( 'Processing' )
                    _this.attr( 'disabled', true )
                },
                success: function(response) {
                    _this.html( html );
                },
                complete: function() {
                    window.location.reload();
                }
            })
        })
    })
})