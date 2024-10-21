const get_region = (data) => {
    httpRequest.get(`/psgc/region`)
        .then(response => {
            if(response.length > 0) {
                $(data.selector).empty();
                $(data.selector).append(`<option value="">-- select --</option>`);
                for (const _d of response) {
                    let isSelected = '';
                    if(data.selected != null) {
                        isSelected = parseInt(_d.code) == parseInt(data.selected) ?
                                ' selected' : '';
                    }
                    $(data.selector).append(`<option value="${ _d.code }"${ isSelected }>${ _d.name }</option>`);
                }
            }
        })
}

const get_province = (data) => {
    httpRequest.get(`/psgc/province/${ data.region }`)
        .then(response => {
            if(response.length > 0) {
                $(data.selector).empty();
                $(data.selector).append(`<option value="">-- select --</option>`);
                for (const _d of response) {
                    let isSelected = '';
                    if(data.selected != null) {
                        isSelected = parseInt(_d.code) == parseInt(data.selected) ?
                                ' selected' : '';
                    }
                    $(data.selector).append(`<option value="${ _d.code }"${ isSelected }>${ _d.name }</option>`);
                }
            }
        })
}

const get_city_municipality = (data) => {
    httpRequest.get(`/psgc/city/${ data.province }`)
        .then(response => {
            if(response.length > 0) {
                $(data.selector).empty();
                $(data.selector).append(`<option value="">-- select --</option>`);
                for (const _d of response) {

                    let isSelected = '';
                    if(data.selected != null) {
                        isSelected = parseInt(_d.code) == parseInt(data.selected) ?
                                ' selected' : '';
                    }

                    $(data.selector).append(`<option value="${ _d.code }"${ isSelected }>${ _d.name }</option>`);
                }
            }
        })
}

const get_barangay = (data) => {
    httpRequest.get(`/psgc/barangay/${ data.city }`)
        .then(response => {
            if(response.length > 0) {
                $(data.selector).empty();
                $(data.selector).append(`<option value="">-- select --</option>`);
                for (const _d of response) {

                    let isSelected = '';
                    if(data.selected != null) {
                        isSelected = parseInt(_d.code) == parseInt(data.selected) ?
                                ' selected' : '';
                    }

                    $(data.selector).append(`<option value="${ _d.code }"${ isSelected }>${ _d.name }</option>`);
                }
            }
        })
}