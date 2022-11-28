<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NFTRequest;
use App\Http\Resources\NFTResource;
use App\Models\NFT;
use App\Traits\Response;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
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
        if(!auth()->user()?->canCreate())
        { return (new Response)->error(401,$nft, "already exceeded creation limit"); }
        $nft = $this->fileManager($request, $nft);
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
        $nft = $this->fileManager($request, $nft);
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

    /**
     * @param NFTRequest $request
     * @param Model|Collection|Builder|array $nft
     * @return array|Builder|Collection|Model
     */
    private function fileManager(NFTRequest $request, Model|Collection|Builder|array $nft): array|Builder|Collection|Model
    {
        if ($request->hasFile('file') && $request->file('file')?->isValid()) {
            $file = $request->file('file');
            $extensions = ['mp4', 'mov', 'gif', 'jpg', 'png', 'pdf', 'ai', 'eps', 'mp3', 'wav', 'aiff'];
            $extension = $file->getClientOriginalExtension();
            if (in_array($extension, $extensions)) {
                $nft['media_link'] = $file->storeAs('files/' . time(), $name);
                $nft['media_type'] = $extension;
            }
        }
        return $nft;
    }
}
