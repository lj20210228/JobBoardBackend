<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class JobResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public static $wrap = 'job';
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'deadline' => $this->deadline?->toDateString(),
            'company' => new CompanyResource($this->whenLoaded('company')),
            'applications_count' => $this->when(isset($this->applications_count), (int) $this->applications_count),

        ];
    }
}
