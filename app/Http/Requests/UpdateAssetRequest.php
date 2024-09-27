<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAssetRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [

            //
            'name' => 'required|max:255',
            'description' => 'sometimes',
            'upload' => 'sometimes|nullable|file|mimetypes:image/*,application/pdf,model/gltf-binary,  application/zip,
                text/csv,model/x.stl-binary',
            /*    'tags' => 'sometimes|max:4|unique:asset_tag,tag_id,NULL,id,asset_id,' . $this->id, */


        ];
    }
}
