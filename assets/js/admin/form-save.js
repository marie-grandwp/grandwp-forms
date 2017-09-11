jQuery(document).ready(function(){
    var formSubmitting = true;

    var scrolled = jQuery(window).scrollTop();

    var header_height = jQuery('.gdfrm_header').outerHeight() + jQuery('.gdfrm_nav').outerHeight();

    var doc_height = jQuery(document).height();

    var window_height = jQuery(window).height();

    var leftcol_height = jQuery('.left-col').outerHeight();

    var diff = doc_height-( scrolled + window_height);

    var refreshScrollParameters = function() {
        scrolled = jQuery(window).scrollTop();

        header_height = jQuery('.gdfrm_header').outerHeight() + jQuery('.gdfrm_nav').outerHeight();

        doc_height = jQuery(document).height();

        window_height = jQuery(window).height();

        leftcol_height = jQuery('.left-col').outerHeight();

        diff = doc_height - ( scrolled + window_height);

        var fixedElementHeight = jQuery('.tobefixed').outerHeight();

        var rightcolWidth = jQuery('.right-col').width();

        jQuery('.right-col').innerHeight(fixedElementHeight);

        jQuery('.tobefixed').outerWidth(rightcolWidth);
    }


    jQuery( function() {
        jQuery( "#fields-list" ).sortable({
            connectWith: "div",
            stop: function(evt, ui) {
                formSubmitting = false;
            }
        });
    } );

    jQuery( function() {
        jQuery( ".options" ).sortable({
            connectWith: ".option",
            stop: function(evt, ui) {
                formSubmitting = false;
            }
        });
    } );


    jQuery(window).on('scroll',function () {
        refreshScrollParameters();

        if( scrolled >= header_height && diff >= 0){
            jQuery('.tobefixed').addClass('gdfrmFixed');
        } else{
            jQuery('.tobefixed').removeClass('gdfrmFixed');
        }
    })

    /* save form with ajax */
    jQuery('.gdfrm_edit_form_container').on("click","#save-form-button", function () {
        var name = jQuery("#form_name").val();
        var id = jQuery("#form_id").val();
        var grandForm = jQuery('#grand-form');
        var _this = jQuery(this);

        var k = 0;
        var formData,
            finalFormData;

        jQuery("#fields-list > div.field-block").each(function() {
            var id=jQuery(this).attr('data-field-id');
            jQuery('.settings-block[data-field-id="'+id+'"] .setting-row').find('.setting-order').val(k);
            k++;
        });

        jQuery(".settings-block .options").each(function() {
            var l = 0;
            jQuery(this).find('.option').each(function () {
                jQuery(this).find('.setting-option-order').val(l);
                l++;
            });
        });

        var editors = jQuery('.wp-editor-wrap.tmce-active');

        var names = [];

        var preview_forms = [];

        editors.each(function () {
            names.push(jQuery(this).find('textarea.setting-row').attr('name'));
        })

        formData = grandForm.serializeArray();

        finalFormData = [];

        formData.forEach(function (entry) {
            if(jQuery.inArray(entry.name,names) != '-1') {
                entry.value = tinyMCE.editors[entry.name].getContent();
            }
            finalFormData.push(entry);
        })

        if(jQuery('.preview-form-id').length>0){

            jQuery('.preview-form-id').each(function () {
                preview_forms.push(jQuery(this).val());
            })
        }

        var general_data = {
            action: "gdfrm_save_form",
            nonce: formSave.nonce,
            form_id: id,
            form_name: name,
            formData: finalFormData,
            preview_forms: preview_forms
        };
        jQuery(this).prepend('<i class="fa fa-spinner fa-spin" aria-hidden="true"></i>').addClass('disabled');
        jQuery.post(ajaxurl, general_data, function (response) {
            if (response.success) {
                jQuery('#save-form-button').find('.fa-spinner').remove();
                _this.removeClass('disabled');

            } else {
                alert('not done');
            }
        }, "json");

        formSubmitting=true;

        return false;
    });

    /* remove field */
    jQuery('.gdfrm_edit_form_container').on("click",".left-col .field-block .gdicon-remove", function () {
        var id = jQuery(this).closest('.field-block').attr('data-field-id');
        var general_data = {
            action: "gdfrm_remove_field",
            nonce: field.removeNonce,
            id: id,
        };
        jQuery.post(ajaxurl, general_data, function (response) {
            if (response.success) {
                jQuery("#fields-list .field-block[data-field-id="+id+"]").remove();
                jQuery(".settings-block[data-field-id="+id+"]").remove();
                jQuery(".settings-block").hide();
                jQuery('.field-block').removeClass('gdfrm_active');
                jQuery('#type-blocks-list').show();
            } else {
                alert('not done');
            }
        }, "json");

        formSubmitting = false;

        return false;
    });

    /* duplicate field */
    jQuery('.gdfrm_edit_form_container').on("click",".left-col .field-block .gdicon-duplicate", function () {
        var id = jQuery(this).closest('.field-block').attr('data-field-id');
        var form = jQuery('.gdfrm_edit_form_container').attr('data-form');
        var type = jQuery(this).closest('.field-block').attr('data-field-type');
        var copied_field = jQuery(this).closest('.field-block');

        var label = jQuery(this).closest('.field-block').find('span').text();

        var _this = jQuery(this);
        var general_data = {
            action: "gdfrm_duplicate_field",
            nonce: field.duplicateNonce,
            id: id,
            form: form,
            type: type
        };

        jQuery.post(ajaxurl, general_data, function (response) {
            if (response.success) {
                copied_field.after(response.fieldBlock);
                jQuery("#settings-list").append(response.settingsBlock);

            } else {
                alert('not done');
            }
        }, "json");

        formSubmitting = false;

        return false;
    });

    /* preview form start */
    jQuery(document).on('click','#preview-form',function (e) {
        e.preventDefault();

        var _this= jQuery(this);
        var form_to_preview = _this.attr('data-form');
        var formData,
            finalFormData,
            k=0,
            grandForm = jQuery('#grand-form');



        jQuery("#fields-list > div.field-block").each(function() {
            var id=jQuery(this).attr('data-field-id');
            jQuery('.settings-block[data-field-id="'+id+'"] .setting-row').find('.setting-order').val(k);
            k++;
        });

        jQuery(".settings-block .options").each(function() {
            var l = 0;
            jQuery(this).find('.option').each(function () {
                jQuery(this).find('.setting-option-order').val(l);
                l++;
            });
        });

        var editors = jQuery('.wp-editor-wrap.tmce-active');

        var names = [];

        editors.each(function () {
            names.push(jQuery(this).find('textarea.setting-row').attr('name'));
        })

        formData = grandForm.serializeArray();

        finalFormData = [];

        formData.forEach(function (entry) {
            if(jQuery.inArray(entry.name,names) != '-1') {
                entry.value = tinyMCE.editors[entry.name].getContent();
            }
            finalFormData.push(entry);
        })

        var general_data = {
            action: "gdfrm_duplicate_form",
            id: form_to_preview,
            ispreview: 1,
            formData: finalFormData
        };

        jQuery.post(ajaxurl, general_data, function (response) {
            if (response.success) {
                jQuery('#grand-form').append('<input type="hidden" class="preview-form-id" value="'+response.preview_form_id+'">');
                window.open(response.preview_form_link, '_blank');
            } else {
                alert('not done');
            }
        }, "json");

    });
    /* preview form end */


    /* open field settings block in the right column */
    jQuery('.gdfrm_edit_form_container').on("click",".gdicon-setting,span.field_name", function () {
            var id = jQuery(this).closest('.field-block').attr('data-field-id');
            var form = jQuery('.gdfrm_edit_form_container').attr('data-form');
            var field_cont = jQuery(this).closest('.field-block');
            jQuery('.field-block').removeClass('gdfrm_active');
            field_cont.addClass('gdfrm_active');


        jQuery('#type-blocks-list').hide();

            jQuery('.settings-block').hide();

            jQuery('.settings-block[data-field-id='+id+']').toggle();

            jQuery('.left-col').animate({
                left: '0',
            } , 200 ,function () {
                jQuery('.right-col').animate({
                    right: '0',
                }, 200 , function () {
                    refreshScrollParameters();

                    if( scrolled >= header_height && diff >= 0){
                        jQuery('.tobefixed').addClass('gdfrmFixed');
                    } else{
                        jQuery('.tobefixed').removeClass('gdfrmFixed');
                    }
                });
            } );
    });

    /* position add field and hide rightcol buttons */
    var rightcol_width = jQuery('.right-col').outerWidth();
    jQuery('.hide-rightcol,.add-field-rightcol').css('right',rightcol_width+'px');

    jQuery(window).resize(function () {
        var rightcol_width = jQuery('.right-col').outerWidth();
        jQuery('.hide-rightcol,.add-field-rightcol').css('right',rightcol_width+'px');
    })

    /* open add new field container */
    jQuery('.gdfrm_edit_form_container').on("click","#add-new-field, .add-field-rightcol", function () {

        jQuery('#type-blocks-list').show();

        jQuery('.settings-block').hide();

        jQuery('.field-block').removeClass('gdfrm_active');

        jQuery('.left-col').animate({
            left: '0',
        } , 200 ,function () {
            jQuery('.right-col').animate({
                right: '0',
            }, 200 , function () {
                refreshScrollParameters();

                if( scrolled >= header_height && diff >= 0){
                    jQuery('.tobefixed').addClass('gdfrmFixed');
                } else{
                    jQuery('.tobefixed').removeClass('gdfrmFixed');
                }
            });
        } );
    });

    /* close rightcol */
    jQuery('.gdfrm_edit_form_container').on("click",".hide-rightcol", function () {
        jQuery('.right-col').animate({
            right: '-765px',
        } , 200 ,function () {
            jQuery('.left-col').animate({
                left: '25%',
            }, 200 );
        } );
    });


    /* add field with ajax */
    jQuery('.gdfrm_edit_form_container').on("click",".right-col .type-block", function () {
        var _this = jQuery(this);
        var type_id = _this.attr('type-id');
        var id = jQuery('#form_id').val();
        var type_name = _this.text();
        var order = jQuery('.gdfrm_content #fields-list .field-block').length;

        if(_this.hasClass('pro-field')){
            alert('This is a Pro Field');
            return false;
        }

        var single_fields = ['Recaptcha','Captcha','Submit'];
        var reload_fields = ['Html','Address'];

        var number_of_fieldtype = jQuery('.field-block[data-field-type='+type_id+']').length;

        if(single_fields.includes(type_name) &&  number_of_fieldtype>=1) {
            alert('You Can Have Only 1 '+type_name+' Field in a Form');
            return false;
        }

        var data = {
            action: "gdfrm_save_field",
            nonce: field.saveNonce,
            form: id,
            type: type_id,
            type_name :type_name,
            order: order
        };

        _this.append('<div class="loading"><i class="fa fa-spinner fa-spin "></i></div>');
        jQuery.post(ajaxurl, data, function (response) {
            if (response.success) {
                jQuery('.gdfrm_content #fields-list').append(response.fieldBlock);
                jQuery("#settings-list").append(response.settingsBlock);

                if(reload_fields.includes(type_name)){
                    location.reload();
                }

                jQuery('.loading').html('<i class="fa fa-check" aria-hidden="true"></i>');

                setTimeout(function () {
                    jQuery('.loading').remove();
                },700);
            } else {
                alert('not done');
            }
        }, "json");

        formSubmitting = false;

        return false;
    });

    /* update field label onchange */
    jQuery(document).on('keyup','.settings-block .setting-label',function () {
        var field_id = jQuery(this).closest('.settings-block').attr('data-field-id');
        var newLabel = jQuery(this).val();
        jQuery('.field-block[data-field-id='+field_id+'] span.field_name').text(newLabel);

        formSubmitting = false;
    });

    /* add single option to checkbox,radio,select */
    jQuery('.gdfrm_edit_form_container').on("click",".gdfrm-add-option", function () {
        var container = jQuery(this).closest('.settings-block').find('.options');

        var field_id = jQuery(this).closest('.settings-block').attr('data-field-id');

        var data = {
            action: "gdfrm_add_field_option",
            nonce: field.addOptionNonce,
            field: field_id,
        };
        jQuery.post(ajaxurl, data, function (response) {
            if (response.success) {
                jQuery(container).append(response.option_row);
            } else {
                alert('not done');
            }
        }, "json");

        formSubmitting = false;

        return false;
    });

    /* remove option */
    jQuery('.gdfrm_edit_form_container').on("click",".gdfrm-remove-option", function () {
        var option = jQuery(this).attr('data-option');
        var row = jQuery(this).closest('.option');

        var data = {
            action: "gdfrm_remove_field_option",
            nonce: field.removeOptionNonce,
            option: option,
        };
        jQuery.post(ajaxurl, data, function (response) {
            if (response.success) {
                row.remove();
            } else {
                alert('not done');
            }
        }, "json");

        formSubmitting = false;

        return false;
    });

    /* open import options block */
    jQuery('.gdfrm_edit_form_container').on("click","i.gdfrm-import-options", function () {
        jQuery(this).closest('.settings-block').find('.import-block').show();
    });

    /* close import options block */
    jQuery('.gdfrm_edit_form_container').on("click",".cancel", function () {
        jQuery(this).closest('.settings-block').find('.import-block').hide();
    });

    /* import options to checkbox,radio and selectbox fields */
    jQuery('.gdfrm_edit_form_container').on("click","span.import-options", function () {
        var options = jQuery(this).closest('.import-block').find('textarea').val();

        var field_id = jQuery(this).closest('.settings-block').attr('data-field-id');

        var container = jQuery(this).closest('.settings-block').find('.options');

        var data = {
            action: "gdfrm_import_options",
            nonce: field.importOptionsNonce,
            options: options,
            field: field_id,
        };
        jQuery.post(ajaxurl, data, function (response) {
            if (response.success) {
                var optionsRows = response.options_rows;
                container.append(optionsRows);
                jQuery('.import-block').hide();
            } else {
                alert('not done');
            }
        }, "json");

        formSubmitting = false;

        return false;
    });


    /* imageselect field */
    var mediaUploader;

    jQuery('.gdfrm_content').on('click','span.add-options',function (e) {
        e.preventDefault();

        var container = jQuery(this).closest('.settings-block').find('.options');

        var field_id = jQuery(this).closest('.settings-block').attr('data-field-id');

        if( mediaUploader ){
            mediaUploader.open();
            return;
        }

        mediaUploader = wp.media.frames.file_frame = wp.media({
            'title'    : 'Choose Image',
            'button'   :{
                'text':'Choose Picture'
            },
            'multiple' : false
        })

        // When an image is selected in the media frame...
        mediaUploader.on( 'select', function() {

            // Get media attachment details from the frame state
            var attachment = mediaUploader.state().get('selection').first().toJSON();
            var data = {
                action: "gdfrm_add_field_option",
                nonce: field.addOptionNonce,
                field: field_id,
                attachment : attachment
            };
            jQuery.post(ajaxurl, data, function (response) {
                if (response.success) {
                    jQuery(container).append(response.option_row);
                } else {
                    alert('not done');
                }
            }, "json");

            formSubmitting = false;

            return false;
        });

    })


    /* mark fields with notices */
    var showNotices = function() {
        jQuery('.notice').each(function () {
            var field_id = jQuery(this).closest('.settings-block').attr('data-field-id');

            jQuery('.field-block[data-field-id='+field_id+']').addClass('hasError');
        });
    };

    setInterval(showNotices,500);

    /* select2 dropdown */
    jQuery('select.select2').select2();

    /* page reload */
    jQuery(window).on("beforeunload",function(e) {
        if(jQuery('#submit-notice-shown').val() == 0 && jQuery('.field-block[data-field-type=18]').length == 0){
            jQuery('.gdicon-submit').trigger('click');
        }

        if (!formSubmitting) {
            return "You have some unsaved changes";
        }
    });

    jQuery(document).on('click','.popup-trigger',function (e) {
        e.preventDefault();
        e.stopPropagation();

        var target = jQuery(this).attr('data-target');

        if(jQuery('#'+target).css('display')=='none'){
            jQuery('#'+target).fadeIn();
        } else{
            jQuery('#'+target).fadeOut();
        }
    })

    jQuery(document).on('click',function () {
        jQuery('.popup').fadeOut();
    })

    jQuery(document).on('click','.popup i',function () {
        jQuery('.popup').fadeOut();
    })

    jQuery(document).on('click','.popup',function (e) {
        e.stopPropagation();
    })
});


