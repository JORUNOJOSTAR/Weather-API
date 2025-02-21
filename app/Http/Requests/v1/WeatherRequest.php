<?php

namespace App\Http\Requests\v1;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use PhpParser\Node\Expr\Cast\String_;

class WeatherRequest extends FormRequest
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
        $mode = $this->query('mode');
        $dayRule = $mode === 'forecast' ? ['required', 'numeric','min:1', 'max:14'] : ['nullable'];
        $dateRule = $this->getDateRule($mode ?? '');
        return [
            'mode' => ['required',Rule::in(['current','forecast','history','future'])],
            'city' => ['required'],
            'days' => $dayRule,
            'date' => $dateRule,
        ];
    }

    private function getDateRule(String $mode){
        $dateRule = ['nullable'];
        switch($mode){
            case 'history':
                $dateRule = [
                    'required',
                    Rule::date()
                        ->afterOrEqual(today()->subYear())  // check date is after yesterday of lastyear
                        ->beforeOrEqual(today())  // or equal to today
                        ->format('Y-m-d')
                    ];
                break;

            case 'future':
                $dateRule = [
                    'required',
                    Rule::date()
                       ->afterOrEqual(today()->addDays(14))  // check date is after 14 days
                       ->beforeOrEqual(today()->addDays(300)) // and 300days from today
                       ->format('Y-m-d')
                ];
                break;
        }
        return $dateRule;
    }
}
