<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'recipients' => ['required', 'array'],
            'recipients.*.email' => ['required', 'email'],
            'message' => ['required', 'string'],
            'module' => ['required', 'string'],
            'action' => ['required', 'string'],
        ];
    }
}