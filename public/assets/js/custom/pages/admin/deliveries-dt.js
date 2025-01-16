"use strict";
var renderDelivery = function() {

    let deliveryDt,
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
        if(deliveryDt) {
            deliveryDt.ajax.reload(null, false);
        }
    }

    var validator = FormValidation.formValidation(
        document.querySelector('#deliveryForm'),
        {
            fields: {
                'supplier_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'invoice_no': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'invoice_date': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'pojo': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\+63\d{10}$/,
                        //     message: 'Invalid mobile number (eg. 639123456789)'
                        // },
                    }
                },
                'cluster_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                        //     message: 'Invalid tin.'
                        // },
                    }
                },
                'office_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                        //     message: 'Invalid tin.'
                        // },
                    }
                },
                'division_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                        //     message: 'Invalid tin.'
                        // },
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

    var itemValidator = FormValidation.formValidation(
        document.querySelector('#itemForm'),
        {
            fields: {
                'unit_of_measure': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'article_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'description': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'category_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'purchase_price': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        regexp: {
                            regexp: /^\d+(\.\d{1,2})?$/,
                            message: 'Invalid input.'
                        },
                    }
                },
                'status': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'office_id': {
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
                'mr_to': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
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
        document.querySelector('#editDeliveryForm'),
        {
            fields: {
                'supplier_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'invoice_no': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'invoice_date': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'pojo': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\+63\d{10}$/,
                        //     message: 'Invalid mobile number (eg. 639123456789)'
                        // },
                    }
                },
                'cluster_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                        //     message: 'Invalid tin.'
                        // },
                    }
                },
                'office_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                        //     message: 'Invalid tin.'
                        // },
                    }
                },
                'office_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                        //     message: 'Invalid tin.'
                        // },
                    }
                },
                'division_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                        // regexp: {
                        //     regexp: /^\d{3}-\d{3}-\d{3}-\d{3}$/,
                        //     message: 'Invalid tin.'
                        // },
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

    var supValidator = FormValidation.formValidation(
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

    return {
        init: function() {
            deliveryDt = $('#delivery-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/delivery/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        delete data.columns;

                        data.searchCols = [ 'supplier_name' ];
                        data.search = data.search.value;
                    }
                },
                columns: [
                    { data: 'action', title: 'Action', className: 'text-center fw-semibold', width: '5%'},
                    { data: 'ref_no', title: 'Delivery Ref. No.', className: 'text-center fw-semibold', width: '20%'},
                    { data: 'supplier_name', title: 'Supplier Information', className: 'text-start fw-semibold', width: '25%',
                        render: function(data, type, row, meta) {
                            return `
                                <div>Name: <span>${row.supplier_name}</span></div>
                                <div>Address: <span>${row.supplier_address}</span></div>
                            `
                        }
                    },
                    { data: 'id', title: 'Delivery Details', className: 'text-start fw-semibold', width: '25%',
                        render: function(data, type, row, meta) {
                            let actCnt = row.itemCount;
                            return `
                                <div>Invoice No.: <span>${row.invoice_no}</span></div>
                                <div>Invoice Date: <span>${moment(row.invoice_date).format('LL')}</span></div>
                                <div>PO/JO: <span>${row.pojo}</span></div>
                                <div>Quantity: <span>${row.del_quantity} (${actCnt})</span></div>
                            `
                        }
                    },
                    { data: 'id', title: 'Requesting Office', className: 'text-start fw-semibold', width: '25%',
                        render: function(data, type, row, meta) {
                            return `
                                <div>${row.division_name} <span>(${row.abbre})</span></div>
                            `
                        }
                    },
                    { data: 'created_at', title: 'Date Created', className: 'text-start fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return moment(data).format('LLL');
                        }
                    },
                ]
            });

            deliveryDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('keyup', '[data-dt-filter="search"]', function(e) {
                deliveryDt.search(e.target.value).draw();
            })

            $(document).on('click', 'a[data-action="edit-delivery"]', function(e) {
                let row = $(this).attr('data-row');
                let data = selectedData = deliveryDt.row(row).data();

                $('#editDeliveryForm')[0].reset();

                $('#editDeliveryForm select[name="supplier_id"]').val(data.supplier_id);
                $('#editDeliveryForm input[name="invoice_no"]').val(data.invoice_no);
                $('#editDeliveryForm input[name="invoice_date"]').val(data.invoice_date);
                $('#editDeliveryForm input[name="pojo"]').val(data.pojo);
                $('#editDeliveryForm input[name="del_quantity"]').val(data.del_quantity);
                $('#editDeliveryForm select[name="office_id"]').val(data.office_id).trigger('change');
                $('#editDeliveryForm select[name="division_id"]').val(data.division_id);

                $('#editDeliveryForm select').select2();

                $('#editDeliveryModal').modal('show');
            })

            $(document).on('click', 'a[data-action="add-item"]', function(e) {
                let row    = $(this).attr('data-row');
                let data   = selectedData = deliveryDt.row(row).data();
                $('#itemModal').modal('show');
            })

            // Initialize Select2 for Unit of Measure
            $('#itemForm #unit_of_measure').select2({
                placeholder: "Select",
                allowClear: true
            });
            // Initialize Select2 for Office Services
            $('#itemForm #officeServicesItems').select2({
                placeholder: "Select",
                allowClear: true
            });

            $('#deliveryForm #officeServices').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Initialize Select2 for Office Division
            $('#itemForm #officeDivisionItems').select2({
                placeholder: "Select",
                allowClear: true
            });

            $('#deliveryForm #officeDivision').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Initialize Select2 for Status
            $('#itemForm #status').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Declare a variable to store the category type
            let catType = '';

            $('#itemForm').on('change', 'select[name="category_id"]', function() {
                // Get the selected option and its data-type attribute
                let selectedOption = $(this).find('option:selected');
                catType = selectedOption.attr('data-type');
                console.log("Category Type Selected:", catType);
            });

            $('#itemForm').on('change', 'input[name="purchase_price"]', function() {
                let ppAmt = $(this).val();

                if (catType === 'ICS' && ppAmt > 50000) {
                    Swal.fire({
                        text: "Purchase price must be less than 50,000.",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        confirmButtonClass: "btn btn-primary"
                    });

                    $(this).val('');
                }
                if (catType === 'PAR' && ppAmt < 50000) {
                    Swal.fire({
                        text: "Purchase price must be greater than or equal to 50,000.",
                        icon: "warning",
                        buttonsStyling: false,
                        confirmButtonText: "OK",
                        confirmButtonClass: "btn btn-primary"
                    });

                    $(this).val('');
                }
            });

            $('#itemForm').on('input', '#purchase_price', function() {
                let ppVal = $('#purchase_price').val();

                if(ppVal > 50000) {
                    $('#itemForm #sn').removeClass('d-none');
                }
                else {
                    $('#itemForm #sn').addClass('d-none');
                }

            })

            $('#supplierForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                supValidator.validate().then(status => {
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
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Supplier successfully added.',
                                    showCancelButton: false,
                                    confirmButtonClass: "btn font-weight-bold btn-primary",
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
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

            $(document).on('click', 'a[data-action="delete-delivery"]', function(e) {
                let row = $(this).attr('data-row');
                let data = deliveryDt.row(row).data();
                console.log(data);
                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                Swal.fire({
                    title: "Are you sure you want to delete delivery?",
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
                        return httpRequest.post(`/delivery/${ data.id }/delete`, formData);
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

            $('#deliveryForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                validator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#deliveryForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#deliveryForm button[type="submit"]').attr('disabled', true);

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

                            $('#deliveryForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#deliveryForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#deliveryModal').modal('hide');
                                $('#deliveryForm')[0].reset();
                                $('#deliveryForm select').select2();
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

            $('#itemForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);
                let itot   = parseInt(selectedData.del_quantity);
                let iInput = parseInt(selectedData.item_count);

                formData.append('delivery_id', selectedData.id),

                itemValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#itemForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#itemForm button[type="submit"]').attr('disabled', true);

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
                                return httpRequest.post(requestUrl, formData)
                                    .then(response => {
                                        console.log('Backend Response:', response);
                                        if (!response.success) {
                                            throw new Error(response.message); // throw error to trigger catch block
                                        }
                                        return response;
                                    });
                            },
                        }).then(response => {
                            $('#itemForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#itemForm button[type="submit"]').attr('disabled', false);

                            if (response.value.success) {
                                iInput = response.value.item_count;
                                selectedData.item_count = iInput;
                                console.log('After Submission - Updated Item Count (iInput):', iInput);
                                updateUI();
                                $('#itemModal').modal('hide');
                                $('#itemForm')[0].reset();
                                $('#itemForm select').select2();

                                if(itot != iInput) {
                                    Swal.fire({
                                        text: "Do you want to add another item?",
                                        icon: "question",
                                        buttonsStyling: false,
                                        confirmButtonText: "Yes",
                                        confirmButtonClass: "btn font-weight-bold btn-primary",
                                        cancelButtonText: "No",
                                        cancelButtonClass: "btn font-weight-bold btn-danger",
                                        showCancelButton: true,
                                        showLoaderOnConfirm: true,
                                        allowEscapeKey: false,
                                        allowEnterKey: false,
                                        allowOutsideClick: () => !Swal.isLoading(),
                                        preConfirm: () => {
                                            // Reset form data and show modal
                                            $('#itemForm')[0].reset();
                                            $('#itemForm select').select2();
                                            $('#itemModal').modal('show');
                                        },
                                    }).then(() => {

                                        $('#itemForm button[type="submit"]').attr('data-kt-indicator', 'off');
                                        $('#itemForm button[type="submit"]').attr('disabled', false);

                                        if(response.value.success) {
                                            updateUI();
                                            $('#itemModal').modal('hide');
                                            $('#itemForm')[0].reset();
                                            $('#itemForm select').select2();
                                            // Swal.fire('Success!', response.value.message, 'success');
                                        }
                                        else {
                                            Swal.fire(response.value.message, response.value.errors, 'error');
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        text: "The quantity is not sufficient to add another item.",
                                        icon: "info",
                                        confirmButtonText: "Ok",
                                        confirmButtonClass: "btn fw-bold btn-light"
                                    });
                                }
                            } else {
                                Swal.fire('Error', response.value.message, 'error');
                            }
                        }).catch(error => {
                            $('#itemForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#itemForm button[type="submit"]').attr('disabled', false);

                            Swal.fire('Error', error.message, 'error');
                        });
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

            $('#editDeliveryForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                editValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#editDeliveryForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#editDeliveryForm button[type="submit"]').attr('disabled', true);

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
                                return httpRequest.post(`/delivery/${ selectedData.id }/edit`, formData);
                            },
                        }).then(response => {

                            $('#editDeliveryForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#editDeliveryForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#editDeliveryModal').modal('hide');
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

            $('#deliveryForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#deliveryForm select[name="office_id"]'),
                    $divisionElem = $('#deliveryForm select[name="division_id"]');

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

            $('#deliveryForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#deliveryForm select[name="division_id"]');

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

            $('#itemForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#itemForm select[name="office_id"]'),
                    $divisionElem = $('#itemForm select[name="division_id"]');

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

            $('#itemForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#itemForm select[name="division_id"]');

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

            $('#itemForm').on('change', 'select[name="division_id"]', function() {
                let divisionId = $(this).val(),
                    $selectElem = $('#itemForm select[name="mr_to"]');

                $selectElem.empty();
                httpRequest
                    .get('/employee/search?n=' + divisionId)
                    .then(response => {
                        if(response.length > 0) {
                            response.sort((a, b) => a.fullname.localeCompare(b.fullname));
                            $selectElem.append(`<option value="0" selected>None</option>`);
                            for (const d of response) {
                                $selectElem.append(`<option value="${d.id}">${d.fullname}</option>`);
                            }
                        }
                    })
            })

            $('#itemForm').on('change', 'select[name="division_id"]', function() {
                let divisionId = $(this).val(),
                    $selectElem = $('#itemForm select[name="mr_to"]');

                $selectElem.empty();
                httpRequest
                    .get('/employee/search?n=' + divisionId)
                    .then(response => {
                        if(response.length > 0) {
                            $selectElem.append(`<option value="0" selected>None</option>`);
                            for (const d of response) {
                                $selectElem.append(`<option value="${d.id}">${d.fullname}</option>`);
                            }
                        }
                    })
            })

            $('#editDeliveryForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#editDeliveryForm select[name="office_id"]'),
                    $divisionElem = $('#editDeliveryForm select[name="division_id"]');

                $selectElem.empty();
                $divisionElem.empty();
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

            $('#editDeliveryForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#editDeliveryForm select[name="division_id"]');

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

            $('#supplier_id').select2({
                language: {
                    noResults: function() {
                        return $('<a href="javascript:void(0);" id="addNewSupplier" data-toggle="modal" data-target="#supplierModal">Add New Supplier</a>');
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            $(document).on('click', '#addNewSupplier', function(e) {
                e.preventDefault();
                $('#supplier_id').select2('close');
                $('#deliveryModal').modal('hide');
                $('#supplierModal').modal('show');
            });
        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderDelivery.init();
});
