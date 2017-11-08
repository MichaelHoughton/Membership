<?php

namespace App\Http\Requests;

use App\User;
use App\Event;
use Illuminate\Foundation\Http\FormRequest;

class BookingsRequest extends FormRequest
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
        $rules = [
            'event_id' => 'required',
            'card_number' => 'required|ccn',
            'exp_month' => 'required',
            'exp_year' => 'required',
            'cvc' => 'required|numeric',
        ];

        $guests = count($this->guest);

        $i = 1;
        while ($i <= $guests) {
            $rules += [
                'guest.' . $i . '.name' => 'required',
                'guest.' . $i . '.email' => 'nullable|email',
            ];

            $i++;
        }

        return $rules;
    }

    /**
     * Formats the error messages
     * @return array
     */
    public function messages()
    {
        $messages = [];

        $guests = count($this->guest);

        $i = 1;
        while ($i <= $guests) {
            $messages += [
                'guest.' . $i . '.name.required' => 'The guest name is required.',
                'guest.' . $i . '.email.email' => 'The email must be a valid email address.',
            ];

            $i++;
        }

        return $messages;
    }

    /**
     * Charges for a booking and stores the guest details
     * @param  \App\User   $user
     * @param  \App\Event  $event
     * @return \App\Booking
     */
    public function chargeAndBook(User $user, Event $event)
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

        //TO-DO Update the charge amount
        $charge = $user->charge(100, [
            'source' => $token['token']
        ]);

        if (!$charge || empty($charge->id)) {
            return false;
        }

        $result = [];
        foreach ($this->guest as $guest) {
            $result[] = $event->bookings()
                ->create($guest);

        }

        return $result;
    }
}
