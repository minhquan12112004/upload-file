<?php

namespace App\Http\Controllers;

use App\Models\canlamsang;
use Illuminate\Http\Request;

class CanlamsangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getCLS()
    {
        $results = DB::table('phongchucnang')
            ->join('canlamsang', 'canlamsang.macls', '=', 'phongchucnang.macls')
            ->select('phongchucnang.mapcn', 'canlamsang.macls', 'canlamsang.tencls', 'canlamsang.gia')
            ->get();

        return response()->json([
            'status' => 'success',
            'data' => $results,
        ]);
    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(canlamsang $canlamsang)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(canlamsang $canlamsang)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, canlamsang $canlamsang)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(canlamsang $canlamsang)
    {
        //
    }
}
