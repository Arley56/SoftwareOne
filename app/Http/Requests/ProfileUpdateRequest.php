<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $hasMonitorProfile = $this->user()?->monitorProfile()->exists() ?? false;

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($this->user()->id),
            ],
            'subject_id' => [
                Rule::requiredIf($hasMonitorProfile),
                'nullable',
                'integer',
                Rule::exists('subjects', 'id'),
            ],
            'description' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
