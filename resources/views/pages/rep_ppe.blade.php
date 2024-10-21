@extends('layout.base')

@section('content')

	<div class="toolbar py-3 pb-lg-10" id="kt_toolbar">
		<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
			<div class="page-title d-flex flex-column me-3">
				<h1 class="d-flex text-white fw-bold my-1 fs-3">Report on the Physical Count of Property, Plant and Equipment (RCPPPE)</h1>
				<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
					<li class="breadcrumb-item text-white opacity-75">
						<a href="javascript:void(0);" class="text-white text-hover-primary">Reports</a>
					</li>
					<li class="breadcrumb-item">
						<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
					</li>
					<li class="breadcrumb-item text-white opacity-75">RPCPPE</li>
				</ul>
			</div>
			{{-- <div class="d-flex align-items-center py-3 py-md-1">
				<a href="javascript:void(0);" data-bs-theme="light" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</a>
			</div> --}}
		</div>
	</div>

    <div class="toolbar pb-lg-10" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex me-3 row w-100">

                <!-- Category Dropdown -->
                <div class="form-group me-3 col-lg-6">
                    <label class="form-label text-white" for="filterCategory">Category</label>
                    <select class="form-select form-select-solid" name="category_id" data-control="select2" data-placeholder="Select" id="category_id">
                        <option value=""></option>
                        @php
                            $category = App\Models\Category::where('type', 'PAR')->get(['id', 'category_name', 'type']);
                        @endphp
                        @foreach ($category as $d)
                            <option value="{{ $d->id }}" data-type="{{ $d->type }}">{{ $d->category_name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date Range Filter -->
                <div class="form-group me-3 col-lg-3">
                    <label class="form-label text-white">Date Range</label>
                    <input class="form-control form-control-solid" placeholder="Pick date range" id="kt_daterangepicker_4"/>
                </div>

                <!-- Generate Button -->
                <div class="form-group me-3 align-self-end col-lg-2" id="ipaExportContainer">
                    {{-- <a href="javascript:void(0);" class="btn bg-body btn-active-color-primary" id="generateIpa">Generate</a> --}}
                    {{-- <a href="javascript:void(0);" id="resetIpa" class="btn btn-secondary">Clear</a> --}}
                    <a href="javascript:void(0);" class="btn btn-icon btn-success" id="genBtnPpe" data-action="gen-ppe">
                        <i class="fas fa-marker text-white fs-3"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-danger" id="clrBtnPpe" data-action="clr-ppe">
                        <i class="fas fa-ban text-white fs-3"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-primary" id="printBtnPpe" data-action="print-ppe">
                        <i class="fas fa-print text-white fs-3"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-warning" id="excelBtnPpe" data-action="dl-ppe">
                        <i class="fas fa-download text-white fs-3"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>


	<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
		<div class="content flex-row-fluid" id="kt_content">
			<div class="card">
				<div class="card-body">
                    <div class="card-header border-0 p-0">
                        <div class="card-toolbar">
                            <div class="d-flex align-items-center position-relative w-100 m-0">
                                <i class="ki-duotone ki-magnifier fs-3 text-gray-500 position-absolute top-50 ms-5 translate-middle-y"><span class="path1"></span><span class="path2"></span></i>
                                <input type="text" data-dt-filter="search" class="form-control form-control-solid w-350px ps-14" name="search" value="" placeholder="Search...">
                            </div>
                        </div>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-middle table-row-bordered fs-7 gy-3" id="ppe-tbl">
                            <thead class="text-start text-gray-400 fw-semibold text-uppercase gs-0"></thead>
                        </table>
                    </div>
				</div>
			</div>
		</div>
	</div>

@endsection

@section('modals')
	{{-- @include('modals.add-delivery')
	@include('modals.edit-delivery')
	@include('modals.add-item')
	@include('modals.edit-item')
	@include('modals.additional-item')
	@include('modals.add-article')
	@include('modals.add-ptr') --}}
@endsection

@section('scripts')
    <script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="assets/js/custom/pages/admin/reports-dt.js?{{ Str::random(12) }}"></script>
@endsection
