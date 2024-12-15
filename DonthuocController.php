<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Donthuoc;

class DonthuocController extends Controller
{
    //
    public function store(Request $request)
    {
        $request->validate([
            'maba' => 'required|exists:hsba,maba',
            'ghichu' => 'nullable|string|max:200',
        ]);

        $donthuoc = Donthuoc::create($request->all());
        return response()->json($donthuoc, 201);
    }

    public function show($id)
    {
        $donthuoc = Donthuoc::findOrFail($id);
        return response()->json($donthuoc);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ghichu' => 'nullable|string|max:200',
        ]);

        $donthuoc = Donthuoc::findOrFail($id);
        $donthuoc->update($request->all());
        return response()->json($donthuoc);
    }

    public function destroy($id)
    {
        $donthuoc = Donthuoc::findOrFail($id);
        $donthuoc->delete();
        return response()->json(['message' => 'Record deleted successfully']);
    }
}
