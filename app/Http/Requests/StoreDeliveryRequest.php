<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreDeliveryRequest extends FormRequest
{
    use ResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'invoice_no'   => [ 'required', 'string', 'min:2', 'max:100' ],
            'invoice_date' => [ 'required', 'date' ],
            'pojo'         => [ 'required', 'string', 'min:4', 'max:100' ],
            'del_quantity' => [ 'required', 'string', 'min:1', 'max:5' ],
        ];
    }

    public function attributes()
    {
        return [
            'inovice_no'   => 'Invoice No.',
            'invoice_date' => 'invoice Date',
            'del_quantity' => 'Quantity',
            'pojo'         => 'PO/JO',
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
