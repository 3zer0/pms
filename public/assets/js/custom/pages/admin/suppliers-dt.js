"use strict";
var renderSupplier = function() {

    let supplierDt,
        selectedData,
        options = {
            minLength: 8,
            checkUppercase: true,
            checkLowercase: true,
            checkDigit: true,
            checkChar: true,
            scoreHighlightClass: "active"
        };

    const updateUI = () => {
        if(supplierDt) {
            supplierDt.ajax.reload(null, false);
        }
    }

    var validator = FormValidation.formValidation(
        document.querySelector('#supplierForm'),
        {
            fields: {
                'supplier_name': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'supplier_address': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'supplier_email': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        emailAddress: {
                            message: 'Invalid email address',
                        },
                    }
                },
                'supplier_mobile_no': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        regexp: {
                            regexp: /^\+63\d{10}$/,
                            message: 'Invalid mobile number (eg. 639123456789)'
                        },
                    }
                },
                'supplier_tin': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        regexp: {
                            regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                            message: 'Invalid tin.'
                        },
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
        document.querySelector('#editSupplierForm'),
        {
            fields: {
                'supplier_name': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'supplier_address': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'supplier_email': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        emailAddress: {
                            message: 'Invalid email address',
                        },
                    }
                },
                'supplier_mobile_no': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        regexp: {
                            regexp: /^\+63\d{10}$/,
                            message: 'Invalid mobile number (eg. 639123456789)'
                        },
                    }
                },
                'supplier_tin': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        regexp: {
                            regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                            message: 'Invalid tin.'
                        },
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
            supplierDt = $('#supplier-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/supplier/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        delete data.columns;

                        data.searchCols = [ 'supplier_name', 'supplier_address', 'supplier_tin' ];
                        data.search = data.search.value;
                    }
                },
                columns: [
                    { data: 'action', title: 'Action', className: 'text-start fw-semibold', width: '5%'},
                    { data: 'supplier_name', title: 'Supplier Information', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            return `
                                <div>Name: <span>${row.supplier_name}</span></div>
                                <div>Addres: <span>${row.supplier_address}</span></div>
                                <div>TIN: <span>${row.supplier_tin}</span></div>
                            `
                        }
                    },
                    { data: 'id', title: 'Supplier Contacts Information', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            return `
                                <div>Mobile No.: <span>${row.supplier_mobile_no}</span></div>
                                <div>Email: <span>${row.supplier_email}</span></div>
                            `
                        }
                    },
                    { data: 'created_at', title: 'Date Created', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            return moment(data).format('LLL');
                        }
                    },
                ]
            })

            supplierDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('keyup', '[data-dt-filter="search"]', function(e) {
                supplierDt.search(e.target.value).draw();
            })

            $(document).on('click', 'a[data-action="edit-supplier"]', function(e) {
                let row = $(this).attr('data-row');
                let data = selectedData = supplierDt.row(row).data();

                $('#editSupplierForm')[0].reset();

                $('#editSupplierForm input[name="supplier_name"]').val(data.supplier_name);
                $('#editSupplierForm input[name="supplier_address"]').val(data.supplier_address);
                $('#editSupplierForm input[name="supplier_mobile_no"]').val(data.supplier_mobile_no);
                $('#editSupplierForm input[name="supplier_email"]').val(data.supplier_email);
                $('#editSupplierForm input[name="supplier_tin"]').val(data.supplier_tin);

                // if(!field_validator('email', editValidator)) {
                //     editValidator.addField('email', emailValidator(data.id));
                // }
                // else {
                //     editValidator.removeField('email');
                // }

                // if(!field_validator('mobile_no', editValidator)) {
                //     editValidator.addField('mobile_no', mobileValidator(data.id));
                // }
                // else {
                //     editValidator.removeField('mobile_no');
                // }

                $('#editSupplierForm select').select2();

                $('#editSupplierModal').modal('show');
            })

            $(document).on('click', 'a[data-action="delete-supplier"]', function(e) {
                let row = $(this).attr('data-row');
                let data = supplierDt.row(row).data();
                console.log(data);

                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                Swal.fire({
                    title: "Are you sure you want to delete supplier?",
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
                        return httpRequest.post(`/supplier/${ data.id }/delete`, formData);
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

            $('#supplierForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                validator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#supplierForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#supplierForm button[type="submit"]').attr('disabled', true);

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

                            $('#supplierForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#supplierForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#supplierModal').modal('hide');
                                $('#supplierForm')[0].reset();
                                $('#supplierForm select').select2();
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

            $('#editSupplierForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                editValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#editSupplierForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#editSupplierForm button[type="submit"]').attr('disabled', true);

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
                                return httpRequest.post(`/supplier/${ selectedData.id }/edit`, formData);
                            },
                        }).then(response => {

                            $('#editSupplierForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#editSupplierForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#editSupplierModal').modal('hide');
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

            const defaultPrefix = '+63';
            const maxDigits = 10;
            const maxLength = defaultPrefix.length + maxDigits;

            $('#supplier_mobile_no').val(defaultPrefix); // Set default prefix

            $('#supplier_mobile_no').on('input', function (event) {
                let input = $(this).val();

                // Prevent deletion of the default prefix
                if (!input.startsWith(defaultPrefix)) {
                    input = defaultPrefix;
                }

                // Remove any non-digit characters except for the '+'
                input = input.replace(/[^\d+]/g, '');

                // Limit the total length to the prefix length plus maxDigits
                if (input.length > maxLength) {
                    input = input.slice(0, maxLength);
                }

                // Set the formatted input back to the textbox
                $(this).val(input);
            });

            $('#supplier_mobile_no').on('keydown', function (event) {
                // Prevent deleting the prefix using backspace or delete keys
                if ($(this).caret().start < defaultPrefix.length && (event.key === 'Backspace' || event.key === 'Delete')) {
                    event.preventDefault();
                }
            });

            $('#supplier_tin').on('input', function () {
                let tin = $(this).val().replace(/-/g, ''); // Remove existing dashes

                // Limit input to 12 digits
                if (tin.length > 12) {
                    tin = tin.slice(0, 12);
                }

                // Insert dashes every 3 digits
                let formattedTin = '';
                for (let i = 0; i < tin.length; i += 3) {
                    if (i > 0) formattedTin += '-';
                    formattedTin += tin.slice(i, i + 3);
                }

                $(this).val(formattedTin);
            });
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderSupplier.init();
});
