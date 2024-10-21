
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-4" id="editUserModal_header">
                <h4>User Employee</h4>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <form id="editUserForm">
                <div class="modal-body px-9 py-3">
                    <div class="text-end required fst-italic fs-7 mb-3">Denotes required field</div>
                    @csrf
                    <div class="scroll-y me-n7 pe-7" id="editUserModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="600px" data-kt-scroll-dependencies="#editUserModal_header" data-kt-scroll-wrappers="#editUserModal_scroll">
                        <div class="row">
                            <div class="col-lg-7">

                                <div class="pe-5">
                                    <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                        <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        <div class="text-gray-900 fw-bold fs-6">User Information </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="firstname" id="eFirstName" placeholder=""/>
                                                    <label for="eFirstName" class="required">Firstname</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="lastname" id="eLastName" placeholder=""/>
                                                    <label for="eLastName" class="required">Lastname</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fv-row mb-5">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-solid" name="designate" id="eDesigNate" placeholder=""/>
                                            <label for="eDesigNate" class="required">Position</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control form-control-solid" name="email" id="eEmailAddress" placeholder=""/>
                                                    <label for="eEmailAddress" class="required">Email Address</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="mobile_no" id="eMobileNo" placeholder=""/>
                                                    <label for="eMobileNo" class="required">Mobile No.</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fv-row mb-5">
                                        <div class="form-floating">
                                            <select class="form-select form-select-solid form-select-sm" name="division_id" data-control="select2" data-hide-search="true" data-placeholder="Select" id="eDivision">
                                                <option value=""></option>
                                                @php $division = App\Models\Division::where('office_id', 25)->get([ 'id', 'division_name' ]); @endphp
                                                @foreach ($division as $d)
                                                    <option value="{{ $d->id }}">{{ $d->division_name }}</option>
                                                @endforeach
                                            </select>
                                            <label for="eDivision">Division <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-lg-5">

                                <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                    <i class="ki-duotone ki-key-square fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                    <div class="text-gray-900 fw-bold fs-6">Security Details </div>
                                </div>

                                <!-- User Account -->
                                <div class="fv-row mb-5">
                                    <div class="form-floating">
                                        <input type="text" class="form-control form-control-solid" name="username" id="eUserName" placeholder="" disabled/>
                                        <label for="eUserName" class="required">Username</label>
                                    </div>
                                </div>

                                <div class="fv-row mb-2" id="e-employee-password">
                                    <div class="form-floating position-relative mb-2">
                                        <input type="password" class="form-control form-control-solid" id="eNewPassword" name="password" placeholder="Enter password" autocomplete="off"/>
                                        <label for="eNewPassword" class="text-gray-700 required">Password</label>
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
                                        <input type="password" class="form-control form-control-solid" id="eConfirmPassword" name="password_confirmation" placeholder="Enter confirm password" autocomplete="off"/>
                                        <label for="eConfirmPassword" class="text-gray-700 required">Confirm Password</label>
                                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
                                            data-kt-password-meter-control="visibility">
                                            <i class="bi bi-eye-slash fs-2"></i>
                                            <i class="bi bi-eye fs-2 d-none"></i>
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <div id="account-settings" class="mb-5">
                            <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                <i class="ki-duotone ki-security-user fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span></i>
                                <div class="text-gray-900 fw-bold fs-6">Account Settings </div>
                            </div>

                            <div class="px-1">
                                <div class="row mb-5">
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fw-semibold fs-7">
                                            <span>User Management</span>
                                            <span class="ms-1 mt-1" data-bs-toggle="tooltip" title="Grant access to user records">
                                                <i class="ki-duotone ki-question fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                    <input class="form-check-input" name="user_view" value="1" type="checkbox" id="eViewUser" checked/>
                                                    <label class="form-check-label" for="eViewUser">
                                                        <div class="fs-7 text-gray-800">View</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                    <input class="form-check-input" name="user_add" value="1" type="checkbox" id="eAddUser"/>
                                                    <label class="form-check-label" for="eAddUser">
                                                        <div class="fs-7 text-gray-800">Add</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                    <input class="form-check-input" name="user_edit" value="1" type="checkbox" id="eEditUser"/>
                                                    <label class="form-check-label" for="eEditUser">
                                                        <div class="fs-7 text-gray-800">Update</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm form-check-danger">
                                                    <input class="form-check-input" name="user_delete" value="1" type="checkbox" id="eDeleteUser"/>
                                                    <label class="form-check-label" for="eDeleteUser">
                                                        <div class="fs-7 text-gray-800">Delete</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="px-1">
                                <div class="row mb-5">
                                    <div class="col-lg-4">
                                        <label class="d-flex align-items-center fw-semibold fs-7">
                                            <span>Supply Management</span>
                                            <span class="ms-1 mt-1" data-bs-toggle="tooltip" title="Grant access to supplier records">
                                                <i class="ki-duotone ki-question fs-3"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            </span>
                                        </label>
                                    </div>
                                    <div class="col-lg-8">
                                        <div class="d-flex flex-wrap gap-3">
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                    <input class="form-check-input" name="supplier_view" value="1" type="checkbox" id="viewSupplier"/>
                                                    <label class="form-check-label" for="viewSupplier">
                                                        <div class="fs-7 text-gray-800">View</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                    <input class="form-check-input" name="supplier_add" value="1" type="checkbox" id="adSupplierr"/>
                                                    <label class="form-check-label" for="addSupplier">
                                                        <div class="fs-7 text-gray-800">Add</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm">
                                                    <input class="form-check-input" name="supplier_edit" value="1" type="checkbox" id="editSupplier"/>
                                                    <label class="form-check-label" for="editSupplier">
                                                        <div class="fs-7 text-gray-800">Update</div>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="fv-row">
                                                <div class="form-check form-check-custom form-check-solid form-check-sm form-check-danger">
                                                    <input class="form-check-input" name="supplier_delete" value="1" type="checkbox" id="deleteSupplier"/>
                                                    <label class="form-check-label" for="deleteSupplier">
                                                        <div class="fs-7 text-gray-800">Delete</div>
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="modal-footer flex-center">
                    <button type="submit" class="btn btn-primary">
                        <span class="indicator-label">Submit</span>
                        <span class="indicator-progress">Please wait...
                        <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                    </button>
                    <button type="button" data-bs-dismiss="modal" class="btn btn-light-danger me-3">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
