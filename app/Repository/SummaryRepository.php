<?php

namespace App\Repository;
use Illuminate\Support\Facades\DB;

class SummaryRepository
{
    //

    function headers_list()
    {
        return DB::connection('mariadb')
            ->table("summary_headers")
            ->select(DB::raw("id,doc_no,doc_date"))
            ->orderBy('id','DESC')
            ->get();
    }

    public function saveHeader($array)
    {
        $result =  DB::connection('mariadb')->table('summary_headers')
        ->insert($array);

        return $result;
    }

    public function updateHeader($array,$id)
    {
        $result =  DB::connection('mariadb')->table('summary_headers')
        ->where('id',$id)
        ->update($array);

        return $result;
    }

    public function availableStubs($id)
    {
        $selected = DB::connection('mariadb')->table('summary_details')
            ->select('stub_id')
            ->where('header_id','!=',$id);

        $available = DB::connection('mariadb')
                ->table('qad_document_types')
                ->select(DB::raw("doc_id,stub_no,doc_from,doc_to,CONCAT(doc_from,' - ',doc_to) label"))
                ->whereNotIn('doc_id',$selected)
                ->orderBy('doc_id','DESC');

        return $available->get();
    }

    public function saveStubs($id,$ids)
    {
        DB::connection('mariadb')->table('summary_details')->where('header_id',$id)->delete();
        DB::connection('mariadb')->table('summary_details')->insertOrIgnore($ids);
    }


    public function selectedStubs($id)
    {
        $selected = DB::connection('mariadb')->table('summary_details')
            ->select('stub_id')
            ->where('header_id','=',$id);

        $available = DB::connection('mariadb')
                ->table('qad_document_types')
                ->select(DB::raw("doc_id,stub_no,doc_from,doc_to,CONCAT(doc_from,' - ',doc_to) label"))
                ->whereIn('doc_id',$selected)
                ->orderBy('doc_id','DESC');

        return $available->get();
    }

    public function buildSummary($id)
    {
        $array = [
            'header' => null,
            'details' => null,
        ];

        $header = DB::connection('mariadb')->table('summary_headers')->where('id','=',$id)
                ->first();

                $details  = DB::connection('mariadb')->table('summary_details')
                ->join('qad_document_types','summary_details.stub_id','=','qad_document_types.doc_id')
                ->select(DB::raw("doc_id,stub_no,doc_from,doc_to,CONCAT(doc_from,' - ',doc_to) label"))
                ->where('header_id','=',$id)
                ->orderBy('stub_no','asc')
                ->get();

        foreach($details as $stub)
        {
            $start = (int) $stub->doc_from;
            $end = (int)  $stub->doc_to;

            $total_cs = 0;
            $total_38 = 0;
            $total_34 = 0;
            $total_gi = 0;
            $total_os = 0;
            $total_mw = 0;

            for($x = $start; $x <= $end; $x++)
            {
                $invoice =  DB::connection('mariadb')->table('qad_invoice')
                    ->join('qad_order','qad_invoice.drno','=','qad_order.drno')
                    ->whereRaw("substr(qad_invoice.doc_type,3,7) = ".$x)
                    ->where('status','=','K')
                    ->select(DB::raw("product_name,order_qty"))
                    ->first();

                if($invoice)
                {
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


                $stub->total_cs = $total_cs;
                $stub->total_38 = $total_38;
                $stub->total_34 = $total_34;
                $stub->total_gi = $total_gi;
                $stub->total_os = $total_os;
                $stub->total_mw = $total_mw;
                $stub->total = $total_cs + $total_38 + $total_34 + $total_gi + $total_os + $total_mw;
        }


        $array['header'] = $header;
        $array['details'] = $details;
        return $array;
    }


// /* Available */
//SELECT doc_id,stub_no,doc_from,doc_to FROM qad_document_types WHERE doc_id NOT IN (SELECT stub_id FROM summary_details)
//SELECT * FROM summary_details JOIN qad_document_types ON summary_details.stub_id = qad_document_types.doc_id WHERE header_id = 2;
}


/*

$details  = DB::connection('mariadb')->table('summary_details')
                ->join('qad_document_types','summary_details.stub_id','=','qad_document_types.doc_id')
                ->select(DB::raw("doc_id,stub_no,doc_from,doc_to,CONCAT(doc_from,' - ',doc_to) label"))
                ->where('header_id','=',$id)
                ->get();

        foreach($details as $stub)
        {
            $start = (int) $stub->doc_from;
            $end = (int)  $stub->doc_to;

            $total_cs = 0;
            $total_38 = 0;
            $total_34 = 0;
            $total_gi = 0;
            $total_os = 0;
            $total_mw = 0;

            for($x = $start; $x <= $end; $x++)
            {
                $invoice =  DB::connection('mariadb')->table('qad_invoice')
                    ->join('qad_order','qad_invoice.drno','=','qad_order.drno')
                    ->whereRaw("substr(qad_invoice.doc_type,3,7) = ".$x)
                    ->select(DB::raw("product_name,order_qty"))
                    ->first();

                if($invoice)
                {
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


                $stub->total_cs = $total_cs;
                $stub->total_38 = $total_38;
                $stub->total_34 = $total_34;
                $stub->total_gi = $total_gi;
                $stub->total_os = $total_os;
                $stub->total_mw = $total_mw;
                $stub->total = $total_cs + $total_38 + $total_34 + $total_gi + $total_os + $total_mw;
        }

*/
