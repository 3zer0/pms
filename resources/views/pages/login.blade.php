<!DOCTYPE html>
<html lang="en">
	<head>
		@include('layout.header')
	</head>

	<body id="kt_body" class="app-blank auth-bg bgi-size-cover bgi-attachment-fixed bgi-position-center bgi-no-repeat">

		<script>var defaultThemeMode = "light"; var themeMode; if ( document.documentElement ) { if ( document.documentElement.hasAttribute("data-bs-theme-mode")) { themeMode = document.documentElement.getAttribute("data-bs-theme-mode"); } else { if ( localStorage.getItem("data-bs-theme") !== null ) { themeMode = localStorage.getItem("data-bs-theme"); } else { themeMode = defaultThemeMode; } } if (themeMode === "system") { themeMode = window.matchMedia("(prefers-color-scheme: dark)").matches ? "dark" : "light"; } document.documentElement.setAttribute("data-bs-theme", themeMode); }
        </script>

		<div class="d-flex flex-root h-100">
			<style>body { background-image: url('assets/media/auth/sample-bg.png'); } [data-bs-theme="dark"] body { background-image: url('assets/media/auth/sample-bg.png'); }</style>

			<div class="d-flex flex-center w-100">
				<div class="bg-body d-flex flex-column align-items-stretch flex-center rounded-4 p-10 p-lg-13 w-lg-550px">
					<div class="d-flex flex-center flex-column flex-column-fluid px-lg-8">
						<form class="form w-100" novalidate="novalidate" id="loginForm">
							@csrf

							<div class="d-flex flex-center pt-8 pt-lg-3 mb-8">
								<div class="d-flex flex-center flex-column text-center">
									<a href="javascript:void(0);" class="mb-4">
										<img alt="Logo" class="w-70px h-60px mx-2" src="assets/media/logos/dole-logo.png" />
										<img alt="Logo" class="w-75px h-65px mx-2" src="assets/media/logos/bagong-pilipinas.png" />
									</a>
									<h3 class="text-gray-800 fw-normal m-0">Property Management System</h3>
								</div>
							</div>

							<div class="text-center mb-5">
								<h2 class="text-gray-900 fw-bolder mb-3">Sign In</h2>
								<div class="text-gray-500 fw-semibold fs-6">Start your session here</div>
							</div>

							<div class="separator separator-content my-12">
								<span class="w-200px text-gray-500 fw-semibold fs-7">Administrator Login</span>
							</div>

							<div class="fv-row form-floating mb-5">
								<input type="text" class="form-control" id="floatingInputEN" name="username" placeholder=""/>
								<label for="floatingInputEN" class="text-gray-700">Username</label>
							</div>

							<div class="fv-row form-floating position-relative mb-3" data-kt-password-meter="true">
								<input type="password" class="form-control" id="floatingInputPW" name="password" placeholder="Enter password" autocomplete="off"/>
								<label for="floatingInputPW" class="text-gray-700">Password</label>
								<span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2"
									data-kt-password-meter-control="visibility">
									<i class="bi bi-eye-slash fs-2"></i>
									<i class="bi bi-eye fs-2 d-none"></i>
								</span>
							</div>

							<div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-5">
								<div></div>
								<a href="javascript:void(0);" data-action="forgot-password" class="link-primary">Forgot Password ?</a>
							</div>

							<div class="d-grid mb-5">
								<button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
									<span class="indicator-label">Sign In</span>
									<span class="indicator-progress">Please wait...
									<span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
								</button>
							</div>

							<div class="text-danger fs-7" id="diplay-error"></div>

						</form>
					</div>
				</div>
			</div>
		</div>
		@include('modals.authentication')
		<script>var hostUrl = "assets/";</script>
		<script src="assets/plugins/global/plugins.bundle.js"></script>
		<script src="assets/js/scripts.bundle.js"></script>
		<script src="assets/js/custom/pages/login-js.js?{{ Str::random(12) }}"></script>
	</body>
</html>
