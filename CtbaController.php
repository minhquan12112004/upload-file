<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ctba;

class CtbaController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'maba' => 'required|exists:hsba,maba',
            'mabl' => 'required|exists:benhly,mabl',
        ]);

        $ctba = Ctba::create($request->all());
        return response()->json($ctba, 201);
    }

    // Cập nhật chi tiết bệnh án
    public function update(Request $request, $maba, $mabl)
{
    $validated = $request->validate([
        'new_mabl' => 'required|integer|exists:benhly,mabl', // Đảm bảo giá trị mới tồn tại
    ]);

    $ctba = Ctba::where('maba', $maba)->where('mabl', $mabl)->firstOrFail();

    $ctba->update([
        'mabl' => $validated['new_mabl'], // Cập nhật mabl
    ]);

    return response()->json([
        'message' => 'Cập nhật thành công!',
        'data' => $ctba,
    ]);
}

    public function destroy($maba, $mabl)
    {
        $ctba = Ctba::where('maba', $maba)->where('mabl', $mabl)->firstOrFail();

        $ctba->delete();

        return response()->json([
            'message' => 'Xóa thành công!',
        ]);
    }

    public function getTenbl($maba)
{
    $results = Ctba::where('maba', $maba)
        ->with('benhly:mabl,tenbl')
        ->get()
        ->map(function ($ctba) {
            return [
                'mabl' => $ctba->benhly->mabl,
                'tenbl' => $ctba->benhly->tenbl,
            ];
        });

    return response()->json([
        'status' => 'success',
        'data' => $results,
    ]);
}
}
