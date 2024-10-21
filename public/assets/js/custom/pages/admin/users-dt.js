"use strict";
var renderEmployee = function() {

    let userDt,
        selectedData,
        options = {
            minLength: 8,
            checkUppercase: true,
            checkLowercase: true,
            checkDigit: true,
            checkChar: true,
            scoreHighlightClass: "active"
        };

    //! Add
    let passwordMeterElement = document.querySelector("#employee-password"),
    passwordMeter = new KTPasswordMeter(passwordMeterElement, options);

    //! Edit
    let ePasswordMeterElement = document.querySelector("#e-employee-password"),
    ePasswordMeter = new KTPasswordMeter(ePasswordMeterElement, options);

    const updateUI = () => {
        if(userDt) {
            userDt.ajax.reload(null, false);
        }
    }

    var validator = FormValidation.formValidation(
        document.querySelector('#userForm'),
        {
            fields: {
                'firstname': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'lastname': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'email': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        emailAddress: {
                            message: 'Invalid email address',
                        },
                        remote: {
                            url: '/user/validate/email',
                            message: 'Email address is not available',
                            type: 'GET'
                        }
                    }
                },
                'mobile_no': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        regexp: {
                            regexp: /(^(63)(\d){10}$)/i,
                            message: 'Invalid mobile number (eg. 639123456789)'
                        },
                        remote: {
                            url: '/user/validate/mobile_no',
                            message: 'Mobile number is not available',
                            type: 'GET'
                        }
                    }
                },
                'division_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'username': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        regexp: {
                            regexp: /^\S*$/,
                            message: 'Username can consist of alphanumeric characters only',
                        },
                        remote: {
                            url: '/user/validate/username',
                            message: 'Username is not available',
                            type: 'GET'
                        }
                    }
                },
                'password': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        callback: {
                            message: 'Use atleast 8 characters length, 1 upper case letter, 1 lower case letter, 1 special character (!@#$&*) and number',
                            callback: function (input) {
                                passwordMeter.check();
                                return passwordMeter.getScore() == 100;
                            },
                        },
                    }
                },
                'password_confirmation': {
                    validators: {
                        identical: {
                            compare: function() {
                                return document.querySelector('#userForm input[name="password"]').value;
                            },
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                }),
            }
        }
    );

    var editValidator = FormValidation.formValidation(
        document.querySelector('#editUserForm'),
        {
            fields: {
                'firstname': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'lastname': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'division_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'password': {
                    validators: {
                        callback: {
                            message: 'Use atleast 8 characters length, 1 upper case letter, 1 lower case letter, 1 special character (!@#$&*) and number',
                            callback: function (input) {
                                if((input.value).trim().length == 0) {
                                    return true;
                                }
                                else {
                                    ePasswordMeter.check();
                                    return ePasswordMeter.getScore() == 100;
                                }
                            },
                        },
                    }
                },
                'password_confirmation': {
                    validators: {
                        identical: {
                            compare: function() {
                                return document.querySelector('#userForm input[name="password"]').value;
                            },
                            message: 'The password and its confirm are not the same'
                        }
                    }
                },
            },
            plugins: {
                trigger: new FormValidation.plugins.Trigger(),
                bootstrap: new FormValidation.plugins.Bootstrap5({
                    rowSelector: '.fv-row',
                    eleInvalidClass: '',
                    eleValidClass: ''
                }),
            }
        }
    );

    let emailValidator = (self) => {
        return {
            validators: {
                notEmpty: {
                    message: 'Required Field',
                    trim: true
                },
                emailAddress: {
                    message: 'Invalid email address',
                },
                remote: {
                    url: '/user/validate/email?self=' + self,
                    message: 'Email address is not available',
                    type: 'GET'
                }
            }
        }
    }

    let mobileValidator = (self) => {
        return {
            validators: {
                notEmpty: {
                    message: 'Required Field',
                    trim: true
                },
                regexp: {
                    regexp: /(^(63)(\d){10}$)/i,
                    message: 'Invalid mobile number (eg. 639123456789)'
                },
                remote: {
                    url: '/user/validate/mobile_no?self=' + self,
                    message: 'Mobile number is not available',
                    type: 'GET'
                }
            }
        }
    }

    return {
        init: function() {
            userDt = $('#user-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/user/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        delete data.columns;

                        data.searchCols = [ 'firstname', 'lastname', 'email', 'mobile_no' ];
                        data.search = data.search.value;
                    }
                },
                columns: [
                    { data: 'action', title: 'Action', className: 'text-start fw-semibold', width: '5%'},
                    { data: 'lastname', title: 'Name', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            return row.firstname + ' ' + row.lastname;
                        }
                    },
                    { data: 'email', title: 'Email Address', className: 'text-start fw-semibold' },
                    { data: 'mobile_no', title: 'Contact No.', className: 'text-start fw-semibold' },
                    { data: 'division_name', title: 'Division', className: 'text-start fw-semibold' },
                    { data: 'created_at', title: 'Date Created', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            return moment(data).format('LLL');
                        }
                    },
                ]
            })

            userDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('keyup', '[data-dt-filter="search"]', function(e) {
                userDt.search(e.target.value).draw();
            })

            $(document).on('click', 'a[data-action="edit-user"]', function(e) {
                let row = $(this).attr('data-row');
                let data = selectedData = userDt.row(row).data();

                $('#editUserForm')[0].reset();

                $('#editUserForm input[name="firstname"]').val(data.firstname);
                $('#editUserForm input[name="lastname"]').val(data.lastname);
                $('#editUserForm input[name="designate"]').val(data.designate);
                $('#editUserForm input[name="email"]').val(data.email);
                $('#editUserForm input[name="mobile_no"]').val(data.mobile_no);
                $('#editUserForm select[name="division_id"]').val(data.division_id);
                $('#editUserForm input[name="username"]').val(data.username);

                $('#editUserForm input[name="user_view"]').prop('checked', data.user_view ? true : false);
                $('#editUserForm input[name="user_add"]').prop('checked', data.user_add ? true : false);
                $('#editUserForm input[name="user_edit"]').prop('checked', data.user_edit ? true : false);
                $('#editUserForm input[name="user_delete"]').prop('checked', data.user_delete ? true : false);

                $('#editUserForm input[name="supplier_view"]').prop('checked', data.supplier_view ? true : false);
                $('#editUserForm input[name="supplier_add"]').prop('checked', data.supplier_add ? true : false);
                $('#editUserForm input[name="supplier_edit"]').prop('checked', data.supplier_edit ? true : false);
                $('#editUserForm input[name="supplier_delete"]').prop('checked', data.supplier_delete ? true : false);

                if(!field_validator('email', editValidator)) {
                    editValidator.addField('email', emailValidator(data.id));
                }
                else {
                    editValidator.removeField('email');
                }

                if(!field_validator('mobile_no', editValidator)) {
                    editValidator.addField('mobile_no', mobileValidator(data.id));
                }
                else {
                    editValidator.removeField('mobile_no');
                }

                $('#editUserForm select').select2();

                $('#editUserModal').modal('show');
            })

            $(document).on('click', 'a[data-action="delete-user"]', function(e) {
                let row = $(this).attr('data-row');
                let data = userDt.row(row).data();

                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                Swal.fire({
                    title: "Are you sure you want to delete user?",
                    icon: "question",
                    buttonsStyling: false,
                    confirmButtonText: "Delete",
                    confirmButtonClass: "btn btn-primary fw-bold",
                    cancelButtonClass: "btn btn-light-danger fw-bold",
                    showCancelButton: true,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    allowOutsideClick: () => !Swal.isLoading(),
                    preConfirm: () => {
                        return httpRequest.post(`/user/${ data.id }/delete`, formData);
                    },
                }).then(response => {
                    if(response.value.success) {
                        updateUI();
                        Swal.fire('Success!', response.value.message, 'success');
                    }
                    else {
                        Swal.fire(response.value.message, response.value.errors, 'error');
                    }
                })


            })

            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                validator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#userForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#userForm button[type="submit"]').attr('disabled', true);

                        Swal.fire({
                            text: "Are you sure you want to submit ?",
                            icon: "question",
                            buttonsStyling: false,
                            confirmButtonText: "Submit",
                            confirmButtonClass: "btn font-weight-bold btn-primary",
                            cancelButtonClass: "btn font-weight-bold btn-danger",
                            showCancelButton: true,
                            showLoaderOnConfirm: true,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            allowOutsideClick: () => !Swal.isLoading(),
                            preConfirm: () => {
                                return httpRequest.post(requestUrl, formData);
                            },
                        }).then(response => {

                            $('#userForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#userForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#userModal').modal('hide');
                                $('#userForm')[0].reset();
                                $('#userForm select').select2();
                                Swal.fire('Success!', response.value.message, 'success');
                            }
                            else {
                                Swal.fire(response.value.message, response.value.errors, 'error');
                            }
                        })
                    }
                    else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            confirmButtonClass: "btn fw-bold btn-light"
                        });
                    }
                })
            })

            $('#editUserForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                editValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#editUserForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#editUserForm button[type="submit"]').attr('disabled', true);

                        Swal.fire({
                            text: "Are you sure you want to submit ?",
                            icon: "question",
                            buttonsStyling: false,
                            confirmButtonText: "Submit",
                            confirmButtonClass: "btn font-weight-bold btn-primary",
                            cancelButtonClass: "btn font-weight-bold btn-danger",
                            showCancelButton: true,
                            showLoaderOnConfirm: true,
                            allowEscapeKey: false,
                            allowEnterKey: false,
                            allowOutsideClick: () => !Swal.isLoading(),
                            preConfirm: () => {
                                return httpRequest.post(`/user/${ selectedData.id }/edit`, formData);
                            },
                        }).then(response => {

                            $('#editUserForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#editUserForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#editUserModal').modal('hide');
                                Swal.fire('Success!', response.value.message, 'success');
                            }
                            else {
                                Swal.fire(response.value.message, response.value.errors, 'error');
                            }
                        })
                    }
                    else {
                        Swal.fire({
                            text: "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            confirmButtonClass: "btn fw-bold btn-light"
                        });
                    }
                })
            })



            $('#userForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#userForm select[name="office_id"]'),
                    $divisionElem = $('#userForm select[name="division_id"]');

                $selectElem.empty();
                $divisionElem.empty();
                console.log(officeId,$selectElem,$divisionElem);
                // if(officeId == 6) {
                //     $selectElem.append('<option value="0" selected>None</option>');
                //     $divisionElem.append('<option value="0" selected>None</option>');
                // }
                    httpRequest
                        .get('/office/search?n=' + officeId)
                        .then(response => {
                            if(response.length > 0) {
                                $selectElem.append(`<option value="0" selected>None</option>`);
                                for (const d of response) {
                                    $selectElem.append(`<option value="${d.id}">${d.office_name} (${d.abbre})</option>`);
                                }
                            }
                        })

            })

            $('#userForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#userForm select[name="division_id"]');

                $selectElem.empty();
                httpRequest
                    .get('/division/search?n=' + officeId)
                    .then(response => {
                        if(response.length > 0) {
                            $selectElem.append(`<option value="0" selected>None</option>`);
                            for (const d of response) {
                                $selectElem.append(`<option value="${d.id}">${d.division_name} (${d.abbre})</option>`);
                            }
                        }
                    })
            })
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderEmployee.init();
});
