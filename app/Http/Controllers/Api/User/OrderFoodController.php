<?php

namespace App\Http\Controllers\Api\User;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Food;
use App\Models\Transaction;
use Illuminate\Http\Request;

class OrderFoodController extends Controller
{
    public function store(Request $request, $id)
    {
        $user = $request->user();
        $food = Food::find($id);

        if ($food) {
            if ($user->roles == 'user') {
                $order = Transaction::create([
                    'user_id' => $user->id,
                    'food_id' => $food->id,
                    'quantity' => $request->quantity,
                    'total' => $food->price * $request->quantity,
                    'name' => $user->name,
                    'email' => $user->email,
                    'address' => $user->address,
                    'phone' => $user->phone,
                    'total_price' => $food->price * $request->quantity,
                    'status' => 'PENDING',
                ]);

                return ResponseFormatter::success($order, 'Order Berhasil');
            } else {
                return ResponseFormatter::error([
                    'message' => 'Unauthorized'
                ], 'Authentication Failed', 500);
            }
        } else {
            return ResponseFormatter::error(
                null,
                'Food Tidak Ada',
                404
            );
        }
    }
}
