const basedUrl = window.location.origin;


/**
 * DataTable Pipelines
 */

 const pipelines = (opts) => {
    // Configuration options
    var conf = $.extend( {
        pages: 5,     // number of pages to cache
        url: '',      // script url
        data: null,   // function or object with parameters to send to the server
                    // matching how `ajax.data` works in DataTables
        method: 'GET' // Ajax HTTP method
    }, opts );

    // Private variables for storing the cache
    var cacheLower = -1;
    var cacheUpper = null;
    var cacheLastRequest = null;
    var cacheLastJson = null;

    return function ( request, drawCallback, settings ) {
        var ajax          = false;
        var requestStart  = request.start;
        var drawStart     = request.start;
        var requestLength = request.length;
        var requestEnd    = requestStart + requestLength;
                
        if ( settings.clearCache ) {
            // API requested that the cache be cleared
            ajax = true;
            settings.clearCache = false;
        }
        else if ( cacheLower < 0 || requestStart < cacheLower || requestEnd > cacheUpper ) {
            // outside cached data - need to make a request
            ajax = true;
        }
        else if ( JSON.stringify( request.order )   !== JSON.stringify( cacheLastRequest.order ) ||
                JSON.stringify( request.columns ) !== JSON.stringify( cacheLastRequest.columns ) ||
                JSON.stringify( request.search )  !== JSON.stringify( cacheLastRequest.search )
        ) {
            // properties changed (ordering, columns, searching)
            ajax = true;
        }
                
        // Store the request for checking next time around
        cacheLastRequest = $.extend( true, {}, request );

        if ( ajax ) {
            // Need data from the server
            if ( requestStart < cacheLower ) {
                requestStart = requestStart - (requestLength*(conf.pages-1));

                if ( requestStart < 0 ) {
                    requestStart = 0;
                }
            }
                    
            cacheLower = requestStart;
            cacheUpper = requestStart + (requestLength * conf.pages);

            request.start = requestStart;
            request.length = requestLength*conf.pages;

            // Provide the same `data` options as DataTables.
            if ( typeof conf.data === 'function' ) {
                // As a function it is executed with the data object as an arg
                // for manipulation. If an object is returned, it is used as the
                // data object to submit
                var d = conf.data( request );
                if ( d ) {
                    $.extend( request, d );
                }
            }
            else if ( $.isPlainObject( conf.data ) ) {
                // As an object, the data given extends the default
                $.extend( request, conf.data );
            }

            return $.ajax( {
                "type":     conf.method,
                "url":      conf.url,
                "data":     request,
                "dataType": "json",
                "cache":    false,
                "success":  function ( json ) {
                    cacheLastJson = $.extend(true, {}, json);
                    if ( cacheLower != drawStart ) {
                        json.data.splice( 0, drawStart-cacheLower );
                    }
                    if ( requestLength >= -1 ) {
                        json.data.splice( requestLength, json.data.length );
                    }
                    
                    drawCallback( json );
                }
            } );
        }
        else {
            json = $.extend( true, {}, cacheLastJson );
            json.draw = request.draw; // Update the echo for each response
            json.data.splice( 0, requestStart-cacheLower );
            json.data.splice( requestLength, json.data.length );

            drawCallback(json);
        }
    }
}

/**
 * Clear DataTable
 */

$.fn.dataTable.Api.register( 'clearPipeline()', function () {
    return this.iterator( 'table', function ( settings ) {
        settings.clearCache = true;
    } );
} );

/**
 * DataTable ServerSide Export
 */

const exportDatas = (e, dt, button, config) => {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;
    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;
        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            if (button[0].className.indexOf('buttons-copy') >= 0) {
                $.fn.dataTable.ext.buttons.copyHtml5.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-excel') >= 0) {
                $.fn.dataTable.ext.buttons.excelHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-csv') >= 0) {
                $.fn.dataTable.ext.buttons.csvHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.csvHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.csvFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
                $.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config) ?
                    $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config) :
                    $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
            } else if (button[0].className.indexOf('buttons-print') >= 0) {
                $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
            }
            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });
            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);
            // Prevent rendering of the full data to the DOM
            return false;
        });
    });
    // Requery the server with the new one-time export settings
    dt.ajax.reload();
}

/**
 * AJAX HTTP Request
 */

let httpRequest = {
    get: async (_url) => {
        let result = null;
        try {
            result = await $.getJSON(_url);
        } catch (error) {
            result = {
                success: false,
                message: error.responseText,
                payload: null 
            }
        }
        return result;
    },
    post: async (_url, _data) => {
        let result = null;
        try {
            result = await $.ajax({
                url        : _url,
                data       : _data,
                type       : 'post',
                dataType   : 'json',
                contentType: false,
                processData: false
            });
        } catch (error) {
            result = {
                success: false,
                message: error.responseText,
                payload: null 
            }
        }
        return result;
    },
    upload: async (_url, _data) => {
        let result = null;
        try {
            result = await $.ajax({
                url        : _url,
                data       : _data,
                type       : 'post',
                dataType   : 'json',
                enctype    : 'multipart/formdata',
                contentType: false,
                processData: false
            });
        } catch (error) {
            result = {
                success: false,
                message: error.responseText,
                payload: null 
            }
        }

        return result;
    },
    token: async (_url, _data, _token) => {
        let result = null;
        try {
            result = await $.ajax({
                headers    : { 'X-CSRF-TOKEN': data.token },
                url        : _url,
                data       : _data,
                type       : 'post',
                dataType   : 'json',
                contentType: false,
                processData: false
            });
        } catch (error) {
            result = {
                success: false,
                message: error.responseText,
                payload: null 
            }
        }
        return result;
    },
}

