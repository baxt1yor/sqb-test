<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

/**
 * @template GetCurrencyItemRequest
 *
 * @property string $valuteID
 * @property string $from
 * @property string $to
 */
class GetCurrencyItemRequest extends FormRequest
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
            "valuteID" => [
                "required",
                Rule::exists("currencies", "valuteId")
            ],
            "from" => [
                "required",
                "date"
            ],
            "to" => [
                "required",
                "date"
            ],
        ];
    }

    public function messages(): array
    {
        return [
            "valuteID.required" => "Kerakli 'ValuteID' ni tanlash majburiy",
            "valuteID.exists" => "Kerakli 'ValuteID' ma'lumotlarimiz orasida topilmadi",
            "from.required" => "Vaqt oralig'ini tanlash majburiy ",
            "from.date" => "Vaqt oralig'i sana bo'lishi lozim",
            "to.required" => "Vaqt oralig'ini tanlash majburiy ",
            "to.date" => "Vaqt oralig'i sana bo'lishi lozim"
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (request()->ajax()){
            throw new HttpResponseException(response()->json($validator->errors(), 422));
        }
        return parent::failedValidation($validator);
    }
}
