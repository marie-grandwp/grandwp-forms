jQuery('.gdfrm_delete_form').on('click',function(){
    if( !confirm( "Are you sure you want to delete this item?" ) ){
        return false;
    }
});

jQuery('body').on('focus',".datepicker", function(){
    jQuery(this).datepicker({dateFormat: "dd-mm-yy"});
})

jQuery('input#select-all').on('change',function () {
        if(this.checked){
            jQuery('input.item-checkbox').prop('checked', true);
        } else{
            jQuery('input.item-checkbox').prop('checked', false);
        }
});

jQuery(document).ready(function () {
    /* remove,read checked forms */
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
                    action: "gdfrm_remove_form",
                    nonce: form.removeNonce,
                    id: id
                };
                jQuery.post(ajaxurl, data, function (response) {
                    if (response.success) {
                        row.remove();
                    } else {
                        alert('not done');
                    }
                }, "json");
            }
        })

        return false;
    })


    jQuery(document).on('change','.switch-checkbox.mask-switch',function () {
        if(this.checked){
            jQuery(this).closest('.setting-row').find('.description').removeClass('readonly');
            jQuery(this).closest('.settings-block').find('.setting-row.setting-default').addClass('readonly');
            jQuery(this).closest('.settings-block').find('.setting-row.setting-placeholder').addClass('readonly');
        } else{
            jQuery(this).closest('.setting-row').find('.description').addClass('readonly');
            jQuery(this).closest('.settings-block').find('.setting-row.setting-placeholder').removeClass('readonly');
            jQuery(this).closest('.settings-block').find('.setting-row.setting-default').removeClass('readonly');
        }
    })

})


