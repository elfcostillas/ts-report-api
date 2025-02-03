<?php

namespace App\Repository;

use App\Models\Stub;
use Illuminate\Support\Facades\DB;

class StubsRepository
{
    //

    function mainQuery()
    {
        return DB::connection('mariadb')->table('qad_document_types');
    }

    public function list()
    {

        return DB::connection('mariadb')
                ->table('qad_document_types')
                ->select(DB::raw("doc_id,stub_no,doc_from,doc_to,(doc_to-doc_from)+1 AS doc_count"))
                ->orderBy('doc_id','DESC')
                ->get();
    }

    public function getStubLabel($id)
    {
        return $this->mainQuery()->where('doc_id','=',$id)->first();
    }

    public function getInvoiceDetails($invoice_no)
    {
        //substr(doc_type,3,7)
        // $invoice = DB::table("qad_invoice")->where('doc_type','like','__'.$invoice_no)->first();
        $invoice = DB::table("qad_invoice")->whereRaw("substr(doc_type,3,7) = ".$invoice_no)->first();
        if($invoice)
        {
            // $invoice->order =  DB::table("qad_order")->where('doc_type','like','__'.$invoice_no)->first();
            $invoice->order =  DB::table("qad_order")->whereRaw("substr(doc_type,3,7) = ".$invoice_no)->select('status')->first();
        }
        return $invoice;
    }

    function getStubInvoices($stub)
    {
        $stub_array = [];
        
        if($stub)
        {
            for($index = $stub->doc_from; $index <= $stub->doc_to; $index++)
            {
                // echo "<br> START $index :".now();
                $invoice = $this->getInvoiceDetails($index);
                // echo "END $index :".now();

                $stub_array[$index] = $invoice;
            }
        }else{
            
        }
      
        return collect($stub_array);

    }

    function getCancelled($date_from,$date_to)
    {
        /*
        select cust_name,qad_order.order_date,qad_order.drno,qad_order.logged_user,remarks,order_qty FROM qad_order
        inner join qad_invoice on qad_invoice.drno = qad_order.drno
        where `status` = 'C' and qad_order.order_date between '2024-11-01' and '2024-11-30';
        */
        $result = DB::connection('mariadb')->table('qad_order')
                    ->join('qad_invoice','qad_invoice.drno','=','qad_order.drno')
                    ->where('status','=','C')->whereBetween('qad_order.order_date',[$date_from,$date_to])
                    ->select(DB::raw("cust_name,date_format(qad_order.order_date,'%m/%d/%Y') as order_date,qad_order.drno,qad_order.logged_user,remarks,order_qty"))
                    ->orderBy('qad_order.drno','ASC');
        return $result->get();
    }

    public function save($ids)
    {
        DB::connection('mariadb')->table('print_summary')->truncate();
        DB::connection('mariadb')->table('print_summary')->insertOrIgnore($ids);
    }

    function buildSummary()
    {
        $selected = DB::connection('mariadb')->table('print_summary')->get();
        
        foreach($selected as $stub)
        {
            
        }
    }
}
