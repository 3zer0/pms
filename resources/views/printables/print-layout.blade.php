<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRINT - {{ Str::upper($item->accountability_type) }}</title>

    <style>
        @media print {
            .container {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
                box-sizing: border-box;
            }

            .print-area {
                background-color: white;
                width: 100%;
                height: 100%;
                margin: 10mm auto; /* Adjust margin as needed */
                padding: 10mm;
                box-sizing: border-box;
            }

            /* Ensure table fits well in the print area */
            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid black;
                padding: 2mm;
                box-sizing: border-box;
            }

            .no-print {
                display: none;
            }
        }
    </style>

</head>
<body>
    <div class="container" size="A4">
        <div class="print-area" style="background-color: white; width: 215.9mm; margin: auto; position: relative;">

            <div style="display: flex; justify-content: center; align-items: center; gap: 20px;">
                <div style="font-weight: bold; font-size: 16pt; padding: 0.25em;">
                    {{ Str::upper($item->accountability_type == 'ICS' ? 'INVENTORY CUSTODIAN SLIP' : 'PROPERTY ACKNOWLEDGEMENT RECEIPT') }}
                </div>
                <div>{!! $qrCode !!}</div>
            </div>

            <table class="mt-3" style="width: 100%;">
                <tr>
                    <td style="text-align: left; vertical-align: center; width: 10%;"><b>Entity Name: </b></td>
                    <td style="text-align: left; vertical-align: center; width: 90%;"><b>Department of Labor and Employment</b></td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: center;"><b>Fund Cluster: </b></td>
                    <td style="text-align: right; vertical-align: center; padding: 0 100px 0 0"><b> {{ Str::upper($item->accountability_type) }} NO.: {{ explode('-', $item->accountability_no, 2)[1] ?? $item->accountability_no }}</b></td>
                </tr>
            </table>

            @if($item->accountability_type == 'PAR')
                <table id="par_table" style="border: 1px solid black; border-collapse: collapse; width:100%; height: 190mm; max-height: 190mm; overflow: hidden; table-layout: fixed">
                    <!-- <table id="par_table" style="border: 1px solid black; border-collapse: collapse;"> -->
                    <thead>
                        <tr>
                            <th colspan="1" style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 16mm;">
                                <div style="">Quantity</div>
                            </th>
                            <th colspan="1" style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 16mm;">
                                <div style="">Unit</div>
                            </th>
                            <th colspan="4" style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 65mm;">
                                <div style="">Description</div>
                            </th>
                            <th colspan="1" style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 35mm;">
                                <div style="">Property Number</div>
                            </th>
                            <th colspan="1" style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 20mm;">
                                <div style="">Date Acquired</div>
                            </th>
                            <th colspan="1" style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 38mm;">
                                <div style="">Amount</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm; text-align: center;">{{ $item->item_quantity }}</td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm; text-align: center;">{{ $item->unit_of_measure }}</td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm; padding: 5px;">{{ $item->description }}</td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm; text-align: center;">{{ $item->property_no }}</td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm; text-align: center;">{{ $item->invoice_date }}</td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm; text-align: right; padding: 5px;">&#8369;{{ number_format($item->purchase_price, 2) }}</td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                        <tr style="height: 0.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 65mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 35mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 20mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 38mm"></td>
                        </tr>
                    </tbody>
                </table>
            @else
                <table id="ics_table" style="border: 1px solid black; border-collapse: collapse;">
                    <thead>
                        <tr style="height: 1em;">
                            <th rowspan="2" colspan="1" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 16mm;">
                                <div style="">Quantity</div>
                            </th>
                            <th rowspan="2" colspan="1" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 16mm;">
                                <div style="">Unit/s</div>
                            </th>

                            <th colspan="4" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 40mm;">
                                <div style="">Amount</div>
                            </th>
                            <th rowspan="2" colspan="4" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 80mm;">
                                <div style="">Description</div>
                            </th>
                            <th rowspan="2" colspan="1" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 15mm;">
                                <div style="">Inventory Item No.</div>
                            </th>
                            <td rowspan="2" colspan="1" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 25mm;">
                                <div style="">Estimated Useful Life</div>
                            </th>
                        </tr>
                        <tr style="height: 1em;">
                            <th colspan="2" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 10mm;">
                                <div style="">Unit Cost</div>
                            </th>
                            <th colspan="2" style="vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; padding: 0.25em; width: 10mm;">
                                <div style="">Total Cost</div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr style='height: 1em;'>
                            <td colspan='1' style='border: 1px solid black; width: 16mm; text-align: center; padding: 0.5em;'>{{ $item->item_quantity }}</td>
                            <td colspan='1' style='border: 1px solid black; width: 16mm; text-align: center; padding: 0.5em;'>{{ $item->unit_of_measure }}</td>
                            <td colspan='2' style='border: 1px solid black; width: 10mm; padding: 0.5em; text-align: right; font-weight: bold'>&#8369;{{ $item->purchase_price }}</td>
                            <td colspan='2' style='border: 1px solid black; width: 10mm; padding: 0.5em; text-align: right; font-weight: bold'>&#8369;{{ number_format($item->item_quantity * $item->purchase_price, 2) }}</td>
                            <td colspan='4' style='border: 1px solid black; width: 80mm; padding: 0.5em;'>
                                <div style='font-weight: bold; text-align: left'>{{ $item->article_name }}</div>
                                <div contenteditable='true' style='text-align: left;'>Model: {{ $item->description }}</div>
                                <div style='text-align: left'>Serial No.: {{ $item->serial_no }}</div>
                                <div style='font-weight: bold; text-align: left'>Date Acquired: {{ $item->invoice_date }}</div>
                            </td>
                            <td colspan='1' style='border: 1px solid black; width: 15mm; text-align: center;'>{{ $item->property_no }}</td>
                            <td colspan='1' style='border: 1px solid black; width: 25mm; text-align: center;'>{{ $item->useful_life }}</td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">

                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                        <tr style="height: 1.5em;">
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 16mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="2" style="border: 1px solid black; width: 10mm"></td>
                            <td colspan="4" style="border: 1px solid black; width: 80mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 15mm"></td>
                            <td colspan="1" style="border: 1px solid black; width: 25mm"></td>
                        </tr>
                    </tbody>
                </table>
            @endif

            <br><br><br>

            <table style="border: none;">
                <tbody>
                    <tr style="height: 10em">
                        <td colspan="5" style="vertical-align: top; padding: 0.25em; width: 100mm;">
                            <div style="text-align: left;">Received by:</div>
                            <div style="text-align: center; margin-top:4em"><strong><span style="font-weight: bold;">{{ $employees->fullname ?? 'n/a'}}</span></strong></div>
                            <div style="text-align: center;"><span style="font-weight: normal;">Signature Over Printed Name</span></div>
                            <div style="text-align: center;"><strong><span style="font-weight: bold; font-size: 7pt;" id="position_title">{{ $employees->position ?? 'n/a'}}</span></strong></div>
                            <div style="text-align: center;"><strong><span style="font-weight: bold; font-size: 7pt;"><?php echo date('M. j, Y') ?></span></strong></div>
                            <div style="text-align: center;"><span style="font-weight: normal;">Date</span></div>
                        </td>
                        <td colspan="5" style="vertical-align: top; padding: 0.25em; width: 100mm;">
                            <div style="text-align: left;">Issued by:</div>
                            <div style="text-align: center; margin-top:4em"><strong><span style="font-weight: bold;">{{ $item->lastname ?? 'n/a'}}, {{ $item->firstname ?? 'n/a'}}</span></strong></div>
                            <div style="text-align: center;"><span style="font-weight: normal;">Signature Over Printed Name of Supply and/or Property Custodian</span></div>
                            <div style="text-align: center;"><span style="font-weight: bold; font-size: 7pt;" id="ics_signatory_pos">{{ $item->designate ?? 'n/a'}}</span></div>
                            <div style="text-align: center;"><span style="font-weight: bold; font-size: 7pt;"><?php echo date('M. j, Y') ?></span></div>
                            <div style="text-align: center;"><span style="font-weight: normal;">Date</span></div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</body>
</html>
