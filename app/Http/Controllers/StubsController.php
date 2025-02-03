<?php

namespace App\Http\Controllers;

use App\Repository\StubsRepository;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class StubsController extends Controller
{
    //
    public function __construct(public StubsRepository $repo)
    {
        
    }
    public function list()
    {
        $result = $this->repo->list();

        return response()->json([
            'data' => $result,
            'status' => 'ok',
            'msg' => null
        ]);
    }

    public function print($doc_id)
    {
        $stub_label = $this->repo->getStubLabel($doc_id);
        $invoice = $this->repo->getStubInvoices($stub_label);
        // echo "<br> END : ".now();
        // die();
        $pdf = PDF::loadView('ts.print',['stub_label' => $stub_label,'invoices' => $invoice])->setPaper('letter','portrait');
        return $pdf->stream('TransportSlip.pdf');
    }

    public function cancelled(Request $request)
    {
        // dd($request->date_from,$request->date_to);

        $date_from = Carbon::createFromFormat('m-d-Y',$request->date_from)->format('Y-m-d');
        $date_to = Carbon::createFromFormat('m-d-Y',$request->date_to)->format('Y-m-d');

        $data = $this->repo->getCancelled($date_from,$date_to);

        $pdf = PDF::loadView('ts.cancelled',['data' => $data])->setPaper('letter','portrait');
        return $pdf->stream('CancelledDR.pdf');

    }

    public function printSummary()
    {
        $data = $this->repo->buildSummary();
        $pdf = PDF::loadView('ts.summary',['data' => $data])->setPaper('letter','portrait');
        return $pdf->stream('StubsSummary.pdf');
    }

    public function save(Request $request)
    {
        // return response()->json($request->ids);
        $data = $request->ids;

        $ids = [];

        foreach($data as $row)
        {
            array_push($ids,['stub_id' => $row['doc_id']]);
        }

        $result = $this->repo->save($ids);

        return response()->json($result);
    }


}
