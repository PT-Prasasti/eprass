<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HelperController extends Controller
{
    public function countNewInquiry()
    {
        $jum = 0;
        $inquiry = \App\Models\Inquiry::selectRaw("count(*) as jum")->whereRaw('id NOT IN (
            SELECT inquiry_id FROM sales_orders where deleted_at is null
        )')->first();
        if (!empty($inquiry)) {
            $jum = $inquiry->jum;
        }
        return response()->json([
            'code' => 200,
            'data' => [
                'jumlah' => $jum
            ]
        ]);
    }
}