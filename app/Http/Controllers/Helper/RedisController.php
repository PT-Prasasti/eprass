<?php

namespace App\Http\Controllers\Helper;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($key, $value) : JsonResponse
    {
        $redis = Redis::get($key);

        if($redis) {
            $data = json_decode($redis, true);
            array_push($data, $value);
        } else {
            $data = array($value);
        }

        $store = Redis::set($key, json_encode($data));

        if($store) {
            return response()->json(array(
                'status' => 200,
                'message' => 'success'
            ));
        } else {
            return response()->json(array(
                'status' => 400,
            ));
        }
    }

    public function delete_item($key, $name, $value) : JsonResponse
    {
        $redis = Redis::get($key);

        if($redis) {
            $data = json_decode($redis, true);

            $array = array();

            foreach($data as $item) {
                if($item[$name] != $value) {
                    $array[] = $item;
                }
            }

            $store = Redis::set($key, json_encode($array));

            if($store) {
                return response()->json(array(
                    'status' => 200,
                    'message' => 'success'
                ));
            } else {
                return response()->json(array(
                    'status' => 400,
                ));
            }
        }
    }
}
