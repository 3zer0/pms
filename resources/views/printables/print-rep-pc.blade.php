<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PRINT - PROPERTY CARD</title>

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
                    PROPERTY CARD
                </div>
            </div>

            <table class="mt-3" style="border: none;">
                <tr>
                    <td colspan="6" style="text-align: center; border: none; padding-bottom: 20px;">As of {{ \Carbon\Carbon::parse($endDate)->format('F d, Y') }}</td>
                </tr>
                <tr>
                    <td style="text-align: left; vertical-align: center; border: none; width: 5%;"><b>Account Category:</b></td>
                    <td style="text-align: left; vertical-align: center; border: none; width: 30%;">{{ $items->first()->category_name }}</td>
                </tr>
            </table>

            <table style="border: 1px solid black; border-collapse: collapse; table-layout: fixed; width: 100%;">
                <thead>
                    <tr>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 20%;">
                            <div style="">Property Number</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 5%;">
                            <div style="">Qty</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 5%;">
                            <div style="">UOM</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 40%;">
                            <div style="">Description</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 15%;">
                            <div style="">Total Price</div>
                        </th>
                        <th style="height: 2em; vertical-align: middle; text-align: center; border: 1px solid black; border-collapse: collapse; width: 15%;">
                            <div style="">Last Counted</div>
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @if($isMultipleItems)
                        @foreach($items as $i)
                        <tr>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $i->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ $i->item_quantity }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $i->unit_of_measure }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $i->description }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ '₱' . number_format($i->purchase_price, 2) }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($i->invoice_date)->format('M. d, Y') }}</td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ $items->first()->property_no }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ $items->first()->item_quantity }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $items->first()->unit_of_measure }}</td>
                            <td style="border: 1px solid black;  text-align: left; padding: 5px; border-spacing: 0px;">{{ $items->first()->description }}</td>
                            <td style="border: 1px solid black;  text-align: right; padding: 5px; border-spacing: 0px;">{{ '₱' . number_format($items->first()->purchase_price, 2) }}</td>
                            <td style="border: 1px solid black;  text-align: center; padding: 5px; border-spacing: 0px;">{{ \Carbon\Carbon::parse($items->first()->invoice_date)->format('M. d, Y') }}</td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <table style="border: none; border-collapse: collapse; table-layout: fixed; width: 100%;">
                <tbody>
                    <tr>
                        <td style="border: none; text-align: right; width: 70%;"><b>No. of Items:</b></td>
                        <td style="border: none; text-align: right; padding: 5px; border-spacing: 0px; width: 15%;">{{ $totalQuantity }}</td>
                        <td style="width: 15%"></td>
                    </tr>
                    <tr>
                        <td style="border: none; text-align: right;"><b>TOTAL:</b></td>
                        <td style="border: none;  text-align: right; padding: 5px; border-spacing: 0px;">{{ '₱' . number_format($totalAmount, 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
