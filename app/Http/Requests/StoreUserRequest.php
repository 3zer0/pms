<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreUserRequest extends FormRequest
{
    use ResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'firstname' => [ 'required', 'string', 'min:2', 'max:75' ],
            'lastname'  => [ 'required', 'string', 'min:2', 'max:75' ],
            'designate' => [ 'required', 'string', 'min:2', 'max:150' ],
            'email'     => [ 'required', 'string', 'min:4', 'max:100' ],
            'mobile_no' => [ 'required', 'string', 'min:3', 'max:15' ],
            'username'  => [ 'required', 'string', 'min:3', 'max:25' ],
            'password'  => [ 'required', 'confirmed', 'min:6', 'max:20', Password::defaults()],
        ];
    }

    public function attributes()
    {
        return [
            'firstname' => 'Firstname',
            'lastname'  => 'Lastname',
            'designate' => 'Designate',
            'email'     => 'Email address',
            'mobile_no' => 'Mobile number',
            'username'  => 'Username',
            'password'  => 'Password',
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
