<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseApiResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [

            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description,
            'image' => $this->image,
            'video' => $this->video,
            'price' => $this->price,
            'total_hours' => $this->total_hours,
            'status' => $this->status,
            'type' => $this->type,
            'module' => $this->whenLoaded(
                'module',
                fn() => [
                    'id' => $this->module->id,
                    'title' => $this->module->title,
                ]
            ),
            'category' => $this->whenLoaded(
                'category',
                fn() => [
                    'id' => $this->category->id,
                    'name' => $this->category->name,
                ]
            ),
            'instructor' => $this->whenLoaded(
                'instructor',
                fn() => [
                    'id' => $this->instructor->id,
                    'name' => $this->instructor->name,
                ]
            ),
        ];
    }
}
