
<div class="modal fade" id="itemModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-4" id="itemModal_header">
                <h4>Add Item</h4>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div id="kt_docs_repeater_basic">
                <form id="itemForm" action="{{ route('item.create') }}">
                {{-- <form id="itemForm"> --}}
                    <div class="modal-body px-9 py-3">
                        <div class="text-end required fst-italic fs-7 mb-3">Denotes required field</div>
                        @csrf
                        {{-- <div class="border border-dashed border-gray-300 rounded mb-3 px-5 py-3"> --}}
                            <div class="scroll-y me-n7 pe-7" id="itemModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="600px" data-kt-scroll-dependencies="#itemModal_header" data-kt-scroll-wrappers="#itemModal_scroll">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="pe-5">
                                            <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                                <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <div class="text-gray-900 fw-bold fs-6">Item Information </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="unit_of_measure" data-hide-search="true" data-placeholder="Select" id="unit_of_measure">
                                                                <option value=""></option>
                                                                <option value="Piece">Piece</option>
                                                                <option value="Set">Set</option>
                                                                <option value="Lot">Lot</option>
                                                                <option value="Unit">Unit</option>
                                                            </select>
                                                            <label for="unit_of_measure">Unit of Measurement <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="article_id" data-control="select2" data-placeholder="Select" id="article_id">
                                                                <option value=""></option>
                                                                @php $article = App\Models\Article::get([ 'id', 'article_name' ]); @endphp
                                                                @foreach ($article as $d)
                                                                    <option value="{{ $d->id }}">{{ $d->article_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for="article_id">Article <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <textarea type="text" class="form-control form-control-solid" name="description" id="description" placeholder=""></textarea>
                                                            <label for="description" class="required">Description</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="category_id" data-control="select2" data-placeholder="Select" id="category_id">
                                                                <option value=""></option>
                                                                @php $category = App\Models\Category::get([ 'id', 'category_name', 'type' ]); @endphp
                                                                @foreach ($category as $d)
                                                                    <option value="{{ $d->id }}" data-type="{{ $d->type }}">{{ $d->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for="category_id">Category <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control form-control-solid" name="purchase_price" id="purchase_price" placeholder=""/>
                                                            <label for="purchase_price" class="required">Purchase Price</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3 d-none" id="sn">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control form-control-solid" name="serial_no" id="serial_no" placeholder=""/>
                                                            <label for="serial_no" class="required">Serial No.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="status" data-hide-search="true" data-placeholder="Select" id="status">
                                                                <option value=""></option>
                                                                <option value="Serviceable">Serviceable</option>
                                                                <option value="Unserviceable">Unserviceable</option>
                                                                <option value="Donated">Donated</option>
                                                                <option value="Disposed">Disposed</option>
                                                                <option value="Unlocated">Unlocated</option>
                                                                <option value="Lost">Lost</option>
                                                                <option value="Stolen">Stolen</option>
                                                                <option value="For Repair">For Repair</option>
                                                                <option value="Returned">Returned</option>
                                                            </select>
                                                            <label for="status">Status <span class="text-danger">*</span></label>
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
                                                            <select class="form-select form-select-solid form-select-sm" name="office_id" data-control="select2" data-placeholder="Select" id="officeServicesItems">
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
                                                            <select class="form-select form-select-solid form-select-sm" name="division_id" data-control="select2" data-placeholder="Select" id="officeDivisionItems">
                                                                <option value=""></option>
                                                            </select>
                                                            <label for="officeDivision">Divsion <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="mr_to" id="mr_to" data-control="select2" data-placeholder="Select">
                                                                <option value=""></option>
                                                            </select>
                                                            {{-- <input type="text" class="form-control form-control-solid" name="mr_to" id="mr_to" placeholder=""/> --}}
                                                            <label for="mr_to">PAR to <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control form-control-solid" name="ass_to" id="ass_to" placeholder=""/>
                                                            <label for="ass_to">Assigned to</label>
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

                    {{-- <div class="form-group text-center mb-5">
                        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
                            <i class="ki-duotone ki-plus fs-3"></i>
                            Add New Item
                        </a>
                    </div> --}}

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
