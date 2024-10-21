@extends('layout.base')

@section('content')

	<div class="toolbar py-5 pb-lg-10" id="kt_toolbar">
		<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
			<div class="page-title d-flex flex-column me-3">
				<h1 class="d-flex text-white fw-bold my-1 fs-3">Item List</h1>
				<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
					<li class="breadcrumb-item text-white opacity-75">
						<a href="javascript:void(0);" class="text-white text-hover-primary">Task</a>
					</li>
					<li class="breadcrumb-item">
						<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
					</li>
					<li class="breadcrumb-item text-white opacity-75">Item List</li>
				</ul>
			</div>
			<div class="d-flex align-items-center py-3 py-md-1">
				<a href="javascript:void(0);" data-bs-theme="light" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#addItemModal">Add Item</a>
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
                        <table class="table align-middle table-row-bordered fs-7 gy-3" id="item-tbl">
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
	@include('modals.edit-delivery') --}}
	@include('modals.add-item')
	@include('modals.edit-item')
	@include('modals.additional-item')
	@include('modals.add-article')
	@include('modals.add-ptr')
@endsection

@section('scripts')
    <script src="assets/plugins/custom/formrepeater/formrepeater.bundle.js"></script>
    <script src="assets/js/custom/pages/admin/items-dt.js?{{ Str::random(12) }}"></script>
@endsection
