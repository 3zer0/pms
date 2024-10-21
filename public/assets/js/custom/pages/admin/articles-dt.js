"use strict";
var renderArticle = function() {

    let articleDt,
        categoryDt,
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
        if(articleDt) {
            articleDt.ajax.reload(null, false);
        }
    }

    var artValidator = FormValidation.formValidation(
        document.querySelector('#articleForm'),
        {
            fields: {
                'article_name': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'useful_life': {
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

    var catValidator = FormValidation.formValidation(
        document.querySelector('#categoryForm'),
        {
            fields: {
                'category_name': {
                    validators: {
                        notEmpty: {
                            message: 'Required Field',
                            trim: true
                        },
                    }
                },
                'category_code': {
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
            // Article Table
            articleDt = $('#article-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                pageLength: 5,
                ordering: false,
                ajax: {
                    url: `/article/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        delete data.columns;

                        data.searchCols = [ 'article_name' ];
                        data.search = data.search.value;
                    }
                },
                columns: [
                    { data: 'action', title: 'Action', className: 'text-center fw-semibold', width: '5%'},
                    { data: 'article_name', title: 'Article Name.', className: 'text-center fw-semibold', width: '70%',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="text-start">${data}</div>
                            `
                        }
                    },
                    { data: 'useful_life', title: 'Useful Life', className: 'text-center fw-semibold', width: '25%'},
                ]
            })

            articleDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('keyup', '[data-dt-filter="search"]', function(e) {
                articleDt.search(e.target.value).draw();
            })

            $('#articleForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                artValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#articleForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#articleForm button[type="submit"]').attr('disabled', true);

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

                            $('#articleForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#articleForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#articleModal').modal('hide');
                                $('#articleForm')[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Article successfully added.',
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

            $(document).on('click', 'a[data-action="delete-article"]', function(e) {
                let row = $(this).attr('data-row');
                let data = articleDt.row(row).data();

                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                Swal.fire({
                    title: "Are you sure you want to delete article?",
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
                        return httpRequest.post(`/article/${ data.id }/delete`, formData);
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

            // Category Table
            categoryDt = $('#category-tbl').DataTable({
                searchDelay: 500,
                processing: true,
                serverSide: true,
                bLengthChange: false,
                pageLength: 5,
                ordering: false,
                ajax: {
                    url: `/category/dt`,
                    dataSrc: 'data',
                    data: function(data) {
                        delete data.columns;

                        data.searchCols = [ 'category_name' ];
                        data.search = data.search.value;
                    }
                },
                columns: [
                    { data: 'action', title: 'Action', className: 'text-center fw-semibold', width: '5%'},
                    { data: 'category_name', title: 'Category Name.', className: 'text-center fw-semibold', width: '70%',
                        render: function(data, type, row, meta) {
                            return `
                                <div class="text-start">${data}</div>
                            `
                        }
                    },
                    { data: 'category_code', title: 'Category Code', className: 'text-end fw-semibold', width: '25%'},
                ]
            })

            categoryDt.on('draw', function () {
                KTMenu.createInstances();
            });

            $(document).on('keyup', '[data-dt-filter="search"]', function(e) {
                categoryDt.search(e.target.value).draw();
            })

            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();

                let requestUrl = $(this).attr('action');
                let formData   = new FormData(this);

                catValidator.validate().then(status => {
                    if(status == 'Valid') {

                        $('#categoryForm button[type="submit"]').attr('data-kt-indicator', 'on');
                        $('#categoryForm button[type="submit"]').attr('disabled', true);

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

                            $('#categoryForm button[type="submit"]').attr('data-kt-indicator', 'off');
                            $('#categoryForm button[type="submit"]').attr('disabled', false);

                            if(response.value.success) {
                                updateUI();
                                $('#categoryModal').modal('hide');
                                $('#categoryForm')[0].reset();
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success!',
                                    text: 'Category successfully added.',
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

            $(document).on('click', 'a[data-action="delete-category"]', function(e) {
                let row = $(this).attr('data-row');
                let data = categoryDt.row(row).data();

                let token = $('meta[name="csrf-token"]').attr('content');
                let formData = new FormData();
                formData.append('_token', token);

                Swal.fire({
                    title: "Are you sure you want to delete category?",
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
                        return httpRequest.post(`/category/${ data.id }/delete`, formData);
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

        }
    };
}();

// On document ready
KTUtil.onDOMContentLoaded(function() {
    renderArticle.init();
});
