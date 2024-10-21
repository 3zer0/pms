
<div class="modal fade" id="itrModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header pb-4" id="itrModal_header">
                <h4>Inventory Transfer Report</h4>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div id="kt_docs_repeater_basic">
                <form id="itrForm" action="{{ route('itr.create') }}">
                {{-- <form id="itemForm"> --}}
                    <div class="modal-body px-9 py-3">
                        <div class="text-end required fst-italic fs-7 mb-3">Denotes required field</div>
                        @csrf
                        {{-- <div class="border border-dashed border-gray-300 rounded mb-3 px-5 py-3"> --}}
                            <div class="scroll-y me-n7 pe-7" id="itrModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="600px" data-kt-scroll-dependencies="#ptrModal_header" data-kt-scroll-wrappers="#itrModal_scroll">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="pe-5">
                                            <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                                <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <div class="text-gray-900 fw-bold fs-6">ITR Information </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="transfer_type" data-control="select2" data-hide-search="true" data-placeholder="Select" id="transfer_type">
                                                                <option value=""></option>
                                                                <option value="Relocate">Relocate</option>
                                                                <option value="Donate">Donate</option>
                                                                <option value="Reassign">Reassign</option>
                                                                <option value="Others">Others</option>
                                                            </select>
                                                            <label for="transfer_type">Transfer Type <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
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

                                            <div class="row">
                                                <div class="col-lg-3" id="sn">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            {{-- <input type="text" class="form-control form-control-solid" name="rec_by" id="rec_by" placeholder=""/>
                                                             --}}
                                                            <select class="form-select form-select-solid form-select-sm" name="rec_by" id="rec_by" data-control="select2" data-placeholder="Select">
                                                                <option value=""></option>
                                                            </select>
                                                            <label for="rec_by" class="required">Received by</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-9">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control form-control-solid" name="trans_reason" id="trans_reason" placeholder=""/>
                                                            <label for="trans_reason">Reason for Transfer <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="row mb-5">
                                    <div class="col-lg-12">
                                        <div class="pe-5">
                                            <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                                <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <div class="text-gray-900 fw-bold fs-6">Details</div>
                                            </div>

                                            <div id="pr_rptr">
                                                <div class="form-group">
                                                    <div>
                                                        <div>
                                                            <div class="border border-dashed border-gray-300 rounded mb-3 px-5 py-3">


                                                                <div class="row">

                                                                    <div class="col-lg-8">
                                                                        <div class="fv-row mb-5">
                                                                            <div class="form-floating">

                                                                                <select class="form-select form-select-solid form-select-sm pr_no" name="property_no" id="property_no_itr">
                                                                                    <option value=""></option>
                                                                                    @php
                                                                                        $property = App\Models\Item::where('ptr', 0)
                                                                                                                    ->join('deliveries', 'items.delivery_id', '=', 'deliveries.id')
                                                                                                                    ->where('accountability_type', 'ICS')
                                                                                                                    ->get(['items.id', 'property_no', 'purchase_price', 'description', 'invoice_date', 'accountability_no']);
                                                                                    @endphp
                                                                                    {{-- @foreach ($property as $d)
                                                                                        <option value="{{ $d->id }}"
                                                                                            data-price="₱{{ number_format($d->purchase_price, 2) }}"
                                                                                            data-description="{{ $d->description }}"
                                                                                            data-date="{{ $d->invoice_date }}"
                                                                                            data-ics="{{ $d->accountability_no }}">
                                                                                            {{ $d->property_no }}
                                                                                        </option>
                                                                                    @endforeach --}}

                                                                                    @foreach ($property as $d)
                                                                                        <option value="{{ $d->id }}"
                                                                                                data-price="₱{{ number_format($d->purchase_price, 2) }}"
                                                                                                data-description="{{ $d->description }}"
                                                                                                data-date="{{ $d->invoice_date }}"
                                                                                                data-ics="{{ explode('-', $d->accountability_no, 2)[1] ?? $d->accountability_no }}">
                                                                                            {{ $d->property_no }}
                                                                                        </option>
                                                                                    @endforeach

                                                                                </select>

                                                                                <label for="property_no">Property No. <span class="text-danger">*</span></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-3">
                                                                        <div class="fv-row mb-5">
                                                                            <div class="form-floating">
                                                                                <select class="form-select form-select-solid form-select-sm ppe_condition" name="ppe_condition" data-hide-search="true" data-placeholder="Select" id="ppe_condition_itr">
                                                                                    <option value=""></option>
                                                                                    <option value="Brand New">Brand New</option>
                                                                                    <option value="Good">Good</option>
                                                                                    <option value="Fair">Fair</option>
                                                                                    <option value="Poor">Poor</option>
                                                                                    <option value="Scrap">Scrap</option>
                                                                                </select>
                                                                                <label for="ppe_condition">Condition of PPE <span class="text-danger">*</span></label>
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="col-lg-1 d-flex align-items-center justify-content-center pb-4">
                                                                        <a href="javascript:;" class="btn btn-light-primary d-flex align-items-center" data-action="add-eqpt-itr">
                                                                            <i class="ki-duotone ki-plus fs-5 me-2 text-primary"></i> Add
                                                                        </a>
                                                                    </div>


                                                                </div>

                                                                <div class="table-responsive">
                                                                    <table class="table table-row-bordered" id="tbl-itr">
                                                                        <thead>
                                                                            <tr class="fw-bold fs-6 text-gray-800">
                                                                                <th>Date Acquired</th>
                                                                                <th>Item No.</th>
                                                                                <th>ICS No./Date</th>
                                                                                <th>Desccription</th>
                                                                                <th>Purchase Price</th>
                                                                                <th>Condition of PPE</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        </tbody>
                                                                    </table>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        {{-- </div> --}}
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
</div>
