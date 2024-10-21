const get_offices = (selector, cluster, val = 0) => {
    $(selector).empty();
    httpRequest
        .get('/office/search?n=' + cluster)
        .then(response => {
            if(response.length > 0) {
                $(selector).append(`<option value="0">None</option>`);
                for (const d of response) {
                    let isSelected = d.id == val ? ' selected' : '';
                    $(selector).append(`<option value="${ d.id }"${ isSelected }>${ d.office_name } (${ d.abbre })</option>`);
                }
            }
        })
}

const get_division = (selector, office, val = 0) => {
    $(selector).empty();
    httpRequest
        .get('/division/search?n=' + office)
        .then(response => {
            if(response.length > 0) {
                $(selector).append(`<option value="0">None</option>`);
                for (const d of response) {
                    let isSelected = d.id == val ? ' selected' : '';
                    $(selector).append(`<option value="${ d.id }"${ isSelected }>${ d.division_name } (${ d.abbre })</option>`);
                }
            }
        })
}