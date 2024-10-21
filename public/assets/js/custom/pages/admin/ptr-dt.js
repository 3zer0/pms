"use strict";
var renderPtr = function() {

    let transDt,
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
        if(transDt) {
            transDt.ajax.reload(null, false);
        }
    }

    var validator = FormValidation.formValidation(
        document.querySelector('#ptrForm'),
        {
            fields: {
                'transfer_type': {
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
                'rec_by': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'trans_reason': {
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

    var validatorItr = FormValidation.formValidation(
        document.querySelector('#itrForm'),
        {
            fields: {
                'transfer_type': {
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
                'rec_by': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'trans_reason': {
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

    return {
        init: function() {
            transDt = $('#ptr-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/ptr/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        delete data.columns;

                        data.searchCols = [ 'supplier_name' ];
                        data.search = data.search.value;
                    }
                },
                columns: [
                    { data: 'action', title: 'Action', className: 'text-center fw-semibold', width: '5%'},
                    { data: 'ref_no', title: 'Ref. No.', className: 'text-center fw-semibold', width: '15%'},
                    { data: 'accountability_type', title: 'Accountability Type', className: 'text-center fw-semibold', width: '15%'},
                    { data: 'transfer_type', title: 'Transfer Type', className: 'text-start fw-semibold', width: '20%'},
                    { data: 'trans_reason', title: 'Reason for Transfer', className: 'text-start fw-semibold', width: '20%'},
                    { data: 'id', title: 'Transferred To', className: 'text-start fw-semibold', width: '25%',
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
            })

            transDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('keyup', '[data-dt-filter="search"]', function(e) {
                transDt.search(e.target.value).draw();
            })

            $(document).on('click', 'a[data-action="edit-ptr"]', function(e) {
                let row = $(this).attr('data-row');
                let data = selectedData = ptrDt.row(row).data();

                $('#editptrForm')[0].reset();

                $('#editptrForm select[name="supplier_id"]').val(data.supplier_id);
                $('#editptrForm input[name="invoice_no"]').val(data.invoice_no);
                $('#editptrForm input[name="invoice_date"]').val(data.invoice_date);
                $('#editptrForm input[name="pojo"]').val(data.pojo);
                $('#editptrForm input[name="del_quantity"]').val(data.del_quantity);
                $('#editptrForm select[name="office_id"]').val(data.office_id).trigger('change');
                $('#editptrForm select[name="division_id"]').val(data.division_id);

                $('#editptrForm select').select2();

                $('#editDeliveryModal').modal('show');
            })

            $(document).on('click', 'a[data-action="add-item"]', function(e) {
                let row = $(this).attr('data-row');
                let data = selectedData = ptrDt.row(row).data();

                $('#itemModal').modal('show');
            })

            // Initialize PTR

            // Transfer Type
            $('#officeServicesPtr').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Office Services
            $('#officeServicesPtr').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Office Division
            $('#officeDivisionPtr').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Received by
            $('#rec_by_ptr').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Initialize ITR

            // Office Services
            $('#officeServices').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Office Division
            $('#officeDivision').select2({
                placeholder: "Select",
                allowClear: true
            });

            $('#ptrForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#ptrForm select[name="office_id"]'),
                    $divisionElem = $('#ptrForm select[name="division_id"]');

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

            $('#ptrForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#ptrForm select[name="division_id"]');

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

            $('#ptrForm').on('change', 'select[name="division_id"]', function() {
                let divisionId = $(this).val(),
                    $selectElem = $('#ptrForm select[name="rec_by"]');

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

            $('#itrForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#itrForm select[name="office_id"]'),
                    $divisionElem = $('#itrForm select[name="division_id"]');

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

            $('#itrForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#itrForm select[name="division_id"]');

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

            $('#itrForm').on('change', 'select[name="division_id"]', function() {
                let divisionId = $(this).val(),
                    $selectElem = $('#itrForm select[name="rec_by"]');

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

            $('#detailForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                // formData.append('item_id', selectedData.id),

                validator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#ptrForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#ptrForm button[type="submit"]').attr('disabled', true);

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
                                        if (!response.success) {
                                            throw new Error(response.message); // throw error to trigger catch block
                                        }
                                        return response;
                                    });
                            },
                        }).then(response => {
                            $('#ptrForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#ptrForm button[type="submit"]').attr('disabled', false);

                            if (response.value.success) {
                                updateUI();
                                $('#ptrModal').modal('hide');
                                $('#ptrForm')[0].reset();
                                $('#ptrForm select').select2();

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
                                        $('#ptrForm')[0].reset();
                                        $('#ptrForm select').select2();
                                        $('#ptrModal').modal('show');
                                    },
                                }).then(() => {

                                    $('#ptrForm button[type="submit"]').attr('data-kt-indicator', 'off');
                                    $('#ptrForm button[type="submit"]').attr('disabled', false);

                                    if(response.value.success) {
                                        updateUI();
                                        $('#ptrModal').modal('hide');
                                        $('#ptrForm')[0].reset();
                                        $('#ptrForm select').select2();
                                        // Swal.fire('Success!', response.value.message, 'success');
                                    }
                                    else {
                                        Swal.fire(response.value.message, response.value.errors, 'error');
                                    }
                                });
                            } else {
                                Swal.fire('Error', response.value.message, 'error');
                            }
                        }).catch(error => {
                            $('#ptrForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#ptrForm button[type="submit"]').attr('disabled', false);

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

            $(document).on('click', 'a[data-action="delete-ptr"]', function(e) {
                let row = $(this).attr('data-row');
                let data = ptrDt.row(row).data();
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
                        return httpRequest.post(`/ptr/${ data.id }/delete`, formData);
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

            $('#ptrForm').on('click', 'a[data-action="add-details"]', function(e) {
                e.preventDefault();
                $('#detailForm').modal('show');
            });

            $('#itemForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                formData.append('ptr_id', selectedData.id),

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
                                updateUI();
                                $('#itemModal').modal('hide');
                                $('#itemForm')[0].reset();
                                $('#itemForm select').select2();

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

            $('#editptrForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                editValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#editptrForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#editptrForm button[type="submit"]').attr('disabled', true);

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
                                return httpRequest.post(`/ptr/${ selectedData.id }/edit`, formData);
                            },
                        }).then(response => {

                            $('#editptrForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#editptrForm button[type="submit"]').attr('disabled', false);

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

            $('#itemForm').on('input', '#purchase_price', function() {
                let ppVal = $('#purchase_price').val();

                if(ppVal > 50000) {
                    $('#itemForm #sn').removeClass('d-none');
                }
                else {
                    $('#itemForm #sn').addClass('d-none');
                }

            })

            $('#editptrForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#editptrForm select[name="office_id"]'),
                    $divisionElem = $('#editptrForm select[name="division_id"]');

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

            $('#editptrForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#editptrForm select[name="division_id"]');

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

            $('#ptrForm').on('change', 'select[name="property_no"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#editptrForm select[name="division_id"]');

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
                $('#ptrModal').modal('hide');
                $('#supplierModal').modal('show');
            });

            $('.pr_no').select2({
                placeholder: 'Select an option',
                width: '100%', // Adjust width as needed
                templateResult: formatOption,
                templateSelection: formatOptionSelection
            });

            function initializeSelect2PPECondition() {
                $('.ppe_condition').select2({
                    placeholder: "Select Condition of PPE",
                    minimumResultsForSearch: Infinity // Disables the search box
                });
            }

            initializeSelect2PPECondition();

            function formatOption(option) {
                if (!option.id) {
                    return option.text;
                }
                var price = $(option.element).data('price');
                var description = $(option.element).data('description');
                var propertyNo = '<strong>' + option.text.trim() + '</strong>';
                var priceAndDescription = '<div style="margin-left: 15px;"><small>Price: ' + price + '<br>Description: ' + description + '</small></div>';

                return $('<span>' + propertyNo + priceAndDescription + '</span>');
            }

            function formatOptionSelection(option) {
                if (!option.id) {
                    return option.text;
                }
                var price = $(option.element).data('price');
                var description = $(option.element).data('description');

                // Display the selected option with all details
                return $('<span><strong>' + option.text.trim() + '</strong> - <small>Price: ' + price + ' - Description: ' + description + '</small></span>');
            }

            // Add PTR
            $('[data-action="add-eqpt-ptr"]').on('click', function() {
                // Get selected values
                var propertySelect    = $('#property_no');
                var selectedOption    = propertySelect.find('option:selected');
                var propertyNo        = selectedOption.text();
                var invoiceDate       = selectedOption.data('date');
                var invoiceDateFormat = moment(invoiceDate).format('ll');
                var purchasePrice     = selectedOption.data('price');
                var description       = selectedOption.data('description');
                var ppeCondition      = $('#ppe_condition').val();

                // Check if a property is selected and condition is chosen
                if (propertyNo === "" || ppeCondition === "") {
                    alert("Please select all required fields.");
                    return;
                }

                // Create a new table row
                var newRow = `
                    <tr>
                        <td>${invoiceDateFormat}</td>
                        <td>${propertyNo}</td>
                        <td>${description}</td>
                        <td>${purchasePrice}</td>
                        <td>${ppeCondition}</td>
                    </tr>
                `;

                // Append the new row to the table body
                $('#tbl-ptr tbody').append(newRow);

                // Remove the selected option from the dropdown
                selectedOption.remove();

                // Optionally, clear the form selections after adding
                propertySelect.val('').trigger('change');
                $('#ppe_condition').val('').trigger('change');
            });

            $('#ptrForm').on('submit', function(e) {
                e.preventDefault();
                // Clear previously added inputs
                $(this).find('input[type="hidden"]').remove();

                // Collect data for hidden fields
                $('#tbl-ptr tbody tr').each(function() {
                    var propertyNo = $(this).find('td').eq(1).text();
                    var ppeCondition = $(this).find('td').eq(4).text();

                    // Add hidden inputs to form
                    $('#ptrForm').append(`<input type="hidden" name="property_no[]" value="${propertyNo}">`);
                    $('#ptrForm').append(`<input type="hidden" name="ppe_condition[]" value="${ppeCondition}">`);
                });

                let requestUrl = $(this).attr('action');
                let token = $('meta[name="csrf-token"]').attr('content');
                let formData   = new FormData(this);
                formData.append('_token', token);

                validator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#ptrForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#ptrForm button[type="submit"]').attr('disabled', true);

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

                            $('#ptrForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#ptrForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#ptrModal').modal('hide');
                                $('#ptrForm')[0].reset();
                                $('#ptrForm select').select2();
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

            });

            // Add ITR
            $('[data-action="add-eqpt-itr"]').on('click', function() {
                // Get selected values
                var propertySelect    = $('#property_no_itr');
                var selectedOption    = propertySelect.find('option:selected');
                var propertyNo        = selectedOption.text();
                var icsNo             = selectedOption.data('ics');
                var invoiceDate       = selectedOption.data('date');
                var invoiceDateFormat = moment(invoiceDate).format('ll');
                var purchasePrice     = selectedOption.data('price');
                var description       = selectedOption.data('description');
                var ppeCondition      = $('#ppe_condition_itr').val();

                // Check if a property is selected and condition is chosen
                if (propertyNo === "" || ppeCondition === "") {
                    alert("Please select all required fields.");
                    return;
                }

                // Create a new table row
                var newRow = `
                    <tr>
                        <td>${invoiceDateFormat}</td>
                        <td>${propertyNo}</td>
                        <td>${icsNo}</td>
                        <td>${description}</td>
                        <td>${purchasePrice}</td>
                        <td>${ppeCondition}</td>
                    </tr>
                `;

                // Append the new row to the table body
                $('#tbl-itr tbody').append(newRow);

                // Remove the selected option from the dropdown
                selectedOption.remove();

                // Optionally, clear the form selections after adding
                propertySelect.val('').trigger('change');
                $('#ppe_condition').val('').trigger('change');
            });

            $('#itrForm').on('submit', function(e) {
                e.preventDefault();
                // Clear previously added inputs
                $(this).find('input[type="hidden"]').remove();

                // Collect data for hidden fields
                $('#tbl-itr tbody tr').each(function() {
                    var propertyNo = $(this).find('td').eq(1).text();
                    var ppeCondition = $(this).find('td').eq(5).text();

                    // Add hidden inputs to form
                    $('#itrForm').append(`<input type="hidden" name="property_no[]" value="${propertyNo}">`);
                    $('#itrForm').append(`<input type="hidden" name="ppe_condition[]" value="${ppeCondition}">`);
                });

                let requestUrl = $(this).attr('action');
                let token = $('meta[name="csrf-token"]').attr('content');
                let formData   = new FormData(this);
                formData.append('_token', token);

                validatorItr.validate().then(status => {
                    if(status == 'Valid') {

                        $('#itrForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#itrForm button[type="submit"]').attr('disabled', true);

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

                            $('#itrForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#itrForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#itrModal').modal('hide');
                                $('#itrForm')[0].reset();
                                $('#itrForm select').select2();
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

            });

            $(document).on('click', 'a[data-action="print-rep"]', function(e) {
                let row = $(this).attr('data-row');
                let data = transDt.row(row).data();
                let type = data.accountability_type;
                let refNo = data.ref_no;
                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                let printUrl = '';
                if(type == 'PAR'){
                    printUrl = `/ptr/${refNo}/print`;
                }
                else{
                    printUrl = `/itr/${refNo}/print`;
                }
                window.open(printUrl, '_blank');
            })

        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderPtr.init();
});
