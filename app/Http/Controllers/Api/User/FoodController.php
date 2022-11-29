<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use Illuminate\Http\Request;

class FoodController extends Controller
{
    public function index()
    {
        $food = Food::all();

        return ResponseFormatter::success(
            $food,
            'Data List Food Berhasil Diambil'
        );
    }

    public function show($id)
    {
        $food = Food::find($id);

        if ($food) {
            return ResponseFormatter::success(
                $food,
                'Data Detail Food Berhasil Diambil'
            );
        } else {
            return ResponseFormatter::error(
                null,
                'Data Food Tidak Ada',
                404
            );
        }
    }
}
