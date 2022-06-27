<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Nation;

class NationController extends Controller
{
    public function index()
    {
        $nations = Nation::orderby('id', 'desc')->get();

        return response()->json($nations);
    }

    public function store(Request $request)
    {

        $nation = Nation::create($request->all());

        return response()->json([
            'status' => 'success',
            'nation'   => $nation
        ]);
    }

    public function show($id)
    {
        $nation = Nation::find($id);

        return response()->json($nation);
    }

    public function update(Request $request, $id)
    {
        $nation = Nation::find($id);
        $nation->update($request->all());

        return response()->json([
            'status' => 'success',
            'post'   => $nation
        ]);
    }

    public function destroy($id)
     {
         $nation = Nation::find($id);
         $nation->delete();

         return response()->json('Nation successfully deleted!');
     }
}