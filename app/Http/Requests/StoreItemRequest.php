<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreItemRequest extends FormRequest
{
    use ResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // 'item_quantity'   => [ 'required', 'string', 'min:1', 'max:11' ],
            'unit_of_measure' => [ 'required', 'string', 'min:1', 'max:11' ],
            'description'     => [ 'required' ],
            'purchase_price'  => [ 'required', 'string', 'max:12' ]
        ];
    }

    public function attributes()
    {
        return [
            // 'item_quantity'   => 'Quantity',
            'unit_of_measure' => 'Unit of Measurement',
            'description'     => 'Description',
            'purchase_price'  => 'Purchase Price'
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
