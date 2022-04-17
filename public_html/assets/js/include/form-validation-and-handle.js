import "./scroll-to";
import "jquery-form";
import "jquery-validation";

$(function() {
    'use strict';

    // Form validation and submit
    function formValidationAndHandle() {
        var validateForms = $('.js-form-validation-handle');

        // Localization
        if (App.locale === 'tr') {
            $.extend( $.validator.messages, {
                required: "Bu alanın doldurulması zorunludur.",
                remote: "Lütfen bu alanı düzeltin.",
                email: "Lütfen geçerli bir e-posta adresi giriniz.",
                url: "Lütfen geçerli bir web adresi (URL) giriniz.",
                date: "Lütfen geçerli bir tarih giriniz.",
                dateISO: "Lütfen geçerli bir tarih giriniz(ISO formatında)",
                number: "Lütfen geçerli bir sayı giriniz.",
                digits: "Lütfen sadece sayısal karakterler giriniz.",
                creditcard: "Lütfen geçerli bir kredi kartı giriniz.",
                equalTo: "Lütfen aynı değeri tekrar giriniz.",
                extension: "Lütfen geçerli uzantıya sahip bir değer giriniz.",
                maxlength: $.validator.format( "Lütfen en fazla {0} karakter uzunluğunda bir değer giriniz." ),
                minlength: $.validator.format( "Lütfen en az {0} karakter uzunluğunda bir değer giriniz." ),
                rangelength: $.validator.format( "Lütfen en az {0} ve en fazla {1} uzunluğunda bir değer giriniz." ),
                range: $.validator.format( "Lütfen {0} ile {1} arasında bir değer giriniz." ),
                max: $.validator.format( "Lütfen {0} değerine eşit ya da daha küçük bir değer giriniz." ),
                min: $.validator.format( "Lütfen {0} değerine eşit ya da daha büyük bir değer giriniz." ),
                require_from_group: $.validator.format( "Lütfen bu alanların en az {0} tanesini doldurunuz." )
            });
        }

        var defaultLocales = {
            tr: {
                sending: 'Gönderiliyor...',
                success: 'Gönderildi!',
                error: 'Bir hata meydana geldi!'
            },
            en: {
                sending: 'Sending...',
                success: 'Sent!',
                error: 'An error occured!'
            },
        };

        validateForms.each(function() {
            var validateForm = $(this);
            var validateError = $('.alert-danger', validateForm);

            // Strings
            var msgSuccess = $(validateForm).attr('data-success-text') === undefined ? defaultLocales[App.locale]['success'] : $(validateForm).attr('data-success-text');
            var msgError = $(validateForm).attr('data-error-text') === undefined ? defaultLocales[App.locale]['error'] : $(validateForm).attr('data-error-text');
            var msgSending = $(validateForm).attr('data-sending-text') === undefined ? defaultLocales[App.locale]['sending'] : $(validateForm).attr('data-sending-text');

            var enableMultipleSend = (typeof $(validateForm).attr('data-enable-multiple-send') != 'undefined' ? $(validateForm).attr('data-enable-multiple-send') : false);
            var ajaxSend = (typeof $(validateForm).attr('data-ajax-send') != 'undefined' ? $(validateForm).attr('data-ajax-send') : true);
            var showMsgSending = (typeof $(validateForm).attr('data-show-sending-text') != 'undefined' ? $(validateForm).attr('data-show-sending-text') : true);
            var showMsgSuccess = (typeof $(validateForm).attr('data-show-success-text') != 'undefined' ? $(validateForm).attr('data-show-success-text') : true);

            var scrollToResult = (typeof $(validateForm).attr('data-scroll-to-result') != 'undefined' ? $(validateForm).attr('data-scroll-to-result') : true);

            validateForm.validate({
                errorElement: 'span',
                errorClass: 'invalid-feedback',
                focusInvalid: false,
                invalidHandler: function() {
                    validateError.show();
                },
                errorPlacement: function(error, element) {
                    if (element.is(':checkbox')) {
                        error.appendTo(element.parents('.form-group'));
                    } else if (element.is(':radio')) {
                        error.appendTo(element.parents('.form-group'));
                    } else if (element.hasClass('js-select2')) {
                        error.insertAfter(element.next('span'));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element) {
                    if ($(element).hasClass('js-select2')) {
                        $(element).parent().find('.select2-selection').addClass('is-invalid');
                    } else if ($(element).attr('type') === 'checkbox' || $(element).attr('type') === 'radio') {
                        $(element).parents('.form-group').addClass('is-invalid');
                    } else {
                        $(element).addClass('is-invalid');
                    }
                },
                unhighlight: function(element) {
                    if ($(element).hasClass('js-select2')) {
                        $(element).parent().find('.select2-selection').removeClass('is-invalid');
                    } else if ($(element).attr('type') === 'checkbox' || $(element).attr('type') === 'radio') {
                        $(element).parents('.form-group').removeClass('is-invalid');
                    } else {
                        $(element).removeClass('is-invalid');
                    }
                },
                success: function(label) {
                    label.removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    var $form = $(form);

                    validateError.hide();

                    if (enableMultipleSend === false) {
                        $form.find('button').prop('disabled', true);
                    }

                    if (showMsgSending === true) {
                        $form.find('.alert').removeClass('d-none alert-danger alert-success').addClass('alert-info').html(msgSending);
                    }

                    // Scroll to form
                    if (scrollToResult === true) {
                        scrollTo({
                            element: $form
                        });
                    }

                    if (ajaxSend === true) {
                        $form.ajaxSubmit({
                            success: function(data) {
                                if (typeof data.success === 'undefined') {
                                    data = JSON.parse(data);
                                }

                                if (data.success) {
                                    if (showMsgSuccess === true) {
                                        msgSuccess = (typeof data.message != 'undefined' ? data.message : msgSuccess);

                                        $form.find('.alert').removeClass('d-none alert-danger alert-info').addClass('alert-success').html(msgSuccess);
                                    }

                                    if (data.redirect) {
                                        window.location.replace(data.redirect);
                                    }
                                } else {
                                    $form.find('.alert').removeClass('d-none alert-success alert-info').addClass('alert-danger').html(msgError + '<br><ul><li>' + data.message + '</li></ul>');

                                    if (enableMultipleSend === false) {
                                        $form.find('button').prop('disabled', false);
                                    }
                                }

                                // Scroll to form
                                if (scrollToResult === true) {
                                    scrollTo({
                                        element: $form
                                    });
                                }
                            },
                            error: function(data) {
                                $form.find('.alert').removeClass('d-none alert-success alert-info').addClass('alert alert-danger').html(msgError + '<br>' + getLaravelErrorsAsList(data));

                                if (enableMultipleSend === false) {
                                    $form.find('button').prop('disabled', false);
                                }

                                // Scroll to form
                                if (scrollToResult === true) {
                                    scrollTo({
                                        element: $form
                                    });
                                }
                            }
                        });
                    } else {
                        form.submit();

                        // Scroll to form
                        if (scrollToResult === true) {
                            scrollTo({
                                element: $form
                            });
                        }
                    }
                }
            });
        });
    }

    // Convert error objects to HTML
    function getLaravelErrorsAsList(data) {
        var errors = '';
        errors += '<ul>';
        if (typeof data.responseJSON.errors !== "undefined") {
            $.each(data.responseJSON.errors, function (key, val) {
                errors += '<li>'+val+'</li>';
            });
        } else {
            errors += '<li>'+data.responseJSON.message+'</li>';
        }
        errors += '</ul>';

        return errors;
    }

    formValidationAndHandle();
});