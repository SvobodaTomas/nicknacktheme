// otherProductAdding
// - this variable tell us that we went through first inquiry form and we are going to add new product
// productUpdating
// - this variable tell us that we are currently updating already defined product (so fields have to be preselecte depending on that definition)
var otherProductAdding = productUpdating = productUpdatingTableRow = checkingFileUpload = false,
    currentUploadedFiles = [];
var f1 = formObject.f1,
    f2 = formObject.f2,
    f1s = formObject.f1s,
    f2s = formObject.f2s;

// One product default state object
var currentProductState_default = {
    productType : {
        type : null,
        text : ''
    },
    cupColorVersion : null,
    productVolume : {
        volume : null,
        text : ''
    },
    hotcupCap : null,
    // productMotive : {
    //     amount : null,
    // },
    productVariant : {
        variant : null,
        text : ''
    },
    product : {
        product : null,
        text : ''
    },
    subproduct : {
        product : null,
        text : ''
    },
};

// currentProductState = Object.assign({}, currentProductState_default);
currentProductState = cloneDeep(currentProductState_default);

(function($) { // Add java script to footer so all Foundation scripts will work - @since WP-Forge 5.5.0.1

    jQuery(document).foundation()

        // Joyride
        .foundation('joyride', 'start');

    // Add button class to all submit buttons
    jQuery('input[type="submit"]').addClass('tiny radius button');

    // Adds flex video to embeded video: http://foundation.zurb.com/docs/components/flex-video.html
    jQuery('iframe[src*="vimeo.com"]').wrap('<div class="flex-video widescreen vimeo" />');
    jQuery('iframe[src*="dailymotion.com"]').wrap('<div class="flex-video widescreen" />');
    jQuery('iframe[src*="youtube.com"]').wrap('<div class="flex-video widescreen" />');

    // BackToTop Button: Controls the fade in of the BacktoTop Button
    jQuery(window).load(function() {
        jQuery("#topofpage").hide().removeAttr("href");
        if (jQuery(window).scrollTop() != "0")
            jQuery("#backtotop").fadeIn("slow")
        var scrollDiv = jQuery("#backtotop");
        jQuery(window).scroll(function(){
            if (jQuery(window).scrollTop() == "0")
                jQuery(scrollDiv).fadeOut("slow")
            else
                jQuery(scrollDiv).fadeIn("slow")
        });
    });
    // BacktoTop
    jQuery('#backtotop').click(function(){
        jQuery('html, body').animate({
        scrollTop: jQuery('body').offset().top
        }, 1000); // Change this value to control the speed of the scroll back to the top of the page.
    });

    // Toggle class for selected color
    jQuery('label .color').click(function(){
        jQuery(this).toggleClass('color-checked');

        var cup_amount = parseInt(jQuery('.cup-volume-row div').attr('cup-amount'));

        if(jQuery(this).hasClass('color-checked')) {
            jQuery('.cup-volume-row div').attr('cup-amount', cup_amount+1);
        } else {
            jQuery('.cup-volume-row div').attr('cup-amount', cup_amount-1);
        }
    });

    // Toggle showing all steps for color cups
    jQuery('.show-all-steps').click(function(e){
        e.preventDefault();

        jQuery(this).closest('li').siblings('li').find('.show-step').fadeToggle().toggleClass('step-hided');
        jQuery(this).closest('li').siblings('li.show-step').fadeToggle().toggleClass('step-hided');
    });

    // Toggle popup size class (foundation reveal-modal) on window resize
    jQuery(window).resize(function() {
        if( jQuery(window).width()<=934 ) {
            jQuery('.product-form-modal.reveal-modal').removeClass('large').addClass('full');
        } else {
            jQuery('.product-form-modal.reveal-modal').removeClass('full').addClass('large');
        }
    });
    // Set popup size class (foundation reveal-modal) when page loads
    var window_width = jQuery(window).width();
    if( window_width<=934 ) {
        jQuery('.product-form-modal.reveal-modal').removeClass('large').addClass('full');
    } else {
        jQuery('.product-form-modal.reveal-modal').removeClass('full').addClass('large');
    }

    // Add spinner on form submit
    $('form.product-form input[type="submit"]').click(function() {
        // Hide submit button, insert copy of it and disable this copy + change button text
        var submit_copy = $(this).clone();
        $(this).css({'opacity':'0','position':'absolute'});
        submit_copy.prop('id', '').prop({'disabled':true,'value':foundation_strings.processing}).insertAfter($(this));
        // Add spinner
        $(this).after('<div class="gform-spinner"><div class="bounce1"></div><div class="bounce2"></div><div class="bounce3"></div></div>');
        // Disable text inputs
        $(this).closest('form.product-form').find('input[type="text"], textarea.textarea').prop('readonly',true);
    });

    // Proper reveal-modal position
    $(document).on('opened.fndtn.reveal', '[data-reveal]', function () {
        if($(this).attr('id') != 'inquiryForm' && $(this).attr('id') != 'inquiryFormNew') {
            // Get modal
            var $modal = $(this);
            // Add special class
            $modal.addClass('properposition');

            // Get viewport position
            var window_top_position = $(window).scrollTop();

            // Move modal
            $('.reveal-modal.properposition').css({'top':window_top_position+'px'});
        }

        $('.off-canvas-wrap').addClass('element--blurred');
    });

    $(document).on('closed.fndtn.reveal', '[data-reveal]', function () {
        $('.off-canvas-wrap').removeClass('element--blurred');
    });

    // end loading all functions

    $(function(){
        $(".accordion").on("click", ".accordion-navigation:not(.active)", function (event) {
            $(".accordion-navigation.active").removeClass('active').find(".content").slideUp("fast");
            $(this).addClass('active').find(".content").slideToggle("fast");
        });
    });
    $(function(){
        $(".accordion").on("click", ".accordion-navigation.active", function (event) {
            $(this).removeClass('active').find(".content").slideUp("fast");
        });
    });

    /* NEW FORMS ------------------ */

    // Disable choices if bad cup volume selected
    $(document).on('gform_page_loaded', function(event, form_id, current_page){

        if(form_id == f1) {

            console.log('-------------PAGE CHANGE ('+current_page+')-------------');

            colorVersionChangeBinding(current_page);

            // TODO: move to colorBinding?
            // Color fields
            showHideColorSelectionFields(current_page);

            // Validation styling
            stylePageValidationMessage(f1s,current_page);

            // Observers
            var observer,           // Observer for watching when new files uploaded
                obderver_exceed;    // Observer for watching when uploaded file exceeds file size

            // Replace number field format when page loads (from e.g. 10,000 to 10000)
            $('#gform_page_'+f1s+'_'+current_page+' .ginput_container_number input').each(function() {
                $(this).val($(this).val().replace(/,/g,""));
                $(this).attr('autocomplete','off');
            });

            // Check color inputs
            colorBinding(current_page);

            // Check volume inputs
            productVolumeBinding(current_page);

            // Check variant inputs
            productVariantBinding(current_page);

            // Check product
            productBinding(current_page);

            // Check subproduct
            subproductBinding(current_page);

            // Cup volume check
            // @important: needs to be after productBinding(),
            // because of case when volume is different from 0.5 or 0.3 of Nicknuck cup
            cupAmountControl();

            // Check files upload inputs
            productFilesBinding(current_page);

            // First page
            if(current_page==1) {

                // Check whether we are adding other item or updating
                if(otherProductAdding || productUpdating) {

                    $('#gform_'+f2s).fadeOut();

                    $('.form-add-product').html('<span class="add-product-plus">&#x271A;</span> '+foundation_strings.add_product);

                    otherProductAdding = false;
                }

                console.log('productUpdating',productUpdating);

                // Bind product change
                productTypeChangeBinding(current_page);

            } else if(current_page==5) {    // Hotcup colors

                // Highlight the selected colors and disable the non-checked
                highlightSelectedColors(current_page,'82');

            } else if(current_page==6) {    // Hotcup basic

                // Highlight the selected colors and disable the non-checked
                highlightSelectedColors(current_page,'83');

                // TODO: current page update
                // Change next button text
                // fileUploadCheck();

            } else if(current_page==11) {   // NickNack

                // Highlight the selected colors and disable the non-checked
                highlightSelectedColors(current_page,'47');

                // Validation styling
                // stylePageValidationMessage(f1s,current_page);

            } else if(current_page==14) {   // Hotcup Cap

                // Highlight the selected colors and disable the non-checked
                highlightSelectedColors(current_page,'99');

            // Last page
            } else if(current_page==jQuery('#gform_'+f1s+' .gform_page').length) {
                // Its a last page

                // Reset first form
                $('.form-add-product.store-current-product').on('click', function(e) {
                    e.preventDefault();

                    getFormData();

                    addOtherProduct($(this)[0]);
                });

                // Finish product specification
                $('#go-to-contact-form').on('click', function(e) {
                    e.preventDefault();

                    getFormData();

                    if(productUpdating) {
                        var updatedFiles = productUpdating[8],
                            definedFiles = $('#fileupload-summary').val();

                        if(typeof definedFiles !== 'undefined' && definedFiles != '') {
                            definedFiles = JSON.parse(definedFiles);
                            definedFiles.push(updatedFiles);
                        } else {
                            definedFiles = [];
                        }

                        $('#fileupload-summary').val(JSON.stringify(definedFiles));

                        // Reset variable for new updated product
                        productUpdating = false;

                    } else {

                        var definedFiles = $('#fileupload-summary').val();
                        if(typeof definedFiles !== 'undefined' && definedFiles != '') {
                            definedFiles = JSON.parse(definedFiles);
                        } else {
                            definedFiles = [];
                        }

                        definedFiles.push(currentUploadedFiles);
                        $('#fileupload-summary').val(JSON.stringify(definedFiles));

                        // Reset variable for new product
                        currentUploadedFiles = [];
                    }

                    // Reset color control value
                    jQuery('#input_'+f1s+'_47').val('');

                    // Hide this form witch product specification
                    $('#gform_'+f1s).hide();

                    // Show form with contact fields
                    $('#gform_'+f2s).show();
                    $('#input_'+f2s+'_3').focus();
                });
            }

            fileUploadCheckNew(current_page);
        }
    });

    // Hide second form, show after "No" clicked on the end of the first form
    $('#gform_'+f2s).hide();

    $(document).ready(function(){
        // Form sent successfully - there is a confirmation
        if($(".form-product-definition-contact").hasClass('gform_confirmation_wrapper')){
            // Hide the f1
            $('#gform_'+f1s).hide();
            $('#gform_'+f2s).show();
        }
        // Form sent with errors - there is a validation error
        if($(".form-product-definition-contact_wrapper").hasClass('gform_validation_error')){

            // Load stored products into form summary
            setSummaryData($('#input_'+f2s+'_8').val());

            // Show the f2
            $('#gform_'+f1s).hide();
            $('#gform_'+f2s).show();
            $('#gform_submit_button_'+f2s).show();

            // TODO: validace, zda není prázdný input (který?)
        }
        $('.form-add-product').on('click', function(e) {
            e.preventDefault();
        });

        if($('#gform_preview_'+f2s+'_12').html() == '' && $('.uploads-summary .field-missing').length <= 0) {
            $('.uploads-summary .gfield_label').after('<span class="field-missing">- '+formObject.fieldMissing+' -</span>');
        }

        $('.form-product-definition-contact_wrapper input').each(function() {
            $(this).attr('autocomplete','off');
        });

        // Change new form heading on confirmation
        if ($('.gform_confirmation_wrapper.form-product-definition-contact').length > 0) {
            $('#inquiryForm .form-header').text(formObject.formHeaderConfirmation);

            // Reload when closing the form
            $('#inquiryForm .close-product-reveal-modal, .reveal-modal-bg').on('click', function(){
                location.href = location.href;
            });
        }

        // Binding on dom ready cause this is the first form page
        productTypeChangeBinding();
    });

    $(window).on('load resize', function() {
        checkFormSummaryScrollable();
    });

    function productTypeChangeBinding(pageNumber) {

        if (!pageNumber) {
            pageNumber = 1;
        }

        // Product type change binging
        if ( $('#gform_page_'+f1s+'_'+pageNumber+' .product-selection').length > 0 ) {
            console.log('product-selection found');

            $('#gform_page_'+f1s+'_'+pageNumber+' .product-selection .gfield_radio').on('change', function(e) {
                var selectedValue = $(this).find('input[type="radio"]:checked').val();
                console.log('selected product type',selectedValue);

                currentProductState.productType.type = selectedValue;

                if ( selectedValue=='hotcup' ) {
                    // Product is set later, in productBinding() - for setting the color version (color/basic)
                    // currentProductState.product.product = 'hotcup';
                    currentProductState.product.text = 'HOT CUP';
                }

                // We changed product type, so our prepared values in productUpdating are now irrelevant
                // TODO: in the future, be ready on double change (product type is accidentaly changed, so we get back = 2 changes were made, but the product is the same)
                // TODO: making problem
                // if (selectedValue!==productUpdating[0]) {
                //     productUpdating = false;
                // }
            });

            // Updating? -> prepare selected values
            if(productUpdating) {
                var selectedProductType = productUpdating[0];
                console.log('<updating> - product type:',selectedProductType);

                $('#gform_page_'+f1s+'_'+pageNumber+' .product-selection input[value="'+selectedProductType+'"]').trigger('click');
            }
        }
    }

    // Highlight the selected colors and disable the non-checked
    // Also add or remove the field id from hidden check amount field
    function highlightSelectedColors(pageNumber,fieldCheckAmountId) {
        console.log('---highlightSelectedColors]');

        $('#gform_page_'+f1s+'_'+pageNumber+' .cup-color-sample-wrapper').each(function() {
            var $this = $(this),
                $input = $this.find('input');

            // Highlight all related color fields
            if($this.hasClass('gfield_error') || $input.val()!='') {
                $this.addClass('color-selected');

                // Control value
                $('#input_'+f1s+'_'+fieldCheckAmountId).addId($input.attr('id'));
            } else {
                // Control value
                $('#input_'+f1s+'_'+fieldCheckAmountId).removeId($input.attr('id'));
            }
        });
    }

    // This function sets proper amount inputs placeholder or error messages
    function cupAmountControl() {
        console.log('---cupAmountControl]');

        if (currentProductState.productType.type=='nicknack') {

            var selectedVolume = $('.gform_wrapper .volume-selection .gfield_radio input[type="radio"]:checked').val(),
                message = '<div class="bad-cup-volume">('+formObject.badCupVolume+')</div>';

            // Exceptions (colored cup and sada are just in 0.5 & 0.3 volume)
            // so if other volume selected, disable these two products
            // otherwise be sure, they are enabled
            if(selectedVolume!=0.5 && selectedVolume!=0.3) {

                // 1) Bez potisku

                // Bez potisku barevny kelimek
                // - disable this item
                $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="barevny"]').attr('disabled','disabled');
                $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="barevny"]+label').after(message);

                // Bez potisku party sada
                // - disable this item
                $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="sada"]').attr('disabled','disabled');
                $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="sada"]+label').after(message);

                // Preselect ok product
                $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value!="sada"]').trigger('click');


                // 2) S potiskem

                // S potiskem barevny kelimek
                // - disable this item
                $('.gform_wrapper .potisk-cup-selection input[type="radio"][value="barevny-kelimek"]').attr('disabled','disabled');
                $('.gform_wrapper .potisk-cup-selection input[type="radio"][value="barevny-kelimek"]+label').after(message);

                // Preselect ok product
                $('.gform_wrapper .potisk-cup-selection input[type="radio"][value="transparentni-kelimek"]').trigger('click');

            } else {
                // Bez potisku barevny kelimek
                $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="barevny"]').removeAttr('disabled');

                // Remove message
                $('.gform_wrapper .bad-cup-volume').remove();
            }

            // Amount placeholder
            var amountPlaceholder = amountDescText = '',
                amountText = formObject.amountText;

            if($('.variant-selection .gfield_radio input:checked').val()=='potisk') {    // Potisk
            // if($('#choice_'+f1s+'_3_0').is(':checked')) {    // Potisk
                if($('.potisk-product-selection .gfield_radio input:checked').val()=='iml') {  // IML
                // if($('#choice_'+f1s+'_5_0').is(':checked')) {  // IML
                    amountPlaceholder = formObject.min1000;
                } else if($('.potisk-product-selection .gfield_radio input:checked').val()=='sitotisk') {  // Sitotisk
                // } else if($('#choice_'+f1s+'_5_1').is(':checked')) {  // Sitotisk
                    amountPlaceholder = formObject.min250;
                }
            } else if($('.variant-selection .gfield_radio input:checked').val()=='bez-potisku') { // Bez potisku
            // } else if($('#choice_'+f1s+'_3_1').is(':checked')) { // Bez potisku
                console.log('-- Bez potisku');
                if($('.bez-potisku-product-selection .gfield_radio input:checked').val()=='barevny' || $('.bez-potisku-product-selection .gfield_radio input:checked').val()=='univerzalni') {  // Barevny nebo univerzalni
                // if($('#choice_'+f1s+'_6_0').is(':checked') || $('#choice_'+f1s+'_6_1').is(':checked')) {  // Barevny nebo univerzalni
                    amountPlaceholder = formObject.min100;
                } else {    // Party sada
                    console.log('-- Sada');
                    amountText = formObject.amountTextSada;
                    amountDescText = formObject.sadaPack;
                }
            }
            $('.custom-cup-amount input').attr('placeholder',amountPlaceholder);
            // $('#input_'+f1s+'_10').attr('placeholder',amountPlaceholder);
            $('.cup-color-sample-wrapper input').attr('placeholder',amountPlaceholder);
            $('.custom-cup-amount label').text(amountText);
            // $('#field_'+f1s+'_10 label').text(amountText);
            $('.custom-cup-amount .gfield_description:not(.validation_message)').text(amountDescText);
            // $('#field_'+f1s+'_10 .gfield_description:not(.validation_message').text(amountDescText);

            // Motive placeholder
            var motivePlaceholder = motiveText = motiveDescText = '';
            if($('.variant-selection .gfield_radio input:checked').val()=='potisk') {    // Potisk
            // if($('#choice_'+f1s+'_3_0').is(':checked')) {    // Potisk
                if($('.potisk-product-selection .gfield_radio input:checked').val()=='iml') {  // IML
                // if($('#choice_'+f1s+'_5_0').is(':checked')) {  // IML
                    motiveText = formObject.motiveAmount;
                    motiveDescText = formObject.motiveMin;
                } else if($('.potisk-product-selection .gfield_radio input:checked').val()=='sitotisk') {  // Sitotisk
                // } else if($('#choice_'+f1s+'_5_1').is(':checked')) {  // Sitotisk
                    motiveText = formObject.motiveColorsAmount;
                }
            }
            $('#input_'+f1s+'_11').attr('placeholder',motivePlaceholder);
            $('#field_'+f1s+'_11 label').text(motiveText);
            $('#field_'+f1s+'_11 .gfield_description:not(.validation_message)').text(motiveDescText);

            // amount = amount_text = $('#input_'+f1s+'_10').val().replace(/,/g,"");
            // if(variant=='potisk') {
            //     motive = motive_text = $('#input_'+f1s+'_11').val().replace(/,/g,"");
            // }

        } else if (currentProductState.productType.type=='hotcup') {
            console.log('> hotcup selected');

            // Amount placeholder
            var amountPlaceholder = amountDescText = '',
                amountText = formObject.amountText;

            if($('.variant-hotcup-selection .gfield_radio input:checked').val()=='potisk') {    // Potisk
            // if($('#choice_'+f1s+'_3_0').is(':checked')) {    // Potisk
                amountPlaceholder = formObject.min250;
                console.log('> potisk');
            } else if($('.variant-hotcup-selection .gfield_radio input:checked').val()=='bez-potisku') { // Bez potisku
            // } else if($('#choice_'+f1s+'_3_1').is(':checked')) { // Bez potisku
                amountPlaceholder = formObject.min100;
                console.log('> bez potisku');
            }
            $('.custom-cup-amount input').attr('placeholder',amountPlaceholder);
            // $('#input_'+f1s+'_10').attr('placeholder',amountPlaceholder);
            $('.cup-color-sample-wrapper input').attr('placeholder',amountPlaceholder);
            $('.custom-cup-amount label').text(amountText);
            // $('#field_'+f1s+'_10 label').text(amountText);
            $('.custom-cup-amount .gfield_description:not(.validation_message)').text(amountDescText);
            // $('#field_'+f1s+'_10 .gfield_description:not(.validation_message').text(amountDescText);

            // Motive placeholder
            var motivePlaceholder = motiveText = motiveDescText = '';
            if($('.variant-hotcup-selection .gfield_radio input:checked').val()=='potisk') {    // Potisk
            // if($('#choice_'+f1s+'_3_0').is(':checked')) {    // Potisk
                motiveText = formObject.motiveColorsAmount;
            }
            if(($('.variant-hotcup-selection .gfield_radio input:checked').val()=='potisk' && $('.hotcup-color-version-print .gfield_radio input:checked').val()=='zakladni') /*|| ($('.variant-hotcup-selection .gfield_radio input:checked').val()=='bez-potisku' && $('.hotcup-color-version-print .gfield_radio input:checked').val()=='zakladni')*/) {    // Potisk + zakladni OR nepotisk + zakladni
                $('#input_'+f1s+'_89').attr('placeholder',motivePlaceholder);
                $('#field_'+f1s+'_89 label').text(motiveText);
                $('#field_'+f1s+'_89 .gfield_description:not(.validation_message)').text(motiveDescText);
            } else if(($('.variant-hotcup-selection .gfield_radio input:checked').val()=='potisk' && $('.hotcup-color-version-print .gfield_radio input:checked').val()=='barevny') /*|| ($('.variant-hotcup-selection .gfield_radio input:checked').val()=='bez-potisku' && $('.hotcup-color-version-print .gfield_radio input:checked').val()=='barevny')*/) { // Potisk + barevny OR nepotisk + barevny
                $('#input_'+f1s+'_88').attr('placeholder',motivePlaceholder);
                $('#field_'+f1s+'_88 label').text(motiveText);
                $('#field_'+f1s+'_88 .gfield_description:not(.validation_message)').text(motiveDescText);
            }
        }
    }

    // Checks page class, and binds cup product change
    // (in case of hotcup is product set sooner productTypeChangeBinding())
    // stores in current product state
    // (ready for any page of the form)
    function productBinding(pageNumber) {

        // Is there a Nicknack cup product?

        // NICKNACK
        if ( currentProductState.productType.type=='nicknack' ) {
            console.log('---productBinding] - Product: product bind check. Page number:',pageNumber,'(NICKNACK)');

            if ( currentProductState.productVariant.variant=='potisk' && $('#gform_page_'+f1s+'_'+pageNumber+' .potisk-product-selection').length>0 ) {
                console.log('Product: print product page');

                $('#gform_page_'+f1s+'_'+pageNumber+' .potisk-product-selection .gfield_radio').on('change',function(){
                    console.log('iml vs sitotisk changed!');
                    currentProductState.product.product = $(this).find('input:checked').val();
                    currentProductState.product.text = $(this).find('input:checked + label').html().replace(/<p>.*<\/p>/g,"");
                });

                // Updating? -> prepare selected values
                if(productUpdating) {
                    let selectedProduct = productUpdating[3];
                    console.log('<updating> - product',selectedProduct);

                    $('#gform_page_'+f1s+'_'+pageNumber+' .potisk-product-selection input[value="'+selectedProduct+'"]').trigger('click');
                }

            } else if ( currentProductState.productVariant.variant=='bez-potisku' && $('#gform_page_'+f1s+'_'+pageNumber+' .bez-potisku-product-selection').length>0 ) {
                console.log('Product: no print product page');

                $('#gform_page_'+f1s+'_'+pageNumber+' .bez-potisku-product-selection .gfield_radio').on('change',function(){
                    console.log('iml vs sitotisk changed!');
                    currentProductState.product.product = $(this).find('input:checked').val();
                    currentProductState.product.text = $(this).find('input:checked + label').html().replace(/<p>.*<\/p>/g,"");
                });

                // Updating? -> prepare selected values
                if(productUpdating) {
                    let selectedProduct = productUpdating[3];
                    console.log('<updating> - product',selectedProduct);

                    $('#gform_page_'+f1s+'_'+pageNumber+' .bez-potisku-product-selection input[value="'+selectedProduct+'"]').trigger('click');
                }
            }

        // HOTCUP
        } else if ( currentProductState.productType.type=='hotcup' ) {
            console.log('---productBinding] - Product: product bind check. Page number:',pageNumber,'(HOTCUP)');

            // S potiskem
            if ( currentProductState.productVariant.variant=='potisk' && $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-version-print').length>0 ) {
                console.log('Hotcup print, basic vs colored');

                $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-version-print .gfield_radio').on('change',function(){
                    console.log('Hotcup print basic vs colored changed!');
                    currentProductState.product.product = $(this).find('input:checked').val();
                    // Text is set sooner, in productTypeChangeBinding()
                    // currentProductState.product.text = $(this).find('input:checked + label').html().replace(/<p>.*<\/p>/g,"");
                });

                // Updating? -> prepare selected values
                if(productUpdating) {
                    let selectedColorVersion = productUpdating[3];
                    console.log('<updating> - print hotcup',selectedColorVersion);

                    $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-version-print input[value="'+selectedColorVersion+'"]').trigger('click');
                }

            // Bez potisku
            } else if ( currentProductState.productVariant.variant=='bez-potisku' && $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-version-noprint').length>0 ) {
                console.log('Hotcup noprint, basic vs colored');

                $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-version-noprint .gfield_radio').on('change',function(){
                    console.log('Hotcup noprint basic vs colored changed!');
                    currentProductState.product.product = $(this).find('input:checked').val();
                    // Text is set sooner, in productTypeChangeBinding()
                    // currentProductState.product.text = $(this).find('input:checked + label').html().replace(/<p>.*<\/p>/g,"");
                });

                // Updating? -> prepare selected values
                if(productUpdating) {
                    let selectedColorVersion = productUpdating[3];
                    console.log('<updating> - noprint hotcup',selectedColorVersion);

                    $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-version-noprint input[value="'+selectedColorVersion+'"]').trigger('click');
                }
            }
        }
    }

    // Checks page class, and binds cup subproduct change
    // stores in current product state
    // (ready for any page of the form)
    function subproductBinding(pageNumber) {

        // Is there a Nicknack cup product?

        if ( currentProductState.productType.type=='nicknack' ) {
            console.log('---subproductBinding] - Subproduct: subproduct bind check. Page number:',pageNumber,'(NICKNACK)');

            if ( currentProductState.productVariant.variant=='potisk' && $('#gform_page_'+f1s+'_'+pageNumber+' .potisk-cup-selection').length>0 ) {
                console.log('Subproduct: print subproduct page');

                $('#gform_page_'+f1s+'_'+pageNumber+' .potisk-cup-selection .gfield_radio').on('change',function(){
                    console.log('print transparent vs colored changed!');
                    currentProductState.subproduct.product = $(this).find('input:checked').val();
                    currentProductState.subproduct.text = $(this).find('input:checked + label').html().replace(/<p>.*<\/p>/g,"");
                });

                // Updating? -> prepare selected values
                if(productUpdating) {
                    let selectedSubproduct = productUpdating[4];
                    console.log('<updating> - print subproduct',selectedSubproduct);

                    $('#gform_page_'+f1s+'_'+pageNumber+' .potisk-cup-selection input[value="'+selectedSubproduct+'"]').trigger('click');
                }
            }

        }

        // TODO: product updating for hotcup? (hotcup doesnt have a subproduct)
    }

    // Checks page class, and binds cup/hotcup variant change
    // stores in current product state
    // (ready for any page of the form)
    function productVariantBinding(pageNumber) {
        console.log('---productVariantBinding] - Variant: cup variant bind check. Page number:',pageNumber);

        // Is there Cup or hotcup variant?

        if ( $('#gform_page_'+f1s+'_'+pageNumber+' .variant-selection').length>0 ) {
            console.log('Variant: cup variant page');

            $('#gform_page_'+f1s+'_'+pageNumber+' .variant-selection .gfield_radio').on('change',function(){
                console.log('cup variant changed!');
                currentProductState.productVariant.variant = $(this).find('input:checked').val();
                currentProductState.productVariant.text = $(this).find('input:checked + label').text();
            });

            // Updating? -> prepare selected values
            if(productUpdating) {
                var selectedProductVariant = productUpdating[2];
                console.log('<updating> - variant:',selectedProductVariant);

                $('#gform_page_'+f1s+'_'+pageNumber+' .variant-selection input[value="'+selectedProductVariant+'"]').trigger('click');
            }

        } else if ( $('#gform_page_'+f1s+'_'+pageNumber+' .variant-hotcup-selection').length>0 ) {
            console.log('Variant: hotcup variant page');

            $('#gform_page_'+f1s+'_'+pageNumber+' .variant-hotcup-selection .gfield_radio').on('change',function(){
                console.log('hotcup variant changed!');
                currentProductState.productVariant.variant = $(this).find('input:checked').val();
                currentProductState.productVariant.text = $(this).find('input:checked + label').text();
            });

            // Updating? -> prepare selected values
            if(productUpdating) {
                var selectedProductVariant = productUpdating[2];
                console.log('<updating> - variant hotcup:',selectedProductVariant);

                $('#gform_page_'+f1s+'_'+pageNumber+' .variant-hotcup-selection input[value="'+selectedProductVariant+'"]').trigger('click');
            }
        }
    }

    // Checks page class, and binds cup/hotcup volume change
    // stores in current product state
    // (ready for any page of the form)
    function productVolumeBinding(pageNumber) {
        console.log('---productVolumeBinding] - Volume: cup volume bind check. Page number:',pageNumber);

        // NickNack volume
        if ( $('#gform_page_'+f1s+'_'+pageNumber).hasClass('cup-volume-bind') ) {
            console.log('Volume: cup amount page',$('#gform_page_'+f1s+'_'+pageNumber+' .volume-hotcup-selection .gfield_radio'));

            // Binding the change
            $('#gform_page_'+f1s+'_'+pageNumber+' .volume-selection .gfield_radio').on('change',function(){
                console.log('Volume: cup volume changed!');
                currentProductState.productVolume.volume = $(this).find('input:checked').val();
                currentProductState.productVolume.text = $(this).find('input:checked + label').text();
            });

            // Updating? -> prepare selected values
            if(productUpdating) {
                var selectedProductVolume = productUpdating[1];
                console.log('<updating> - volume:',selectedProductVolume);

                $('#gform_page_'+f1s+'_'+pageNumber+' .volume-selection input[value="'+selectedProductVolume+'"]').trigger('click');
            }
        }

        // HotCup volume
        if ( $('#gform_page_'+f1s+'_'+pageNumber).hasClass('hotcup-volume-bind') ) {
            console.log('Volume: hotcup amount page',$('#gform_page_'+f1s+'_'+pageNumber+' .volume-hotcup-selection .gfield_radio'));

            // Binding the change
            $('#gform_page_'+f1s+'_'+pageNumber+' .volume-hotcup-selection .gfield_radio').on('change',function(){
                console.log('Volume: hotcup volume changed!');
                currentProductState.productVolume.volume = $(this).find('input:checked').val();
                currentProductState.productVolume.text = $(this).find('input:checked + label').text();
            });

            // Updating? -> prepare selected values
            if(productUpdating) {
                var selectedProductVolume = productUpdating[1];
                console.log('<updating> - volume hotcup:',selectedProductVolume);

                $('#gform_page_'+f1s+'_'+pageNumber+' .volume-hotcup-selection input[value="'+selectedProductVolume+'"]').trigger('click');
            }
        }
    }

    // Checking whether show color fields selection or final amount input
    // shows/hides colors input / final amount input
    // (ready for any page of the form)
    function showHideColorSelectionFields(pageNumber) {
        console.log('---showHideColorSelectionFields]');

        // Nicknack
        if ( $('#gform_page_'+f1s+'_'+pageNumber).hasClass('cup-amount-check') ) {

            // Color
            if(currentProductState.cupColorVersion=='color') {

                $('.cup-color-sample-wrapper').show();
                $('.custom-cup-amount').hide();

            // Transparent
            } else {

                $('.cup-color-sample-wrapper').hide();
                $('.custom-cup-amount').show();
            }
        }

        // Hotcup
        if ( $('#gform_page_'+f1s+'_'+pageNumber).hasClass('hotcup-amount-check') ) {

            $('.custom-cup-amount').hide();

            // Color
            if(currentProductState.cupColorVersion=='color') {

                $('.cup-color-sample-wrapper').show();
                $('.cup-color-sample-wrapper.basic').hide();

            // Basic
            } else {

                $('.cup-color-sample-wrapper').hide();
                $('.cup-color-sample-wrapper.basic').show();
            }
        }

        // Hotcup Cap
        if ( $('#gform_page_'+f1s+'_'+pageNumber).hasClass('hotcup-cap-amount-check') ) {

            $('.custom-cup-amount').hide();

            $('.cup-color-sample-wrapper').hide();
            $('.cup-color-sample-wrapper.cap').show();
        }
    }

    // This function checks, whether on current page is field for changing the color version
    // - NickNack: colored vs Transparent
    // - HotCup: colored vs basic
    // - HotCup Cap (no versions)
    // via class [ cup-color-check / hotcup-color-check / hotcup-cap-color-check ] on gravity forms field
    function colorVersionChangeBinding(pageNumber) {
        console.log('---colorVersionChangeBinding]');

        // Cup
        if ( $('#gform_page_'+f1s+'_'+pageNumber+' .cup-color-check').length > 0 ) {
            $('#gform_page_'+f1s+'_'+pageNumber+' .cup-color-check .gfield_radio').on('change', function(e) {
                var selectedValue = $(this).find('input[type="radio"]:checked').val();

                if(selectedValue=='barevny' || selectedValue=='barevny-kelimek') {
                    currentProductState.cupColorVersion = 'color';
                } else {
                    currentProductState.cupColorVersion = 'transparent';
                }
            });
        }

        // Hotcup
        if ( $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-check').length > 0 ) {
            $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-color-check .gfield_radio').on('change', function(e) {
                var $this = $(this),
                    selectedValue = $this.find('input[type="radio"]:checked').val();

                if(selectedValue=='barevny') {
                    currentProductState.cupColorVersion = 'color';
                } else {
                    currentProductState.cupColorVersion = 'basic';
                }
            });
        }

        // Hotcup cap
        if ( $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-cap-color-check').length > 0 ) {

            $('#gform_page_'+f1s+'_'+pageNumber+' .hotcup-cap-color-check .gfield_radio').on('change', function(e) {
                // var selectedValue = $(this).find('input[type="radio"]:checked').val();
                console.log('CAP VERSION CHANGED',$(this).find('input[type="radio"]:checked').val());

                currentProductState.hotcupCap = $(this).find('input[type="radio"]:checked').val();

                // if(selectedValue=='s-vickem') {
                //     currentProductState.hotcupCap = 'cap';
                // } else {
                //     currentProductState.hotcupCap = 'basic';
                // }
            });

            if ( productUpdating ) {
                console.log('Product updating on CAP, currently: ',currentProductState.hotcupCap);
                $('#gform_page_'+f1s+'_'+pageNumber).find('input[value="'+currentProductState.hotcupCap+'"]').trigger('click');
            }
        }
    }

    // Action when clicking cup color field
    // shows/hides number input for amount for this color
    // (ready for any page of the form)
    function colorBinding(pageNumber){

        // Try to find some color fields
        if ( $('#gform_page_'+f1s+'_'+pageNumber+' .cup-color-sample-wrapper').length > 0 ) {
            console.log('---colorBinding] - Some colors found');

            $('#gform_page_'+f1s+'_'+pageNumber+' .cup-color-sample-wrapper .cup-color-sample,#gform_page_'+f1s+'_'+pageNumber+' .cup-color-sample-wrapper .gfield_label').on('click', function(e) {
                var $gfield = $(this).closest('.gfield');
                console.log('state',currentProductState);

                if ($gfield.hasClass('color-selected')) {
                    console.log('UNchecking color');
                    // Unselect
                    $gfield.find('input').val(formObject.disVal);
                    $gfield.removeClass('color-selected');
                    $gfield.find('input').prop('disabled',true);

                    // Control value
                    if (currentProductState.productType.type=='nicknack') {
                        console.log('remove id (clicked)');
                        $('#input_'+f1s+'_47').removeId($gfield.find('input').attr('id'));
                    } else if (currentProductState.productType.type=='hotcup') {
                        console.log('remove id (clicked) (hotcup)');
                        if (currentProductState.cupColorVersion=='color') {
                            $('#input_'+f1s+'_82').removeId($gfield.find('input').attr('id'));
                        } else {
                            $('#input_'+f1s+'_83').removeId($gfield.find('input').attr('id'));
                        }
                    }

                } else {
                    console.log('checking color');
                    // Mark as selected
                    $gfield.addClass('color-selected');
                    $gfield.find('input').val('');
                    $gfield.find('input').focus();
                    $gfield.find('input').prop('disabled',false);

                    // Nicknack cup
                    if (currentProductState.productType.type=='nicknack') {
                        console.log('add id (clicked)');
                        $('#input_'+f1s+'_47').addId($gfield.find('input').attr('id'));

                    // Hotcup
                    } else if (currentProductState.productType.type=='hotcup') {
                        console.log('add id (clicked) (hotcup)');

                        // Hotcup cap
                        if ($('#gform_page_'+f1s+'_'+pageNumber).hasClass('hotcup-cap-amount-check')) {
                            console.log('is hotcup cap');

                            $('#input_'+f1s+'_99').addId($gfield.find('input').attr('id'));

                        // Hotcup
                        } else {
                            console.log('is hotcup cup');

                            if (currentProductState.cupColorVersion=='color') {
                                $('#input_'+f1s+'_82').addId($gfield.find('input').attr('id'));
                            } else {
                                $('#input_'+f1s+'_83').addId($gfield.find('input').attr('id'));
                            }
                        }
                    }
                }
            });

        } else {
            console.log('---colorBinding] - NO colors found');
        }

        if ( $('#gform_page_'+f1s+'_'+pageNumber).hasClass('page-amount-check') ) {

            // Updating -> prepare selected values
            if(productUpdating) {
                if(productUpdatingTableRow) {
                    productUpdatingTableRow.remove();
                    productUpdatingTableRow = false;
                }

                colors = colorsCap = amount = motive = "";

                // Setting the variables
                // colors - make array from string
                // amount + motive - set value and replace the comma (1,600 -> 1600)
                if(typeof productUpdating[5] !== 'undefined') {

                    if ( currentProductState.productType.type=='nicknack' ) {
                        colors = productUpdating[5]=="-" ? '' : productUpdating[5].replace("<br>","").split("€€");
                    } else {
                        // There may be multiple <br> so replace all accurrences
                        colors = productUpdating[5]=="-" ? '' : replaceAll(productUpdating[5],"<br>","");
                        if ( colors.indexOf("Víčka:")>=0 ) {
                            colorsSplit = colors.split("Víčka:");
                            colors = colorsSplit[0].split("€€");
                            colorsCap = colorsSplit[1].split("§§");
                            // currentProductState.hotcupCap = 's-vickem';
                        } else {
                            colors = colors.split("€€");
                            // currentProductState.hotcupCap = 'bez-vicka';
                        }
                    }
                }
                if(typeof productUpdating[6] !== 'undefined') {
                    amount = productUpdating[6]=='-' ? '' : productUpdating[6].replace(/,/g,"");
                }
                if(typeof productUpdating[7] !== 'undefined') {
                    motive = productUpdating[7]=='-' ? '' : productUpdating[7].replace(/,/g,"");
                }

                console.log('<updating> cup-amount-check page, colors',colors,'amount',amount,'motive',motive);

                let amountSelector_id = motiveSelector_id = controlSelector_id = '';

                if ( currentProductState.productType.type=='nicknack' ) {
                    amountSelector_id = '10';
                    motiveSelector_id = '11';
                    controlSelector_id = '47';
                } else {
                    if ( currentProductState.product.product=='zakladni' ) {
                        // amountSelector_id = '10';
                        motiveSelector_id = '89';
                        controlSelector_id = '83';
                    } else {
                        // amountSelector_id = '10';
                        motiveSelector_id = '88';
                        controlSelector_id = '82';
                    }
                }

                // Amount
                if (amountSelector_id!='') {
                    $('#input_'+f1s+'_10').val(amount);
                }

                // Motive
                $('#input_'+f1s+'_'+motiveSelector_id).val(motive);

                // Colors amount
                for (var i = 0; i < colors.length; i++) {
                    var color_pair = colors[i].split(':'),
                        cp_color = color_pair[0],
                        cp_colorAmount = color_pair[1];

                    $('#gform_page_'+f1s+'_'+pageNumber+' .cup-color-sample-wrapper').each(function() {
                        // Is this color selected?
                        if($(this).find('label').text()==cp_color) {
                            var $thisInput = $(this).find('input');
                            // Insert amount, that was set to this color
                            $thisInput.val(cp_colorAmount);

                            // Add this input into controlIds array
                            $('#input_'+f1s+'_'+controlSelector_id).addId($thisInput.attr('id'));

                            return false;
                        }
                    });
                }

                // Cap colors amount
                for (var i = 0; i < colorsCap.length; i++) {
                    var color_pair = colorsCap[i].split(':'),
                        cp_color = color_pair[0],
                        cp_colorAmount = color_pair[1];

                    console.log('cp_color',cp_color,'cp_colorAmount',cp_colorAmount);

                    $('#gform_page_'+f1s+'_'+pageNumber+'.hotcup-cap-amount-check .cup-color-sample-wrapper').each(function() {
                        // Is this color selected?
                        if($(this).find('label').text()==cp_color) {
                            console.log('Cap color found');
                            // $(this).trigger('click');
                            var $thisInput = $(this).find('input');
                            console.log('$thisInput',$thisInput);
                            // Insert amount, that was set to this color
                            $thisInput.val(cp_colorAmount);

                            // Add this input into controlIds array
                            $('#input_'+f1s+'_'+controlSelector_id).addId($thisInput.attr('id'));

                            return false;
                        }
                    });
                }
            }
        }
    }

    // This function checks, whether on current page is upload file button
    // if so, prevents default action and triggers clicking the right upload button in second (contact) form
    function productFilesBinding(pageNumber) {
        console.log('---productFilesBinding]');

        if ($('#gform_page_'+f1s+'_'+pageNumber+' #select-multiple-files').length>0) {

            // Trigger the right upload button when upload clicked
            $('#select-multiple-files').on('click', function(e){
                e.preventDefault();
                
                // Upload
                $('#gform_browse_button_'+f2s+'_12').trigger('click');
            });

            // Watching for new files
            var target = document.querySelector('#gform_preview_'+f2s+'_12');
            // Create an observer instance
            observer = new MutationObserver(function(mutations,observer) {
                
                // Check files only when nodes added (not when nodes removed)
                if(mutations[0].addedNodes.length > 0) {
                    var uploadedFiles = uploadedFiles_key = false;

                    // Get currently uploaded files
                    var uploadedFilesRaw = $('#gform_uploaded_files_'+f2s).val();
                    if(uploadedFilesRaw) {
                        uploadedFiles = JSON.parse(uploadedFilesRaw);
                        uploadedFiles_key = Object.keys(uploadedFiles)[0];
                    }
                    
                    if(!checkingFileUpload) {
                        var html = $('#select-multiple-files').html();
                        // Spinner
                        $('#select-multiple-files').html('<span class="gform_ajax_spinner uploading-files"></span>'+html);
                        checkFilesUploaded(pageNumber,uploadedFiles[uploadedFiles_key]);
                    }

                    // Remove text indication that no file uploaded
                    if($('#gform_preview_'+f2s+'_12').html() != '') {
                        $('.uploads-summary .field-missing').remove();
                    }
                }

                if(mutations[0].removedNodes.length > 0) {
                    // Show message that no file is uploaded
                    if($('#gform_preview_'+f2s+'_12').html() == '' && $('.uploads-summary .field-missing').length <= 0) {
                        $('.uploads-summary .gfield_label').after('<span class="field-missing">- '+formObject.fieldMissing+' -</span>');
                    }
                }
            });
            // Configuration of the observer
            var config = { attributes: false, childList: true, characterData: true };
            // Pass in the target node, as well as the observer options
            observer.observe(target, config);

            // Watching for exceeding file size
            var target_exceed = document.querySelector('#gform_multifile_messages_'+f2s+'_12');
            // Create an observer instance
            obderver_exceed = new MutationObserver(function(mutations,observer) {

                // Check files only when nodes added (not when nodes removed)
                if(mutations[0].addedNodes.length > 0) {
                    alert(formObject.maxFileSize);
                }
            });
            // Configuration of the observer
            var config_exceed = { attributes: false, childList: true, characterData: true };
            // Pass in the target node, as well as the observer options
            obderver_exceed.observe(target_exceed, config_exceed);

            $(".uploads-wrapper .gform_button_select_files").each(function() {
                $(this).val(formObject.selectFiles);
            });

            // TODO: works here?
            // Updating -> prepare
            if(productUpdating) {

                var updatedFiles = productUpdating[8];

                if(typeof updatedFiles !== 'undefined' && updatedFiles != '') {
                    previewsCheck(updatedFiles);
                }

            } else {
                previewsCheck(currentUploadedFiles);
            }
        }
    }

    function checkFilesUploaded(pageNumber,files) {
        if(typeof files === 'undefined') {
            files = [];
        }

        checkingFileUpload = true;
        var pendingUploads = true;
        $('#gform_page_'+f1s+'_'+pageNumber+' .gform_next_button').prop('disabled',true);

        setInterval(function() {
            if(pendingUploads) {
                $.each(gfMultiFileUploader.uploaders, function(i, uploader){
                    if(i=='gform_multifile_upload_'+f2s+'_12') {
                        if(uploader.total.queued<=0){
                            pendingUploads = checkingFileUpload = false;

                            $('#select-multiple-files .gform_ajax_spinner').remove();

                            fileUploadCheck();

                            // Get new files info
                            var newFiles = [];
                            var uploadedFilesAfter = JSON.parse($('#gform_uploaded_files_'+f2s).val());
                            var uploadedFilesAfter_key = Object.keys(uploadedFilesAfter)[0];
                            var filesAfter = uploadedFilesAfter[uploadedFilesAfter_key];
                            for(var i=0;i<filesAfter.length;i++) {
                                var found = false;
                                for(var y=0;y<files.length;y++) {
                                    if(files[y].temp_filename==filesAfter[i].temp_filename) {
                                        // If found, remove from array
                                        found = true;
                                        files.splice(y,1);
                                        break;
                                    }
                                }
                                // New file?
                                if(!found) {
                                    newFiles.push(filesAfter[i]);
                                }
                            }

                            if(productUpdating) {
                                // Store info about new files in currently updated product variable
                                var updatedFiles = productUpdating[8];
                                for (var x = 0; x < newFiles.length; x++) {
                                    updatedFiles.push(newFiles[x]);
                                }
                                productUpdating[8] = updatedFiles;

                            } else {
                                // Store info about new files in custom hidden input
                                for (var x = 0; x < newFiles.length; x++) {
                                    currentUploadedFiles.push(newFiles[x]);
                                }
                            }

                            if(newFiles.length>0) {

                                // TODO: will be previewsCheck() ok here?

                                // Go through all new files and clone review to review on current page
                                $('#gform_preview_'+f2s+'_12 .ginput_preview').each(function() {
                                    for(var y=0;y<newFiles.length;y++) {
                                        if(newFiles[y].temp_filename.indexOf($(this).attr('id')) > 0) {
                                            $('#current-files').append($(this).clone());
                                        }
                                    }
                                });

                                // Delete reference from hidden input when uploaded file deleting
                                $('#gform_preview_'+f2s+'_12 .gform_delete').each(function() {
                                    var onclick = $(this).attr('onclick');
                                    $(this).attr('onclick','removingUploadedFile(this);'+onclick);
                                });
                                $('#current-files .gform_delete').each(function() {
                                    $(this)[0].onclick = null;
                                    $(this).attr('onclick','');
                                });

                                // Bind new event to remove button in preview
                                $('#current-files .gform_delete').on('click', function() {
                                    var id = $(this).closest('.ginput_preview').attr('id');
                                    $(this).closest('.ginput_preview').remove();

                                    fileUploadCheck();

                                    // $('#gform_preview_'+f2s+'_12 #'+id).find('.gform_delete').trigger('click');
                                    // <-- TODO: check if it's good in safari
                                    if($('#gform_preview_'+f2s+'_12 #'+id).length > 0) {
                                        $('#gform_preview_'+f2s+'_12 #'+id).find('.gform_delete')[0].click();
                                    }

                                    // Remove from productUpdating variable, when changing defined product
                                    if(productUpdating) {
                                        var updatedFiles = productUpdating[8];
                                        for (var x = 0; x < updatedFiles.length; x++) {
                                            if(updatedFiles[x].temp_filename.indexOf(id) > 0) {
                                                updatedFiles.splice(x,1);
                                            }
                                        }
                                        productUpdating[8] = updatedFiles;
                                    }

                                    // Remove from currentUploadedFiles variable, when defining new product
                                    if(currentUploadedFiles) {
                                        for (var x = 0; x < currentUploadedFiles.length; x++) {
                                            if(currentUploadedFiles[x].temp_filename.indexOf(id) > 0) {
                                                currentUploadedFiles.splice(x,1);
                                            }
                                        }
                                    }
                                });
                            }

                            // Change button text when last file removed
                            fileUploadCheck();
                        }
                    }
                });
            }
        }, 200);
    }

    // This function chekcs whether there is error message for whole current page
    // (that means there is a validation error message above the "next/continue button")
    function stylePageValidationMessage(formId,pageNumber) {
        console.log('---stylePageValidationMessage]');

        // Colors page - no color selected error (nicknack or hotcup or hotcup cap)
        // These pages have specific hidden input for this message
        if ( $('#gform_page_'+formId+'_'+pageNumber).hasClass('page-amount-check') && $('#gform_page_'+formId+'_'+pageNumber+' .colors-number-validation-message .validation_message').length > 0) {

            let nextPageButtonWidth = $('.form-product-definition #gform_page_'+formId+'_'+pageNumber+' .gform_next_button').outerWidth();

            $('#gform_page_'+formId+'_'+pageNumber+' .colors-number-validation-message .validation_message').css({'width':nextPageButtonWidth});
            $('#gform_page_'+formId+'_'+pageNumber+' .colors-number-validation-message').css({'text-align':'center'});
            $('.form-product-definition .gform_page_footer').css({'margin-top':'0'});

        // Other pages (except pages with colors)
        } else if( !$('#gform_page_'+formId+'_'+pageNumber).hasClass('page-amount-check') && $('#gform_page_'+formId+'_'+pageNumber+' .gform_fields > .gfield_error > .validation_message').length > 0 ) {

            let nextPageButtonWidth = $('.form-product-definition #gform_page_'+formId+'_'+pageNumber+' .gform_next_button').outerWidth();

            $('#gform_page_'+formId+'_'+pageNumber+' .gform_fields > .gfield_error > .validation_message').css({'width':nextPageButtonWidth});
            $('#gform_page_'+formId+'_'+pageNumber+' .gform_fields > .gfield_error').css({'text-align':'center'});
            $('.form-product-definition .gform_page_footer').css({'margin-top':'0'});
        }
    }

    function checkFormSummaryScrollable() {
        var table = $('#form-summary'),
            tableRow = table.find('tbody tr'),
            tableWrap = $('#form-summary-wrapper .table-scroll');

        if(table.length>0 && tableRow.length>0 && tableWrap.length>0) {
            if(table.width() > tableWrap.width()) {
                tableWrap.addClass('scrollable');
            } else {
                tableWrap.removeClass('scrollable');
            }
        }
    }

    function getFormData() {

        var product_type, volume, variant, product, subproduct, colors, capColors, amount, motive, data;
        var product_type_text, volume_text, variant_text, product_text, subproduct_text, colors_text, capColors_text, amount_text, motive_text, data_text;

        subproduct = subproduct_text = colors = colors_text = motive = motive_text = '-';

        // Product type
        product_type = currentProductState.productType.type;
        product_type_text = currentProductState.productType.text;

        // Product volume
        volume = currentProductState.productVolume.volume;
        volume_text = currentProductState.productVolume.text;

        // Product variant
        variant = currentProductState.productVariant.variant;
        variant_text = currentProductState.productVariant.text;

        // Product color version
        color_version = currentProductState.cupColorVersion;

        // Product
        product = currentProductState.product.product;
        product_text = currentProductState.product.text;

        console.log('== getting form data ... == [product_type',product_type,'volume',volume,'variant',variant,'product',product,']');

        // Amount & Motive amount
        // - Nicknack cup
        if (product_type=='nicknack') {
            console.log('++ nicknack (variant '+variant+')');

            // Subproduct
            if(product=='sitotisk') {
                subproduct = $('#input_'+f1s+'_8 input:checked').val();
                subproduct_text = $('#input_'+f1s+'_8 input:checked + label').html().replace(/<p>.*<\/p>/g,"");
            }

            if (variant=='potisk') {
                console.log('++ potisk');

                if (color_version=='color') {
                    amount = amount_text = "-";
                } else {
                    amount = amount_text = $('#input_'+f1s+'_10').val().replace(/,/g,"");
                }
                motive = motive_text = $('#input_'+f1s+'_11').val().replace(/,/g,"");

            } else if (variant=='bez-potisku') {
                console.log('++ bez-potisku (product '+product+')');
                // Uniferzalni OR sada
                if (product=='univerzalni' || product=='sada') {
                    amount = amount_text = $('#input_'+f1s+'_10').val().replace(/,/g,"");
                    motive = motive_text = '-';
                    console.log('uni OR sada',amount_text);

                // Barevny
                } else {
                    amount = amount_text = '-';
                    motive = motive_text = '-';
                }
            } else {
                console.log('++ variant is different',variant);
            }

            // Colors
            if(product=='barevny' || color_version=='color') {
                var colorsArray = [];

                $('#gform_'+f1s+' .gform_page.cup-amount-check .cup-color-sample-wrapper').each(function() {    // Barvy
                    var label = $(this).find('.gfield_label').text(),
                        amount = $(this).find('input').val().replace(/,/g,"");

                    if(amount>0) {
                        colorsArray.push(label+':'+amount);
                    }
                });

                colors = colorsArray.join('€€');
                colors_text = colorsArray.join(',<br>');
            }

        // Hot cup
        } else if (product_type=='hotcup') {

            // Subproduct
            if(variant=='potisk') {
                subproduct = $('#input_'+f1s+'_78 input:checked').val();
                subproduct_text = $('#input_'+f1s+'_78 input:checked + label').html().replace(/<p>.*<\/p>/g,"");
            }

            // Default amount and motive
            amount = amount_text = '-';  // Amount is defined for each selected color
            motive = motive_text = '-';  // Motive is relevant only when potis, so this will be overriden later if its that case

            // Motive overriding if variant is potisk
            if (variant=='potisk') {

                if (product=='barevny') {
                    motive = motive_text = $('#input_'+f1s+'_88').val().replace(/,/g,"");

                } else if (product=='zakladni') {
                    motive = motive_text = $('#input_'+f1s+'_89').val().replace(/,/g,"");
                }
            }

            // Colors
            var colorsArray = [];

            if(color_version=='color') {

                $('#gform_'+f1s+' .gform_page.hotcup-amount-check.color .cup-color-sample-wrapper').each(function() {    // Barvy
                    var label = $(this).find('.gfield_label').text(),
                        amount = $(this).find('input').val().replace(/,/g,"");

                    if(amount>0) {
                        colorsArray.push(label+':'+amount);
                    }
                });

            } else if(color_version=='basic') {

                $('#gform_'+f1s+' .gform_page.hotcup-amount-check.basic .cup-color-sample-wrapper').each(function() {    // Barvy
                    var label = $(this).find('.gfield_label').text(),
                        amount = $(this).find('input').val().replace(/,/g,"");

                    if(amount>0) {
                        colorsArray.push(label+':'+amount);
                    }
                });
            }

            colors = colorsArray.join('€€');
            colors_text = colorsArray.join(',<br>');

            // Colors (hotcup cap)
            var capColorsArray = [];

            if(currentProductState.hotcupCap=='s-vickem') {

                $('#gform_'+f1s+' .gform_page.hotcup-cap-amount-check .cup-color-sample-wrapper').each(function() {    // Barvy
                    var label = $(this).find('.gfield_label').text(),
                        amount = $(this).find('input').val().replace(/,/g,"");

                    if(amount>0) {
                        capColorsArray.push(label+':'+amount);
                    }
                });

            }

            capColors = capColorsArray.join('§§');
            capColors_text = capColorsArray.join(',<br>');
        }

        var productDemandSet = $('#input_'+f2s+'_8').val(),
            productDemandSetLen = productDemandSet.length,
            index = productDemandSetLen,
            currentDemand = currentDemand_summary = '';

        if(productDemandSetLen<=0) {
            productDemandSet = [];
        } else {
            productDemandSet = JSON.parse(productDemandSet);
        }

        // Complete colors (within cap colors)

        if (capColors) {
            if (colors) {
                colors = colors + '<br>Víčka:<br>' + capColors;
            } else {
                colors = 'Víčka:<br>' + capColors;
            }
        }
        if (capColors_text) {
            if (colors_text) {
                colors_text = colors_text + '<br>Víčka:<br>' + capColors_text;
            } else {
                colors_text = 'Víčka:<br>' + capColors_text;
            }
        }

        // TODO: different structure for Hotcup?

        currentDemand = product_type + '@@' + volume +'@@'+ variant +'@@'+ product +'@@'+ subproduct +'@@'+ colors +'@@'+ amount +'@@'+ motive;
        console.log('currentDemand',currentDemand);

        currentDemand_summary = '<tr><td>' + volume_text +'</td><td>'+ variant_text +'</td><td>'+ product_text +'</td><td>'+ subproduct_text +'</td><td>'+ colors_text +'</td><td>'+ amount_text +'</td><td>'+ motive_text +'</td><td><a class="change-product" onclick="changeItem(this)" title="'+formObject.changeProduct+'">&nbsp;</a> <a class="remove-product" onclick="removeItem(this)" title="'+formObject.removeProduct+'">&nbsp;</a></td></tr>';

        productDemandSet.push(currentDemand);
        console.log('productDemandSet',productDemandSet);
        productDemandSet = JSON.stringify(productDemandSet);
        console.log('productDemandSet JSON',productDemandSet);

        setFormData(productDemandSet,currentDemand_summary);
    }

    // This function adds last product definition to contact form
    // One part to the summary table, latter to the hidden input
    function setFormData(demandSet,summary) {

        $('#input_'+f2s+'_8').val(demandSet); // Add item to array in hidden input
        $('#form-summary').append(summary); // Add row to the summary table

        // Check if is summary scrollable
        checkFormSummaryScrollable();

        // Hide no product selected message
        if($('#no-product-message').length>0) $('#no-product-message').remove();

        // Show submit button
        $('#gform_submit_button_'+f2s).show();
    }

    // This function recreates the summary table again,
    // when there is a error with submitting
    function setSummaryData(value) {
        if(!value) return;

        // Prepare data
        var productsArray = JSON.parse(value);

        for (var index = 0; index < productsArray.length; index++) {
            var product = productsArray[index];
            productParams = product.split("@@");

            //  0: product_type
            //  1: volume
            //  2: variant
            //  3: product
            //  4: subproduct
            //  5: colors
            //  6: amount
            //  7: motive
            // (8: files)
            var pp_product_type, pp_volume, pp_variant, pp_product, pp_subproduct, pp_colors, pp_amount, pp_motive;

            pp_product_type = productParams[0];

            // Volume
            pp_volume = productParams[1];
            // volume_text = $('#input_'+f1s+'_2 input[value="'+productParams[1]+'"] + label').text();
            if(pp_product_type=='nicknack') {
                volume_text = $('#gform_'+f1s+' .volume-selection input[value="'+pp_volume+'"] + label').text();
            } else {
                volume_text = $('#gform_'+f1s+' .volume-hotcup-selection input[value="'+pp_volume+'"] + label').text();
            }

            // Variant
            pp_variant = productParams[2];
            // variant_text = $('#input_'+f1s+'_3 input[value="'+productParams[1]+'"] + label').text();
            if(pp_product_type=='nicknack') {
                variant_text = $('#gform_'+f1s+' .variant-selection input[value="'+pp_variant+'"] + label').text();
            } else {
                variant_text = $('#gform_'+f1s+' .variant-hotcup-selection input[value="'+pp_variant+'"] + label').text();
            }

            // Product
            pp_product = productParams[3];
            pp_subproduct = productParams[4];
            subproduct_text = '-';
            // if($('#input_'+f1s+'_5 input[value="'+productParams[2]+'"] + label').length > 0) {
            //     product_text = $('#input_'+f1s+'_5 input[value="'+productParams[2]+'"] + label').html().replace(/<p>.*<\/p>/g,"");
            // } else {
            //     product_text = $('#input_'+f1s+'_6 input[value="'+productParams[2]+'"] + label').html().replace(/<p>.*<\/p>/g,"");
            // }
            if(pp_product_type=='nicknack') {
                if(pp_variant=='potisk') {
                    product_text = $('#gform_'+f1s+' .potisk-product-selection input[value="'+pp_product+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                    if( $('#gform_'+f1s+' .potisk-cup-selection input[value="'+pp_subproduct+'"] + label').length > 0 ) {
                        subproduct_text = $('#gform_'+f1s+' .potisk-cup-selection input[value="'+pp_subproduct+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                    }
                } else {
                    product_text = $('#gform_'+f1s+' .bez-potisku-product-selection input[value="'+pp_product+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                }
            } else {
                if(pp_variant=='potisk') {
                    product_text = $('#gform_'+f1s+' .hotcup-color-version-print input[value="'+pp_product+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                } else {
                    product_text = $('#gform_'+f1s+' .hotcup-color-version-noprint input[value="'+pp_product+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                }
            }

            // if(productParams[4]!='-') {
            //     subproduct_text = $('#input_'+f1s+'_8 input[value="'+productParams[3]+'"] + label').html().replace(/<p>.*<\/p>/g,"");
            // } else {
            //     subproduct_text = productParams[3];
            // }

            summaryRow = '<tr><td>' + volume_text +'</td><td>'+ variant_text +'</td><td>'+ product_text +'</td><td>'+ subproduct_text +'</td><td>'+ productParams[5] +'</td><td>'+ productParams[6] +'</td><td>'+ productParams[7] +'</td><td><a href="#" class="change-product" onclick="changeItem(this)" title="'+formObject.changeProduct+'"></a> <a href="#" class="remove-product" onclick="removeItem(this)" title="'+formObject.removeProduct+'"></a></td></tr>';

            $('#form-summary').append(summaryRow);
        }
    }

    function fileUploadCheck() {
        // Change next button text depending on number of files uploaded
        if($('#current-files .ginput_preview').length <= 0) {
            $('.gform_next_button').val(formObject.noFilesContinue);
        } else {
            $('.gform_next_button').prop('disabled',false).val(formObject.continueText);
        }
    }

    function fileUploadCheckNew(current_page) {
        if($('#gform_page_'+f1s+'_'+current_page+' #current-files').length > 0){
            // Change next button text depending on number of files uploaded
            if($('#gform_page_'+f1s+'_'+current_page+' #current-files .ginput_preview').length <= 0) {
                // $('#gform_page_'+f1s+'_'+current_page+' .gform_next_button').css({'border-color':'orange'});
                $('.gform_next_button').val(formObject.noFilesContinue);
            } else {
                $('.gform_next_button').prop('disabled',false).val(formObject.continueText);
            }
        }
    }

    function previewsCheck(filesArray) {

        console.log('PreviewsCheck - filesArray',filesArray);

        // Append previews
        $('#gform_preview_'+f2s+'_12 .ginput_preview').each(function() {
            for(var y=0;y<filesArray.length;y++) {
                if(filesArray[y].temp_filename.indexOf($(this).attr('id')) > 0) {
                    $('#current-files').append($(this).clone());
                }
            }
        });

        // Remove onclick event on these reviews
        $('#current-files .gform_delete').each(function() {
            $(this)[0].onclick = null;
            $(this).attr('onclick','');
        });

        // Bind new event to remove button in preview
        $('#current-files .gform_delete').on('click', function() {
            var id = $(this).closest('.ginput_preview').attr('id');
            $(this).closest('.ginput_preview').remove();

            fileUploadCheck();

            // Remove from productUpdating variable
            for(var y=0;y<filesArray.length;y++) {
                if(filesArray[y].temp_filename.indexOf(id) > 0) {
                    filesArray.splice(y,1);
                }
            }

            if(productUpdating) {
                productUpdating[8] = filesArray;
            }

            // <-- TODO: check if it's good in safari
            if($('#gform_preview_'+f2s+'_12 #'+id).length > 0) {
                $('#gform_preview_'+f2s+'_12 #'+id).find('.gform_delete')[0].click();
            }
        });
    }

    // Show form summary
    $('#show-form-summary').on('click', function(e) {
        e.preventDefault();

        $(this).hide();

        // Get contact fields
        var contactName = $('#input_'+f2s+'_3').val()!='' ? $('#input_'+f2s+'_3').val() : '<span class="field-missing">- '+formObject.fieldMissing+' -</span>',
            contactEmail = $('#input_'+f2+'_11').val()!='' ? $('#input_'+f2+'_11').val() : '<span class="field-missing">- '+formObject.fieldMissing+' -</span>',
            contactPhone = $('#input_'+f2s+'_5').val(),
            contactMessage = $('#input_'+f2s+'_6').val();

        // Prepare contact summary
        contact_summary = contactName + ' <a href="#" class="contact-summary-update" onclick="updateContactSummary()">('+formObject.updateContactFields+')</a><br>' + contactEmail + '<br>' + contactPhone + '<br>' + contactMessage;

        $('#contact-summary').html(contact_summary);

        // Hide Point 7 and contact fields
        $('.form-product-definition-contact_wrapper .gfield:nth-child(1),.form-product-definition-contact_wrapper .gfield:nth-child(2),.form-product-definition-contact_wrapper .gfield:nth-child(3),.form-product-definition-contact_wrapper .gfield:nth-child(4),.form-product-definition-contact_wrapper .gfield:nth-child(5)').hide();

        // Show uploads summary (filenames) and footer with submit button
        $('.uploads-summary,#form-summary-wrapper,.form-product-definition-contact_wrapper .gform_footer').show();

    });

    // volume-selection
    $('.gform_wrapper .volume-selection .gfield_radio input[type="radio"]:checked').val();
    // variant-selection
    $('.gform_wrapper .variant-selection .gfield_radio input[type="radio"]:checked').val();
    $('.gform_wrapper .variant-selection .gfield_radio input[type="radio"]:checked + label').text();
    // potisk-product-selection
    $('.gform_wrapper .potisk-product-selection .gfield_radio input[type="radio"]:checked').val();
    // bez-potisku-product-selection
    $('.gform_wrapper .bez-potisku-product-selection .gfield_radio input[type="radio"]:checked').val();
    // potisk-cup-selection
    $('.gform_wrapper .potisk-cup-selection .gfield_radio input[type="radio"]:checked').val();

    // Form submitting
    $('.form-product-definition-contact').on('submit', function() {
        $('.product-form-modal').addClass('submitting');
        $('#inquiryFormOverlay').addClass('submitting');
        if($('.form-submitting-spinner').length <= 0) {
            $('.product-form-modal').after('<span class="gform_ajax_spinner form-submitting-spinner"></span>');
        }
    });

    $.fn.addId = function(id) {
        if(typeof id === 'string') {
            var currentIds = $(this).val(),
                currentIdsArray = [];

            if(currentIds !== '') {
                currentIdsArray = JSON.parse(currentIds);
            }

            // Push if not already in array
            if(currentIdsArray.length == 0 || (currentIdsArray.length > 0 && currentIdsArray.findIndex(function(el){return el==id}) < 0)) {
                currentIdsArray.push(id);
            }

            $(this).val(JSON.stringify(currentIdsArray));
        }
    }

    $.fn.removeId = function(id) {
        if(typeof id === 'string') {
            var currentIds = $(this).val(),
                currentIdsArray = [];

            if(currentIds !== '') {
                currentIdsArray = JSON.parse(currentIds);
            }

            if(Array.isArray(currentIdsArray)) {
                for( var i = 0; i < currentIdsArray.length; i++){ 
                    if ( currentIdsArray[i] === id) {
                        currentIdsArray.splice(i, 1);
                    }
                }
            }

            $(this).val(JSON.stringify(currentIdsArray));
        }
    }

})(jQuery);

// Remove uploaded file
function removingUploadedFile(el) {

    var $this = jQuery(el);

    var deletedFileId = $this.closest('.ginput_preview').attr('id'),
        summary = jQuery('#fileupload-summary').val();

    if(summary != '') {
        summary = JSON.parse(summary);
        // For each product
        for (var i = 0; i < summary.length; i++) {
            var temp_files = [];
            // For each file
            for (var y = 0; y < summary[i].length; y++) {
                if(summary[i][y].temp_filename.indexOf(deletedFileId)<0) {
                    temp_files.push(summary[i][y]);
                }
            }

            summary[i] = temp_files;
        }

        jQuery('#fileupload-summary').val(JSON.stringify(summary));
    }
}

// Change product definition
function changeItem(el) {

    // First reset the form
    resetFirstForm();

    jQuery(el).addClass('no-bg').html('<span class="gform_ajax_spinner change-product-spinner"></span>');

    var $tr = jQuery(el).closest('tr');
    index = $tr.index();

    var productDemandSet = jQuery('#input_'+f2s+'_8').val();
    productDemandSetArray = JSON.parse(productDemandSet);

    currentProduct = productDemandSetArray[index];

    //  0: product_type
    //  1: volume
    //  2: variant
    //  3: product
    //  4: subproduct
    //  5: colors
    //  6: amount
    //  7: motive
    // (8: files)

    // Make array
    productUpdating = currentProduct.split("@@");

    // Add files if attach to this product
    var files = jQuery('#fileupload-summary').val();

    if(files != '') {
        files = JSON.parse(files);

        productUpdating.push(files[index]);

        files.splice(index,1);

        jQuery('#fileupload-summary').val(JSON.stringify(files));
    }

    // Remove item from hidden input
    if(index<0 || productDemandSetArray[index]=='undefined') {
        return;
    } else {
        productDemandSetArray.splice(index,1);
    }
    jQuery('#input_'+f2s+'_8').val(JSON.stringify(productDemandSetArray));

    // Go to first page
    jQuery('#gform_previous_button_'+f1s+'_4').trigger('click');

    productUpdatingTableRow = $tr;

    return false;
}

// Remove product definition
function removeItem(el) {
    // item = product

    var $tr = jQuery(el).closest('tr');
    index = $tr.index();

    var productDemandSet = jQuery('#input_'+f2s+'_8').val();
    productDemandSetArray = JSON.parse(productDemandSet);

    // Remove item from hidden input
    if(index<0 || productDemandSetArray[index]=='undefined') {
        return;
    } else {
        productDemandSetArray.splice(index,1);
    }
    jQuery('#input_'+f2s+'_8').val(JSON.stringify(productDemandSetArray));

    // Remove files for this item if some given
    var allFiles = jQuery('#fileupload-summary').val();
    if(allFiles != '') {
        allFiles = JSON.parse(allFiles);

        // Get files for currently removing item
        var files = allFiles[index];

        // Remove files for this item (= on index position in allFiles array)
        allFiles.splice(index,1);
        jQuery('#fileupload-summary').val(JSON.stringify(allFiles));

        // Trigger removing files for currently removing item
        jQuery('#gform_preview_'+f2s+'_12 .ginput_preview').each(function() {
            for(var y=0;y<files.length;y++) {
                if(files[y].temp_filename.indexOf(jQuery(this).attr('id')) > 0) {

                    jQuery(this).find('.gform_delete')[0].click();
                }
            }
        });
    }

    // Remove item from summary
    $tr.fadeOut("fast",function(){
        $tr.remove();

        // If it was the last tr, show empty row message and hide submit button
        if(jQuery('#form-summary tbody tr').length<=0) {
            jQuery('#form-summary').after('<div id="no-product-message">'+formObject.setProductBeforeSubmit+'</div>');
            jQuery('#gform_submit_button_'+f2s).hide();
        }
    });

    return false;
}

// Add new product definition
function addOtherProduct(el) {

    jQuery(el).find('.add-product-plus').addClass('gform_ajax_spinner').text('');

    otherProductAdding = true;

    // <-- TODO: same as above, refactoring!
    if(productUpdating) {
        console.log('addOtherProduct (product updating)');

        var updatedFiles = productUpdating[8],
            definedFiles = jQuery('#fileupload-summary').val();
            
        if(typeof definedFiles !== 'undefined' && definedFiles != '') {
            definedFiles = JSON.parse(definedFiles);
            definedFiles.push(updatedFiles);
        } else {
            definedFiles = [];
        }
        
        jQuery('#fileupload-summary').val(JSON.stringify(definedFiles));

        // Reset variable for new updated product
        productUpdating = false;

    } else {
        console.log('addOtherProduct');

        // If adding other product from last page of first form
        if(jQuery(el).hasClass('store-current-product')) {
            var definedFiles = jQuery('#fileupload-summary').val();
            if(typeof definedFiles !== 'undefined' && definedFiles != '') {
                definedFiles = JSON.parse(definedFiles);
            } else {
                definedFiles = [];
            }

            definedFiles.push(currentUploadedFiles);
            jQuery('#fileupload-summary').val(JSON.stringify(definedFiles));
        }

        // Reset variable for new product
        currentUploadedFiles = [];
    }

    resetFirstForm();

    return false;
}

// Reset first form (form for product definition)
function resetFirstForm() {

    // Reset current product state
    // currentProductState = currentProductState_default;
    // currentProductState = Object.assign({}, currentProductState_default);
    currentProductState = cloneDeep(currentProductState_default);

    // Reset selected choices on first 4 pages (volume, variant, product, subproduct)
    for (var pageNumber = 1; pageNumber <= jQuery('.form-product-definition_wrapper .gform_page').length; pageNumber++) {

        // Uncheck each radio input
        jQuery('#gform_page_'+f1s+'_'+pageNumber).find('input[type="radio"]').each(function() {
            jQuery(this).prop('checked',false);
        });

        // Empty each number/text input
        jQuery('#gform_page_'+f1s+'_'+pageNumber).find('input[type="number"]').each(function() {
            jQuery(this).val('');
        });
        jQuery('#gform_page_'+f1s+'_'+pageNumber).find('input[type="text"]').each(function() {
            jQuery(this).val('');
        });
    }

    // Uploaded data
    jQuery('#current-files').html('');

    // Colors
    jQuery('.cup-color-sample-wrapper').each(function() {
        jQuery(this)
            .removeClass('color-selected')
            .find('input').val(formObject.disVal).prop('disabled',true);
    });

    // Control amount hidden fields
    jQuery('#input_'+f1s+'_47').val('');
    jQuery('#input_'+f1s+'_82').val('');
    jQuery('#input_'+f1s+'_83').val('');

    // Go to first page
    jQuery('#gform_previous_button_'+f1s+'_4').trigger('click');

    return false;
}

// Update contact summary in second form (contact form)
function updateContactSummary() {

    // Show point 7
    jQuery('.form-product-definition-contact_wrapper .gfield:nth-child(1),.form-product-definition-contact_wrapper .gfield:nth-child(2),.form-product-definition-contact_wrapper .gfield:nth-child(3),.form-product-definition-contact_wrapper .gfield:nth-child(4),.form-product-definition-contact_wrapper .gfield:nth-child(5),#show-form-summary').show();

    jQuery('.uploads-summary,#form-summary-wrapper,.form-product-definition-contact_wrapper .gform_footer').hide();

    return false;
}

// Function for deep clone of the object
function cloneDeep(obj) {

    let clone = {};

    for (let key in obj){
        if (typeof obj[key] === "object"){
            clone[key] = cloneDeep(obj[key]);
        } else {
            clone[key] = obj[key];
        }
    }

    return clone;
}

function replaceAll(string, search, replace) {
    return string.split(search).join(replace);
}