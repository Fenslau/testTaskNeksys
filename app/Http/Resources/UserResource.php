<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        if ($request->is('api/login')) {
            return [
                'auth_token' => $this->email_verified_at ? $this->createToken('auth_token')->plainTextToken : null,
                'user' => [
                    'id' => $this->id,
                    'name' => $this->name,
                    'email' => $this->email,
                ]
            ];
        } else {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'created_at' => $this->created_at,
            ];
        }
    }
}
