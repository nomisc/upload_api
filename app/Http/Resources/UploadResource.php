<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UploadResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'original_name'=> $this->original_name,
            'file_name'=> $this->file_name,
            'file_path'=>  $this->file_path,
            'file_size'=> $this->file_size,
            'mime_type'=> $this->mime_type,
            'extension'=> $this->extension
        ];
    }
}
