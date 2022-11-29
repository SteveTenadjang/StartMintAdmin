<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\BundleRequest;
use App\Http\Resources\BundleResource;
use App\Models\Bundle;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BundleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {  return response()->success(BundleResource::collection(Bundle::all())); }

    /**
     * Store a newly created resource in storage.
     *
     * @param BundleRequest $request
     * @return JsonResponse
     */
    public function store(BundleRequest $request): JsonResponse
    {
        $user = new Bundle($request->validated());
        return !$user->save()
            ? response()->error()
            : response()->created(BundleResource::make($user));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $user = Bundle::query()->find($id);
        return !$user
            ? response()->idNotFound()
            : response()->success(BundleResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     * EC = Bundle Collection name for Spatie media
     *
     * @param BundleRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(BundleRequest $request, int $id): JsonResponse
    {
        $user = Bundle::query()->find($id);
        if(!$user)
        { return response()->idNotFound(); }

        return (!$user->update($request->validated()))
            ? response()->error()
            : response()->success(BundleResource::make($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $user = Bundle::query()->find($id);
        if(!$user)
        { return response()->idNotFound(); }

        return (!$user->delete())
            ? response()->error()
            : response()->success(BundleResource::make($user));
    }
}
