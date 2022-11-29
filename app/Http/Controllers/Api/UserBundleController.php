<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserBundleRequest;
use App\Http\Resources\UserBundleResource;
use App\Models\UserBundle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserBundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {  return response()->success(UserBundleResource::collection(UserBundle::all())); }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserBundleRequest $request
     * @return JsonResponse
     */
    public function store(UserBundleRequest $request): JsonResponse
    {
        $user = new UserBundle($request->validated());
        return !$user->save()
            ? response()->error()
            : response()->created(UserBundleResource::make($user));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = UserBundle::query()->find($id);
        return !$user
            ? response()->idNotFound()
            : response()->success(UserBundleResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     * EC = UserBundle Collection name for Spatie media
     *
     * @param UserBundleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(UserBundleRequest $request, int $id): JsonResponse
    {
        $user = UserBundle::query()->find($id);
        if(!$user)
        { return response()->idNotFound(); }

        return (!$user->update($request->validated()))
            ? response()->error()
            : response()->success(UserBundleResource::make($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = UserBundle::query()->find($id);
        if(!$user)
        { return response()->idNotFound(); }

        return (!$user->delete())
            ? response()->error()
            : response()->success(UserBundleResource::make($user));
    }
}
