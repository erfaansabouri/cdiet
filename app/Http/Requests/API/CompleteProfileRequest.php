<?php

namespace App\Http\Requests\API;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompleteProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'full_name' => [
                'required',
                'string',
            ],
            'email' => [
                'nullable',
            ],
            'phone_number' => [
                'nullable',
            ],
            'sex' => [
                'nullable',
                Rule::in(array_values(User::SEXES)),
            ],
            'pregnant_status' => [
                'nullable',
                'boolean',
                //'required_if:sex,==,'.User::SEXES['female'],
            ],
            'lactation_status' => [
                'nullable',
                'boolean',
                //'required_if:sex,==,'.User::SEXES['female'],
            ],
            'birthday' => [
                'nullable',
                'string',
                'jdate',
            ],
            'exercise' => [
                'nullable',
                'string',
                Rule::in(array_values(User::EXERCISES)),
            ],
            'height' => [
                'nullable',
                'numeric',
            ],
            'weight' => [
                'nullable',
                'numeric',
            ],
            'target_weight' => [
                'nullable',
                'numeric',
            ],
            'goal' => [
                'nullable',
                'string',
                Rule::in(array_values(User::GOALS)),
            ],
        ];
    }
}
