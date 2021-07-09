<?php declare(strict_types=1);


namespace App\Http\Resources;


use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     schema="country_resource",
 *     type="object",
 *     title="Country resource",
 *     @OA\Property(property="id", type="integer", format="int"),
 *     @OA\Property(property="name", type="string", example="Austria"),
 *     @OA\Property(property="iso2", type="string", example="AT"),
 *     @OA\Property(property="iso3", type="string", example="AUT"),
 *  )
 */
class CountryResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'iso2' => $this->iso2,
            'iso3' => $this->iso3,
        ];
    }
}
