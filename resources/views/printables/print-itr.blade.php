<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRINT - ITR</title>

    <style>
        @media print {
            .container {
                margin: 0;
                padding: 0;
                width: 210mm;
                height: 297mm;
                box-sizing: border-box;
                font-family: 'Times New Roman', serif;
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
                /* border: 1px solid black; */
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
    <div class="container" size="A4" style="font-family: 'Times New Roman', serif;">
        <div class="print-area" style="background-color: white; width: 215.9mm; margin: auto; position: relative;">

            <table style="width: 100%; font-size: 9pt;">
                <tr>
                    <td style="text-align: right; vertical-align: center; width: 15%;"><i>Appendix A.5 </i></td>
                </tr>
            </table>

            <div style="display: flex; justify-content: center; align-ptrs: center; gap: 20px; margin-top: 10px;">
                <div style="font-weight: bold; font-size: 16pt; padding: 0.25em;">
                    INVENTORY TRANSFER REPORT
                </div>
            </div>

            <table class="mt-3" style="width: 100%; font-size: 9pt;">
                <tr>
                    <td style="text-align: left; vertical-align: center; width: 15%;"><b>Entity Name: </b></td>
                    <td style="text-align: left; vertical-align: center; width: 50%;"><b>Department of Labor and Employment</b></td>
                    <td style="text-align: left; vertical-align: center; width: 35%;"><b>Fund Cluster: </b></td>
                </tr>
            </table>

            <table style="border: 1px solid black; width: 100%; height: 5em; border-spacing: 0px; font-size: 9pt;">
                <tbody>
                    <tr>
                        <td style="border: none; text-align: left; vertical-align: center; width: 40%; padding: 5px 3px 0px 5px;"><b>From Accountable Officer/Agency/Fund Cluster: </b></td>
                        <td style="border: none; text-align: left; vertical-align: center; width: 30%; padding: 5px 3px 0px 0px;"><b>DOLE - {{ $trans->del_off }}</b></td>
                        <td style="border: none; text-align: left; vertical-align: center; width: 8%; padding: 5px 0px 0px 3px;"><b>ITR No.: </b></td>
                        <td style="border: none; text-align: left; vertical-align: center; width: 22%; padding: 5px 0px 0px 0px;"><b>{{$trans->property_no}}</b></td>
                    </tr>
                    <tr>
                        <td style="border: none; text-align: left; vertical-align: center; width: 40%; padding: 0px 3px 3px 5px;"><b>To Accountable Officer/Agency/Fund Cluster: </b></td>
                        <td style="border: none; text-align: left; vertical-align: center; width: 30%; padding: 0px 3px 3px 0px;"><b>DOLE - {{ $trans->ptr_off }}</b></td>
                        <td style="border: none; text-align: left; vertical-align: center; width: 8%; padding: 0px 0px 3px 5px;"><b>Date: </b></td>
                        <td style="border: none; text-align: left; vertical-align: center; width: 22%; padding: 0px 0px 3px 0px;"><b>{{ \Carbon\Carbon::parse($trans->invoice_date)->format('F d, Y') }}</b></td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black; border-top: none; width: 100%; font-size: 9pt;">
                <tbody style="padding: 5px;">
                    <tr>
                        <td colspan="2" style="text-align: left; vertical-align: center; padding: 5px; border-spacing: 0px;">
                            <b>Transfer Type: (check only one)</b>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-indent: 100px; vertical-align: center; width: 50%; border-spacing: 0px; padding: 0;">
                            <input type="checkbox" name="select_row[]" value="{{ $trans->id }}" 
                                   {{ $trans->transfer_type == 'Donate' ? 'checked' : '' }} 
                                   style="margin: 0; line-height: 1; height: 15px;">
                            <label style="margin: 0; line-height: 1; height: 15px;">Donation</label>
                        </td>
                        <td style="text-align: left; vertical-align: center; width: 50%; border-spacing: 0px; padding: 0;">
                            <input type="checkbox" name="select_row[]" value="{{ $trans->id }}" 
                                   {{ $trans->transfer_type == 'Relocate' ? 'checked' : '' }} 
                                   style="margin: 0; line-height: 1; height: 15px;">
                            <label style="margin: 0; line-height: 1; height: 15px;">Relocate</label>
                        </td>
                    </tr>
                    <tr>
                        <td style="text-indent: 100px; vertical-align: center; width: 50%; padding-bottom: 5px; border-spacing: 0px; padding: 0 0 2mm 0;">
                            <input type="checkbox" name="select_row[]" value="{{ $trans->id }}" 
                                   {{ $trans->transfer_type == 'Reassign' ? 'checked' : '' }} 
                                   style="margin: 0; line-height: 1; height: 15px;">
                            <label style="margin: 0; line-height: 1; height: 15px;">Reassignment</label>
                        </td>
                        <td style="text-align: left; vertical-align: center; width: 50%; padding-bottom: 5px; border-spacing: 0px; padding: 0 0 2mm 0;">
                            <input type="checkbox" name="select_row[]" value="{{ $trans->id }}" 
                                   {{ $trans->transfer_type == 'Others' ? 'checked' : '' }} 
                                   style="margin: 0; line-height: 1; height: 15px;">
                            <label style="margin: 0; line-height: 1; height: 15px;">Others (Specify)</label>
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black; border-collapse: collapse; border-top: none; width: 100%; font-size: 9pt;">
                <thead>
                    <tr>
                        <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; font-weight: bold; border-spacing: 0px; width: 13%;">Date Acquired</td>
                        <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; font-weight: bold; border-spacing: 0px; width: 12%;">Item No.</td>
                        <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; font-weight: bold; border-spacing: 0px; width: 13%;">ICS No./Date</td>
                        <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; font-weight: bold; border-spacing: 0px; width: 35%;">Description</td>
                        <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; font-weight: bold; border-spacing: 0px; width: 12%;">Amount</td>
                        <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; font-weight: bold; border-spacing: 0px; width: 15%;">Condition of PPE</td>
                    </tr>
                </thead>
                <tbody>
                    @if($isMultipleItems)
                        @foreach($items as $item)
                        <tr>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($item->invoice_date)->format('M. d, Y') }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $item->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ explode('-', $item->accountability_no, 2)[1] ?? $item->accountability_no }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $item->description }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ '₱' . number_format($item->purchase_price, 2) }}</td>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ $item->ppe_condition }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($items->first()->invoice_date)->format('M. d, Y') }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ explode('-', $items->first()->accountability_no, 2)[1] ?? $items->first()->accountability_no }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $items->first()->description }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ '₱' . number_format($items->first()->purchase_price, 2) }}</td>
                            <td style="border: 1px solid black;  border-top: none; text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->ppe_condition }}</td>
                        </tr>
                    @endif
                    <tr>
                        <td colspan="6" style="border: 1px solid black; text-align: center; padding: 10px;">
                            - x - x - x - NOTHING FOLLOWS - x - x - x -
                        </td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black;  border-top: none; width:100%; table-layout: fixed; font-size: 9pt;">
                <tbody>
                    <tr>
                        <td style="text-align: left; vertical-align: center; padding: 5px 0 0 5px; border-spacing: 0px;"><b>Reason for Transfer: </b></td>
                    </tr>
                    <tr>
                        <td style="text-align: center; padding: 0 0 20px 0; border-spacing: 0px;">{{$trans->trans_reason}}</td>
                    </tr>
                </tbody>
            </table>

            <table style="border: 1px solid black;  border-top: none; width: 100%; font-size: 9pt;">
                <thead>
                    <tr>
                        <td style="text-align: left; vertical-align: center; width: 15%; padding: 5px 3px 3px 5px; border-spacing: 0px;"></td>
                        <td style="text-align: left; vertical-align: center; width: 27%; padding: 5px 3px 3px 3px; border-spacing: 0px;">Approved by:</td>
                        <td style="text-align: left; vertical-align: center; width: 31%; padding: 5px 3px 3px 3px; border-spacing: 0px;">Released/Issued by:</td>
                        <td style="text-align: left; vertical-align: center; width: 27%; padding: 5px 5px 3px 3px; border-spacing: 0px;">Received by:</td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align: left; vertical-align: center; padding: 25px 3px 3px 5px; border-spacing: 0px;">Signature:</td>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"></td>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"></td>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"></td>
                    </tr>
                    <tr>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;">Printed Name:</td>
                        <td style="text-align: left; text-align: center; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"><b>{{ $appSig }}</b></td>
                        <td style="text-align: left; text-align: center; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"><b>{{ $relSig }}</b></td>
                        <td style="text-align: left; text-align: center; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"><b>{{ $employees->fullname }}</b></td>
                    </tr>
                    <tr>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;">Designation:</td>
                        <td style="text-align: left; text-align: center; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;">{{ $appPos }}</td>
                        <td style="text-align: left; text-align: center; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;">{{ $relPos }}</td>
                        <td style="text-align: left; text-align: center; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;">{{ $employees->position }}</td>
                    </tr>
                    <tr>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;">Date:</td>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"></td>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"></td>
                        <td style="text-align: left; vertical-align: center; padding: 5px 3px 3px 5px; border-spacing: 0px;"></td>
                    </tr>
                </tbody>
            </table>

        </div>
    </div>
</body>
</html>
