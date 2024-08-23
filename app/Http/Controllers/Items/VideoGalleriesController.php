<?php

namespace App\Http\Controllers\Items;

use App\Http\Controllers\Controller;
use App\Models\Items\VideoGallery;
use App\Services\VideoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VideoGalleriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(Request $request)
    {
        $item = auth()->user()->item()
            ->where('keyword', $request->keyword)
            ->firstOrFail();
        $video_galleries = VideoGallery::where('item_id', $item->id)
            ->simplePaginate('15');
        return view('items.video-gallery.index', compact('video_galleries', 'item'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(Request $request)
    {
        $item = auth()->user()->item()
            ->where('keyword', $request->keyword)
            ->firstOrFail();

        return view('items.video-gallery.create', compact('item'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $item = auth()->user()->item()->where('keyword', $request->keyword)->firstOrFail();
        $request->validate(['video' => 'required|file', 'title' => 'required|']);

        $filename = VideoService::uploadVideo($request->file('video'));
        VideoGallery::create([
            'title' => $request->title,
            'file' => $filename,
            'item_id' => $item->id,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('video-gallery.index', ['keyword' => $item->keyword]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $keyword
     * @param VideoGallery $videoGallery
     * @return View
     */
    public function edit($keyword, VideoGallery $videoGallery)
    {
        $item = auth()->user()->item()->with('video')->where('keyword', $keyword)->firstOrFail();
        $videoGallery  = $item->getRelation('video');
        return view('items.video-gallery.edit', compact('item', 'videoGallery', 'item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param VideoGallery $videoGallery
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($keyword, VideoGallery $videoGallery, Request $request)
    {
        $request->validate(['title' => 'required|string',
            'video' => 'sometimes|nullable']);
        $item = auth()->user()->item()->with('video')->where('keyword', $keyword)->firstOrFail();
        $data = ['title' => $request->title];
        if($request->hasFile('video')){
            $filename = VideoService::changedFile($request->file('video'), $videoGallery->file);
            $data += ['file' => $filename];
        }
        $videoGallery->update($data);
        return redirect()->route('video-gallery.index', $item->keyword);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $keyword
     * @param VideoGallery $video_gallery
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy($keyword, VideoGallery $video_gallery)
    {
        $item = auth()->user()->item()->where('keyword', $keyword)->firstOrFail();
        Storage::disk('ftp')->delete(config('app.videosRoute') . $video_gallery->file);
        $video_gallery->delete();
        return redirect()->route('video-gallery.index', $item->keyword);
    }
}
