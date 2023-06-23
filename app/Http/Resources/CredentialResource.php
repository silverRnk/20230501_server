<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class CredentialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'file_id' => $this->id ?? '',
            'file_type' => $this->credential_type ?? '',
            'file_name' => $this->file_name ?? '',
            'updated_date' =>  $this->updated_at ?? '',
        ];
    }
}
