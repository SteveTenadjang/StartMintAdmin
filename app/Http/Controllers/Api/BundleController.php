<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BundleRequest;
use App\Http\Resources\BundleResource;
use App\Models\Bundle;
use App\Traits\Response;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {  return (new Response)->success(BundleResource::collection(Bundle::all())); }

    /**
     * Store a newly created resource in storage.
     *
     * @param BundleRequest $request
     * @return array
     */
    public function store(BundleRequest $request): array
    {
        $user = new Bundle($request->validated());
        return !$user->save()
            ? (new Response)->error()
            : (new Response)->created(BundleResource::make($user));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $user = Bundle::query()->find($id);
        return !$user
            ? (new Response)->idNotFound()
            : (new Response)->success(BundleResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     * EC = Bundle Collection name for Spatie media
     *
     * @param BundleRequest $request
     * @param int $id
     * @return array
     */
    public function update(BundleRequest $request, int $id): array
    {
        $user = Bundle::query()->find($id);
        if(!$user)
        { return (new Response)->idNotFound(); }

        return (!$user->update($request->validated()))
            ? (new Response)->error(400)
            : (new Response)->success(BundleResource::make($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $user = Bundle::query()->find($id);
        if(!$user)
        { return (new Response)->idNotFound(); }

        return (!$user->delete())
            ? (new Response)->error(400,$user)
            : (new Response)->success(BundleResource::make($user));
    }
}
