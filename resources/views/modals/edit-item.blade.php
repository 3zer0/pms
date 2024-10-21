
<div class="modal fade" id="editItemModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false" data-bs-focus="false">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header pb-4" id="editItemModal_header">
                <h4>Edit Item</h4>
                <div class="btn btn-sm btn-icon btn-active-color-primary" data-bs-dismiss="modal">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
            </div>
            <div id="kt_docs_repeater_basic">
                <form id="editItemForm">
                    <div class="modal-body px-9 py-3">
                        <div class="text-end required fst-italic fs-7 mb-3">Denotes required field</div>
                        @csrf
                            <div class="scroll-y me-n7 pe-7" id="editItemModal_scroll" data-kt-scroll="true" data-kt-scroll-activate="{default: false, lg: true}" data-kt-scroll-max-height="600px" data-kt-scroll-dependencies="#editItemModal_header" data-kt-scroll-wrappers="#editItemModal_scroll">
                                <div class="row">
                                    <div class="col-lg-12">

                                        <div class="pe-5">
                                            <div class="d-flex align-items-center bg-light rounded mb-5 p-3">
                                                <i class="ki-duotone ki-user-edit fs-1 mx-3 text-primary"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                                                <div class="text-gray-900 fw-bold fs-6">Item Information </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-lg-3">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <input type="text" class="form-control form-control-solid" name="ref_no" id="ref_no" disabled/>
                                                            <label for="ref_no" class="required">Reference No.</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-3">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="unit_of_measure" data-hide-search="true" data-placeholder="Select" id="unit_of_measure">
                                                                <option value=""></option>
                                                                <option value="Piece">Piece</option>
                                                                <option value="Set">Set</option>
                                                                <option value="Lot">Lot</option>
                                                            </select>
                                                            <label for="unit_of_measure">Unit of Measurement <span class="text-danger">*</span></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
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
                                                <div class="col-lg-3">
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
                                                            <input type="text" class="form-control form-control-solid" name="purchase_price" id="purchase_price" placeholder=""/>
                                                            <label for="purchase_price" class="required">Purchase Price</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div class="fv-row mb-5">
                                                        <div class="form-floating">
                                                            <select class="form-select form-select-solid form-select-sm" name="category_id" data-control="select2" data-placeholder="Select" id="category_id">
                                                                <option value=""></option>
                                                                @php $category = App\Models\Category::get([ 'id', 'category_name' ]); @endphp
                                                                @foreach ($category as $d)
                                                                    <option value="{{ $d->id }}">{{ $d->category_name }}</option>
                                                                @endforeach
                                                            </select>
                                                            <label for="category_id">Category <span class="text-danger">*</span></label>
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
</div>
