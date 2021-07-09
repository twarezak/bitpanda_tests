<?php
declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\UserDetailsUpdateRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller as BaseController;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

/**
 * @OA\Info(
 *      version="1.0.0",
 *      title="Task #1 Documentation",
 *      description="Simple API",
 *      @OA\Contact(
 *          email="t.warezak@gmail.com"
 *      ),
 * )
 *
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="API Server"
 * )
 *
 * @OA\Tag(
 *     name="Task #1 - users",
 *     description="API Endpoints of Projects"
 * )
 */
class UserController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Get(
     *     tags={"Users"},
     *     path="/users",
     *     description="Users list",
     *     @OA\Parameter(
     *          name="filter[country]",
     *          in="query",
     *          description="Filter results by country - e.g.: `?filter[country]=Austriar`",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="Austria",
     *          ),
     *          style="form"
     *      ),
     *     @OA\Parameter(
     *          name="filter[active]",
     *          in="query",
     *          description="Filter results by active - e.g.: `?filter[active]=true`",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *              example="true",
     *          ),
     *          style="form"
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/users_resource")),
     *      ),
     * )
     */
    public function list(): AnonymousResourceCollection
    {
        $users = QueryBuilder::for(User::class)
            ->allowedFilters([
                AllowedFilter::exact('active'),
                AllowedFilter::exact('country', 'details.country.name')
            ])
            ->get();

        return UserResource::collection($users->load(['details', 'details.country']));
    }

    /**
     * @OA\Put(
     *     tags={"Users"},
     *     path="/users/{userId}/details",
     *     description="Update user details",
     *     @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *     @OA\RequestBody(
     *          required=true,
     *          @OA\MediaType(
     *              mediaType="application/x-www-form-urlencoded",
     *              @OA\Schema(ref="#/components/schemas/uder_details_update_request")
     *          ),
     *      ),
     *     @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(ref="#/components/schemas/users_resource"),
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="User details not exist.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  description="Error message",
     *                  type="string",
     *                  example="User details not exist.",
     *              ),
     *          ),
     *      ),
     *     @OA\Response(
     *          response=404,
     *          description="User not found"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="message",
     *                  description="Error message",
     *                  type="string",
     *                  example="The given data was invalid.",
     *              ),
     *              @OA\Property(
     *                  property="errors",
     *                  description="Validation details",
     *                  type="object"
     *              ),
     *          ),
     *      ),
     * )
     */
    public function updateDetails(UserDetailsUpdateRequest $request, User $user): UserResource
    {

        abort_if(\is_null($user->details()->first()), Response::HTTP_CONFLICT, 'User details not exist.');

        $user->details()->update($request->validated());

        return new UserResource($user->load(['details', 'details.country']));
    }

    /**
     * @OA\Delete(
     *      tags={"Users"},
     *      description="Detlete user",
     *      path="/users/{userId}",
     *      @OA\Parameter(
     *          name="userId",
     *          in="path",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="OK"
     *      ),
     *      @OA\Response(
     *          response=409,
     *          description="User details not exist.",
     *          @OA\JsonContent(
     *              @OA\Property(
     *                  property="error",
     *                  description="Error message",
     *                  type="string",
     *                  example="User details not exist.",
     *              ),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      ),
     * )
     */
    public function delete(User $user): Response
    {
        abort_if(!\is_null($user->details()->first()), Response::HTTP_CONFLICT, 'User details not exist.');

        $user->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
