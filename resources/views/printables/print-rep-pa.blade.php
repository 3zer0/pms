<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRINT - PROPERTY ACCOUNTABILITY</title>

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
                /* padding: 2mm; */
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
                {{-- <div>{!! $qrCode !!}</div> --}}
                <div style="font-weight: bold; font-size: 16pt; padding: 0.25em;">
                    PROPERTY ACCOUNTABILITY
                </div>
            </div>

            <table class="mt-3" style="border: none;">
                <tr>
                    <td colspan="6" style="text-align: center; border: none; padding-bottom: 20px;">{{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: center; border: none; width: 5%;"><b>Name:</b></td>
                    <td style="text-align: left; vertical-align: center; border: none; width: 30%;">{{ $employees->fullname }}</td>
                    <td style="text-align: left; vertical-align: center; border: none; width: 10%;"><b>Designation:</b></td>
                    <td style="text-align: left; vertical-align: center; border: none; width: 25%;">{{ $employees->position }}</td>
                    <td style="text-align: left; vertical-align: center; border: none; width: 5%;"><b>Office:</b></td>
                    <td style="text-align: left; vertical-align: center; border: none; width: 25%;">{{ $employees->abbre }}</td>
                </tr>
            </table>

            <p style="text-align: justify;">
                Pursuant to Section 56 of MNGAS Volume II and Section 492 of GAAM Volume 1 shich requires that PAR shal be renewed every three (3) years after issuance of whenever a transfer of accountability has been made, the following PPE listed below is your current accountability bassed on available records. Please indicate in the "Remarks" column its current condition (S-surrendered, T-transferred, U-unserviceable, W-working) and location.
            </p>

            <table style="border: 1px solid black; border-collapse: collapse; table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 15%;">
                            <div style="">Date Acquired</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 10%;">
                            <div style="">Property No.</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 5%;">
                            <div style="">Qty</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 5%;">
                            <div style="">UOM</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 30%;">
                            <div style="">Description</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 10%;">
                            <div style="">Location</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 15%;">
                            <div style="">Last Counted</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 10%;">
                            <div style="">Remarks</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($isMultipleItems)
                        @foreach($items as $i)
                        <tr>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($i->invoice_date)->format('M. d, Y') }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ $i->item_quantity }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $i->unit_of_measure }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $i->description }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->divab }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($i->invoice_date)->format('M. d, Y') }}</td>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->ppe_condition }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($item->invoice_date)->format('M. d, Y') }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ $items->first()->item_quantity }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $items->first()->unit_of_measure }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $items->first()->description }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->divab }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($items->invoice_date)->format('M. d, Y') }}</td>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->ppe_condition }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td style="border: 1px solid black; text-align: center;" colspan="2"><b>TOTAL PPE</b></td>
                        <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ $totalQuantity }}</td>
                    </tr>
                </tbody>
            </table>

            <p style="text-indent: 5px; font-size: 8pt;">
                <i>Attach List of Surrendered Items, Credit Slip or any proof for cancellation of accountability forreturned/surrendered property (ies) listed above.</i>
            </p>

            <p style="text-align: justify;">
                By signing this notification of accountability, I certify that I have indicated true and correct information and shall be the basis b the dministrativ Service in updating my PPE accountability. I acknowledge that I am accountable for the PPEs listed aabove. I understand that I will pa or replace the same property in case of loss. In caseof resignation, transfer or retirement, I will turn-over these properties to the AS before issuance of my clearance.
            </p>

            <br>

            <table style="border: none;">
                <tbody>
                    <tr style="height: 5em">
                        <td colspan="5" style="vertical-align: top; padding: 0.25em; width: 100mm; border: none;">
                        </td>
                        <td colspan="5" style="vertical-align: top; padding: 0.25em; width: 100mm; border: none;">
                            <div style="text-align: center; margin-top:4em"><strong><span style="font-weight: bold;">{{ $employees->fullname ?? 'n/a'}}</span></strong></div>
                            <div style="text-align: center;"><span style="font-weight: normal; font-size: 7pt;">Signature Over Printed Name</span></div>
                            <div style="text-indent: 7em; margin-top: 5px; margin-bottom: 5px;"><span style="font-weight: normal; font-size: 7pt;">Date:</span></div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black; border-collapse: collapse; table-layout: fixed; width: 100%;">
                <tbody>
                    <tr style="height: 5em">
                        <td colspan="5" style="vertical-align: top; padding: 0.25em; width: 50%; border-right: 1px solid black;">
                            <div style="text-align: left;">Noted by (Division Head):</div>
                            <div style="text-align: center; margin-top:3em">
                                <strong><span style="font-weight: bold;">{{ $employees->division_head ?? 'n/a'}}</span></strong>
                            </div>
                            <div style="text-align: center;">
                                <span style="font-weight: normal;">Signature Over Printed Name</span>
                            </div>
                            <div style="text-indent: 7em; margin-top: 5px; margin-bottom: 5px;">
                                <span style="font-weight: normal; font-size: 7pt;">Date:</span>
                            </div>
                        </td>
                        <td colspan="5" style="vertical-align: top; padding: 0.25em; width: 50%; border-left: 1px solid black;">
                            <div style="text-align: left;">Verified and Updated by (Property Division):</div>
                            <div style="text-align: center; margin-top:3em">
                                <strong><span style="font-weight: bold;">{{ $item->lastname ?? 'n/a'}}, {{ $item->firstname ?? 'n/a'}}</span></strong>
                            </div>
                            <div style="text-align: center;">
                                <span style="font-weight: normal;">Signature Over Printed Name</span>
                            </div>
                            <div style="text-indent: 7em; margin-top: 5px; margin-bottom: 5px;">
                                <span style="font-weight: normal; font-size: 7pt;">Date:</span>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <p style="text-indent: 5px; margin-top: 2em; font-size: 7pt;">
                <i>Please return duly accomplished form to the Property Division within fifteen (15) days upon receipt.</i>
            </p>


        </div>
    </div>
</body>
</html>
