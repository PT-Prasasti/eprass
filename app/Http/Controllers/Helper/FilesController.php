<?php

namespace App\Http\Controllers\Helper;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FilesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store_temp($file, $path): JsonResponse
    {
        $filename = uniqid() . '___' . $file->getClientOriginalName();
        $upload = $file->storeAs('temp/' . $path, $filename);
        $result = array(
            'filename' => $filename,
            'aliases' => $file->getClientOriginalName()
        );

        if ($upload) {
            return response()->json(array(
                'status' => 200,
                'data' => $result
            ));
        } else {
            return response()->json(array(
                'status' => 400
            ));
        }
    }

    public function show($folder1, $folder2, $filename)
    {
        if ($folder1 == 'temp') {
            $filePath = $folder1 . '/' . $folder2 . '/' . $filename;
        } else {
            $filePath = 'public/' . $folder1 . '/' . $folder2 . '/' . $filename;
        }

        if (Storage::exists($filePath)) {
            return response()->file(storage_path('app/' . $filePath));
        }

        abort(404);
    }

    public function store($fileDirectory = 'others', $file)
    {
        do {
            $fileName      = date('Y_m_d_His_') . $file->hashName();
        } while (Storage::disk('public')->exists($fileDirectory . '/' . $fileName));

        return $file->storeAs($fileDirectory, $fileName, 'public');
    }
}
