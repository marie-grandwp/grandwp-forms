jQuery('.form_loading_icon').on('click', function(){
    return false;
});

jQuery(window).on('load', function(){
    jQuery('.form_loading_icon').css('display', 'none');
});

jQuery(document).ready(function() {

    function isValidEmailAddress(emailAddress) {
        var pattern = new RegExp(/^(("[\w-+\s]+")|([\w-+]+(?:\.[\w-+]+)*)|("[\w-+\s]+")([\w-+]+(?:\.[\w-+]+)*))(@((?:[\w-+]+\.)*\w[\w-+]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$)|(@\[?((25[0-5]\.|2[0-4][\d]\.|1[\d]{2}\.|[\d]{1,2}\.))((25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\.){2}(25[0-5]|2[0-4][\d]|1[\d]{2}|[\d]{1,2})\]?$)/i);
        return pattern.test(emailAddress);
    }


    jQuery('.gdfrm-required input,.gdfrm-required textarea,.gdfrm-required select').each(function(){
        var _this = jQuery(this);

        _this.shake = function () {
            _this.on('blur',function () {
                setTimeout(function(){
                    if(jQuery.trim(_this.val())==''){
                        _this.effect( "shake", { direction: "up", times: 2, distance: 5}, 500 );
                        _this.addClass('user-error');
                    } else{
                        _this.removeClass('user-error');
                    }
                },100);

            })
        }

        _this.stateChange = function () {
            _this.on('change',function () {
                console.log(jQuery.trim(_this.val()));
                if(jQuery.trim(_this.val())==''){
                    _this.removeClass('user-error');
                    _this.siblings('.error-block').text('');
                }
            })
        }

        setTimeout(function(){
            _this.shake();
            _this.stateChange();
        },100);
    });

    jQuery('.gdfrm-form-field.hidden input,.gdfrm-form-field.hidden textarea').on('focus',function(){
        var _this = jQuery(this);

        _this.closest('.gdfrm-form-field').addClass('field-focus');
    });

    jQuery('.gdfrm-form-field.hidden .hidden-placeholder').on('click',function(){
        var _this = jQuery(this);

        _this.closest('.gdfrm-form-field').find('input,textarea').focus();
    });







    function validateInputs(obj){
        var success = true;
        var form_cont_id = obj.attr('id');

        var required_empty_error = jQuery('#'+form_cont_id).children('.required-empty-error').val();
        if(required_empty_error == '') required_empty_error = 'This field is required';

        var email_format_error = jQuery('#'+form_cont_id).children('.email-format-error').val();
        if(email_format_error == '') email_format_error = 'Wrong Email Format';

        var upload_size_error = jQuery('#'+form_cont_id).children('.upload-size-error').val();
        if(upload_size_error == '') upload_size_error = 'Max Upload Size Exceeded';

        var file_format_error = jQuery('#'+form_cont_id).children('.file-format-error').val();
        if(file_format_error == '') file_format_error = 'Wrong File Format';


            /* validate required fields */
        jQuery('#'+form_cont_id+' .gdfrm-required').each(function () {
            var Field ;
            var _this = jQuery(this);

            if(_this.hasClass('gdfrm-checkbox') || jQuery(this).hasClass('gdfrm-imageselect')){
                Field = _this.find('input[type=checkbox]');

                var field_name = Field.attr('name');

                if(!Field.is(':checked')){
                    success = false;
                    _this.addClass('empty');
                    _this.find('.error-block').text(required_empty_error).show();
                }
            } else{
                Field = jQuery(this).find('div').find('input,textarea,select');
                if( Field.val()=='' ){
                    success = false;
                    _this.addClass('empty');
                    _this.find('.error-block').text(required_empty_error).show();
                }
            }
        })

        /* validate email fields */
        jQuery('#'+form_cont_id+' .email').each(function () {
            var emailField = jQuery(this).find('input[type=email]');

            if(!isValidEmailAddress(emailField.val())){
                success = false;
                jQuery(this).find('.error-block').text(email_format_error).show();
            }
        })

        /* validate max selected checkboxes */
        jQuery('.gdfrm-checkbox-options').each(function () {
            var max_sel = jQuery(this).attr('data-max-sel');

            var options_number = jQuery(this).find('.gdfrm-checkbox-option').length;

            if( max_sel > options_number ) max_sel = options_number;

            if( max_sel > 0 ){
                    var selected = jQuery(this).find('input[type="checkbox"]:checked').length;

                    if( selected > max_sel ){
                        success = false;
                        jQuery(this).next('.error-block').text('You can select max '+max_sel+' option(s)').show();
                    }

            }
        })

        return success;
    }

    /* image option select */
    jQuery('.gdfrm-checkbox-option-image input').on('change',function (e) {
        var max_sel = jQuery(this).closest('.gdfrm-checkbox-options').attr('data-max-sel');
        var _this_cont = jQuery(this).closest('.gdfrm-checkbox-option-image');
        var _this = jQuery(this);

        var already_selected = jQuery(this).closest('.gdfrm-checkbox-options').find('input[type="checkbox"]:checked').length;

        if( max_sel < already_selected && max_sel>0){
            _this.attr('checked',false);
            _this_cont.removeClass('gdfrm-selected');


            alert('You can select only '+max_sel+' option(s)');
        } else {

            _this_cont.toggleClass('selected');
        }


    })


    /* form submit */
    jQuery('.gdfrm-form').on("submit",function (e) {
        e.preventDefault();
        var form = jQuery(this);
        var button = form.find('input[type=submit]');
        var form_id = form.attr('form-id');

        var validateSuccess = validateInputs(form);

        if(validateSuccess){

            var formData = new FormData();

            var files = jQuery('.gdfrm-inputfile');

            var postData = form.serialize();

            jQuery.each(jQuery(files), function(i, obj) {
                jQuery.each(obj.files,function(j,file){
                    formData.append(obj.name, file);
                })
            });

            formData.append('action', 'gdfrm_submit_form');
            formData.append('form_id', form_id);
            formData.append('postData', postData);

            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data : formData,
                contentType: false,
                processData: false,
                beforeSend: function(){

                    button.unbind( "click" );
                    button.val( "Sending..." );

                },
                success: function( response ){
                    response = JSON.parse(response);
                    console.log(response);
                    if (response.success) {
                            button.val( "Send" ).css('pointer-events','none');

                            if( response.action_onsubmit == '1' ){ /*success message */
                                form.closest('.gdfrm-form-container').append('<div class="success-message">'+response.success_message+'</div>');
                                if(response.hide_form == '1'){
                                    form.remove();
                                }
                            } else if(response.action_onsubmit == '2'){ /*redirect */
                                if(response.redirect_url!=''){
                                    window.location.replace(response.redirect_url)
                                }
                            } else if(response.action_onsubmit == '3'){ /*reset form */
                                document.getElementById("gdfrm-"+form_id).reset();
                            }

                        jQuery('.error-block').html('');
                    } else if( response.validation_errors ){
                            var errors = response.validation_errors;
                         jQuery.each(errors,function(k,error){
                                var id = error.field;
                                var error = error.error;
                                jQuery('.gdfrm-form-field.field-'+id+' .error-block').html(error).show();
                            });
                            button.val( "Send" ).css('pointer-events','auto');

                    } else {
                            alert('not done');
                        }
                    }
            });

            return false;
        }
    });


    /* datepicker */
    jQuery( ".grandwpdatepicker" ).each(function () {
        var min_date = jQuery( this ).attr('min-date');
        var max_date = jQuery( this ).attr('max-date');
        var format   = jQuery( this ).attr('format');
        if(min_date!='' && max_date!='' ){
            jQuery( this ).datepicker({ minDate: new Date(min_date) , maxDate:  new Date(max_date) , dateFormat: format});
        } else if(min_date!='' && max_date==''){
            jQuery( this ).datepicker({ minDate: new Date(min_date) , dateFormat: format});
        } else if(min_date=='' && max_date!=''){
            jQuery( this ).datepicker({ maxDate:  new Date(max_date) , dateFormat: format});
        } else{
            jQuery(this).datepicker({ dateFormat: format});
        }
    })


    /* text and textarea length limit */
    jQuery('.gdfrm-form-field.gdfrm-text input,.gdfrm-form-field.gdfrm-password input,.gdfrm-form-field.gdfrm-textarea textarea').on('keydown',function (e) {
        if(!jQuery(this).is('[readonly]')  && jQuery(this).attr('limit')!='' ){
            jQuery(this).next('.limit-text').show();
            var limit = parseInt(jQuery(this).attr('limit'));
            var limitType = jQuery(this).attr('limitType');

            if(limit>0){
                if(limitType=='char'){
                    if(jQuery(this).val().length == limit && e.keyCode!='8'){
                        e.preventDefault();
                    } else{
                        if(e.keyCode=='8'){
                            jQuery(this).next('.limit-text').find('.left').text((jQuery(this).val().length == 0) ? limit-jQuery(this).val().length : limit-jQuery(this).val().length + 1);
                        } else{
                            jQuery(this).next('.limit-text').find('.left').text(limit-jQuery(this).val().length-1);
                        }
                    }
                } else if(limitType=='word'){
                    var words = jQuery(this).val().split(' ');
                    if(words.length == limit+1){
                        if(e.keyCode!== 8){
                            e.preventDefault();
                        }
                    } else{
                        jQuery(this).next('.limit-text').find('.left').text((e.keyCode === 8) ? limit-words.length + 1 : limit-words.length);
                    }
                }
            }
        }
    });

    /* password view toggle */
    jQuery('.gdfrm-password-block').on('click','.gdfrm-view-password',function () {
        passwordField = jQuery(this).closest('.gdfrm-password-block').find('input');
        if(passwordField.attr('type') == 'password') {
            passwordField.attr('type','text') ;
        }
        else {
            passwordField.attr('type','password') ;
        }
    })

})

