"use strict";
var renderItem = function() {

    let itemDt,
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
        if(itemDt) {
            itemDt.ajax.reload(null, false);
        }
    }

    var validator = FormValidation.formValidation(
        document.querySelector('#addItemForm'),
        {
            fields: {
                'delivery_id': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
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
        document.querySelector('#editItemForm'),
        {
            fields: {
                'article_id': {
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
                'item_quantity': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'unit_of_measure': {
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
                'description': {
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
                'purchase_price': {
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

    var pValidator = FormValidation.formValidation(
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

    return {
        init: function() {
            itemDt = $('#item-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/item/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        delete data.columns;

                        data.searchCols = [ 'ref_no' ];
                        data.search = data.search.value;
                    }
                },
                columns: [
                    { data: 'action', title: 'Action', className: 'text-start fw-semibold', width: '5%'},
                    { data: 'ref_no', title: 'Reference No.', className: 'text-start fw-semibold'},
                    { data: 'item_quantity', title: 'Quantity', className: 'text-start fw-semibold'},
                    { data: 'unit_of_measure', title: 'UOM', className: 'text-start fw-semibold'},
                    { data: 'article_name', title: 'Article', className: 'text-start fw-semibold'},
                    { data: 'description', title: 'Description', className: 'text-start fw-semibold'},
                    { data: 'purchase_price', title: 'Purchase Price', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            return parseFloat(data).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    },
                    { data: 'id', title: 'Total Price', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            let pp = parseFloat(row.purchase_price);
                            let qty = parseInt(row.item_quantity);
                            let tp = pp * qty;

                            return parseFloat(tp).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 });
                        }
                    },
                    { data: 'category_name', title: 'Category', className: 'text-start fw-semibold'},
                    { data: 'property_no', title: 'Property No.', className: 'text-start fw-semibold'},
                    { data: 'accountability_type', title: 'Accountability Form', className: 'text-start fw-semibold'},
                    { data: 'accountability_no', title: 'ICS/PAR No.', className: 'text-start fw-semibold'},
                    { data: 'id', title: 'Employee', className: 'text-start fw-semibold',
                        render: function(data, type, row, meta) {
                            return `
                                <div>${row.employee.fullname}</div>
                            `;
                        }
                    },
                    { data: 'created_at', title: 'Date Created', className: 'text-start fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return moment(data).format('LLL');
                        }
                    },
                ]
            })

            itemDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('keyup', '[data-dt-filter="search"]', function(e) {
                itemDt.search(e.target.value).draw();
            })

            $(document).on('click', 'a[data-action="edit-item"]', function(e) {

                // Get the row index from the clicked link
                let rowIndex = $(this).attr('data-row');

                // Retrieve the data for the specified row index
                let data = selectedData = itemDt.row(rowIndex).data();

                // Reset the form
                $('#editItemForm')[0].reset();

                // Populate the form fields
                $('#editItemForm #ref_no').val(data.ref_no);
                $('#editItemForm input[name="item_quantity"]').val(data.item_quantity);
                $('#editItemForm select[name="unit_of_measure"]').val(data.unit_of_measure);
                $('#editItemForm select[name="article_id"]').val(data.article_id);
                $('#editItemForm #description').val(data.description);
                $('#editItemForm input[name="purchase_price"]').val(data.purchase_price);
                $('#editItemForm select[name="category_id"]').val(data.category_id);

                // Log the ID specifically
                console.log(data); // Check if this always shows the ID as '2'

                if (data.accountability_type === 'PAR') {
                    $('#editItemForm input[name="serial_no"]').prop('disabled', false);
                    $('#editItemForm input[name="serial_no"]').val(data.serial_no);
                } else {
                    $('#editItemForm input[name="serial_no"]').prop('disabled', true);
                    $('#editItemForm input[name="serial_no"]').val('N/A');
                }

                // Reinitialize Select2
                $('#editItemForm select').select2();

                // Show the modal
                $('#editItemModal').modal('show');
            });

            $(document).on('click', 'a[data-action="add-item"]', function(e) {
                let row = $(this).attr('data-row');
                let data = selectedData = itemDt.row(row).data();

                $('#addItemForm')[0].reset();

                $('#itemModal').modal('show');
            })

            $(document).on('click', 'a[data-action="ptr-item"]', function(e) {
                let row = $(this).attr('data-row');
                let data = selectedData = itemDt.row(row).data();

                $('#ptrForm')[0].reset();

                $('#ptrModal').modal('show');
            })

            $(document).on('click', 'a[data-action="delete-item"]', function(e) {
                let row = $(this).attr('data-row');
                let data = itemDt.row(row).data();

                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                Swal.fire({
                    title: "Are you sure you want to delete item?",
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
                        return httpRequest.post(`/item/${ data.id }/delete`, formData);
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

            $(document).on('click', 'a[data-action="print-item"]', function(e) {
                let row = $(this).attr('data-row');
                let data = itemDt.row(row).data();
                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                let printUrl = `/item/${data.item_id}/print`;
                window.open(printUrl, '_blank');
            })

            $(document).on('click', 'a[data-action="print-qr"]', function(e) {
                let row = $(this).attr('data-row');
                let data = itemDt.row(row).data();
                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                let printQr = `/item/${data.item_id}/qr`;
                window.open(printQr, '_blank');
            })

            // Add Item

            // Initialize Select2 for Unit of Measure
            $('#addItemForm #unit_of_measure').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Initialize Select2 for Office Services
            $('#addItemForm #officeServicesItems').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Initialize Select2 for Office Division
            $('#addItemForm #officeDivisionItems').select2({
                placeholder: "Select",
                allowClear: true
            });

            // Initialize Select2 for Status
            $('#addItemForm #status').select2({
                placeholder: "Select",
                allowClear: true
            });

            $('#addItemForm').on('change', 'select[name="cluster_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#addItemForm select[name="office_id"]'),
                    $divisionElem = $('#addItemForm select[name="division_id"]');

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

            $('#addItemForm').on('change', 'select[name="office_id"]', function() {
                let officeId = $(this).val(),
                    $selectElem = $('#addItemForm select[name="division_id"]');

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

            $('#addItemForm').on('change', 'select[name="division_id"]', function() {
                let divisionId = $(this).val(),
                    $selectElem = $('#addItemForm select[name="mr_to"]');

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


            // Declare a variable to store the category type
            let catType = '';

            $('#addItemForm').on('change', 'select[name="category_id"]', function() {
                // Get the selected option and its data-type attribute
                let selectedOption = $(this).find('option:selected');
                catType = selectedOption.attr('data-type');
                console.log("Category Type Selected:", catType);
            });

            $('#addItemForm').on('change', 'input[name="purchase_price"]', function() {
                let ppAmt = $(this).val();

                if(ppAmt > 50000) {
                    $('#addItemForm #sn').removeClass('d-none');
                }
                else {
                    $('#addItemForm #sn').addClass('d-none');
                }

                if (catType === 'ICS' && ppAmt > 50000) {
                    $('#addItemForm #sn').removeClass('d-none');
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
                    $('#addItemForm #sn').addClass('d-none');
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

            // $('#addItemForm').on('input', 'input[name="purchase_price"]', function() {
            //     let value = $(this).val();

            //     // Allow only numbers, commas, and a dot for decimal input
            //     value = value.replace(/[^0-9.]/g, '');

            //     // Split the input into whole number and decimal parts
            //     let parts = value.split('.');
            //     parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ',');

            //     // If there are decimals, keep only two decimal places
            //     let formattedValue = parts[0];
            //     if (parts.length > 1) {
            //         formattedValue += '.' + parts[1].substring(0, 2);
            //     }

            //     // Add peso sign and display the formatted value
            //     $(this).val('₱' + formattedValue);
            // });

            $('#addItemForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                validator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#addItemForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#addItemForm button[type="submit"]').attr('disabled', true);

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

                            $('#addItemForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#addItemForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#addItemModal').modal('hide');
                                $('#addItemForm')[0].reset();
                                $('#addItemForm select').select2();
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

            $('#editItemForm').on('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(this);

                editValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#editItemForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#editItemForm button[type="submit"]').attr('disabled', true);

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
                                return httpRequest.post(`/item/${ selectedData.item_id }/edit`, formData);
                            },
                        }).then(response => {

                            $('#editItemForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#editItemForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#editItemModal').modal('hide');
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

            $('#addItemForm #article_id').select2({
                language: {
                    noResults: function() {
                        return $('<a href="javascript:void(0);" id="addNewArticle" data-toggle="modal" data-target="#supplierModal">Add Article</a>');
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            $(document).on('click', '#addNewArticle', function(e) {
                e.preventDefault();
                $('#article_id').select2('close');
                $('#addItemModal').modal('hide');
                $('#articleModal').modal('show');
            });

            $('#addItemForm #category_id').select2({
                language: {
                    noResults: function() {
                        return $('<a href="javascript:void(0);" id="addNewCategory" data-toggle="modal" data-target="#supplierModal">Add Category</a>');
                    }
                },
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            $(document).on('click', '#addNewCategory', function(e) {
                e.preventDefault();
                $('#category_id').select2('close');
                $('#addItemModal').modal('hide');
                $('#articleModal').modal('show');
            });

        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderItem.init();
});
