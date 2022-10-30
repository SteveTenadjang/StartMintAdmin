<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NFTRequest;
use App\Http\Resources\NFTResource;
use App\Models\NFT;
use App\Traits\Response;
use Illuminate\Http\Request;

class NFTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return array
     */
    public function index(Request $request): array
    {  return (new Response)->success(NFTResource::collection(NFT::all())); }

    /**
     * Store a newly created resource in storage.
     *
     * @param NFTRequest $request
     * @return array
     */
    public function store(NFTRequest $request): array
    {
        $user = new NFT($request->validated());
        return !$user->save()
            ? (new Response)->error()
            : (new Response)->created(NFTResource::make($user));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $user = NFT::query()->find($id);
        return !$user
            ? (new Response)->idNotFound()
            : (new Response)->success(NFTResource::make($user));
    }

    /**
     * Update the specified resource in storage.
     * EC = NFT Collection name for Spatie media
     *
     * @param NFTRequest $request
     * @param int $id
     * @return array
     */
    public function update(NFTRequest $request, int $id): array
    {
        $user = NFT::query()->find($id);
        if(!$user)
        { return (new Response)->idNotFound(); }

        return (!$user->update($request->validated()))
            ? (new Response)->error(400)
            : (new Response)->success(NFTResource::make($user));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $user = NFT::query()->find($id);
        if(!$user)
        { return (new Response)->idNotFound(); }

        return (!$user->delete())
            ? (new Response)->error(400,$user)
            : (new Response)->success(NFTResource::make($user));
    }
}
