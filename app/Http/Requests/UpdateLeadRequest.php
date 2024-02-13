<?php

namespace App\Http\Requests;

use App\Enums\MortgagePurposes;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'mortgage_request_amount' => 'required|integer',
            'purpose_mortgage' => [
                'required',
                Rule::in(MortgagePurposes::options()),
            ],
        ];
    }
}
