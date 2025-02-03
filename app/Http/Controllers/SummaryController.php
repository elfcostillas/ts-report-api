<?php

namespace App\Http\Controllers;

use App\Repository\SummaryRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class SummaryController extends Controller
{
    //
    public function __construct(public SummaryRepository $repo)
    {
        
    }

    public function list()
    {
        $result = $this->repo->headers_list();

        return response()->json([
            'data' => $result,
            'status' => 'ok',
            'msg' => null
        ]);
    }

    public function saveHeader(Request $request)
    {   
        $data = $request->forms;

        $data['doc_date'] = Carbon::createFromFormat('m-d-Y', $data['doc_date'])->format('Y-m-d');
        $result = $this->repo->saveHeader($data);

        return response()->json([
            'data' => $result,
            'status' => 'ok',
            'msg' => null
        ]);
    }

    public function updateHeader(Request $request)
    {
        $data = $request->forms;

        $data['doc_date'] = Carbon::createFromFormat('m-d-Y', $data['doc_date'])->format('Y-m-d');
        $id = $data['id'];
        unset($data['id']);

        $result = $this->repo->updateHeader($data,$id);

        return response()->json([
            'data' => $result,
            'status' => 'ok',
            'msg' => null
        ]);
    }

    public function saveStubs(Request $request)
    {
        $id = $request->id;
        $data = $request->ids;

        $ids = [];

        foreach($data as $row)
        {
            array_push($ids,['stub_id' => $row['doc_id'],'header_id' => $id]);
        }

        $result = $this->repo->saveStubs($id,$ids);

        return response()->json($result);
    }

    
    public function availableStubs(Request $request)
    {
        $result = $this->repo->availableStubs($request->id);

        return response()->json([
            'data' => $result,
            'status' => 'ok',
            'msg' => null
        ]);
    }

    public function selecedStubs(Request $request)
    {
        $result = $this->repo->selectedStubs($request->id);

        return response()->json([
            'data' => $result,
            'status' => 'ok',
            'msg' => null
        ]);
        
    }

    public function print(Request $request)
    {
        $data = $this->repo->buildSummary($request->id);

        $pdf = PDF::loadView('ts.summary',[ 'data' => $data])->setPaper('letter','portrait');
        return $pdf->stream('StubsSummary.pdf');
    }
    
    
}
