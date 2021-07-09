<?php declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * @OA\Schema(
     *     schema="users_resource",
     *     type="object",
     *     title="Users resource",
     *     @OA\Property(property="id", type="integer", example="1"),
     *     @OA\Property(property="email", type="string", example="name@examle.com"),
     *     @OA\Property(property="active", type="bool", example="true"),
     *     @OA\Property(property="details", type="object", ref="#/components/schemas/details_resource"),
     *     @OA\Property(property="created_at", type="string", format="datetime", example="2020-01-01 12:01:01"),
     *     @OA\Property(property="updated_at", type="string", format="datetime", example="2020-01-01 12:01:01"),
     *  )
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'active' => $this->active,
            'details' => new UserDetailsResource($this->whenLoaded('details')),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
