"use strict";
var renderResetPassword = function() {

    let options = {
        minLength          : 8,
        checkUppercase     : true,
        checkLowercase     : true,
        checkDigit         : true,
        checkChar          : true,
        scoreHighlightClass: "active"
    };

    let passwordMeterElement = document.querySelector("#reset-employee-password"),
    passwordMeter = new KTPasswordMeter(passwordMeterElement, options);

    var validator = FormValidation.formValidation(
        document.querySelector('#passwordForm'),
        {
            fields: {
                'password': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        callback: {
                            message: 'Use atleast 8 characters length, 1 upper case letter, 1 lower case letter, 1 special character (!@#$&*) and number',
                            callback: function (input) {
                                passwordMeter.check();
                                return passwordMeter.getScore() == 100;
                            },
                        },
                    }
                },
                'password_confirmation': {
                    validators: {
                        identical: {
                            compare: function() {
                                return document.querySelector('#passwordForm input[name="password"]').value;
                            },
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                })
            }
        }
    );

    return {
        init: function() {

            $('#passwordForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                validator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#passwordForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#passwordForm button[type="submit"]').attr('disabled', true);

                        Swal.fire({
                            title: "Are you sure you want to save new password ?",
                            icon: "question",
                            buttonsStyling: false,
                            confirmButtonText: "Submit",
                            confirmButtonClass: "btn fw-bold btn-primary",
                            cancelButtonClass: "btn fw-bold btn-light-danger",
                            showCancelButton: true,
                            showLoaderOnConfirm: true,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            allowOutsideClick: () => !Swal.isLoading(),
                            preConfirm: () => {
                                return httpRequest.post(requestUrl, formData);
                            },
                        }).then(response => {

                            $('#passwordForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#passwordForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                $('#passwordModal').modal('hide');
                                Swal.fire({
                                    title: 'Success!',
                                    text: response.value.message,
                                    icon: "success",
                                    buttonsStyling: false,
                                    showCancelButton: false,
                                    confirmButtonText: "Proceed",
                                    customClass: {
                                        confirmButton: "btn fw-bold btn-light"
                                    }
                                }).then(function () {
                                    // window.location.reload();
                                });
                            }
                            else {
                                Swal.fire(response.value.message, response.value.errors, 'error');
                            }
                        })
                    }
                    else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            confirmButtonClass: "btn fw-bold btn-light"
                        });
                    }
                })
            })
        }
    };
}();

KTUtil.onDOMContentLoaded(function() {
    renderResetPassword.init();
});