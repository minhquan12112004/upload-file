<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ctcls;

class CtclsController extends Controller
{

// Thêm mới CTCLS
    public function createCtcls(Request $request)
    {
        $validatedData = $request->validate([
            'maba' => 'required|integer',
            'mapcn' => 'required|integer',
            'ketqua' => 'nullable|string|max:300',
        ]);

        $ctcls = Ctcls::create($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'CTCLS created successfully!',
            'data' => $ctcls,
        ]);
    }

    // Cập nhật CTCLS
    public function updateCtcls(Request $request, $maba, $mapcn)
    {
        $validatedData = $request->validate([
            'ketqua' => 'nullable|string|max:300',
        ]);

        $ctcls = Ctcls::where('maba', $maba)
            ->where('mapcn', $mapcn)
            ->firstOrFail();

        $ctcls->update($validatedData);

        return response()->json([
            'status' => 'success',
            'message' => 'CTCLS updated successfully!',
            'data' => $ctcls,
        ]);
    }

    // Xóa CTCLS
    public function deleteCtcls($maba, $mapcn)
    {
        $ctcls = Ctcls::where('maba', $maba)
            ->where('mapcn', $mapcn)
            ->firstOrFail();

        $ctcls->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'CTCLS deleted successfully!',
        ]);
    }

// Truy vấn getTenCtCls
    public function getCtclsDetails($maba)
    {
    $results = DB::table('ctcls')
        ->join('phongchucnang', function ($join) {
            $join->on('ctcls.mapcn', '=', 'phongchucnang.mapcn')
                 ->on('ctcls.macls', '=', 'phongchucnang.macls');
        })
        ->join('canlamsang', 'phongchucnang.macls', '=', 'canlamsang.macls')
        ->where('ctcls.maba', $maba)
        ->select('canlamsang.macls', 'canlamsang.tencls', 'ctcls.ketqua')
        ->get();

    return response()->json([
        'status' => 'success',
        'data' => $results,
    ]);
}
}
