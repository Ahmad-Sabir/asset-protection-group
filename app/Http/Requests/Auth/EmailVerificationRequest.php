<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;

class EmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (
            ! hash_equals(
                (string) $this->route('id'),
                /** @phpstan-ignore-next-line */
                (string) $this->user()->getKey()
            )
        ) {
            return false;
        }

        if (
            ! hash_equals(
                (string) $this->route('hash'),
                /** @phpstan-ignore-next-line */
                hash("sha512", $this->user()->getEmailForVerification())
            )
        ) {
            return false;
        }

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return mixed
     */
    public function withValidator($validator)
    {
        return $validator;
    }
}
