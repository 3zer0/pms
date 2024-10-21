<div class="modal fade" id="otpModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false"
data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered mw-650px">
        <div class="modal-content">
            <div class="modal-body px-10">
                
                <form autocomplete="off" id="otpForm">
                    <div class="p-7">

                        <h2 class="text-dark fw-bold mb-7">Login Authentication</h2>

                        <input type="hidden" name="token">

                        <div id="otp-selection">
                            <p class="text-muted fs-5 fw-semibold mb-10">
                                In addition to your username and password, you’ll have to enter a code (delivered via Email Address or SMS) to log into your account.
                            </p>
                            
                            <div class="pb-10">
                                <input type="radio" class="btn-check" name="auth_option" value="smtp" checked="checked"  id="tfa_option_1"/>
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5 rounded-3" for="tfa_option_1">
                                    <span class="svg-icon svg-icon-muted svg-icon-2tx text-primary me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M21 19H3C2.4 19 2 18.6 2 18V6C2 5.4 2.4 5 3 5H21C21.6 5 22 5.4 22 6V18C22 18.6 21.6 19 21 19Z" fill="currentColor"/>
                                            <path d="M21 5H2.99999C2.69999 5 2.49999 5.10005 2.29999 5.30005L11.2 13.3C11.7 13.7 12.4 13.7 12.8 13.3L21.7 5.30005C21.5 5.10005 21.3 5 21 5Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    <span class="d-block fw-semibold text-start">                            
                                        <span class="text-gray-900 fw-bold d-block fs-3">Send via Email</span>
                                        <span class="text-muted fw-semibold fs-6">
                                            We will send a code on your registered email address to complete your login request.
                                        </span>
                                    </span>
                                </label>   
    
                                <input type="radio" class="btn-check" name="auth_option" value="sms" id="tfa_option_2"/>
                                <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center rounded-3" for="tfa_option_2">
                                    <span class="svg-icon svg-icon-muted svg-icon-2tx text-primary me-4">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.3" d="M2 4V16C2 16.6 2.4 17 3 17H13L16.6 20.6C17.1 21.1 18 20.8 18 20V17H21C21.6 17 22 16.6 22 16V4C22 3.4 21.6 3 21 3H3C2.4 3 2 3.4 2 4Z" fill="currentColor"/>
                                            <path d="M18 9H6C5.4 9 5 8.6 5 8C5 7.4 5.4 7 6 7H18C18.6 7 19 7.4 19 8C19 8.6 18.6 9 18 9ZM16 12C16 11.4 15.6 11 15 11H6C5.4 11 5 11.4 5 12C5 12.6 5.4 13 6 13H15C15.6 13 16 12.6 16 12Z" fill="currentColor"/>
                                        </svg>
                                    </span>
                                    <span class="d-block fw-semibold text-start">                              
                                        <span class="text-gray-900 fw-bold d-block fs-3">Send via SMS</span>
                                        <span class="text-muted fw-semibold fs-6">We will send a code on your registered mobile number to complete your login request.</span>
                                    </span>                           
                                </label>           
                            </div>

                            <div class="text-center">
                                <button type="reset" data-bs-dismiss="modal" class="btn btn-light-danger me-3">Cancel</button>
                                <button type="button" class="btn btn-primary" data-action="select-otp">Continue</button>
                            </div>
                        </div>
                        @csrf
                        <div id="auth-section" class="d-none">
                            <div class="notice d-flex bg-light-primary rounded-3 border-primary border border-dashed mb-10 p-6 d-none" id="smtp-otp">
                                <span class="svg-icon svg-icon-muted svg-icon-2tx text-primary me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                        <rect x="11" y="17" width="7" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                                        <rect x="11" y="9" width="2" height="2" rx="1" transform="rotate(-90 11 9)" fill="currentColor"/>
                                    </svg>
                                </span>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <div class="fs-6 text-gray-700">We've e-mailed you a 6 digit security code. Please check your e-mail <span class="fst-italic fw-bolder" id="smtp-email">(sample@email.com)</span> and enter the code below to complete the verification.
                                            <div class="fw-bold pt-2">
                                                <button type="button" id="resend-code-smtp" class="btn btn-warning btn-sm resend-code" dt-option="smtp">
                                                    <span class="indicator-label" id="resend-text-smtp">
                                                        Resend code in 180
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="notice d-flex bg-light-primary rounded-3 border-primary border border-dashed mb-10 p-6 d-none" id="sms-otp">
                                <span class="svg-icon svg-icon-muted svg-icon-2tx text-primary me-4">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor"/>
                                        <rect x="11" y="17" width="7" height="2" rx="1" transform="rotate(-90 11 17)" fill="currentColor"/>
                                        <rect x="11" y="9" width="2" height="2" rx="1" transform="rotate(-90 11 9)" fill="currentColor"/>
                                    </svg>
                                </span>
                                <div class="d-flex flex-stack flex-grow-1">
                                    <div class="fw-semibold">
                                        <div class="fs-6 text-gray-700">We've sent you a 6 digit security code on your mobile number <span class="fst-italic fw-bolder" id="sms-number">(*******9123)</span>. Please check your mobile device and enter the code below to complete the verification.
                                            <div class="fw-bold pt-2">
                                                <button type="button" id="resend-code-sms" class="btn btn-warning btn-sm resend-code" dt-option="sms">
                                                    <span class="indicator-label" id="resend-text-sms">
                                                        Resend code in 180
                                                    </span>
                                                    <span class="indicator-progress">
                                                        Please wait...
                                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                                    </span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="mb-10">
                                <div class="fw-bold text-center text-dark fs-6 mb-1 ms-1">Type your 6 digit security code</div>
                                <div class="d-flex justify-content-center flex-wrap mb-5">
                                    <input type="text" name="code_1" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control h-45px w-45px h-md-60px w-md-60px fs-2qx text-center m-1 otp-flds" value="" />
                                    <input type="text" name="code_2" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control h-45px w-45px h-md-60px w-md-60px fs-2qx text-center m-1 otp-flds" value="" />
                                    <input type="text" name="code_3" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control h-45px w-45px h-md-60px w-md-60px fs-2qx text-center m-1 otp-flds" value="" />
                                    <input type="text" name="code_4" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control h-45px w-45px h-md-60px w-md-60px fs-2qx text-center m-1 otp-flds" value="" />
                                    <input type="text" name="code_5" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control h-45px w-45px h-md-60px w-md-60px fs-2qx text-center m-1 otp-flds" value="" />
                                    <input type="text" name="code_6" data-inputmask="'mask': '9', 'placeholder': ''" maxlength="1" class="form-control h-45px w-45px h-md-60px w-md-60px fs-2qx text-center m-1 otp-flds" value="" />
                                </div>
    
                                <div class="text-center">
                                    <span class="text-danger fs-8 text-center" id="otp-error"></span>
                                </div>
                            </div>

                            <div class="text-center text-muted fs-7 mb-5">
                                <span class="text-muted me-1">Problem receiving security code ?</span>

                                <a href="#" class="link-primary fw-semibold me-1" id="reselect-auth">Try another</a>
                            </div>
                            
                            <div class="text-center mt-10" id="btn-complete">
                                <button type="reset" data-bs-dismiss="modal" class="btn btn-light-danger me-3">Cancel</button>
                                <button type="submit" id="otpModal_submit" class="btn btn-success">
                                    <span class="indicator-label">
                                        Authenticate
                                    </span>
                                    <span class="indicator-progress">
                                        Please wait...
                                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span>
                                    </span>
                                </button>
                            </div>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>