<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin : 30px 30px 30px 30px;
        }

        * {
            font-size: 9pt;
        }

        .b {
            font-weight: bold;
        }

        .bt {
            border-bottom:double;
        }
    </style>
    <?php
        function getTotal($data)
        {
            $total = 0;

            foreach($data as $row)
            {
                $total += $row->order_qty;
            }

            return number_format($total,2);
        }
    ?>
</head>
<body>
    <table border=0 style="width:100%;margin-bottom:2rem;">
        <tr>
            <td rowspan="4" style="width:100px;">
                <img width="84" height="74" src="{{ public_path('images/jlr_logo_print.jpg') }}" alt="">
            </td>
            <td class="b" style="font-size:10pt">JLR CONSTRUCTION and AGGREGATES Inc</td>
        </tr>
        <tr>
            
            <td style="font-size:10pt">Aggregates Summary Report - Listing</td>
        </tr>
        <tr>
            <td>&nbsp;</td>
        </tr>
        <tr>
            
            <td  style="font-size:10pt">For the month of ____________________</td>
        </tr>
    </table>
    <table style="width:100%;border-collapse:collapse" border=0 >
        <tr>
            <td class="b bt" >CUSTOMER NAME</td>
            <td style="width:80px;text-align:center" class="b bt" >ORDER DATE</td>
            <td style="width:60px;text-align:center" class="b bt" >DR NO</td>
            <td class="b bt" >USER</td>
            <td class="b bt" >REMARKS</td>
            <td style="width:30px;text-align:center" class="b bt" >QTY</td>
        </tr>
        @foreach($data as $row)
            <tr>
                <td style="text-align:left;">{{ $row->cust_name }}</td>
                <td style="text-align:center;">{{ $row->order_date }}</td>
                <td style="text-align:center;">{{ $row->drno }}</td>
                <td style="text-align:left;">{{ $row->logged_user }}</td>
                <td style="text-align:left;">{{ $row->remarks }}</td>
                <td style="text-align:right;">{{ $row->order_qty }}</td>
            </tr>
        @endforeach
        <tr>
            <td style="border-top:double;border-bottom:double;" class="b" colspan=5>TOTAL VOLUME</td>
            <td style="border-top:double;border-bottom:double;text-align:right" class="b"> {{  getTotal($data) }} </td>
        </tr>
    </table>
</body>
</html>