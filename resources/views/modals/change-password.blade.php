
<div class="modal fade" id="passwordModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered mw-500px">
        <div class="modal-content">
            <form id="passwordForm" action="{{ route('user.edit', [ 'id' => $authUser->id ]) }}">
                <div class="modal-body">
                    @csrf
                    <div class="px-5 pt-3">
                        <div class="notice d-flex bg-light-warning rounded border-warning border border-dashed mb-5 p-2">
                            <i class="ki-duotone ki-information fs-2x text-warning ms-1 me-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                            <div class="d-flex flex-stack flex-grow-1 mb-0">
                                <div class="fw-semibold">
                                    <div class="fs-6 text-gray-900 fw-bold">IMPORTANT</div>
                                    <div class="fs-7 text-gray-700 ">
                                        <ul class="mb-0 px-2">
                                            <li class="required">Denotes required field</li>
                                            <li>Use atleast 8 characters length, 1 upper case letter, 1 lower case letter, 1 special character (!@#$&*) and number</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex align-items-center bg-light rounded mb-3 p-3">
                            <i class="ki-duotone ki-security-user fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                            <div class="text-gray-900 fw-bold fs-6">Reset Password </div>
                        </div>

                        <div class="fv-row mb-5" id="reset-employee-password">
                            <div class="form-floating position-relative mb-2">
                                <input type="password" class="form-control form-control-solid" id="newPassword" name="password" placeholder="Enter password" autocomplete="off"/>
                                <label for="newPassword" class="text-gray-700 required">Password</label>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                            <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                                <div class="flex-grow-1 bg-light bg-active-danger rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-light bg-active-warning rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-light bg-active-warning rounded h-5px me-2"></div>
                                <div class="flex-grow-1 bg-light bg-active-success rounded h-5px"></div>
                            </div>
                        </div>

                        <div class="fv-row mb-5">
                            <div class="form-floating position-relative" data-kt-password-meter="true">
                                <input type="password" class="form-control form-control-solid" id="confirmPassword" name="password_confirmation" placeholder="Enter confirm password" autocomplete="off"/>
                                <label for="confirmPassword" class="text-gray-700 required">Confirm Password</label>
                                <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                    data-kt-password-meter-control="visibility">
                                    <i class="bi bi-eye-slash fs-2"></i>
                                    <i class="bi bi-eye fs-2 d-none"></i>
                                </span>
                            </div>
                        </div>

                        <div class="text-center mb-3">
                            <button type="submit" class="btn btn-primary me-1">
                                <span class="indicator-label">Save Password</span>
                                <span class="indicator-progress">Please wait...
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                            </button>
                            <button type="button" data-bs-dismiss="modal" class="btn btn-light-danger me-3">Close</button>
                        </div>

                    </div>
                </div>
            </form>
        </div>
    </div>
</div>