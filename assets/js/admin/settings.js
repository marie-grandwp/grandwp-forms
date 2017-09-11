jQuery(document).ready(function(){
    /* save plugin settings */
    jQuery('.gdfrm_content').on("click","#save-form-button", function () {
        var grandForm = jQuery('#grand-form');
        var _this = jQuery(this);

        formData = grandForm.serializeArray();

        var general_data = {
            action: "gdfrm_save_settings",
            nonce: settingsSave.nonce,
            formData:formData,
        };
        jQuery(this).prepend('<i class="fa fa-spinner fa-spin"></i>').addClass('disabled');
        jQuery.post(ajaxurl, general_data, function (response) {
            if (response.success) {
                jQuery('#save-form-button').find('.fa-spinner').remove();
                _this.removeClass('disabled');
            } else {
                alert('not done');
            }
        }, "json");

        return false;
    });
});