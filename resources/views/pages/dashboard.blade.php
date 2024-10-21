@extends('layout.base')

@section('content')

	<div class="toolbar py-5 pb-lg-10" id="kt_toolbar">
		<div id="kt_toolbar_container" class="container-xxl d-flex flex-stack flex-wrap">
			<div class="page-title d-flex flex-column me-3">
				<h1 class="d-flex text-white fw-bold my-1 fs-3">Dashboard</h1>
				<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-1">
					<li class="breadcrumb-item text-white opacity-75">
						<a href="index.html" class="text-white text-hover-primary">Home</a>
					</li>
					<li class="breadcrumb-item">
						<span class="bullet bg-white opacity-75 w-5px h-2px"></span>
					</li>
					<li class="breadcrumb-item text-white opacity-75">Dashboards</li>
				</ul>
			</div>
			<div class="d-flex align-items-center py-3 py-md-1">
				<div class="me-4">
					<a href="#" class="btn btn-custom btn-active-white btn-flex btn-color-white btn-active-color-white" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
					<i class="ki-duotone ki-filter fs-5 me-1">
						<span class="path1"></span>
						<span class="path2"></span>
					</i>Filter</a>
					<div class="menu menu-sub menu-sub-dropdown w-250px w-md-300px" data-kt-menu="true" id="kt_menu_6606389eb7168">
						<div class="px-7 py-5">
							<div class="fs-5 text-gray-900 fw-bold">Filter Options</div>
						</div>
						
						<div class="separator border-gray-200"></div>
						
						<div class="px-7 py-5">
							<div class="mb-10">
								<label class="form-label fw-semibold">Status:</label>
								<div>
									<select class="form-select form-select-solid" multiple="multiple" data-kt-select2="true" data-close-on-select="false" data-placeholder="Select option" data-dropdown-parent="#kt_menu_6606389eb7168" data-allow-clear="true">
										<option></option>
										<option value="1">Approved</option>
										<option value="2">Pending</option>
										<option value="2">In Process</option>
										<option value="2">Rejected</option>
									</select>
								</div>
							</div>
							
							<div class="mb-10">
								<label class="form-label fw-semibold">Member Type:</label>
								<div class="d-flex">
									<label class="form-check form-check-sm form-check-custom form-check-solid me-5">
										<input class="form-check-input" type="checkbox" value="1" />
										<span class="form-check-label">Author</span>
									</label>
									<label class="form-check form-check-sm form-check-custom form-check-solid">
										<input class="form-check-input" type="checkbox" value="2" checked="checked" />
										<span class="form-check-label">Customer</span>
									</label>
								</div>
							</div>
							
							<div class="mb-10">
								<label class="form-label fw-semibold">Notifications:</label>
								<div class="form-check form-switch form-switch-sm form-check-custom form-check-solid">
									<input class="form-check-input" type="checkbox" value="" name="notifications" checked="checked" />
									<label class="form-check-label">Enabled</label>
								</div>
							</div>

							<div class="d-flex justify-content-end">
								<button type="reset" class="btn btn-sm btn-light btn-active-light-primary me-2" data-kt-menu-dismiss="true">Reset</button>
								<button type="submit" class="btn btn-sm btn-primary" data-kt-menu-dismiss="true">Apply</button>
							</div>
						</div>
					</div>
				</div>
				<a href="#" data-bs-theme="light" class="btn bg-body btn-active-color-primary" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button">Create</a>
			</div>
		</div>
	</div>

	<div id="kt_content_container" class="d-flex flex-column-fluid align-items-start container-xxl">
		<div class="content flex-row-fluid" id="kt_content">
			<div class="card">
				<div class="card-body">
			
				</div>
			</div>
		</div>
	</div>

@endsection