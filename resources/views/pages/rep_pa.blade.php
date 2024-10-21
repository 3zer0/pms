@extends('layout.base')

@section('content')

	<div class="toolbar py-3 pb-lg-10" id="kt_toolbar">
		<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
			<div class="page-title d-flex flex-column me-3">
				<h1 class="d-flex text-white fw-bold my-1 fs-3">Property Accountability</h1>
				<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
					<li class="breadcrumb-item text-white opacity-75">
						<a href="javascript:void(0);" class="text-white text-hover-primary">Reports</a>
					</li>
					<li class="breadcrumb-item">
						<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
					</li>
					<li class="breadcrumb-item text-white opacity-75">Property Accountability</li>
				</ul>
			</div>
			{{-- <div class="d-flex align-items-center py-3 py-md-1">
				<a href="javascript:void(0);" data-bs-theme="light" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</a>
			</div> --}}
		</div>
	</div>

    <div class="toolbar pb-lg-10" id="kt_toolbar">
        <div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
            <div class="page-title d-flex row w-100">

                <!-- Category Dropdown -->
                <div class="form-group col-lg-4">
                    <label class="form-label text-white" for="filterCategory">Office/Bureau/Services</label>
                    <select class="form-select form-select-solid form-select-sm" name="office_id" data-control="select2" data-placeholder="Select" id="officeServicesItems">
                        <option value=""></option>
                        @php $offices = App\Models\Office::orderby('id', 'DESC')->get(); @endphp
                        @foreach ($offices as $office)
                            <option value="{{ $office->id }}">{{ $office->office_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label class="form-label text-white" for="filterCategory">Divsion</label>
                    <select class="form-select form-select-solid form-select-sm" name="division_id" data-control="select2" data-placeholder="Select" id="officeDivisionItems">
                        <option value=""></option>
                    </select>
                </div>
                <div class="form-group col-lg-4">
                    <label class="form-label text-white" for="filterCategory">Employee Name</label>
                    <select class="form-select form-select-solid form-select-sm" name="mr_to" id="mr_to" data-control="select2" data-placeholder="Select">
                        <option value=""></option>
                    </select>
                </div>
            </div>

            <div class="page-title d-flex me-3 my-3 row w-100">

                <!-- Date Range Filter -->
                <div class="form-group col-lg-3">
                    <label class="form-label text-white">Date Range</label>
                    <input class="form-control form-control-solid form-control-sm" placeholder="Pick date range" id="kt_daterangepicker_4"/>
                </div>

                <!-- Generate Button -->
                <div class="form-group align-self-end col-lg-2" id="paExportContainer">
                    {{-- <a href="javascript:void(0);" class="btn bg-body btn-active-color-primary" id="generateIpa">Generate</a> --}}
                    {{-- <a href="javascript:void(0);" id="resetIpa" class="btn btn-secondary">Clear</a> --}}
                    <a href="javascript:void(0);" class="btn btn-icon btn-success btn-sm" id="printBtn" data-action="gen-pa">
                        <i class="fas fa-marker text-white fs-3"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-danger btn-sm" id="printBtn" data-action="clr-pa">
                        <i class="fas fa-ban text-white fs-3"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-primary btn-sm" id="printBtn" data-action="print-pa">
                        <i class="fas fa-print text-white fs-3"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-warning btn-sm" id="excelBtnPa" data-action="dl-pa">
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
                        <table class="table align-middle table-row-bordered fs-7 gy-3" id="pa-tbl">
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