/* initialize google map */
function gdfrm_initMap() {
    jQuery('.gdfrm-map-block').each(function () {
        var map_lat = jQuery(this).attr('center_lat');
        var map_lng = jQuery(this).attr('center_lng');
        var center = {lat: parseFloat(map_lat), lng: parseFloat(map_lng)};
        var id = jQuery(this).attr('id');
        var draggable = jQuery(this).attr('draggable');

        var map = new google.maps.Map(document.getElementById(id), {
            zoom: 8,
            center: center,
            draggable: draggable
        });

        var marker = new google.maps.Marker({
            position: center,
            map: map
        });
    })

}

function myForm(form_id){
    var _this = this;

    _this.init = function(){
        _this.form = jQuery('#'+form_id);
        _this.form_id = form_id;
        _this.sitekey = jQuery('#'+form_id+'-recaptcha').attr('sitekey');
        _this.theme = jQuery('#'+form_id+'-recaptcha').attr('theme');
        _this.recaptchaWidgetId = '';
        if(jQuery('#'+form_id+'-recaptcha').is('div')){
            _this.recaptchaType = 'regular';
        } else {
            _this.recaptchaType = 'hidden';
        }

        if(typeof grecaptcha === 'undefined' || typeof grecaptcha.render !== 'function'){
            setTimeout(function(){
                _this.init();
            },100);
        }else{
            _this.initRecaptcha();
        }
    };


    _this.onSubmit = function(){
        _this.form.submit();
        return false;

    };

    _this.initRecaptcha = function(){
        if(_this.recaptchaType=='regular'){
            _this.recaptchaWidgetId = grecaptcha.render(_this.form_id+'-recaptcha', {
                sitekey: _this.sitekey,
                theme: _this.theme
            })
        } else {
            _this.recaptchaWidgetId = grecaptcha.render(_this.form_id+'-recaptcha', {
                sitekey: _this.sitekey,
                callback: _this.onSubmit
            })
        }

    };

    _this.init();

}
jQuery('.gdfrm-form').each(function(){
    var _el = jQuery(this);
    setTimeout(function(){
        myForm(_el.attr('id'));
    },0);
});


