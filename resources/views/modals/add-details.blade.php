
<div class="modal fade" id="detailModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-4" id="detailModal_header">
                <h4>Delivery</h4>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>

            <form id="detailForm" action="{{ route('item.create') }}">
                <div class="modal-body px-9 py-3">
                    <div class="text-end required fst-italic fs-7 mb-3">Denotes required field</div>
                    @csrf
                    <div class="scroll-y me-n7 pe-7" id="deliveryModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="600px" data-kt-scroll-dependencies="#deliveryModal_header" data-kt-scroll-wrappers="#deliveryModal_scroll">
                        <div class="row">
                            <div class="col-lg-12">

                                <div class="pe-5">
                                    <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                        <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                        <div class="text-gray-900 fw-bold fs-6">Detail Information </div>
                                    </div>

                                    <div class="fv-row mb-5">
                                        <div class="form-floating">
                                            <select class="form-select form-select-solid form-select-sm" name="property_no" data-control="select2" data-placeholder="Select" id="property_no">
                                                <option value=""></option>
                                                @php $detail = App\Models\Item::get([ 'id', 'property_no' ]); @endphp
                                                @foreach ($detail as $d)
                                                    <option value="{{ $d->id }}">{{ $d->property_no }}</option>
                                                @endforeach
                                            </select>
                                            <label for="property_no">Property No. <span class="text-danger">*</span></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="invoice_no" id="invoice_no" placeholder=""/>
                                                    <label for="invoice_no" class="required">Invoice No.</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="date" class="form-control form-control-solid" name="invoice_date" id="invoice_date" placeholder=""/>
                                                    <label for="invoice_date" class="required">Invoice Date</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-lg-3">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="del_quantity" id="del_quantity" placeholder=""/>
                                                    <label for="del_quantity" class="required">Quantity</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <input type="text" class="form-control form-control-solid" name="pojo" id="pojo" placeholder=""/>
                                                    <label for="pojo" class="required">PO/JO</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                            <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                            <div class="text-gray-900 fw-bold fs-6">Requesting Office Information </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <select class="form-select form-select-solid form-select-sm" name="office_id" data-control="select2" data-placeholder="Select" id="officeServices">
                                                        <option value=""></option>
                                                        @php $offices = App\Models\Office::orderby('id', 'DESC')->get(); @endphp
                                                        @foreach ($offices as $office)
                                                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <label for="officeServices">Office/Bureau/Services <span class="text-danger">*</span></label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="fv-row mb-5">
                                                <div class="form-floating">
                                                    <select class="form-select form-select-solid form-select-sm" name="division_id" data-control="select2" data-placeholder="Select" id="officeDivision">
                                                        <option value=""></option>
                                                    </select>
                                                    <label for="officeDivision">Divsion <span class="text-danger">*</span></label>
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
