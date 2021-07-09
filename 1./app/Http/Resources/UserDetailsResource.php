<?php declare(strict_types=1);


namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="details_resource",
 *     type="object",
 *     title="Details resource",
 *     @OA\Property(property="first_name", type="string", example="Jan"),
 *     @OA\Property(property="last_name", type="string", example="Kowaslki"),
 *     @OA\Property(property="phone_number", type="string", example="0043664777777"),
 *     @OA\Property(property="country", type="object", ref="#/components/schemas/country_resource"),
 *  )
 */
class UserDetailsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'phone_number' => $this->phone_number,
            'country' => new CountryResource($this->whenLoaded('country')),
        ];
    }
}
