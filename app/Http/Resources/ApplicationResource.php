<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApplicationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'application';
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user'=>new UserResource($this->user),
            'job'=>new JobResource($this->job),
            'status'=>$this->status,
            'resume_url' => $this->resume_url,
            'linkedin_url' => $this->linkedinUrl,


        ];
    }
}
