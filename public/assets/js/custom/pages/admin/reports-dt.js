"use strict";
var renderItem = function() {

    let ipaDt,
        paDt,
        pcDt,
        ppeDt,
        sepDt,
        selectedData,
        options = {
            minLength: 8,
            checkUppercase: true,
            checkLowercase: true,
            checkDigit: true,
            checkChar: true,
            scoreHighlightClass: "active"
        };

    var start = moment().subtract(29, "days");
    var end = moment();

    function cb(start, end) {
        $("#kt_daterangepicker_4").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
    }

    $('#kt_daterangepicker_4').daterangepicker({
        opens: 'left',
        autoUpdateInput: false, // Prevent auto-filling the input
        locale: {
            cancelLabel: 'Clear'
        }
    });

    $("#kt_daterangepicker_4").daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
        "Today": [moment(), moment()],
        "Yesterday": [moment().subtract(1, "days"), moment().subtract(1, "days")],
        "Last 7 Days": [moment().subtract(6, "days"), moment()],
        "Last 30 Days": [moment().subtract(29, "days"), moment()],
        "This Month": [moment().startOf("month"), moment().endOf("month")],
        "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
        }
    }, cb);

    cb(start, end);

    const updateUI = () => {
        if(ipaDt) {
            ipaDt.ajax.reload(null, false);
        }
        if(paDt) {
            paDt.ajax.reload(null, false);
        }
    }

    return {
        init: function() {

            // Inventory per Account DT
            ipaDt = $('#ipa-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/reports/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        // Remove the default columns data to prevent conflicts
                        delete data.columns;

                        // Add search parameters
                        data.searchCols = ['ref_no'];
                        data.search = data.search.value;

                        // Add custom filter parameters
                        data.category = $('#category_id').val(); // Get selected category
                        data.date_range = $('#kt_daterangepicker_4').val(); // Get selected date range
                    }
                },
                columns: [
                    { data: 'property_no', title: 'Property No.', className: 'text-center fw-semibold', width: '10%'},
                    { data: 'item_quantity', title: 'Quantity', className: 'text-center fw-semibold', width: '5%'},
                    { data: 'unit_of_measure', title: 'UOM', className: 'text-center fw-semibold', width: '10%'},
                    { data: 'id', title: 'Details', className: 'text-center fw-semibold',
                        render: function(data, type, row, meta) {
                            return `
                                <div class='text-start'><span class="text-muted">Category:</span> ${row.category_name}</div>
                                <div class='text-start'><span class="text-muted">Description:</span> ${row.description}</div>
                            `;
                        }
                    },
                    { data: 'purchase_price', title: 'Purchase Price', className: 'text-center fw-semibold', width: '15%',
                        render: function(data, type, row, meta) {
                            let price = parseFloat(data).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 })
                            return `<div class='text-end'>${price}</div>`;
                        }
                    },
                    { data: 'id', title: 'Last Counted', className: 'text-start fw-semibold', width: '15%'},
                    { data: 'created_at', title: 'Date Created', className: 'text-start fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return moment(data).format('LLL');
                        }
                    },
                ]
            })

            ipaDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('click', '[data-action]', function() {
                var action = $(this).attr('data-action');

                if (action === 'gen-ipa') {
                    // Get selected category and date range
                    var category = $('#category_id').val();
                    var dateRange = $('#kt_daterangepicker_4').val();

                    // Apply filters to DataTable
                    // Assuming column 1 corresponds to the category
                    ipaDt.column(1).search(category || '', true, false);

                    // Assuming column 2 corresponds to the date range (you can modify this as needed)
                    ipaDt.column(2).search(dateRange || '', true, false);

                    // Redraw the table with the new filters applied
                    ipaDt.draw();
                }

                if (action === 'clr-ipa') {
                    // Clear the selection
                    $('#category_id').val('').trigger('change'); // Use .trigger('change') to update Select2
                    $('#kt_daterangepicker_4').val('');

                    // Optionally, reload the DataTable to show all data again
                    ipaDt.ajax.reload();
                }

                if (action === 'print-ipa') {
                    let cat = $('#category_id').val();
                    let dateRange = $('#kt_daterangepicker_4').val();

                    if (!cat || !dateRange) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Filters',
                            text: 'Please select category before printing.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Perform an AJAX request to check if there are any available items
                        $.ajax({
                            url: `/reports/check-items-ipa`,  // Endpoint for checking items
                            type: 'GET',
                            data: { category_id: cat, date_range: dateRange },
                            success: function (response) {
                                if (response.hasItems) {
                                    // If items are available, proceed with opening the print URL
                                    let printUrl = `/reports/print/ipa?category_id=${cat}&date_range=${dateRange}`;
                                    window.open(printUrl, '_blank');
                                } else {
                                    // Trigger SweetAlert if no items are found
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'No Data Available',
                                        text: 'No items found for the selected filters. Please try different filters.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                // Handle error if the AJAX request fails
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error checking the data. Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                }
            });

            $('#excelBtnIpa').on('click', function() {
                ipaDt.button('.buttons-excel').trigger();
            });

            // Property Accountability
            paDt = $('#pa-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/reports/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        // Remove the default columns data to prevent conflicts
                        delete data.columns;

                        // Add search parameters
                        data.searchCols = ['ref_no'];
                        data.search = data.search.value;

                        // Add custom filter parameters
                        data.mr_to = $('#mr_to').val(); // Get selected category
                        data.date_range = $('#kt_daterangepicker_4').val(); // Get selected date range
                    }
                },
                columns: [
                    { data: 'invoice_date', title: 'Date Acquired', className: 'text-center fw-semibold', width: '15%',
                        render: function(data, type, row, meta) {
                            return moment(data).format('ll');
                        }
                    },
                    { data: 'property_no', title: 'Property No.', className: 'text-center fw-semibold', width: '10%'},
                    { data: 'item_quantity', title: 'Quantity', className: 'text-center fw-semibold', visible: false},
                    { data: 'unit_of_measure', title: 'UOM', className: 'text-center fw-semibold', visible: false},
                    { data: 'description', title: 'Description', className: 'text-center fw-semibold', visible: false},
                    { data: 'id', title: 'Details', className: 'text-center fw-semibold', width: '50%',
                        render: function(data, type, row, meta) {
                            let price = parseFloat(row.purchase_price).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 })
                            return `
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Description:</span>
                                    <span>${row.description}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Quantity:</span>
                                    <span>${row.item_quantity} ${row.unit_of_measure}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Location:</span>
                                    <span>${row.divab}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Purchase Price:</span>
                                    <span>${price}</span>
                                </div>
                            `;

                        }
                    },
                    { data: 'divab', title: 'Location', className: 'text-center fw-semibold', visible: false},
                    { data: 'purchase_price', title: 'Purchase Price', className: 'text-center fw-semibold', visible: false},
                    { data: 'id', title: 'Remarks', className: 'text-start fw-semibold', width: '25%'},
                    { data: 'created_at', title: 'Date Created', className: 'text-start fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return moment(data).format('LLL');
                        }
                    },
                ]
            })

            paDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('click', '[data-action]', function() {
                var action = $(this).attr('data-action');

                if (action === 'gen-pa') {
                    // Get selected category and date range
                    var empname = $('#mr_to').val();
                    var dateRange = $('#kt_daterangepicker_4').val();

                    // Apply filters to DataTable
                    // Assuming column 1 corresponds to the category
                    paDt.column(1).search(empname || '', true, false);

                    // Assuming column 2 corresponds to the date range (you can modify this as needed)
                    paDt.column(2).search(dateRange || '', true, false);

                    // Redraw the table with the new filters applied
                    paDt.draw();
                }

                if (action === 'clr-pa') {
                    // Clear the selection
                    $('#officeServicesItems').val('').trigger('change'); // Use .trigger('change') to update Select2
                    $('#officeDivisionItems').val('').trigger('change'); // Use .trigger('change') to update Select2
                    $('#mr_to').val('').trigger('change'); // Use .trigger('change') to update Select2

                    $('#kt_daterangepicker_4').val('');

                    // Optionally, reload the DataTable to show all data again
                    paDt.ajax.reload();
                }

                if (action === 'print-pa') {
                    // Get the selected filters (name and date range)
                    let mrTo = $('#mr_to').val();  // Name (MR to)
                    let dateRange = $('#kt_daterangepicker_4').val();  // Date range

                    // Check if both mrTo and dateRange are provided
                    if (!mrTo || !dateRange) {
                        // Trigger SweetAlert if filters are not provided
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Filters',
                            text: 'Please select both "MR to" and a valid date range before printing.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Perform an AJAX request to check if there are any available items
                        $.ajax({
                            url: `/reports/check-items-pa`,  // Endpoint for checking items
                            type: 'GET',
                            data: { mr_to: mrTo, date_range: dateRange },
                            success: function (response) {
                                if (response.hasItems) {
                                    // If items are available, proceed with opening the print URL
                                    let printUrl = `/reports/print/pa?mr_to=${mrTo}&date_range=${dateRange}`;
                                    window.open(printUrl, '_blank');
                                } else {
                                    // Trigger SweetAlert if no items are found
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'No Data Available',
                                        text: 'No items found for the selected filters. Please try different filters.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                // Handle error if the AJAX request fails
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error checking the data. Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                }
            });

            $('#excelBtnPa').on('click', function() {
                paDt.button('.buttons-excel').trigger();
            });

            // Handle change for cluster_id
            $('select[name="cluster_id"]').on('change', function() {
                let officeId = $(this).val(),
                    $selectElem = $('select[name="office_id"]'),
                    $divisionElem = $('select[name="division_id"]');

                $selectElem.empty();
                $divisionElem.empty();
                console.log(officeId, $selectElem, $divisionElem);

                httpRequest
                    .get('/office/search?n=' + officeId)
                    .then(response => {
                        if(response.length > 0) {
                            $selectElem.append(`<option value="0" selected>None</option>`);
                            for (const d of response) {
                                $selectElem.append(`<option value="${d.id}">${d.office_name} (${d.abbre})</option>`);
                            }
                        }
                    });
            });

            // Handle change for office_id
            $('select[name="office_id"]').on('change', function() {
                let officeId = $(this).val(),
                    $selectElem = $('select[name="division_id"]');

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
                    });
            });

            // Handle change for division_id
            $('select[name="division_id"]').on('change', function() {
                let divisionId = $(this).val(),
                    $selectElem = $('select[name="mr_to"]');

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
                    });
            });

            // // Initialize IPA DataTable buttons
            // new $.fn.dataTable.Buttons(ipaDt, {
            //     buttons: [
            //         {
            //             extend: 'excelHtml5',
            //             text: '<i class="ki-duotone ki-file-download text-white fs-3"></i>',
            //             title: function() {
            //                 var dateRange = $('#kt_daterangepicker_4').val();
            //                 var endDate = dateRange ? dateRange.split(' - ')[1] : '';
            //                 return 'Inventory per Account\nReport as of ' + endDate;
            //             },
            //             className: 'd-none', // Hide the default button
            //             exportOptions: {
            //                 columns: ':visible',
            //                 modifier: {
            //                     search: 'applied',
            //                     order: 'applied'
            //                 }
            //             }
            //         }
            //     ]
            // });
            // ipaDt.buttons().container().appendTo('#ipaExportContainer'); // Append to IPA container

            // // Initialize PA DataTable buttons
            // new $.fn.dataTable.Buttons(paDt, {
            //     buttons: [
            //         {
            //             extend: 'excelHtml5',
            //             text: '<i class="fas fa-download text-white fs-3"></i>',
            //             title: function() {
            //                 var dateRange = $('#kt_daterangepicker_4').val();
            //                 var endDate = dateRange ? dateRange.split(' - ')[1] : '';
            //                 return 'Property Accountability\nReport as of ' + endDate;
            //             },
            //             exportOptions: {
            //                 columns: ':visible',
            //                 modifier: {
            //                     search: 'applied',
            //                     order: 'applied'
            //                 }
            //             }
            //         }
            //     ]
            // });

            // Append buttons to the container
            // paDt.buttons().container().appendTo('#paExportContainer');

            // Property Card DT
            pcDt = $('#pc-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/reports/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        // Remove the default columns data to prevent conflicts
                        delete data.columns;

                        // Add search parameters
                        data.searchCols = ['ref_no'];
                        data.search = data.search.value;

                        // Add custom filter parameters
                        data.category = $('#category_id').val(); // Get selected category
                        data.date_range = $('#kt_daterangepicker_4').val(); // Get selected date range
                    }
                },
                columns: [
                    { data: 'property_no', title: 'Property No.', className: 'text-center fw-semibold', width: '10%'},
                    { data: 'item_quantity', title: 'Quantity', className: 'text-center fw-semibold', width: '5%'},
                    { data: 'unit_of_measure', title: 'UOM', className: 'text-center fw-semibold', width: '10%'},
                    { data: 'id', title: 'Details', className: 'text-center fw-semibold',
                        render: function(data, type, row, meta) {
                            return `
                                <div class='text-start'><span class="text-muted">Category:</span> ${row.category_name}</div>
                                <div class='text-start'><span class="text-muted">Description:</span> ${row.description}</div>
                            `;
                        }
                    },
                    { data: 'purchase_price', title: 'Purchase Price', className: 'text-center fw-semibold', width: '15%',
                        render: function(data, type, row, meta) {
                            let price = parseFloat(data).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 })
                            return `<div class='text-end'>${price}</div>`;
                        }
                    },
                    { data: 'id', title: 'Last Counted', className: 'text-start fw-semibold', width: '15%'},
                    { data: 'created_at', title: 'Date Created', className: 'text-start fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return moment(data).format('LLL');
                        }
                    },
                ]
            })

            pcDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('click', '[data-action]', function() {
                var action = $(this).attr('data-action');

                if (action === 'gen-pc') {
                    // Get selected category and date range
                    var category = $('#category_id').val();
                    var dateRange = $('#kt_daterangepicker_4').val();

                    // Apply filters to DataTable
                    // Assuming column 1 corresponds to the category
                    pcDt.column(1).search(category || '', true, false);

                    // Assuming column 2 corresponds to the date range (you can modify this as needed)
                    pcDt.column(2).search(dateRange || '', true, false);

                    // Redraw the table with the new filters applied
                    pcDt.draw();
                }

                if (action === 'clr-pc') {
                    // Clear the selection
                    $('#category_id').val('').trigger('change'); // Use .trigger('change') to update Select2
                    $('#kt_daterangepicker_4').val('');

                    // Optionally, reload the DataTable to show all data again
                    pcDt.ajax.reload();
                }

                if (action === 'print-pc') {
                    let cat = $('#category_id').val();
                    let dateRange = $('#kt_daterangepicker_4').val();

                    if (!cat || !dateRange) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Filters',
                            text: 'Please select category before printing.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Perform an AJAX request to check if there are any available items
                        $.ajax({
                            url: `/reports/check-items-pc`,  // Endpoint for checking items
                            type: 'GET',
                            data: { category_id: cat, date_range: dateRange },
                            success: function (response) {
                                if (response.hasItems) {
                                    // If items are available, proceed with opening the print URL
                                    let printUrl = `/reports/print/pc?category_id=${cat}&date_range=${dateRange}`;
                                    window.open(printUrl, '_blank');
                                } else {
                                    // Trigger SweetAlert if no items are found
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'No Data Available',
                                        text: 'No items found for the selected filters. Please try different filters.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                // Handle error if the AJAX request fails
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error checking the data. Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                }
            });

            $('#excelBtnIpa').on('click', function() {
                pcDt.button('.buttons-excel').trigger();
            });

            // RPCPPE DT
            ppeDt = $('#ppe-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/reports/dt?type=PAR`,
                    dataSrc: 'data',
                    data: function(data) {
                        // Remove the default columns data to prevent conflicts
                        delete data.columns;

                        // Add search parameters
                        data.searchCols = ['ref_no'];
                        data.search = data.search.value;

                        // Add custom filter parameters
                        data.category = $('#category_id').val(); // Get selected category
                        data.date_range = $('#kt_daterangepicker_4').val(); // Get selected date range
                        data.type = 'PAR';
                    }
                },
                columns: [
                    { data: 'category_name', title: 'Article', className: 'text-center fw-semibold', visible: false},
                    { data: 'description', title: 'Description', className: 'text-center fw-semibold', visible: false},
                    { data: 'id', title: 'Details', className: 'text-center fw-semibold', width: '50%',
                        render: function(data, type, row, meta) {
                            let price = parseFloat(row.purchase_price).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 })
                            return `
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Property No.:</span>
                                    <span>${row.property_no}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Article:</span>
                                    <span>${row.category_name}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Description:</span>
                                    <span>${row.description}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Unit Value:</span>
                                    <span>${price}</span>
                                </div>
                            `;
                        }
                    },
                    { data: 'id', title: 'Quantities', className: 'text-center fw-semibold', width: '25%',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Quantity per Property Card:</span>
                                    <span>1</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Quantity per Physical Count:</span>
                                    <span>1</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Shortage/Overage Quantity:</span>
                                    <span>0</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Shortage/Overage Value:</span>
                                    <span>0.00</span>
                                </div>
                            `;
                        }
                    },
                    { data: 'property_no', title: 'Property Number', className: 'text-center fw-semibold', visible: false},
                    { data: 'unit_of_measure', title: 'UOM', className: 'text-center fw-semibold', visible: false},
                    { data: 'purchase_price', title: 'Unit Value', className: 'text-center fw-semibold', visible: false},
                    { data: 'item_quantity', title: 'Qty per Property Card', className: 'text-center fw-semibold', visible: false},
                    { data: 'item_quantity', title: 'Qty per Physical Count', className: 'text-center fw-semibold', visible: false},
                    { data: 'id', title: 'Shortage/Overage Qty', className: 'text-center fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return `<div class='text-end'>0</div>`;
                        }
                    },
                    { data: 'id', title: 'Shortage/Overage Value', className: 'text-center fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return `<div class='text-end'>0.00</div>`;
                        }
                    },
                    { data: 'id', title: 'Remarks', className: 'text-center fw-semibold', width: '25%',
                        render: function(data, type, row, meta) {
                            return `
                                <div class='text-center'>${row.employee.fullname}</div>
                                <div class='text-center'>${row.divab}</div>
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

            ppeDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('click', '[data-action]', function() {
                var action = $(this).attr('data-action');

                if (action === 'gen-ppe') {
                    // Get selected category and date range
                    var category = $('#category_id').val();
                    var dateRange = $('#kt_daterangepicker_4').val();

                    // Apply filters to DataTable
                    // Assuming column 1 corresponds to the category
                    ppeDt.column(1).search(category || '', true, false);

                    // Assuming column 2 corresponds to the date range (you can modify this as needed)
                    ppeDt.column(2).search(dateRange || '', true, false);

                    // Redraw the table with the new filters applied
                    ppeDt.draw();
                }

                if (action === 'clr-ppe') {
                    // Clear the selection
                    $('#category_id').val('').trigger('change'); // Use .trigger('change') to update Select2
                    $('#kt_daterangepicker_4').val('');

                    // Optionally, reload the DataTable to show all data again
                    ppeDt.ajax.reload();
                }

                if (action === 'print-ppe') {
                    let cat = $('#category_id').val();
                    let dateRange = $('#kt_daterangepicker_4').val();

                    if (!cat || !dateRange) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Filters',
                            text: 'Please select category before printing.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Perform an AJAX request to check if there are any available items
                        $.ajax({
                            url: `/reports/check-items-ppe`,  // Endpoint for checking items
                            type: 'GET',
                            data: { category_id: cat, date_range: dateRange },
                            success: function (response) {
                                if (response.hasItems) {
                                    // If items are available, proceed with opening the print URL
                                    let printUrl = `/reports/print/ppe?category_id=${cat}&date_range=${dateRange}`;
                                    window.open(printUrl, '_blank');
                                } else {
                                    // Trigger SweetAlert if no items are found
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'No Data Available',
                                        text: 'No items found for the selected filters. Please try different filters.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                // Handle error if the AJAX request fails
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error checking the data. Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                }

            });

            // RPCSEP DT
            sepDt = $('#sep-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                ordering: false,
                ajax: {
                    url: `/reports/dt?type=ICS`,
                    dataSrc: 'data',
                    data: function(data) {
                        // Remove the default columns data to prevent conflicts
                        delete data.columns;

                        // Add search parameters
                        data.searchCols = ['ref_no'];
                        data.search = data.search.value;

                        // Add custom filter parameters
                        data.category = $('#category_id').val(); // Get selected category
                        data.date_range = $('#kt_daterangepicker_4').val(); // Get selected date range
                    }
                },
                columns: [
                    { data: 'article_name', title: 'Article', className: 'text-center fw-semibold', visible: false},
                    { data: 'description', title: 'Description', className: 'text-center fw-semibold', visible: false},
                    { data: 'id', title: 'Details', className: 'text-center fw-semibold', width: '50%',
                        render: function(data, type, row, meta) {
                            let price = parseFloat(row.purchase_price).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 })
                            return `
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Property No.:</span>
                                    <span>${row.property_no}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Article:</span>
                                    <span>${row.category_name}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Description:</span>
                                    <span>${row.description}</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 120px;">Unit Value:</span>
                                    <span>${price}</span>
                                </div>
                            `;
                        }
                    },
                    { data: 'id', title: 'Quantities', className: 'text-center fw-semibold', width: '25%',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Quantity per Property Card:</span>
                                    <span>1</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Quantity per Physical Count:</span>
                                    <span>1</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Shortage/Overage Quantity:</span>
                                    <span>0</span>
                                </div>
                                <div class="d-flex">
                                    <span class="text-start text-muted fw-bold" style="min-width: 180px;">Shortage/Overage Value:</span>
                                    <span>0.00</span>
                                </div>
                            `;
                        }
                    },
                    { data: 'property_no', title: 'Property Number', className: 'text-center fw-semibold', visible: false},
                    { data: 'unit_of_measure', title: 'UOM', className: 'text-center fw-semibold', visible: false},
                    { data: 'purchase_price', title: 'Unit Value', className: 'text-center fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            let price = parseFloat(data).toLocaleString('en-PH', { style: 'currency', currency: 'PHP', minimumFractionDigits: 2, maximumFractionDigits: 2 })
                            return `<div class='text-end'>${price}</div>`;
                        }
                    },
                    { data: 'item_quantity', title: 'Qty per Property Card', className: 'text-center fw-semibold', visible: false},
                    { data: 'item_quantity', title: 'Qty per Physical Count', className: 'text-center fw-semibold', visible: false},
                    { data: 'id', title: 'Shortage/Overage Qty', className: 'text-center fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return `<div class='text-end'>0</div>`;
                        }
                    },
                    { data: 'id', title: 'Shortage/Overage Value', className: 'text-center fw-semibold', visible: false,
                        render: function(data, type, row, meta) {
                            return `<div class='text-end'>0.00</div>`;
                        }
                    },
                    { data: 'id', title: 'Remarks', className: 'text-center fw-semibold', width: '25%',
                        render: function(data, type, row, meta) {
                            console.log(data);
                            return `
                                <div class='text-center'>${row.employee.fullname}</div>
                                <div class='text-center'>${row.divab}</div>
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

            sepDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('click', '[data-action]', function() {
                var action = $(this).attr('data-action');

                if (action === 'gen-sep') {
                    // Get selected category and date range
                    var category = $('#category_id').val();
                    var dateRange = $('#kt_daterangepicker_4').val();

                    // Apply filters to DataTable
                    // Assuming column 1 corresponds to the category
                    sepDt.column(1).search(category || '', true, false);

                    // Assuming column 2 corresponds to the date range (you can modify this as needed)
                    sepDt.column(2).search(dateRange || '', true, false);

                    // Redraw the table with the new filters applied
                    sepDt.draw();
                }

                if (action === 'clr-sep') {
                    // Clear the selection
                    $('#category_id').val('').trigger('change'); // Use .trigger('change') to update Select2
                    $('#kt_daterangepicker_4').val('');

                    // Optionally, reload the DataTable to show all data again
                    ppeDt.ajax.reload();
                }

                if (action === 'print-sep') {
                    let cat = $('#category_id').val();
                    let dateRange = $('#kt_daterangepicker_4').val();

                    if (!cat || !dateRange) {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Missing Filters',
                            text: 'Please select category before printing.',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        // Perform an AJAX request to check if there are any available items
                        $.ajax({
                            url: `/reports/check-items-sep`,  // Endpoint for checking items
                            type: 'GET',
                            data: { category_id: cat, date_range: dateRange },
                            success: function (response) {
                                if (response.hasItems) {
                                    // If items are available, proceed with opening the print URL
                                    let printUrl = `/reports/print/sep?category_id=${cat}&date_range=${dateRange}`;
                                    window.open(printUrl, '_blank');
                                } else {
                                    // Trigger SweetAlert if no items are found
                                    Swal.fire({
                                        icon: 'info',
                                        title: 'No Data Available',
                                        text: 'No items found for the selected filters. Please try different filters.',
                                        confirmButtonText: 'OK'
                                    });
                                }
                            },
                            error: function () {
                                // Handle error if the AJAX request fails
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'There was an error checking the data. Please try again later.',
                                    confirmButtonText: 'OK'
                                });
                            }
                        });
                    }
                }

            });

            // $('#excelBtnIpa').on('click', function() {
            //     ipaDt.button('.buttons-excel').trigger();
            // });


        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderItem.init();
});
