<?php

namespace App\Helpers;

use \Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class Result
{
    /**
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public static function success(string $message = '', array $data = []): JsonResponse
    {
        $out = [
          'result' => 'success'
        ];

        if (!empty($message)) {
            $out['message'] = $message;
        }

        if (!empty($data)) {
            $out = $out + $data;
        }

        return response()->json($out);
    }

    /**
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public static function error(string $message = '', array $data = [], int $code = 422): JsonResponse
    {
        $out = [];

        if (!empty($message)) {
            $out['message'] = $message;
        }

        if (!empty($data)) {
            $out = $out + $data;
        }

        return response()->json($out, $code);
    }

}
