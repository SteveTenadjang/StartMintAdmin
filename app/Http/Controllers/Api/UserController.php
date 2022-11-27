<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {  return (new Response)->success(UserResource::collection(User::all())); }

    /**
     * Store a newly created resource in storage.
     *
     * @param UserRequest $request
     * @return array
     */
    public function store(UserRequest $request): array
    {
        $user = new User($request->validated());
        if(!$user->save())
        { return (new Response)->error(); }
        $user->bundle()->attach($request->input('bundle_id')?:1);
        return (new Response)->created(UserResource::make($user));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @return array
     */
    public function show(): array
    {
        return (!auth()->user())
            ? (new Response)->idNotFound()
            : (new Response)->success(UserResource::make(auth()->user()));
    }

    /**
     * Update the specified resource in storage.
     * EC = User Collection name for Spatie media
     *
     * @param UserRequest $request
     * @return array
     */
    public function update(UserRequest $request): array
    {
        $user = auth()->user();
        if(!$user)
        { return (new Response)->idNotFound(); }

        if(!$user->update($request->validated()))
        { return (new Response)->error(400);}

        if($request->has('bundle_id'))
        { $user->bundle()->sync([$user->bundle()->first()['id'] => ['status' => false], $request->input('bundle_id')]); }
        return (new Response)->success(UserResource::make($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $user = User::query()->find($id);
        if(!$user)
        { return (new Response)->idNotFound(); }

        return (!$user->delete())
            ? (new Response)->error(400,$user)
            : (new Response)->success(UserResource::make($user));
    }
}
