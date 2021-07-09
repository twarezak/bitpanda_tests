<?php declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @OA\Schema(
 *     schema="uder_details_update_request",
 *     type="object",
 *     title="User details update request",
 *     @OA\Property(property="first_name", type="string", example="Jan"),
 *     @OA\Property(property="last_name", type="string", example="Kowalski"),
 *     @OA\Property(property="phone_number", type="string", example="48123123123"),
 *     @OA\Property(property="country_id", type="integer", example=1),
 *  )
 */
class UserDetailsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:255',
            'country_id' => 'required|int|exists:countries,id'
        ];
    }

    public function validated()
    {
        $data = parent::validated();

        $data['citizenship_country_id'] = $data['country_id'];
        unset($data['country_id']);

        return $data;
    }
}
