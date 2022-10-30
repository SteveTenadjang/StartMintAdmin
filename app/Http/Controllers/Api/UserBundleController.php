<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\UserBundleRequest;
use App\Http\Resources\UserBundleResource;
use App\Models\UserBundle;
use App\Traits\Response;
use Illuminate\Http\Request;

class UserBundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {  return (new Response)->success(UserBundleResource::collection(UserBundle::all())); }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserBundleRequest $request
     * @return array
     */
    public function store(UserBundleRequest $request): array
    {
        $user = new UserBundle($request->validated());
        return !$user->save()
            ? (new Response)->error()
            : (new Response)->created(UserBundleResource::make($user));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $user = UserBundle::query()->find($id);
        return !$user
            ? (new Response)->idNotFound()
            : (new Response)->success(UserBundleResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     * EC = UserBundle Collection name for Spatie media
     *
     * @param UserBundleRequest $request
     * @param int $id
     * @return array
     */
    public function update(UserBundleRequest $request, int $id): array
    {
        $user = UserBundle::query()->find($id);
        if(!$user)
        { return (new Response)->idNotFound(); }

        return (!$user->update($request->validated()))
            ? (new Response)->error(400)
            : (new Response)->success(UserBundleResource::make($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $user = UserBundle::query()->find($id);
        if(!$user)
        { return (new Response)->idNotFound(); }

        return (!$user->delete())
            ? (new Response)->error(400,$user)
            : (new Response)->success(UserBundleResource::make($user));
    }
}
