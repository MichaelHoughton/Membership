<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class SubscriptionsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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
            'card_number' => 'required|ccn',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required|numeric',
        ];
    }

    /**
     * Creates a new subscription
     */
    public function subscribe(User $user)
    {
        $token = $user->generateToken([
            'cardNumber' => $this->card_number,
            'expiryMonth' => $this->exp_month,
            'expiryYear' => $this->exp_year,
            'cvc' => $this->cvc,
        ]);

        if ($token['status'] == 'error') {
            return false;
        }

        return $user->newSubscription(config('app.membership_name'), config('app.membership_plan'))
            ->create($token['token']);
    }
}
