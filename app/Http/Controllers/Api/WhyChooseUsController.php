<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\WhyChooseUs;

class WhyChooseUsController extends Controller
{
    public function create(Request $request, WhyChooseUs $why)
    {
        $data = $why->saveWhyChooseUs($request);
        return response()->json([
            'message' => 'Save Success',
            'data' => $data,
        ], 200);
    }

    public function list(Request $request)
    {
        $keyword = $request->keyword;
        if ($keyword == '') {
            $data = WhyChooseUs::orderBy('position', 'ASC')
                ->orderBy('id', 'DESC')
                ->get(['id', 'title', 'icon', 'description', 'position', 'status', 'created_at']);
        } else {
            $data = WhyChooseUs::where('title', 'LIKE', '%' . $keyword . '%')
                ->orderBy('position', 'ASC')
                ->orderBy('id', 'DESC')
                ->get(['id', 'title', 'icon', 'description', 'position', 'status', 'created_at']);
        }

        return response()->json([
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function edit($id)
    {
        $data = WhyChooseUs::where(['id' => $id])->first();
        return response()->json([
            'data' => $data,
            'message' => 'success',
        ]);
    }

    public function delete($id)
    {
        $query = WhyChooseUs::find($id);
        if ($query) {
            $query->delete();
        }
        return response()->json(['message' => 'Delete Success'], 200);
    }
}
