<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string', 'max:50',
            'username' => ['string', 'max:50', 'alpha_dash', Rule::unique(User::class)->ignore($this->user()->id)],
            'avatar'   => 'file|mimes:jpg|mimetypes:image/jpeg|max:100|dimensions:max_width=500|dimensions:ratio=1/1',
            'user_desc' => 'nullable|string|max:100',
            'email' => ['email', 'max:100', Rule::unique(User::class)->ignore($this->user()->id)],
        ];
    }
}
