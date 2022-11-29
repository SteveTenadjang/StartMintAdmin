<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\NFTRequest;
use App\Http\Resources\NFTResource;
use App\Models\NFT;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NFTController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request): JsonResponse
    {  return response()->success((NFTResource::collection(NFT::all()))); }

    /**
     * Store a newly created resource in storage.
     *
     * @param NFTRequest $request
     * @return JsonResponse
     */
    public function store(NFTRequest $request): JsonResponse
    {
        $nft = new NFT($request->validated());
        $nft['created_by'] = auth()->id();
        if(!auth()->user()?->canCreate())
        { return response()->error(401,$nft, "already exceeded creation limit"); }
        $nft = $this->fileManager($request, $nft);
        return !$nft->save()
            ? response()->error()
            : response()->created(NFTResource::make($nft));
    }

    /**
     * Display the specified resource and it's relations.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function show(int $id): JsonResponse
    {
        $nft = NFT::query()->find($id);
        return !$nft
            ? response()->idNotFound()
            : response()->success(NFTResource::make($nft));
    }

    /**
     * Update the specified resource in storage.
     * EC = NFT Collection name for Spatie media
     *
     * @param NFTRequest $request
     * @param int $id
     * @return JsonResponse
     */
    public function update(NFTRequest $request, int $id): JsonResponse
    {
        $nft = NFT::query()->find($id);
        if(!$nft)
        { return response()->idNotFound(); }
        $nft = $this->fileManager($request, $nft);
        return (!$nft->update($request->validated()))
            ? response()->error()
            : response()->success(NFTResource::make($nft));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy(int $id): JsonResponse
    {
        $nft = NFT::query()->find($id);
        if(!$nft)
        { return response()->idNotFound(); }

        return (!$nft->delete())
            ? response()->error(400,$nft)
            : response()->success(NFTResource::make($nft));
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
                $nft['media_link'] = $file->storeAs('files/' . time(), $request->input('media_title'));
                $nft['media_type'] = $extension;
            }
        }
        return $nft;
    }
}
