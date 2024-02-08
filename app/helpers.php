<?php

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

function sendSuccessResponse(string $message, int $statusCode = 200, $payload = []): JsonResponse
{
    return response()->json([
        'success' => true,
        'message' => $message,
        'data' => $payload
    ], $statusCode);
}

function sendErrorResponse(string $message, int $statusCode = 200, $payload = []): JsonResponse
{
    return response()->json([
        'success' => false,
        'message' => $message,
        'data' => $payload
    ], $statusCode);
}

function upload($model, $request, $input = 'image'): void
{
    if ($request) {
        $file_extension = $request->getClientOriginalExtension();
        $isPdf = $file_extension == 'pdf';

        // Modify the storage path to depend on the $input variable
        $storage_path = public_path('uploads/' . ($isPdf ? 'pdf' : 'image'));

        // Create folder if not exists
        if (!file_exists($storage_path)) {
            mkdir($storage_path, 0755, true);
        }

        $file_name = uniqid(rand()) . time() . $request->getClientOriginalName();
        if ($isPdf) {
            $request->move($storage_path, $file_name);
            if (!empty($model->$input)) {
                if (File::exists($storage_path . '/' . $model->$input)) {
                    unlink($storage_path . "/" . $model->$input);
                }
            }
            $model->$input = $file_name;
            $model->save();
        } else {
            // Assuming you are using the Intervention Image facade
            $file = Image::make($request); // Make sure to get the file from the request correctly

            $file->save($storage_path . '/' . $file_name);
            if (!empty($model->$input)) {
                if (File::exists($storage_path . '/' . $model->$input)) {
                    unlink($storage_path . '/' . $model->$input);
                }
            }
            $model->$input = $file_name;
            $model->save();
        }
    }
}
