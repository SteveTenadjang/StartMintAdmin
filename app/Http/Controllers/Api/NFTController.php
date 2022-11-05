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
        $nft = new NFT($request->validated());
        $nft['created_by'] = auth()->id();
        if(auth()->user()?->isFreeAccount() && !auth()->user()?->canCreatedToday()){
            return (new Response)->error(401,$nft, "Can't create more than 1 NFT in 24H");
        }
        if(!auth()->user()?->isFreeAccount() && !auth()->user()?->canCreatedThisMonth()){
            return (new Response)->error(401,$nft, "already exceeded monthly(30 days) creation limit");
        }
        return !$nft->save()
            ? (new Response)->error()
            : (new Response)->created(NFTResource::make($nft));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @param int $id
     * @return array
     */
    public function show(int $id): array
    {
        $nft = NFT::query()->find($id);
        return !$nft
            ? (new Response)->idNotFound()
            : (new Response)->success(NFTResource::make($nft));
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
        $nft = NFT::query()->find($id);
        if(!$nft)
        { return (new Response)->idNotFound(); }

        return (!$nft->update($request->validated()))
            ? (new Response)->error(400)
            : (new Response)->success(NFTResource::make($nft));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id): array
    {
        $nft = NFT::query()->find($id);
        if(!$nft)
        { return (new Response)->idNotFound(); }

        return (!$nft->delete())
            ? (new Response)->error(400,$nft)
            : (new Response)->success(NFTResource::make($nft));
    }
}
