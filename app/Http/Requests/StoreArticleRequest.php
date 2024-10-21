<?php

namespace App\Http\Requests;

use App\Traits\ResponseTrait;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class StoreArticleRequest extends FormRequest
{
    use ResponseTrait;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'article_name' => [ 'required', 'string', 'min:2', 'max:255' ],
            'useful_life'  => [ 'required' ],
        ];
    }

    public function attributes()
    {
        return [
            'article_name' => 'Article Name',
            'useful_life'  => 'Useful Life'
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
