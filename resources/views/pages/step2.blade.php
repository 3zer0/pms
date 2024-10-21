<div class="alert alert-dismissible bg-light-info d-flex flex-column align-items-center flex-sm-row px-4 py-3 mb-3">
    <i class="ki-duotone ki-information-4 fs-2hx text-info me-4 mb-5 mb-sm-0"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
    <div class="d-flex flex-column pe-0 pe-sm-10">
        <span class="fw-bold fs-6">Local Chapters/Affiliate Union</span>
    </div>
</div>

<div id="kt_docs_repeater_basic">
    <div class="form-group">
        <div data-repeater-list="data">
            <div data-repeater-item>
                <div class="border border-dashed border-gray-300 rounded mb-3 px-5 py-3">
                    <div class="text-end mb-3">
                        <a href="javascript:;" data-repeater-delete class="btn btn-sm btn-light-danger">
                            <i class="ki-duotone ki-trash fs-5"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i>
                            Remove
                        </a>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="fv-row mb-3">
                                <label class="form-label required fs-7">Name</label>
                                <input type="text" class="form-control form-control-lg form-control-solid fs-6 mb-2 mb-md-0 lca-names" name="lca_name" placeholder="" />
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="fv-row mb-3">
                                <label class="form-label required fs-7">Bargaining Unit Being Represented</label>
                                <select class="form-select form-select-lg form-select-solid fs-7" name="lca_bargain">
                                    <option value="">-- select --</option>
                                    <option value="RANK-AND-FILE">Rank-and-file</option>
                                    <option value="SUPERVISORY">Supervisory</option>
                                    <option value="BOTH">Rank-and-file and Supervisory</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="fv-row mb-3">
                        <label class="form-label required fs-7">Address</label>
                        <textarea type="text" class="form-control form-control-lg form-control-solid fs-6 mb-2 mb-md-0" name="lca_address" placeholder=""></textarea>
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="fv-row mb-3">
                                <label class="form-label required fs-7">No. of Members</label>
                                <input type="text" class="form-control form-control-lg form-control-solid fs-6 mb-2 mb-md-0" name="lca_no_members" placeholder="" oninput="this.value = this.value.replace(/[^0-9.]/g, '');"/>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="fv-row mb-3">
                                <label class="form-label required fs-7">Certified Bargaining Agent as of</label>
                                <input type="date" class="form-control form-control-lg form-control-solid fs-6 mb-2 mb-md-0" name="lca_certified" placeholder="" />
                            </div>
                        </div>
                    </div>


                    <div class="d-flex align-items-center flex-wrap gap-5">
                        <label class="form-label required fs-7 mt-2">With CBA <span class="fst-italic fs-8">(Registered?)</span></label>
                        <div class="fv-row d-flex">
                            <div class="form-check form-check-custom form-check-solid form-check-sm">
                                <input class="form-check-input registered" type="radio" value="Yes" name="lca_with_cba" id="cba_yes"/>
                                <label class="form-check-label text-gray-800 fw-semibold" for="cba_yes">
                                    Yes
                                </label>
                            </div>
                            <div class="form-check form-check-custom form-check-solid form-check-sm ms-5">
                                <input class="form-check-input registered" type="radio" value="No" name="lca_with_cba" id="cba_no"/>
                                <label class="form-check-label text-gray-800 fw-semibold" for="cba_no">
                                    No
                                </label>
                            </div>
                        </div>
                        <div class="row d-none ms-3" data-cba-fields="0">
                            <div class="col-lg-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label required fs-7">CBA Duration From</label>
                                    <input type="date" class="form-control form-control-lg form-control-solid fs-6 mb-2 mb-md-0" name="lca_cba_duration_from" placeholder="" />
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="fv-row mb-3">
                                    <label class="form-label required fs-7">CBA Duration To</label>
                                    <input type="date" class="form-control form-control-lg form-control-solid fs-6 mb-2 mb-md-0" name="lca_cba_duration_to" placeholder="" />
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>

    <div class="form-group text-center mt-5">
        <a href="javascript:;" data-repeater-create class="btn btn-light-primary">
            <i class="ki-duotone ki-plus fs-3"></i>
            Add New Local Chapters/Affiliate
        </a>
    </div>
</div>
