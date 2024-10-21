<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StorePtrRequest extends FormRequest
{
    use ResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transfer_type' => [ 'required' ],
            'rec_by'        => [ 'required' ],
            'trans_reason'  => [ 'required' ]
        ];
    }

    public function attributes()
    {
        return [
            'transfer_type' => 'Transfer Type',
            'rec_by'        => 'Received by',
            'trans_reason'  => 'Transfer Reason'
        ];
    }

    protected function failedValidation(Validator $validator) {
        if($this->wantsJson() || $this->ajax()) {
            $errors = implode('<br>-', $validator->errors()->all());
            $response = $this->errorResponse('Ops! Some errors occured while validating input fields.', $errors);

            throw (new ValidationException($validator, $response));
        }

        parent::failedValidation($validator);
    }
}
