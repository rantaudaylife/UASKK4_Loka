<?php

namespace App\Http\Controllers\Api\Admin;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $food = Food::all();

        return ResponseFormatter::success(
            $food,
            'Data List Food Berhasil Diambil'
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $image = $request->file('image')->store('food', 'public');

        if ($user->roles == 'admin') {
            $food = Food::create([
                'name' => $request->name,
                'image' => $image,
                'description' => $request->description,
                'price' => $request->price,
                'rate' => $request->rate,
            ]);

            return ResponseFormatter::success($food, 'Food Berhasil Ditambahkan');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $food = Food::find($id);

        if ($food) {
            return ResponseFormatter::success(
                $food,
                'Data Detail Food Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error([
                'message' => 'Data Tidak Ditemukan',
                'id' => $id
            ], 'Data Tidak Ditemukan', 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $food = Food::find($id);

        if ($user->roles == 'admin') {
            $food->update([
                'name' => $request->name ?? $food->name,
                'description' => $request->description ?? $food->description,
                'price' => $request->price ?? $food->price,
                'rate' => $request->rate ?? $food->rate,
            ]);

            return ResponseFormatter::success($food, 'Food Berhasil Diupdate');
        } else {
            return ResponseFormatter::error([
                'message' => 'Unauthorized'
            ], 'Authentication Failed', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $food = Food::find($id);

        if ($food) {
            $food->delete();

            return ResponseFormatter::success($food, 'Food Berhasil Dihapus');
        } else {
            return ResponseFormatter::error([
                'message' => 'Data Tidak Ditemukan',
                'id' => $id
            ], 'Data Tidak Ditemukan', 404);
        }
    }
}
