<!DOCTYPE html>
<html>
<head>
    <title>QR Code</title>
    <style>
        @page {
            size: portrait;
            height: 62mm;
            width: 29mm;
            margin: 0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background-color: #d4d4d4;
            font-family: Poppins, Helvetica, "sans-serif";
            font-size: 13px;
            /* line-height: 1.5; */
        }

        h4 {
            font-size: 15px;
            font-weight: 600;
            margin: 0;
        }

        p {
            font-size: 13px;
            line-height: 1.2;
            text-align: justify;
        }

        .container {
            position: relative;
            background: white;
            display: block;
            margin: 0 auto;
            /* margin-bottom: .50cm; */
        }

        .container[size="legal"] {
            height: 62mm;
            width: 29mm;
            height: 100%;
        }

        .print-area {
            padding: 0;
        }

        /* .center {
            text-align: center;
        }

        .right {
            text-align: right;
        }

        .left {
            text-align: left;
        } */

        .font-weight-regular {
            font-weight: 400;
        }

        .font-weight-bold {
            font-weight: 600;
        }

        .font-12 {
            font-size: 12px;
        }

        .font-13 {
            font-size: 13px;
        }

        .font-14 {
            font-size: 14px;
        }

        .font-15 {
            font-size: 15px;
        }

        .m-0 {
            margin: 0;
        }

        .mt-1 {
            margin-top: 10px;
        }

        .mt-2 {
            margin-top: 15px;
        }

        .mt-3 {
            margin-top: 20px;
        }

        .mb-1 {
            margin-bottom: 10px;
        }

        .mb-2 {
            margin-bottom: 15px;
        }

        .mb-3 {
            margin-bottom: 20px;
        }


        .pr-indent {
            text-indent: 50px;
            text-align: justify;
        }

        .justify {
            text-align: justify;
        }

        .d-flex {
            display: flex;
        }

        .d-space-between {
            justify-content: space-between;
        }

        .d-align-items-center {
            align-items: center;
        }

        table {
            border-collapse: collapse;
        }

        .table td, .table th {
            border: 1px solid #000;
            padding: 1px 2px;
        }

        .inline {
            display: flex;
        }

        li {
            list-style-type: none;
        }



        @media print {
            body, .container {
                margin: 0;
                box-shadow: 0;
            }

            table { page-break-inside:auto }
            tr    { page-break-inside:avoid; page-break-after:auto }
            thead { display:table-header-group }
            tfoot { display:table-footer-group }
        }
    </style>
</head>
{{-- <body>
    <div class="visible-print text-center">
        <h1>Laravel QR Code</h1>
        {!! $qrCode !!}
    </div>
</body> --}}


<body>
    <div class="container" size="legal">
        <div class="print-area">
            <div class="" style="display: flex; justify-content: center; align-item: center;">
                {{-- <img src="assets/media/logos/dole_logo_new.png" height="80" width="80" style="text-align: left; opacity: 1; margin-top: 25px;"> --}}
                <img src="{{ asset('assets/media/logos/dole_logo_new.png') }}" height="80" width="80" style="text-align: left; opacity: 1; margin-top: 25px;">

                <div style="color: black;">
                    <!-- <div style="text-align: left; font-weight: bold; font-size: 10px; padding-bottom: 1px;">PROPERTY INVENTORY STICKER</div> -->
                </div>
                </div>

                <div style="color: black; text-align: center; font-weight: bold; font-size: 10px; padding-bottom: 1px; margin-top: 3px;">PROPERTY INVENTORY STICKER</div>
                <div style="color: black; text-align: center; font-weight: bold; font-size: 10px;"><u>PLEASE DO NOT REMOVE</u></div>
                <div class="form-group" style="margin-bottom: 0;">
                <div id="qrcode" style="text-align: center; margin-bottom: 5px; margin-top: 5px;">{!! $qrCode !!}</div>
                {{-- <div style="color: black; text-align: center; font-weight: bold; font-size: 10px; margin-bottom: 5px;"><u><span><?= $result->ics_no == '-' ? 'Par No.: ' . $result->par_no : 'ICS No.: ' .  $result->ics_no ?></span></u></div> --}}
                <div style="color: black; text-align: center; font-weight: bold; font-size: 8px; padding-bottom: 1px;">GOVERNMENT PROPERTY</div>
            </div>
        </div>
    </div>

    {{-- <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <script src="../assets/js/jquery.qrcode.min.js"></script> --}}

    {{-- <script>
        let ics = '<?= $result->ics_no ?>';
        let par = '<?= $result->par_no ?>';
        let code = (ics == '-') ? 'Par No.: ' + par : 'ICS No.: ' + ics;
        let qrCode = '<?= $result->are_id ?>' + '-' + '<?= $result->code ?>';
        $(document).ready(function() {
            $('#code').html(code);
            $('#qrcode').qrcode({width: 110,height: 110,text: qrCode, render: 'canvas'});
        })
    </script> --}}

</body>
</html>
