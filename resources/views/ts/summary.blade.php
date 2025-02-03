<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title> 
    <style>
        @page {
            margin : 86px 42px 42px 42px;
        }

        * {
            font-size : 9pt;
        }

        .c {
            text-align : center;
        }

        .b {
            font-weight : bold;
        }
    </style>
</head>
<?php

use Carbon\Carbon;

    $doc_date = null;

    if($data['header'])
    {
        $doc_date = Carbon::createFromFormat('Y-m-d',$data['header']->doc_date)->format('M d, Y');
    }

    $ctr = 1;

    $gtotal_cs = 0;
    $gtotal_38 = 0;
    $gtotal_34 = 0;
    $gtotal_gi = 0;
    $gtotal_os = 0;
    $gtotal_mw = 0;
    $gtotal = 0;

    $avg = 0;

    function eFormat($n)
    {
        return ($n==0) ? '-' : number_format($n,2);
    }

?>
<body>
    <table border=0 style="border-collapse:collapse;width:100%;">
        <tr>
            <td >JLR CONSTRUCTION AND AGGREGATES INC.</td>
            <td style="width:172px;"></td>
            <td rowspan="3" style="width:120px;text-align:center;"> <div style="text-align:center;width:100px;font-weight:bold;border:2px solid black;padding:8px;font-size:12pt;margin-left:0"> {{ $data['header']->doc_no }}  </div></td>
        </tr>
        <tr>
            <td>USED TRANSPORT SLIP</td>
            <td ></td>
           
        </tr>
        <tr>
            <td>{{ $doc_date }}</td>
            <td >&nbsp;</td>
           
        </tr>
    </table>
    <table border=1 style="margin-top:8px;border-collapse:collapse;width:100%;">
        <tr>
            <td colspan=3> </td>
            <td colspan=7 style="text-align:center;font-weight:bold;"> KIND OF MATERIALS</td>
        </tr>
        <tr>
            <td style="text-align:center;font-weight:bold;width:38px;">NO</td>
            <td style="text-align:center;font-weight:bold;width:68px;">STUB NO</td>
            <td style="text-align:center;font-weight:bold;">SERIES NO</td>
            <td style="text-align:center;font-weight:bold;width:60px;">CS/WS</td>
            <td style="text-align:center;font-weight:bold;width:60px;">3/8</td>
            <td style="text-align:center;font-weight:bold;width:60px;">3/4</td>
            <td style="text-align:center;font-weight:bold;width:60px;">G1</td>
            <td style="text-align:center;font-weight:bold;width:60px;">OS</td>
            <td style="text-align:center;font-weight:bold;width:60px;">MW</td>
            <td style="text-align:center;font-weight:bold;width:68px;">TOTAL</td>
        </tr>

        @if($data['details'] )

       
        @foreach($data['details'] as $stub)
            <tr>
                <td class="c">{{ $ctr }}</td>
                <td class="c">{{ $stub->stub_no }}</td>
                <td class="c">{{ $stub->label }}</td>
                <td class="c">{{ eFormat($stub->total_cs) }}</td>
                <td class="c">{{ eFormat($stub->total_38) }}</td>
                <td class="c">{{ eFormat($stub->total_34) }}</td>
                <td class="c">{{ eFormat($stub->total_gi) }}</td>
                <td class="c">{{ eFormat($stub->total_os) }}</td>
                <td class="c">{{ eFormat($stub->total_mw) }}</td>
                <td class="c">{{ eFormat($stub->total)  }}</td>
            </tr>
            <?php
               

                $gtotal_cs += $stub->total_cs;
                $gtotal_38 += $stub->total_38;
                $gtotal_34 += $stub->total_34;
                $gtotal_gi += $stub->total_gi;
                $gtotal_os += $stub->total_os;
                $gtotal_mw += $stub->total_mw;
                $gtotal += $stub->total;

                $avg = $gtotal/$ctr;

                $ctr++;

            ?>
        @endforeach
        
        @endif
        <tr>
            <td colspan=3 >&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td colspan=3 >&nbsp;</td>
            <td class="b" style="text-align:center;"> {{ eFormat($gtotal_cs) }}</td>
            <td class="b" style="text-align:center;"> {{ eFormat($gtotal_38) }}</td>
            <td class="b" style="text-align:center;"> {{ eFormat($gtotal_34) }}</td>
            <td class="b" style="text-align:center;"> {{ eFormat($gtotal_gi) }}</td>
            <td class="b" style="text-align:center;"> {{ eFormat($gtotal_os) }}</td>
            <td class="b" style="text-align:center;"> {{ eFormat($gtotal_mw) }}</td>
            <td class="b" style="text-align:center;"> {{ eFormat($gtotal) }}</td>
        </tr>
        <tr>
            <td colspan=3 >&nbsp;</td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align:center;"> {{ eFormat($avg) }}</td>
        </tr>
    </table>
    <table style="margin-top:42px;">
        <tr>
            <td style="width: 64px">Prepared by</td>
            <td style="width: 64px"></td>
        </tr>
        <tr>
            <td></td>
            <td  style="text-align:center;">HBC</td>
        </tr>
    </table>
</body>
</html>