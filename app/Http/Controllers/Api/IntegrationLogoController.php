<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\IntegrationLogo;

class IntegrationLogoController extends Controller
{
    public function create(Request $request, IntegrationLogo $logo)
    {
        $data = $logo->saveIntegrationLogo($request);
        return response()->json([
            'message' => 'Save Success',
            'data' => $data,
        ], 200);
    }

    public function list(Request $request)
    {
        $keyword = $request->keyword;
        $group   = $request->group_key;
        $query   = IntegrationLogo::query();

        if ($keyword != '') {
            $query->where('name', 'LIKE', '%' . $keyword . '%');
        }
        if ($group != '' && array_key_exists($group, IntegrationLogo::GROUPS)) {
            $query->where('group_key', $group);
        }

        $data = $query
            ->orderBy('group_key', 'ASC')
            ->orderBy('position', 'ASC')
            ->orderBy('id', 'DESC')
            ->get(['id', 'name', 'image', 'link', 'group_key', 'position', 'status', 'created_at']);

        return response()->json([
            'data'   => $data,
            'groups' => IntegrationLogo::GROUPS,
            'message' => 'success',
        ]);
    }

    public function edit($id)
    {
        $data = IntegrationLogo::where(['id' => $id])->first();
        return response()->json([
            'data'   => $data,
            'groups' => IntegrationLogo::GROUPS,
            'message' => 'success',
        ]);
    }

    public function delete($id)
    {
        $query = IntegrationLogo::find($id);
        if ($query) {
            $query->delete();
        }
        return response()->json(['message' => 'Delete Success'], 200);
    }
}
