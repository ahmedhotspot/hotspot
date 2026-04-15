<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaController extends Controller
{
    public function index()
    {
        return view('admin.media.index', [
            'media' => Media::orderBy('id', 'desc')->paginate(20),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'files'   => 'required|array',
            'files.*' => 'file|max:10240',
        ]);

        foreach ($request->file('files', []) as $file) {
            $path = $file->store('media', 'public');
            Media::create([
                'collection'    => 'library',
                'disk'          => 'public',
                'path'          => $path,
                'original_name' => $file->getClientOriginalName(),
                'mime_type'     => $file->getMimeType(),
                'size'          => $file->getSize(),
                'uploaded_by'   => auth()->id(),
            ]);
        }

        return back()->with('success', __('Uploaded successfully'));
    }

    public function destroy(Media $media)
    {
        if ($media->disk && $media->path) {
            Storage::disk($media->disk)->delete($media->path);
        }
        $media->delete();

        return back()->with('success', __('Deleted successfully'));
    }
}
