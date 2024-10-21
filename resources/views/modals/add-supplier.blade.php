
<div class="modal fade" id="supplierModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-4" id="supplierModal_header">
                <h4>Supplier</h4>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <form id="supplierForm" action="{{ route('supplier.create') }}">
                <div class="modal-body px-9 py-3">
                    <div class="text-end required fst-italic fs-7 mb-3">Denotes required field</div>
                    @csrf
                    <div class="scroll-y me-n7 pe-7" id="supplierModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="600px" data-kt-scroll-dependencies="#supplierModal_header" data-kt-scroll-wrappers="#supplierModal_scroll">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="pe-5">
                                    <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                        <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        <div class="text-gray-900 fw-bold fs-6">Supplier Information </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="supplier_name" id="supplier_name" placeholder=""/>
                                                    <label for="supplier_name" class="required">Name</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="fv-row mb-5">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-solid" name="supplier_address" id="supplier_address" placeholder=""/>
                                            <label for="supplier_address" class="required">Address</label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="supplier_mobile_no" id="supplier_mobile_no" placeholder=""/>
                                                    <label for="supplier_mobile_no" class="required">Mobile No.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="email" class="form-control form-control-solid" name="supplier_email" id="supplier_email" placeholder=""/>
                                                    <label for="supplier_email" class="required">Email Address</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="supplier_tin" id="supplier_tin" placeholder=""/>
                                                    <label for="supplier_tin" class="required">Tax Identification No.</label>
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
