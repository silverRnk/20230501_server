<?php

namespace App\Http\Resources;

use App\Models\Credential;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CredentialsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        $stdId = $this->std_ID;
        $birthCert = Credential::query()
        ->where('std_ID', $stdId)
        ->where('credential_type', 'birth_cert')->first();

        $form137 = Credential::query()
        ->where('std_ID', $stdId)
        ->where('credential_type', 'form_137')->first();

        $goodMoral = Credential::query()
        ->where('std_ID', $stdId)
        ->where('credential_type', 'good_moral')->first();

        $form138 = Credential::query()
        ->where('std_ID', $stdId)
        ->where('credential_type', 'form_138')->first();
       
        $reportCard = Credential::query()
        ->where('std_ID', $stdId)
        ->where('credential_type', 'report_card')->first();
       
        return [
            'birth_cert' => new CredentialResource($birthCert),
            'form_137' => new CredentialResource($form137),
            'good_moral' => new CredentialResource($goodMoral),
            'form_138' => new CredentialResource($form138),
            'report_card' => new CredentialResource($reportCard)
        ];
    }
}
