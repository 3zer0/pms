<!DOCTYPE html>
<html lang="en">
	<head>
		@include('layout.header')
	</head>
	<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">
		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
        </script>
		<div class="d-flex flex-column flex-root">
			<div class="page d-flex flex-row flex-column-fluid">
				<div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
					<div id="kt_header" class="header align-items-stretch mb-5 mb-lg-10" data-kt-sticky="true" data-kt-sticky-name="header" data-kt-sticky-offset="{default: '200px', lg: '300px'}">
						<div class="container-xxl d-flex align-items-center">
							<div class="d-flex topbar align-items-center d-lg-none ms-n2 me-3" title="Show aside menu">
								<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_header_menu_mobile_toggle">
									<i class="ki-duotone ki-abstract-14 fs-1"><span class="path1"></span><span class="path2"></span>
									</i>
								</div>
							</div>
							<div class="header-logo me-5 me-md-10 flex-grow-1 flex-lg-grow-0">
								<a href="index.html">
									<img alt="Logo" src="assets/media/logos/dole-logo.png" class="logo-default h-40px" />
									<img alt="Logo" src="assets/media/logos/dole-logo.png" class="logo-sticky h-40px" />
								</a>
							</div>
							<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1">
								<div class="d-flex align-items-stretch" id="kt_header_nav">
									<div class="header-menu align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="{default:'200px', '300px': '250px'}" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_header_menu_mobile_toggle" data-kt-swapper="true" data-kt-swapper-mode="prepend" data-kt-swapper-parent="{default: '#kt_body', lg: '#kt_header_nav'}">
										<div class="menu menu-rounded menu-column menu-lg-row menu-active-bg menu-title-gray-700 menu-state-primary menu-arrow-gray-500 fw-semibold my-5 my-lg-0 align-items-stretch px-2 px-lg-0" id="#kt_header_menu" data-kt-menu="true">
											<div data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="bottom-start" class="menu-item menu-lg-down-accordion menu-sub-lg-down-indention me-0 me-lg-2">
												<span class="menu-link py-3">
													<span class="menu-title">Home</span>
													<span class="menu-arrow d-lg-none"></span>
												</span>
												<div class="menu-sub menu-sub-lg-down-accordion menu-sub-lg-dropdown px-lg-2 py-lg-4 w-lg-200px">
													<div class="menu-item">
														<a class="menu-link py-3" href="dashboard" title="" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-dismiss="click" data-bs-placement="right">
															<span class="menu-icon">
																<i class="ki-duotone ki-rocket fs-2"><span class="path1"></span><span class="path2"></span>
																</i>
															</span>
															<span class="menu-title">Dashboard</span>
														</a>
													</div>
												</div>
											</div>

                                            @include('layout.nav.nav-employee')

										</div>
									</div>
								</div>

								<div class="topbar d-flex align-items-stretch flex-shrink-0">
									{{-- <div class="d-flex align-items-center ms-1 ms-lg-3">
										<div class="position-relative btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" id="kt_drawer_chat_toggle">
											<i class="ki-duotone ki-message-text-2 fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span>
											</i>
											<span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
										</div>
									</div> --}}
									<div class="d-flex align-items-center ms-1 ms-lg-3">
										<a href="#" class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="{default:'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<i class="ki-duotone ki-night-day theme-light-show fs-1"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span>
											</i>
											<i class="ki-duotone ki-moon theme-dark-show fs-1">
												<span class="path1"></span>
												<span class="path2"></span>
											</i>
										</a>
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-night-day fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span><span class="path6"></span><span class="path7"></span><span class="path8"></span><span class="path9"></span><span class="path10"></span>
														</i>
													</span>
													<span class="menu-title">Light</span>
												</a>
											</div>
											<div class="menu-item px-3 my-0">
												<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
													<span class="menu-icon" data-kt-element="icon">
														<i class="ki-duotone ki-moon fs-2"><span class="path1"></span><span class="path2"></span>
														</i>
													</span>
													<span class="menu-title">Dark</span>
												</a>
											</div>
										</div>
									</div>

									<div class="d-flex align-items-center me-lg-n2 ms-1 ms-lg-3" id="kt_header_user_menu_toggle">
										<div class="btn btn-icon btn-active-light-primary btn-custom w-30px h-30px w-md-40px h-md-40px" data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
											<img class="h-30px w-30px rounded" src="assets/media/avatars/blank.png" alt="" />
										</div>
										<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
											<div class="menu-item px-3">
												<div class="menu-content d-flex align-items-center px-3">
													<div class="symbol symbol-50px me-5">
														<img alt="Logo" src="assets/media/avatars/blank.png" />
													</div>
													<div class="d-flex flex-column">
														<div class="fw-bold d-flex align-items-center fs-5">{{ $authUser->firstname . ' ' . $authUser->lastname }}</div>
														<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">System Administrator</a>
													</div>
												</div>
											</div>
											<div class="separator my-2"></div>
											<div class="menu-item px-5 my-1">
												<a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#passwordModal" class="menu-link px-5">Account Settings</a>
											</div>
											<div class="menu-item px-5">
												<form method="POST" action="{{ route('logout') }}">
													@csrf
													<a href="{{ route('logout') }}" onclick="event.preventDefault();
													this.closest('form').submit();" class="menu-link px-5" id="rLogout">Sign Out</a>
												</form>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					@yield('content')

					@yield('modals')

					@include('modals.change-password')

					<div class="footer py-4 d-flex flex-lg-column" id="kt_footer">
						<div class="container-xxl d-flex flex-column flex-md-row align-items-center justify-content-between">
							<div class="text-gray-900 order-2 order-md-1">
								<span class="text-muted fw-semibold me-1">2024&copy;</span>
                                Property Management System -
                                <a href="javascript:void(0);" class="text-gray-800 text-hover-primary">PMS</a>
							</div>
						</div>
					</div>

				</div>
			</div>
		</div>

		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
				<span class="path1"></span>
				<span class="path2"></span>
			</i>
		</div>

		<script>var hostUrl = "assets/";</script>
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/plugins/custom/datatables/datatables.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<script src="assets/js/widgets.bundle.js"></script>
		<script src="assets/js/custom/utils.js?{{ Str::random(12) }}"></script>
		<script src="assets/js/custom/pages/reset-password.js?{{ Str::random(12) }}"></script>
		@yield('scripts')
		@yield('extend_script')
	</body>
</html>
