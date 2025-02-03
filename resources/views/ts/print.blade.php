<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        @page {
            margin : 20px 20px;
        }

         * {
            font-size : 8pt;
         }

         .header {
            text-align: center;
         }

         table#main tr td {
            padding : 1px;
            border:1px solid black;

         }
         .tableHeader{
            text-align: center;
         }

         table#main {
            margin-top: 2px;   
         }

         .tableData 
         {
            text-align: center;;
         }

         .b {
            font-weight: bold;
         }
    </style>
</head>

<?php

use Carbon\Carbon;

function formatDate($invoice)
{   
    // $carbonDate = Carbon::createFromFormat('Y-m-d',$invoice->ship_date);
    // return ($date) ?  $carbonDate->format('m/d/Y') : '';
    return ($invoice) ? Carbon::createFromFormat('Y-m-d',$invoice->ship_date)->format('m/d/Y') : '';
}

function formatN($n)
{
    return  ($n==0) ? '-' : number_format($n,2);
}

?>

<body>
<table style="width:100%;">
        <tr>
            <td class="tableHeader b" style="text-align:center;">JLR CONSTRUNCTION AND AGGREGATES INC.</td>
        </tr>
        <tr>
            <td class="tableHeader b" style="text-align:center;">TRASNPORT SLIP</td>
        </tr>
        <tr>
            <td> STUB - {{ $stub_label->stub_no }} &nbsp; &nbsp; &nbsp; SERIES - {{ $stub_label->doc_from }} - {{ $stub_label->doc_to }}</td>
        </tr>
    </table>
    <!-- <div class="header b">  <BR> </div>
    <div class="docLabel"> </div> -->
    <table id="main" border=1 style="width:100%;border-collapse:collapse;border:1px solid black;">
         <thead>
            <tr>
                <td style="min-width: 60px;" rowspan="2" class="tableHeader b"> DATE</td>
                <td style="min-width: 80px;" rowspan="2" class="tableHeader b"> PLATE NO.</td>
                <td style="min-width: 55px;" rowspan="2" class="tableHeader b"> SERIAL NO.</td>
                <td style="min-width: 55px;" colspan="6" class="tableHeader b"> KIND OF MATERIALS</td>
            </tr>
            <tr>
                <td style="min-width: 55px;" class="tableHeader b">CS/WS</td>
                <td style="min-width: 55px;" class="tableHeader b">3/8</td>
                <td style="min-width: 55px;" class="tableHeader b">3/4</td>
                <td style="min-width: 55px;" class="tableHeader b">G1</td>
                <td style="min-width: 55px;" class="tableHeader b">OS</td>
                <td style="min-width: 55px;" class="tableHeader b">MW</td>
            </tr>
         </thead>
         <tbody>
            <?php
                   $total_cs =  0; 
                   $total_38 = 0;
                   $total_34 = 0;
                   $total_gi =  0;
                   $total_os =  0;
                   $total_mw =  0;
            ?>
            @foreach($invoices as $key => $invoice)

                <?php
                    $col_cs =  0; 
                    $col_38 = 0;
                    $col_34 = 0;
                    $col_gi =  0;
                    $col_os =  0;
                    $col_mw =  0;

                    if($invoice){
                        if($invoice->order){
                            if($invoice->order->status != 'C'){
                                switch($invoice->product_name)
                                {
                                    case 'MINE WASTE' :
                                            $col_mw = $invoice->order_qty;
                                            $total_mw += $invoice->order_qty;
                                        break;
        
                                    case 'CRUSHED SAND' :
                                            $col_cs = $invoice->order_qty;
                                            $total_cs += $invoice->order_qty;
                                        break; 
        
                                    case 'ORDINARY SAND' :
                                            $col_os = $invoice->order_qty;
                                            $total_os += $invoice->order_qty;
                                        break; 
        
                                    case 'GRAVEL 3/8' :
                                            $col_38 = $invoice->order_qty;
                                            $total_38 += $invoice->order_qty;
                                        break; 
                                    case 'GRAVEL 3/4' :
                                            $col_34 = $invoice->order_qty;
                                            $total_34 += $invoice->order_qty;
                                        break;
                                    case 'GRAVEL 1 1/2' :
                                            $col_gi = $invoice->order_qty;
                                            $total_gi += $invoice->order_qty;
                                        break; 
        
                                    case 'QUARRY MATERIAL' :
                                        dd("CALL IT");
                                        break; 
                                        
                                    default :
                                        dd("CALL IT");
                                        break; 
                                }
                            }
                           
                        }
                       
                    }
                ?>
                
                <tr>
                    @if($invoice)
                        <td class="tableData" > {{ formatDate($invoice) }} </td>
                        <td class="tableData" > {{ ($invoice) ? $invoice->truck_no : '' }} </td>
                        <td class="tableData" > {{ $key }} </td>

                        @if($invoice->order)
                            @if($invoice->order->status == 'C')
                                <td class="tableData" colspan="6" >CANCELLED</td>
                            @else

                            <td class="tableData" > {{ formatN($col_cs) }}</td>
                            <td class="tableData" > {{ formatN($col_38) }}</td>
                            <td class="tableData" > {{ formatN($col_34) }}</td>
                            <td class="tableData" > {{ formatN($col_gi) }}</td>
                            <td class="tableData" > {{ formatN($col_os) }}</td>
                            <td class="tableData" > {{ formatN($col_mw) }}</td>
                            @endif
                        @else
                      
                            <td class="tableData" > {{ formatN($col_cs) }}</td>
                            <td class="tableData" > {{ formatN($col_38) }}</td>
                            <td class="tableData" > {{ formatN($col_34) }}</td>
                            <td class="tableData" > {{ formatN($col_gi) }}</td>
                            <td class="tableData" > {{ formatN($col_os) }}</td>
                            <td class="tableData" > {{ formatN($col_mw) }}</td>
                        @endif
                    @else
                        <td class="tableData" > {{ formatDate($invoice) }} </td>
                        <td class="tableData" > {{ ($invoice) ? $invoice->truck_no : '' }} </td>
                        <td class="tableData" > {{ $key }} </td>
                        <td class="tableData" > {{ formatN($col_cs) }}</td>
                        <td class="tableData" > {{ formatN($col_38) }}</td>
                        <td class="tableData" > {{ formatN($col_34) }}</td>
                        <td class="tableData" > {{ formatN($col_gi) }}</td>
                        <td class="tableData" > {{ formatN($col_os) }}</td>
                        <td class="tableData" > {{ formatN($col_mw) }}</td>
                    @endif
                   
                </tr>
            @endforeach
            <tr>
                <td colspan="3" style="text-align:right;" class="b" >TOTAL</td>
                <td class="tableData b" > {{ formatN($total_cs) }}</td>
                <td class="tableData b" > {{ formatN($total_38) }}</td>
                <td class="tableData b" > {{ formatN($total_34) }}</td>
                <td class="tableData b" > {{ formatN($total_gi) }}</td>
                <td class="tableData b" > {{ formatN($total_os) }}</td>
                <td class="tableData b" > {{ formatN($total_mw) }}</td>
            </tr>
            <tr>
                <td colspan="8"></td>
                <td class="tableData b" > {{ $total_cs + $total_38 + $total_34 + $total_gi + $total_os + $total_mw }} </td>
            </tr>
         </tbody>
    </table>

    <table border=0 style="width:100%;margin-top:6px;">
        <tr>
            <td class="b">Prepared By : </td>
            <td class="b">Checked By : </td>
        </tr>
    </table>
</body>
</html>

<?php
/*
  +"id": 341761
  +"customer_name": "ESCARAN, RINO"
  +"order_date": "2024-10-01"
  +"order_time": "09:33:22"
  +"ship_date": "2024-10-01"
  +"order_id": 610949
  +"order_type": "CASH - PICKUP"
  +"reference": "JLR AR"
  +"reference_no": "Q021720"
  +"destination": "ESTACA, MINGLANILLA, CEBU"
  +"driver": "ALCANSADO EDUARD"
  +"logged_user": "Jenalyn Penas"
  +"product_name": "CRUSHED SAND"
  +"unit_price": "1300.00"
  +"totalprice": "2340.00"
  +"payment_amount": "0.00"
  +"check_type": ""
  +"checkdetail": ",,2024-10-01"
  +"truck_no": "JAT-5459 ESCARAN"
  +"truckdim": "L-3.00 W-1.50 H-0.40 *0.00 = V-1.80 *1.80"
  +"order_qty": "1.80"
  +"hauler": "1489"
  +"rembalance": 49777.96
  +"location": ""
  +"doc_type": "CS2640251"
  +"otp_doc": "Q605408-OCT.31-0020"
  +"drno": "Q605408"
  +"no": null
  */
?>