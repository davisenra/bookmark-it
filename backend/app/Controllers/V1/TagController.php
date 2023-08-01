<?php

declare(strict_types=1);

namespace App\Controllers\V1;

use App\Controllers\Controller;
use App\Models\Tag;
use App\Models\User;
use App\Requests\Tag\CreateTagRequest;
use App\Resources\TagResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TagController extends Controller
{
    public function index(Request $request): JsonResource
    {
        /** @var User $user */
        $user = $request->user();
        $userTags = Tag::where(['user_id' => $user->id])->paginate();

        return TagResource::collection($userTags);
    }

    public function store(CreateTagRequest $request): TagResource
    {
        /** @var User $user */
        $user = $request->user();

        $tag = new Tag();
        $tag->name = $request['name'];
        $tag->user()->associate($user);
        $tag->save();

        return new TagResource($tag);
    }

    public function destroy(Request $request, string $id): Response
    {
        /** @var User $user */
        $user = $request->user();

        /** @var ?Tag $tag */
        $tag = Tag::where(['id' => $id, 'user_id' => $user->id])->first();

        if ($tag === null) {
            return new Response(null, 404);
        }

        $tag->bookmarks()->detach();
        $tag->delete();

        return new Response(null, 204);
    }
}
