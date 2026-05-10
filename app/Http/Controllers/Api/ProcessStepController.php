<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\ProcessStep;

class ProcessStepController extends Controller
{
    public function create(Request $request, ProcessStep $step)
    {
        $data = $step->saveProcessStep($request);
        return response()->json([
            'message' => 'Save Success',
            'data' => $data,
        ], 200);
    }

    public function list(Request $request)
    {
        $keyword = $request->keyword;
        $query = ProcessStep::query();

        if ($keyword != '') {
            $query->where('title', 'LIKE', '%' . $keyword . '%');
        }

        $data = $query->orderBy('position', 'ASC')
            ->orderBy('id', 'DESC')
            ->get(['id', 'title', 'icon', 'position', 'status', 'created_at']);

        return response()->json([
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function edit($id)
    {
        $data = ProcessStep::where(['id' => $id])->first();
        return response()->json([
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function delete($id)
    {
        $query = ProcessStep::find($id);
        if ($query) {
            $query->delete();
        }
        return response()->json(['message' => 'Delete Success'], 200);
    }
}
