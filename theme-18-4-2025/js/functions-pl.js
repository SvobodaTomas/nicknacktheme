var otherProductAdding = productUpdating = productUpdatingTableRow = checkingFileUpload = false,
    currentUploadedFiles = [];
var f1 = formObject.f1,
    f2 = formObject.f2,
    f1s = formObject.f1s,
    f2s = formObject.f2s;

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
        
        // Toggle class for selected color - added by Tonda
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
            if($(this).attr('id') != 'inquiryForm') {
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

                // Observers
                var observer,           // Observer for watching when new files uploaded
                    obderver_exceed;    // Observer for watching when uploaded file exceeds file size

                // Replace number field format when page loads (from e.g. 10,000 to 10000)
                $('#gform_page_'+f1s+'_'+current_page+' .ginput_container_number input').each(function() {
                    $(this).val($(this).val().replace(/,/g,""));
                    $(this).attr('autocomplete','off');
                });

                if(current_page==1) {
                    // Check whether we are adding other item
                    if(otherProductAdding || productUpdating) {

                        $('#gform_'+f2s).fadeOut();

                        $('.form-add-product').html('<span class="add-product-plus">&#x271A;</span> '+foundation_strings.add_product);

                        otherProductAdding = false;
                    }

                    // Updating -> prepare selected values
                    if(productUpdating) {
                        volume = productUpdating[0];
                        
                        $('#field_'+f1s+'_2 input[value="'+volume+'"]').trigger('click');
                    }

                    // Validation styling
                    stylePageValidationMessage(f1s,current_page);

                } else if(current_page==2) {
                    // Updating -> prepare selected values
                    if(productUpdating) {
                        variant = productUpdating[1];
                        
                        $('#input_'+f1s+'_3 input[value="'+variant+'"]').trigger('click');
                    }

                    // Validation styling
                    stylePageValidationMessage(f1s,current_page);

                } else if(current_page==3) {
                    var selectedVolume = $('.gform_wrapper .volume-selection .gfield_radio input[type="radio"]:checked').val(),
                        message = '<div class="bad-cup-volume">('+formObject.badCupVolume+')</div>';

                    if(selectedVolume!=0.5 && selectedVolume!=0.3) {
                        // Bez potisku barevny kelimek
                        $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="barevny"]').attr('disabled','disabled');
                        $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="barevny"]+label').after(message);

                        // Bez potisku party sada
                        $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="sada"]').attr('disabled','disabled');
                        $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="sada"]+label').after(message);
                        $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value!="sada"]').trigger('click');

                    } else {
                        // Bez potisku barevny kelimek
                        $('.gform_wrapper .bez-potisku-product-selection input[type="radio"][value="barevny"]').removeAttr('disabled');

                        // Remove message
                        $('.gform_wrapper .bad-cup-volume').remove();
                    }

                    // Updating -> prepare selected values
                    if(productUpdating) {
                        product = productUpdating[2];
                        subproduct = productUpdating[3];
                        
                        if($('#input_'+f1s+'_5 input[value="'+product+'"]').length > 0)
                            $('#input_'+f1s+'_5 input[value="'+product+'"]').trigger('click');
                        else if($('#input_'+f1s+'_6 input[value="'+product+'"]').length > 0)
                            $('#input_'+f1s+'_6 input[value="'+product+'"]').trigger('click');
                    }

                    // Validation styling
                    stylePageValidationMessage(f1s,current_page);

                } else if(current_page==4) {
                    var selectedVolume = $('.gform_wrapper .volume-selection .gfield_radio input[type="radio"]:checked').val(),
                        message = '<div class="bad-cup-volume">('+formObject.badCupVolumeLong+')</div>';

                    if(selectedVolume!=0.5 && selectedVolume!=0.3) {

                        // Rotacni sitotisk barevny kelimek
                        $('.gform_wrapper .potisk-cup-selection input[type="radio"][value="barevny-kelimek"]').attr('disabled','disabled');
                        $('.gform_wrapper .potisk-cup-selection input[type="radio"][value="barevny-kelimek"]+label').after(message);
                        $('.gform_wrapper .potisk-cup-selection input[type="radio"][value!="barevny-kelimek"]').trigger('click');

                    } else {
                        // Rotacni sitotisk barevny kelimek
                        $('.gform_wrapper .potisk-cup-selection input[type="radio"][value="barevny-kelimek"]').removeAttr('disabled');

                        // Remove message
                        $('.gform_wrapper .bad-cup-volume').remove();
                    }

                    // Updating -> prepare selected values
                    if(productUpdating) {
                        subproduct = productUpdating[3];
                        
                        if($('#input_'+f1s+'_8 input[value="'+subproduct+'"]').length > 0)
                            $('#input_'+f1s+'_8 input[value="'+subproduct+'"]').trigger('click');
                    }

                    // Validation styling
                    stylePageValidationMessage(f1s,current_page);

                } else if(current_page==5) {

                    // Show Colors field condition
                    if(
                        // if is potisk && sitotisk && barevny
                        ($('#choice_'+f1s+'_3_0').is(':checked') && $('#choice_'+f1s+'_5_1').is(':checked') && $('#choice_'+f1s+'_8_1').is(':checked'))
                        ||
                        // else if is bez potisku && barevny
                        ($('#choice_'+f1s+'_3_1').is(':checked') && $('#choice_'+f1s+'_6_0').is(':checked')) ) {

                        $('.cup-color-sample-wrapper').show();
                        $('.custom-cup-amount').hide();
                    } else {
                        $('.cup-color-sample-wrapper').hide();
                        $('.custom-cup-amount').show();
                    }

                    // Highlighting, focusing and disabling
                    $('.cup-color-sample-wrapper .cup-color-sample,.cup-color-sample-wrapper .gfield_label').on('click', function(e) {
                        var $gfield = $(this).closest('.gfield');

                        if ($gfield.hasClass('color-selected')) {
                            // Unselect
                            $gfield.find('input').val(formObject.disVal);
                            $gfield.removeClass('color-selected');
                            $gfield.find('input').prop('disabled',true);

                            // Control value
                            $('#input_'+f1s+'_47').removeId($gfield.find('input').attr('id'));
                            
                        } else {
                            // Mark as selected
                            $gfield.addClass('color-selected');
                            $gfield.find('input').val('');
                            $gfield.find('input').focus();
                            $gfield.find('input').prop('disabled',false);

                            // Control value
                            $('#input_'+f1s+'_47').addId($gfield.find('input').attr('id'));
                        }
                    });

                    // Amount placeholder
                    var amountPlaceholder = amountDescText = '',
                        amountText = formObject.amountText;

                    if($('#choice_'+f1s+'_3_0').is(':checked')) {    // Potisk
                        if($('#choice_'+f1s+'_5_0').is(':checked')) {  // IML
                            amountPlaceholder = formObject.min1000;
                        } else if($('#choice_'+f1s+'_5_1').is(':checked')) {  // Sitotisk
                            amountPlaceholder = formObject.min250;
                        }
                    } else if($('#choice_'+f1s+'_3_1').is(':checked')) { // Bez potisku
                        if($('#choice_'+f1s+'_6_0').is(':checked') || $('#choice_'+f1s+'_6_1').is(':checked')) {  // Barevny nebo univerzalni
                            amountPlaceholder = formObject.min100;
                        } else {    // Party sada
                            amountText = formObject.amountTextSada;
                            amountDescText = formObject.sadaPack;
                        }
                    }
                    $('#input_'+f1s+'_10').attr('placeholder',amountPlaceholder);
                    $('.cup-color-sample-wrapper input').attr('placeholder',amountPlaceholder);
                    $('#field_'+f1s+'_10 label').text(amountText);
                    $('#field_'+f1s+'_10 .gfield_description:not(.validation_message').text(amountDescText);

                    // Motive placeholder
                    var motivePlaceholder = motiveText = motiveDescText = '';
                    if($('#choice_'+f1s+'_3_0').is(':checked')) {    // Potisk
                        if($('#choice_'+f1s+'_5_0').is(':checked')) {  // IML
                            motiveText = formObject.motiveAmount;
                            motiveDescText = formObject.motiveMin;
                        } else if($('#choice_'+f1s+'_5_1').is(':checked')) {  // Sitotisk
                            motiveText = formObject.motiveColorsAmount;
                        }
                    }
                    $('#input_'+f1s+'_11').attr('placeholder',motivePlaceholder);
                    $('#field_'+f1s+'_11 label').text(motiveText);
                    $('#field_'+f1s+'_11 .gfield_description:not(.validation_message)').text(motiveDescText);

                    // Updating -> prepare selected values
                    if(productUpdating) {
                        if(productUpdatingTableRow) {
                            productUpdatingTableRow.remove();
                            productUpdatingTableRow = false;
                        }

                        colors = amount = motive = "";
                        
                        // Setting the variables
                        // colors - make array from string
                        // amount + motive - set value and replace the comma (1,600 -> 1600)
                        if(typeof productUpdating[4] !== 'undefined') {
                            colors = productUpdating[4]=="-" ? '' : productUpdating[4].replace("<br>","").split("€€");
                        }
                        if(typeof productUpdating[6] !== 'undefined') {
                            amount = productUpdating[5]=='-' ? '' : productUpdating[5].replace(/,/g,"");
                        }
                        if(typeof productUpdating[6] !== 'undefined') {
                            motive = productUpdating[6]=='-' ? '' : productUpdating[6].replace(/,/g,""); 
                        }
                        
                        $('#input_'+f1s+'_10').val(amount);              // Pocet kusu
                        $('#input_'+f1s+'_11').val(motive);              // Pocet barev / motivu
                        
                        for (var i = 0; i < colors.length; i++) {
                            var color_pair = colors[i].split(':'),
                                cp_color = color_pair[0],
                                cp_colorAmount = color_pair[1];
                            
                            $('.cup-color-sample-wrapper').each(function() {
                                // Is this color selected?
                                if($(this).find('label').text()==cp_color) {
                                    var $thisInput = $(this).find('input');
                                    // Insert amount, that was set to this color
                                    $thisInput.val(cp_colorAmount);

                                    // Add this input into controlIds array
                                    $('#input_'+f1s+'_47').addId($thisInput.attr('id'));

                                    return false;
                                }
                            });
                        }
                    }

                    // Highlight the selected colors and disable the non-checked
                    $('.cup-color-sample-wrapper').each(function() {
                        var $this = $(this),
                            $input = $this.find('input');

                        // Highlight all related color fields
                        if($this.hasClass('gfield_error') || $input.val()!='') {
                            $this.addClass('color-selected');

                            // Control value
                            $('#input_'+f1s+'_47').addId($input.attr('id'));
                        } else {
                            // Control value
                            $('#input_'+f1s+'_47').removeId($input.attr('id'));
                        }
                    });

                    // Validation styling
                    stylePageValidationMessage(f1s,current_page);

                } else if(current_page==6) {
                    
                    // Updating -> prepare selected values
                    if(productUpdating) {
                        
                        var updatedFiles = productUpdating[7];

                        if(typeof updatedFiles !== 'undefined' && updatedFiles != '') {
                            previewsCheck(updatedFiles);
                        }

                    } else {
                        previewsCheck(currentUploadedFiles);
                    }

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
                                checkFilesUploaded(current_page,uploadedFiles[uploadedFiles_key]);
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

                    // Change next button text
                    fileUploadCheck();

                } else if(current_page==7) {
                    
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
                            var updatedFiles = productUpdating[7],
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
            }
        });

        // Hide second form, show after "No" clicked on the end of the first form
        $('#gform_'+f2s).hide();

        $(document).ready(function(){
            if($(".form-product-definition-contact").hasClass('gform_confirmation_wrapper')){
                // Hide the f1
                $('#gform_'+f1s).hide();
                $('#gform_'+f2s).show();
            }
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
            }
        });

        $(window).on('load resize', function() {
            checkFormSummaryScrollable();
        });

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
                                    var updatedFiles = productUpdating[7];
                                    for (var x = 0; x < newFiles.length; x++) {
                                        updatedFiles.push(newFiles[x]);
                                    }
                                    productUpdating[7] = updatedFiles;

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
                                            var updatedFiles = productUpdating[7];
                                            for (var x = 0; x < updatedFiles.length; x++) {
                                                if(updatedFiles[x].temp_filename.indexOf(id) > 0) {
                                                    updatedFiles.splice(x,1);
                                                }
                                            }
                                            productUpdating[7] = updatedFiles;
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

        function stylePageValidationMessage(formId,pageNumber) {
            // Colors page - no color selected error
            if(pageNumber == 5 && $('#gform_page_'+formId+'_'+pageNumber+' .colors-number-validation-message .validation_message').length > 0) {
                var nextPageButtonWidth = $('.form-product-definition #gform_page_'+formId+'_'+pageNumber+' .gform_next_button').outerWidth();
                $('#gform_page_'+formId+'_'+pageNumber+' .colors-number-validation-message .validation_message').css({'width':nextPageButtonWidth});
                $('#gform_page_'+formId+'_'+pageNumber+' .colors-number-validation-message').css({'text-align':'center'});
                $('.form-product-definition .gform_page_footer').css({'margin-top':'0'});
            
            // Other pages
            } else if(pageNumber != 5 && $('#gform_page_'+formId+'_'+pageNumber+' .gform_fields > .gfield_error > .validation_message').length > 0) {
                var nextPageButtonWidth = $('.form-product-definition #gform_page_'+formId+'_'+pageNumber+' .gform_next_button').outerWidth();
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

            var volume, variant, product, subproduct, colors, amount, motive, data;
            var volume_text, variant_text, product_text, subproduct_text, colors_text, amount_text, motive_text, data_text;

            subproduct = subproduct_text = colors = colors_text = motive = motive_text = '-';

            // Get data from all inputs
            volume = $('#input_'+f1s+'_2 input:checked').val();
            volume_text = $('#input_'+f1s+'_2 input:checked + label').text();
            variant = $('#input_'+f1s+'_3 input:checked').val();
            variant_text = $('#input_'+f1s+'_3 input:checked + label').text();
            if(variant=='potisk') {
                product = $('#input_'+f1s+'_5 input:checked').val();
                // Remove additional description (in p tag)
                product_text = $('#input_'+f1s+'_5 input:checked + label').html().replace(/<p>.*<\/p>/g,"");
            } else {
                product = $('#input_'+f1s+'_6 input:checked').val();
                // Remove additional description (in p tag)
                product_text = $('#input_'+f1s+'_6 input:checked + label').html().replace(/<p>.*<\/p>/g,"");
            }
            if(product=='sitotisk') {
                subproduct = $('#input_'+f1s+'_8 input:checked').val();
                subproduct_text = $('#input_'+f1s+'_8 input:checked + label').html().replace(/<p>.*<\/p>/g,"");
            }
            if(product=='barevny' || subproduct=='barevny-kelimek') {
                var colorsArray = [];

                $('.cup-color-sample-wrapper').each(function() {    // Barvy
                    var label = $(this).find('.gfield_label').text(),
                        amount = $(this).find('input').val().replace(/,/g,"");

                    if(amount>0) {
                        colorsArray.push(label+':'+amount);
                    }
                });

                colors = colorsArray.join('€€');
                colors_text = colorsArray.join(',<br>');
            }
            amount = amount_text = $('#input_'+f1s+'_10').val().replace(/,/g,"");
            if(variant=='potisk') {
                motive = motive_text = $('#input_'+f1s+'_11').val().replace(/,/g,"");
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

            currentDemand = volume +'@@'+ variant +'@@'+ product +'@@'+ subproduct +'@@'+ colors +'@@'+ amount +'@@'+ motive;

            currentDemand_summary = '<tr><td>' + volume_text +'</td><td>'+ variant_text +'</td><td>'+ product_text +'</td><td>'+ subproduct_text +'</td><td>'+ colors_text +'</td><td>'+ amount_text +'</td><td>'+ motive_text +'</td><td><a href="#" class="change-product" onclick="changeItem(this)" title="'+formObject.changeProduct+'">&nbsp;</a> <a href="#" class="remove-product" onclick="removeItem(this)" title="'+formObject.removeProduct+'">&nbsp;</a></td></tr>';

            productDemandSet.push(currentDemand);
            productDemandSet = JSON.stringify(productDemandSet);

            setFormData(productDemandSet,currentDemand_summary);
        }

        function setFormData(demandSet,summary) {

            $('#input_'+f2s+'_8').val(demandSet);
            $('#form-summary').append(summary);

            // Check if is summary scrollable
            checkFormSummaryScrollable();

            // Hide no product selected message
            if($('#no-product-message').length>0) $('#no-product-message').remove();

            // Show submit button
            $('#gform_submit_button_'+f2s).show();
        }

        function setSummaryData(value) {
            if(!value) return;

            // Prepare data
            var productsArray = JSON.parse(value);

            for (var index = 0; index < productsArray.length; index++) {
                var product = productsArray[index];
                productParams = product.split("@@");

                volume_text = $('#input_'+f1s+'_2 input[value="'+productParams[0]+'"] + label').text();
                variant_text = $('#input_'+f1s+'_3 input[value="'+productParams[1]+'"] + label').text();
                if($('#input_'+f1s+'_5 input[value="'+productParams[2]+'"] + label').length > 0) {
                    product_text = $('#input_'+f1s+'_5 input[value="'+productParams[2]+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                } else {
                    product_text = $('#input_'+f1s+'_6 input[value="'+productParams[2]+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                }
                if(productParams[3]!='-') {
                    subproduct_text = $('#input_'+f1s+'_8 input[value="'+productParams[3]+'"] + label').html().replace(/<p>.*<\/p>/g,"");
                } else {
                    subproduct_text = productParams[3];
                }

                summaryRow = '<tr><td>' + volume_text +'</td><td>'+ variant_text +'</td><td>'+ product_text +'</td><td>'+ subproduct_text +'</td><td>'+ productParams[4] +'</td><td>'+ productParams[5] +'</td><td>'+ productParams[6] +'</td><td><a href="#" class="change-product" onclick="changeItem(this)" title="'+formObject.changeProduct+'"></a> <a href="#" class="remove-product" onclick="removeItem(this)" title="'+formObject.removeProduct+'"></a></td></tr>';

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

        function previewsCheck(filesArray) {
            
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
                    productUpdating[7] = filesArray;
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
        var updatedFiles = productUpdating[7],
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

    // Pages to reset
    var pages = [1,2,3,4];

    // Reset selected choices on first 4 pages (volume, variant, product, subproduct)
    for (var pageNumber = 0; pageNumber < pages.length; pageNumber++) {
        var element = pages[pageNumber];
        jQuery('#gform_page_'+f1s+'_'+pageNumber).find('input[type="radio"]').each(function() {
            jQuery(this).prop('checked',false);
        });
    }

    jQuery('#input_'+f1s+'_10').val('');              // Pocet kusu
    jQuery('#input_'+f1s+'_11').val('');              // Pocet barev / motivu

    // Uploaded data
    jQuery('#current-files').html('');

    // Colors
    jQuery('.cup-color-sample-wrapper').each(function() {
        var $wrapper = jQuery(this);
        $wrapper.removeClass('color-selected');
        $wrapper.find('input').val(formObject.disVal).prop('disabled',true);
    });
    jQuery('#input_'+f1s+'_47').val('');

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