/**
 * Currency Format
 */

const currencyFormat = (value) => {
    return Number(value).toLocaleString('en-PH', {
        style: 'currency',
        currency: 'PHP',
        useGrouping: true,
        minimumFractionDigits: 2,
        maximumFractionDigits: 2,
    });
}


const get_field_office = (fieldOffice) => {
    let _offices = [
        { id: 'RO', name: "Regional Office" },
        { id: 'CFO', name: "CAMANAVA Field Office" },
        { id: 'MPFO', name: "Makati-Pasay Field Office" },
        { id: 'MFO', name: "Manila Field Office" },
        { id: 'MTPLFO', name: "MUNTAPARLAS Field Office" },
        { id: 'PFO', name: "PAPAMAMARISAM Field Office" },
        { id: 'QCFO', name: "Quezon City Field Office" },
        { id: 'ORD', name: "Office of the Regional Director" },
        { id: 'OARD', name: "Office of the Assistant Director" },
        { id: 'OARD_1', name: "Office of the Assistant Director 1" },
        { id: 'OARD_2', name: "Office of the Assistant Director 2" },
        { id: 'IMSD', name: "Internal Management & Services Division" },
        { id: 'TSSD-EPWW', name: "Technical Service & Support Division - EPWW" },
        { id: 'TSSD-LRLS', name: "Technical Service & Support Division - LRLS" },
        { id: 'MALSU', name: "Mediation - Arbitration and Legal Services Unit" },
        { id: 'BLE', name: "Beauru of Labor and Employment" },
        { id: 'CAR', name: "Cordillera Administrative Region" },
        { id: 'CARAGA', name: "Caraga Administrative Region" },
        { id: 'RO-I', name: "Regional Office I" },
        { id: 'RO-II', name: "Regional Office II" },
        { id: 'RO-III', name: "Regional Office III" },
        { id: 'RO-IVA', name: "Regional Office IVA" },
        { id: 'RO-IVB', name: "Regional Office IVB" },
        { id: 'RO-V', name: "Regional Office V" },
        { id: 'RO-VI', name: "Regional Office VI" },
        { id: 'RO-VII', name: "Regional Office VII" },
        { id: 'RO-VIII', name: "Regional Office VIII" },
        { id: 'RO-IX', name: "Regional Office IX" },
        { id: 'RO-X', name: "Regional Office X" },
        { id: 'RO-XI', name: "Regional Office XI" },
        { id: 'RO-XII', name: "Regional Office XII" },
        { id: 'CENTRAL OFFICE', name: "Central Office" },
    ]

    return _offices.find(itm => itm.id == fieldOffice) || [];
}

const get_leave_type = (code) => {
    let _application = [
        { code: 'VL', name: "Vacation Leave" },
        { code: 'MFL', name: "Forced Leave" },
        { code: 'SL', name: "Sick Leave" },
        { code: 'ML', name: "Maternity Leave" },
        { code: 'PL', name: "Paternity Leave" },
        { code: 'SPL', name: "Special Privilege Leave" },
        { code: 'SOPL', name: "Solo Parent Leave" },
        { code: 'STL', name: "Study Leave" },
        { code: 'VAWCL', name: "10-Day VAWC Leave" },
        { code: 'RPL', name: "Rehabilitation Privilege" },
        { code: 'SLB', name: "Special Leave Benefits for Women" },
        { code: 'SEL', name: "Special Emergency (Calamity) Leave" },
        { code: 'ADL', name: "Adoption Leave" },
        { code: 'VBL', name: "Vaccination/Booster Leave" },
        { code: 'QL', name: "Quarantine Leave" },
        { code: 'EML', name: "15 Days Extension of Maternity Leave of Solo Parent" },
        { code: 'CTF', name: "Compassionate Time-Off" },
        { code: 'CTO', name: "Compensatory Time-Off" },
        { code: 'FV', name: "Family Visit" },
    ]

    return _application.find(itm => itm.code == code).name || [];
}

let _mandatoryField = {
    validators: {
        notEmpty: {
            message: 'Required Field',
            trim: true
        },
    }
}

const field_validator = (fieldName, validation) => {
    let fields = validation.getFields(),
        _obj   = Object.keys(fields)
    return _obj.includes(fieldName);
}

/**
 * Convert date
 */

const convertDate = (date, format = 'YYYY-MM-DD') => {
    return moment(date).format(format);
}

const display_date_range = (start, end) => {

    if(start == end) return moment(start).format('ll');
    
    let _strMonth = convertDate(start, 'MMMM YYYY'),
        _endMonth = convertDate(end, 'MMMM YYYY');

    if(_strMonth == _endMonth) {
        return `${ convertDate(start, 'MMM. DD') } ${ convertDate(end, ' - DD, YYYY') }`; 
    }
    
    return `${ convertDate(start, 'MMM. DD, YYYY') } - ${ convertDate(end, 'MMM. DD, YYYY') }`;  
}

$(document).on('change', 'input[type="text"], textarea', function() {
    let _val = $(this).val(),
        newVal = _val.replace(/'/g, '’');

    $(this).val(newVal);
})

const transform_text = (txt) => {
    return txt.toLowerCase().replace(/\b(\w)/g, s => s.toUpperCase())
}
