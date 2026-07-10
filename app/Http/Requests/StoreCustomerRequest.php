<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCustomerRequest extends FormRequest
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
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:customers,email',
            'phone' => 'nullable|string|max:20',
            'company' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive,blocked',
            'source' => 'nullable|in:lead,quote_request,direct,referral',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
            'tags' => 'nullable|array',
            'tags.*' => 'nullable|string|max:50',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The customer name is required.',
            'email.required' => 'The email address is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'status.required' => 'The customer status is required.',
            'status.in' => 'Invalid status selected.',
        ];
    }
}
