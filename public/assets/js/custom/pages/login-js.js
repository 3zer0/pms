"use strict";
var renderLogin = function() {

    var intVal = 0;

    $('[data-action="forgot-password"]').on('click', function() {
        Swal.fire('Information', 'This feature is currently under development.', 'info');
    })

    let n = document.querySelector("[name=code_1]"),
        i = document.querySelector("[name=code_2]"),
        o = document.querySelector("[name=code_3]"),
        u = document.querySelector("[name=code_4]"),
        r = document.querySelector("[name=code_5]"),
        c = document.querySelector("[name=code_6]");

    n.focus();
    n.addEventListener("keyup", function () {
        1 === this.value.length && i.focus();
    });
    i.addEventListener("keyup", function () {
        1 === this.value.length && o.focus();
    });
    o.addEventListener("keyup", function () {
        1 === this.value.length && u.focus();
    });
    u.addEventListener("keyup", function () {
        1 === this.value.length && r.focus();
    });
    r.addEventListener("keyup", function () {
        1 === this.value.length && c.focus();
    });
    c.addEventListener("keyup", function () {
        1 === this.value.length && c.blur();
    });

    $('#otpForm').bind('paste', '.otp-flds', function(e){
        var pastedData = e.originalEvent.clipboardData.getData('text');
            pastedData = pastedData.replace(/\s/g, '');
        if(pastedData.length == 6) {
            for (let i = 0; i < pastedData.length; i++) {
                const val = pastedData.charAt(i);
                $(`#otpForm input[name="code_${ i + 1 }"]`).val(val);
            }

            n.blur(); i.blur(); o.blur(); u.blur(); r.blur(); c.blur();
        }
    });

    $('#loginForm').on('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(this);

        $.ajax({
            url: 'auth',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#loginForm button[type="submit"]').attr('data-kt-indicator', 'on');
                $('#loginForm button[type="submit"]').attr('disabled', true);
                $('#diplay-error').empty();
            },
            success: function( response ) {

                $('#loginForm button[type="submit"]').attr('data-kt-indicator', 'off');
                $('#loginForm button[type="submit"]').attr('disabled', false);

                if(response.success) {

                    $('#loginForm input[name="password"]').val('');
                    $('#otpForm input[name="token"]').val(response.data.token);
                    $('#otpForm #smtp-email').text(response.data.email);
                    $('#otpForm #sms-number').text(response.data.mobile);
                    // $('#qrcode').qrcode({ width: 130, height: 130, text: response.data.link });

                    // $('#otpForm #resend-code').click();

                    $('#otpModal').modal('show');
                }
                else {
                    if(response.data != null) {
                        let _a = response.data;
                            _a = _a.split('-');
                        let accessDenied = lgn == 1 ? 'access_denied?atr=' + _a[1]  : 'access_denied1?atr=' + _a[1];
                        if(_a[1].length > 0) {
                            window.location.href = accessDenied;
                        }
                    }

                    $('#diplay-error').html(response.message);
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#loginForm button[type="submit"]').attr('data-kt-indicator', 'off');
                $('#loginForm button[type="submit"]').attr('disabled', false);

                Swal.fire('Error!', errorThrown, 'error')
            }
        })
    })

    const sendCode = (opt, btnResend) => {
        let token = $('#otpForm input[name="token"]').val();
        let _validToken = $('#otpForm input[name="_token"]').val();

        if(intVal == 0) {

            intVal = 180;

            let formData = new FormData();
            formData.append('_token', _validToken);
            formData.append('token', token);
            formData.append('auth_opt', opt);

            $.ajax({
                url        : '/send_code',
                method     : 'POST',
                data       : formData,
                dataType   : 'json',
                contentType: false,
                processData: false,
                beforeSend : function() {
                    btnResend.attr('data-kt-indicator', 'on');
                    btnResend.attr('disabled', true);
                },
                success: function( response ) {
                    btnResend.attr('data-kt-indicator', 'off');
                    btnResend.attr('disabled', true);

                    $('#otpForm input[name="code_1]').val('');
                    $('#otpForm input[name="code_2]').val('');
                    $('#otpForm input[name="code_3]').val('');
                    $('#otpForm input[name="code_4]').val('');
                    $('#otpForm input[name="code_5]').val('');
                    $('#otpForm input[name="code_6]').val('');

                    if(response.success) {
                        var newTimer = setInterval(function() {
                            intVal = intVal - 1;
                            $('#otpForm #resend-text-' + opt).text('Resend code in ' + intVal);

                            if(intVal == 0) {
                                clearInterval(newTimer);
                                $('#otpForm #resend-text-' + opt).text('Send Code');
                                btnResend.attr('disabled', false);
                            }
                        }, 1000);

                        // Swal.fire('Success!', 'One-Time Password (OTP) was successfully sent to your email', 'success')
                    }
                    else {
                        Swal.fire('Error!', response.errors, 'error');
                    }
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    btnResend.attr('data-kt-indicator', 'off');
                    btnResend.attr('disabled', false);

                    Swal.fire('Error!', errorThrown, 'error')
                }
            })
        }
    }

    $('#otpForm').on('click', 'button[data-action="select-otp"]', function() {
        let authOpt = $('#otpForm input[name="auth_option"]:checked').val();

        if(authOpt == undefined) {
            Swal.fire('Error!', 'Please select authentication option.', 'error');
            return;
        }

        if(authOpt == 'sms') {
            Swal.fire('Reminder', `We can't send a verification code by text right now. Please choose another method.`, 'warning');
            return;
        }

        intVal = 0;

        $('#otpForm #auth-section').removeClass('d-none');
        $('#otpForm #otp-selection').addClass('d-none');

        if(authOpt == 'smtp') {
            $('#otpForm #smtp-otp').removeClass('d-none');
            $('#otpForm #sms-otp').addClass('d-none');

            $('#otpForm #resend-code-smtp').click();
        }
        else if(authOpt == 'sms') {

            // $('#otpForm #smtp-otp').addClass('d-none');
            // $('#otpForm #sms-otp').removeClass('d-none');

            // $('#otpForm #resend-code-sms').click();
        }
    })

    $('#otpForm').on('click', '#resend-code-smtp', function() {
        let _this = $(this);
        let option = _this.attr('dt-option');

        sendCode(option, _this);
    })

    $('#otpForm').on('click', '#resend-code-sms', function() {
        let _this = $(this);
        let option = _this.attr('dt-option');

        sendCode(option, _this);
    })

    $('#otpForm').on('click', 'button[type="reset"]', function() {
        $('#otpForm #otp-selection').removeClass('d-none');
        $('#otpForm #auth-section').addClass('d-none');
        $('#otpForm #smtp-otp').addClass('d-none');
        $('#otpForm #sms-otp').addClass('d-none');
    })

    $('#otpForm').on('click', '#reselect-auth', function() {
        $('#otpForm #otp-selection').removeClass('d-none');
        $('#otpForm #auth-section').addClass('d-none');
        $('#otpForm #smtp-otp').addClass('d-none');
        $('#otpForm #sms-otp').addClass('d-none');
    })

    $('#otpForm').on('submit', function(e) {
        e.preventDefault();

        let token = $('#otpForm input[name="token"]').val();
        let code1 = $('#otpForm input[name="code_1"]').val();
        let code2 = $('#otpForm input[name="code_2"]').val();
        let code3 = $('#otpForm input[name="code_3"]').val();
        let code4 = $('#otpForm input[name="code_4"]').val();
        let code5 = $('#otpForm input[name="code_5"]').val();
        let code6 = $('#otpForm input[name="code_6"]').val();
        let code = `${ code1 }${ code2 }${ code3 }${ code4 }${ code5 }${ code6 }`;

        let formData = new FormData(this);
        formData.delete('code_1');
        formData.delete('code_2');
        formData.delete('code_3');
        formData.delete('code_4');
        formData.delete('code_5');
        formData.delete('code_6');
        formData.append('code', Number(code.trim()));

        $.ajax({
            url: 'auth_validate',
            type: 'POST',
            data: formData,
            dataType: 'json',
            contentType: false,
            processData: false,
            beforeSend: function() {
                $('#otpForm button[type="submit"]').attr('data-kt-indicator', 'on');
                $('#otpForm button[type="submit"]').attr('disabled', true);
                $('#otpForm #otp-error').empty();
            },
            success: function( response ) {

                $('#otpForm button[type="submit"]').attr('data-kt-indicator', 'off');
                $('#otpForm button[type="submit"]').attr('disabled', false);

                if(response.success) {
                    window.location.href = 'deliveries';
                    // window.location.href = 'dashboard';
                }
                else {
                    if(response.message == 'Authentication Failed!') {
                        Swal.fire({
                            title: response.message,
                            text: response.errors,
                            icon: "error",
                            buttonsStyling: false,
                            showCancelButton: false,
                            confirmButtonText: "Try again",
                            customClass: {
                                confirmButton: "btn font-weight-bold btn-light"
                            }
                        }).then(function () {

                        });
                    }
                    else {
                        $('#otpForm #otp-error').text(response.errors);
                    }
                }
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                $('#otpForm button[type="submit"]').attr('data-kt-indicator', 'off');
                $('#otpForm button[type="submit"]').attr('disabled', false);

                Swal.fire('Error!', errorThrown, 'error')
            }
        })
    })

    return {
        init: function() {

            $(document).keydown(function(e){
                var keyCode = e.keyCode || e.which;
                if(keyCode === 123){
                    e.preventDefault();
                }
            });

        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderLogin.init();
});
