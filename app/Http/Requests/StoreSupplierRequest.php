<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreSupplierRequest extends FormRequest
{
    use ResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'supplier_name'      => [ 'required', 'string', 'min:2', 'max:500' ],
            'supplier_address'   => [ 'required', 'string', 'min:2', 'max:500' ],
            'supplier_mobile_no' => [ 'required', 'string', 'min:13', 'max:13' ],
            'supplier_email'     => [ 'required', 'string', 'min:4', 'max:125' ],
            'supplier_tin'       => [ 'required', 'string', 'min:15', 'max:15' ],
        ];
    }

    public function attributes()
    {
        return [
            'supplier_name'      => 'Name',
            'supplier_address'   => 'Address',
            'supplier_mobile_no' => 'Mobile number',
            'supplier_email'     => 'Email address',
            'supplier_tin'       => 'TIN',
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
