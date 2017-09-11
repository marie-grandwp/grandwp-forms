jQuery(document).ready(function(){
    jQuery('input#select-all').on('change',function () {
        if(this.checked){
            jQuery('input.item-checkbox').prop('checked', true);
        } else{
            jQuery('input.item-checkbox').prop('checked', false);
        }
    })


    /* remove single submission */
    jQuery('.gdfrm-delete-submission').on('click tap',function () {
        var id = jQuery(this).attr('data-id');
        var row = jQuery(this).closest('tr');

        var data = {
            action: "gdfrm_remove_submission",
            nonce: submission.removeNonce,
            id: id
        };
        jQuery.post(ajaxurl, data, function (response) {
            if (response.success) {
                row.remove();
            } else {
                alert('not done');
            }
        }, "json");

        return false;
    })

    /* remove,read checked submissions */
    jQuery('#doaction').on('click tap',function (e) {
        e.preventDefault();

        var action = jQuery('#bulk-action-selector-top').val();

        var items = jQuery('input.item-checkbox:checked');


        items.each(function () {
            var id = jQuery(this).val();
            var row = jQuery(this).closest('tr');
            var _this = jQuery(this);

            if(action == 'trash'){
                var data = {
                    action: "gdfrm_remove_submission",
                    nonce: submission.removeNonce,
                    id: id
                };
                jQuery.post(ajaxurl, data, function (response) {
                    if (response.success) {
                        row.remove();
                    } else {
                        alert('not done');
                    }
                }, "json");
            } else if( action == 'mark_read' ){
                var data = {
                    action: "gdfrm_read_submission",
                    nonce: submission.readNonce,
                    id: id
                };
                jQuery.post(ajaxurl, data, function (response) {
                    if (response.success) {
                        row.removeClass('gdfrm-new-sub');
                        _this.prop('checked',false);
                        jQuery('input#select-all').prop('checked',false);
                    } else {
                        alert('not done');
                    }
                }, "json");
            }
        })

        return false;
    })
});
