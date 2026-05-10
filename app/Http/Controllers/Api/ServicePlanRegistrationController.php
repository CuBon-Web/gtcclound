<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\models\ServicePlanRegistration;
use Illuminate\Http\Request;

class ServicePlanRegistrationController extends Controller
{
    public function list(Request $request)
    {
        $keyword = trim((string) $request->input('keyword', ''));
        $query = ServicePlanRegistration::query()
            ->with(['category:id,name,slug'])
            ->orderBy('id', 'DESC');

        if ($keyword !== '') {
            $like = '%' . addcslashes($keyword, '%_\\') . '%';
            $query->where(function ($q) use ($like) {
                $q->where('full_name', 'like', $like)
                    ->orWhere('phone', 'like', $like)
                    ->orWhere('email', 'like', $like)
                    ->orWhere('plan_title', 'like', $like)
                    ->orWhere('address', 'like', $like)
                    ->orWhere('ip', 'like', $like);
            });
        }

        $data = $query->get();

        return response()->json([
            'data' => $data,
            'message' => 'success',
        ], 200);
    }

    public function delete($id)
    {
        $row = ServicePlanRegistration::find($id);
        if (!$row) {
            return response()->json(['message' => 'Không tìm thấy bản ghi'], 404);
        }
        $row->delete();

        return response()->json([
            'message' => 'Xóa thành công',
        ], 200);
    }
}
