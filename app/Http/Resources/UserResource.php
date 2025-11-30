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
    public static $wrap = 'user';

    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'role'=>$this->role,
            'email'=>$this->email,
            'company'=>CompanyResource::whenLoaded('company')
        ];
    }
}