/* refresh simple captcha */
function gdfrm_refresh_captcha(e) {
    e.preventDefault();
    captchaid = jQuery(this).attr('captchaid');
    captchacontainer=jQuery(this).closest('.gdfrm-captcha-box');
    img = captchacontainer.find('img').eq(0);

    user='user';
    var general_data = {
        action: "gdfrm_refresh_simple_captcha",
        captchaid: captchaid
    };

    jQuery.post(ajaxurl, general_data, function (response) {
        if (response) {
            console.log(response);
            img.remove();

            newimg='<img src="'+response.url+'">';

            captchacontainer.find('input[name=captcha-id]').val(response.id);

            jQuery(newimg).prependTo(captchacontainer);

        } else {
            alert('not done');
        }
    }, "json");
}

/* upload file */
var inputs = document.querySelectorAll( '.gdfrm-inputfile' );
Array.prototype.forEach.call( inputs, function( input )
{
    var filenames	 = input.nextElementSibling;

    input.addEventListener( 'change', function( e )
    {
        var fileName = '';
        if( this.files && this.files.length > 0 ){
            var file_list = this.files;
            jQuery.each(file_list,function(idx,elm){
                console.log(elm);
                fileName += '<div class="single-file"><i class="gdfrm-icon gdfrm-file"></i><span>'+elm.name+'</span></div>';
            });


        }

        if( fileName )
            filenames.innerHTML = fileName;
    });
});


/* phone,text mask */
jQuery('.masked').each(function () {
    var maskpattern = jQuery(this).attr('data-pattern');
    jQuery(this).mask( maskpattern );

    jQuery(this).on("blur", function() {
        var last = jQuery(this).val().substr( jQuery(this).val().indexOf("-") + 1 );

        if( last.length == 3 ) {
            var move = jQuery(this).val().substr( jQuery(this).val().indexOf("-") - 1, 1 );
            var lastfour = move + last;

            var first = jQuery(this).val().substr( 0, 9 );

            jQuery(this).val( first + '-' + lastfour );
        }
    });
})

/* select2 dropdowns */

jQuery(".select2").each(function () {
    var search_on = jQuery(this).attr('search');
    var placeholder = 'Select';

    if(jQuery(this).hasClass('select-country')) placeholder = "Select Country";

    if(search_on && search_on!=0){
        jQuery(this).select2({
            placeholder: placeholder,
        });
    } else {
        jQuery(this).select2({
            placeholder: placeholder,
            minimumResultsForSearch: -1
        });
    }
});

/* refresh simple captcha on refresh button click */
jQuery('.gdfrm-captcha-box>a').click(gdfrm_refresh_captcha);



