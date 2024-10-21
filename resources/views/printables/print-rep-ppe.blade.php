<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRINT - RCPPPE</title>

    <style>
        @media print {
            @page {
            size: A4 landscape; /* Force landscape orientation for printing */
            margin: 10mm;       /* Adjust the margin as needed */
            }
            html, body {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
            }

            .container, .print-area {
                margin: 0;
                padding: 0;
                width: 100%;
                height: 100%;
                box-sizing: border-box;
            }

            /* Ensure the content does not overflow the page */
            .print-area {
                background-color: white;
                width: 297mm; /* Full width for A4 landscape */
                height: 210mm; /* Full height for A4 landscape */
                margin: 0;
                padding: 10mm; /* Adjust if needed */
                box-sizing: border-box;
                overflow: hidden; /* Prevents content overflow */
            }

            table {
                width: 100%;
                border-collapse: collapse;
            }

            th, td {
                border: 1px solid black;
                box-sizing: border-box;
            }

            /* Hide elements not meant for printing */
            .no-print {
                display: none;
            }
        }
    </style>



</head>
<body>
    <div class="container" size="A4">
        {{-- <div class="print-area" style="background-color: white; width: 215.9mm; margin: auto; position: relative;">
             --}}
             <div class="print-area" style="background-color: white; width: 100%; height: 100%; margin: 0; padding: 0; position: relative;">


            <h2 style="text-align: center; padding: 0.25em;">
                REPORT ON THE PHYSICAL COUNT OF PROPERTY, PLANT AND EQUIPMENT
            </h2>

            <div style="text-align: center; margin: 5px 0 5px 0;">
                <b>{{ $items->first()->category_name }}</b>
            </div>

            <div style="text-align: center; font-size: 7pt;">
                <i>(Type of Property, Plant and Equipmeent)</i>
            </div>

            <div style="text-align: center; margin-top: 10px;">
                As of {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}
            </div>

            <div style="text-align: start; margin: 5px 0 5px 0; font-size: 8pt;">
                Fund Cluster : 01
            </div>

            <div style="text-align: start; margin: 10px 0 20px 0; font-size: 8pt;">
                For which {{ $userId->jurisdiction->division->division_head ?? 'n/a'}}, {{ $employees->position ?? 'n/a' }}, {{ $userId->jurisdiction->division->division_name ?? 'n/a'}} is accountable, having assumed such accountability on {{ \Carbon\Carbon::parse($endDate)->format('d F Y') }}
            </div>

            <table style="border: 1px solid black; border-collapse: collapse; table-layout: fixed; width: 100%; font-size: 8pt;">
                <thead>
                    <tr>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 13%;" rowspan="2">
                            <div style="">Article</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 20%;" rowspan="2">
                            <div style="">Description</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 7%;" rowspan="2">
                            <div style="">Property Number</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 8%;" rowspan="2">
                            <div style="">Unit of Measure</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 11%;" rowspan="2">
                            <div style="">Unit Value</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 7%;" rowspan="2">
                            <div style="">Quantity per Property Card</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 8%;" rowspan="2">
                            <div style="">Quantity per Physical Count</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 12%;" colspan="2">
                            <div style="">Shortage/Overage</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse; width: 14%;" rowspan="2">
                            <div style="">Remarks</div>
                        </th>
                    </tr>
                    <tr>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse;">Quantity</th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; font-size: 6pt; border: 1px solid black; border-collapse: collapse;">Value</th>
                    </tr>
                </thead>
                <tbody>
                    @if($isMultipleItems)
                        @foreach($items as $i)
                        <tr>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->article_name }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $i->description }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->unit_of_measure }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ '₱' . number_format($i->purchase_price, 2) }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">1</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">1</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">0</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">0.00</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->fullname }}<br>{{ $i->divab }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->article_name }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $items->first()->description }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->unit_of_measure }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ '₱' . number_format($items->first()->purchase_price, 2) }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">1</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">1</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">0</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">0.00</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->fullname }}<br>{{ $items->first()->divab }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <table style="border: none; border-collapse: collapse; table-layout: fixed; width: 100%; margin: 1em 0 2em 0;">
                <tbody>
                    <tr>
                        <td colspan="4" style="border: none;"></td> <!-- Empty space -->
                        <td colspan="2" style="border: none; text-align: right;"><b>No. of Items:</b></td>
                        <td colspan="2" style="border: none; text-align: right;">{{ $totalQuantity }}</td>
                        <td colspan="4" style="border: none;"></td> <!-- Empty space -->
                    </tr>
                    <tr>
                        <td colspan="4" style="border: none;"></td> <!-- Empty space -->
                        <td colspan="2" style="border: none; text-align: right;"><b>TOTAL:</b></td>
                        <td colspan="2" style="border: none; text-align: right;">{{ '₱' . number_format($totalAmount, 2) }}</td>
                        <td colspan="4" style="border: none;"></td> <!-- Empty space -->
                    </tr>
                </tbody>
            </table>




            <table style="border: 1px solid black; border-collapse: collapse; table-layout: fixed; width: 100%;">
                <tbody>
                    <tr style="height: 5em">
                        <td colspan="2" style="vertical-align: top; padding: 0.25em; border: none;">
                            <div style="text-align: left;">Certified Correct by:</div>
                            <div style="text-align: center; margin-top: 3em;">
                                <strong><span style="font-weight: bold;">{{ $userId->jurisdiction->division->division_head ?? 'n/a' }}</span></strong>
                            </div>
                            <div style="text-align: center;">
                                <span style="font-weight: normal;">{{ $employees->position ?? 'n/a' }}, {{ $userId->jurisdiction->division->division_name }}</span>
                            </div>
                        </td>
                        <td colspan="2" style="vertical-align: top; padding: 0.25em; border: none;">
                            <div style="text-align: left;">Approved by:</div>
                            <div style="text-align: center; margin-top: 3em;">
                                <strong><span style="font-weight: bold;">{{ $userId->jurisdiction->office->director_name ?? 'n/a' }}</span></strong>
                            </div>
                            <div style="text-align: center;">
                                <span style="font-weight: normal;">{{ $employees->position ?? 'n/a' }}, {{ $userId->jurisdiction->office->office_name ?? 'n/a' }}</span>
                            </div>
                        </td>
                        <td colspan="2" style="vertical-align: top; padding: 0.25em; border: none;">
                            <div style="text-align: left;">Verified by:</div>
                            <div style="text-align: center; margin-top: 4em;"></div>
                            <div style="text-align: center;">
                                <span style="font-weight: normal;">Signature Over Printed Name of COA Representative</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</body>
</html>
