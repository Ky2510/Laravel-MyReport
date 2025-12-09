<?php

namespace App\Http\Requests;

use App\MyHelper\Constants\HttpStatusCodes;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\File;

class StoreDocumentFileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'ref_id'       => 'nullable|string',
            'filename'     => 'required|string',
            'filecontent'  => 'required|array',
            'filecontent.*' => 'required|string',
            'fileurl'      => 'sometimes',
        ];
    }

    protected function passedValidation()
    {
        $decoded = base64_decode($this->filecontent[0]);

        $directory = public_path('images/document/');

        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0775, true, true);
        }

        File::put($directory . $this->filename, $decoded);

        $this->merge([
            'fileurl' => 'https://payroll.gratiajayamulya.co.id/images/document/' . $this->filename
        ]);
    }


    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'error'   => true,
                'message' => $validator->errors()->first(),
                'errors'  => $validator->errors(),
            ], HttpStatusCodes::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
