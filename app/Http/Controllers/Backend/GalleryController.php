<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\Models\Gallery;

class GalleryController extends Controller
{

    public function index()
    {
        $galleries = Gallery::orderBy('id', 'desc')->get();
        return view('backend.home.gallery.index', compact('galleries'));
    }

    public function create(Request $request)
    {
        return view('backend.home.gallery.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $galleryImages = [];

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/home/'), $imageName);
                    $galleryImages[] = 'uploads/home/' . $imageName; 
                }
            }
        }

        Gallery::insert([
            'title' => $request->title,
            'images' => json_encode($galleryImages), 
            'inserted_by' => Auth::id(),
            'inserted_at' => Carbon::now(),
        ]);

        return redirect()->route('manage-gallery.index')->with('message', 'Gallery created successfully!');
    }

    public function edit($id)
    {
        $banner_details = Gallery::findOrFail($id); 
        return view('backend.home.gallery.edit', compact('banner_details'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $gallery = Gallery::findOrFail($id);

        $existingImages = json_decode($gallery->images, true) ?? [];

        $deletedImages = $request->input('deleted_images', []);
        if (!empty($deletedImages)) {
            $existingImages = array_diff($existingImages, $deletedImages);

            foreach ($deletedImages as $delImg) {
                if (file_exists(public_path($delImg))) {
                    unlink(public_path($delImg));
                }
            }
        }

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                if ($image->isValid()) {
                    $imageName = time() . rand(10, 999) . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path('uploads/home/'), $imageName);
                    $existingImages[] = 'uploads/home/' . $imageName;
                }
            }
        }

        $gallery->update([
            'title' => $request->title,
            'images' => json_encode(array_values($existingImages)), 
            'modified_by' => Auth::id(),
            'modified_at' => Carbon::now(),
        ]);

        return redirect()->route('manage-gallery.index')->with('message', 'Gallery updated successfully!');
    }



}