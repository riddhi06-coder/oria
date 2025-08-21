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
use App\Models\HomePartner;

class HomePartnersController extends Controller
{

    public function index()
    {
        $partners = HomePartner::whereNull('deleted_at')->get();
        return view('backend.home.partners.index', compact('partners'));
    }

    public function create(Request $request)
    {
        return view('backend.home.partners.create');
    }

    public function store(Request $request)
    {
        // ✅ Step 1: Validation
        $request->validate([
            'section_title' => 'required|string|max:255',
            'banner_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'section_title.required' => 'The Section Title field is required.',
            'banner_image.required'  => 'The Banner Image field is required.',
            'banner_image.image'     => 'The Banner Image must be an image file.',
            'banner_image.mimes'     => 'The Banner Image must be a file of type: jpg, jpeg, png, webp.',
            'banner_image.max'       => 'The Banner Image must not be greater than 2MB.',
            'gallery_image.*.required' => 'Each Gallery Image is required.',
            'gallery_image.*.image'    => 'Each Gallery Image must be an image file.',
            'gallery_image.*.mimes'    => 'Each Gallery Image must be of type: jpg, jpeg, png, webp.',
            'gallery_image.*.max'      => 'Each Gallery Image must not be greater than 2MB.',
        ]);

        try {
            // ✅ Store Banner Image in public/uploads/partners/banner/
            $bannerImageName = time() . '_banner.' . $request->banner_image->extension();
            $request->banner_image->move(public_path('uploads/home'), $bannerImageName);

            // ✅ Store Gallery Images in public/uploads/partners/gallery/
            $galleryImages = [];
            if ($request->hasFile('gallery_image')) {
                foreach ($request->file('gallery_image') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                    $image->move(public_path('uploads/home'), $imageName);
                    $galleryImages[] = $imageName;
                }
            }

            // ✅ Save to DB
            $partner = new HomePartner();
            $partner->section_title = $request->section_title;
            $partner->section_description = $request->section_description;
            $partner->banner_image = $bannerImageName; // only filename
            $partner->gallery_images = json_encode($galleryImages); // store as JSON
            $partner->inserted_by  = Auth::id();
            $partner->inserted_at  = Carbon::now();
            $partner->save();

            return redirect()->route('manage-our-partners.index')
                ->with('message', 'Partner details saved successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $feature = HomePartner::findOrFail($id);
        $galleryImages = json_decode($feature->gallery_images, true);
        // dd($galleryImages);
        return view('backend.home.partners.edit', compact('feature', 'galleryImages'));
    }

    public function update(Request $request, $id)
    {
        // ✅ Step 1: Validation
        $request->validate([
            'section_title'    => 'required|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'gallery_image.*'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'section_title.required' => 'The Section Title field is required.',
            'banner_image.image'     => 'The Banner Image must be an image file.',
            'banner_image.mimes'     => 'The Banner Image must be of type: jpg, jpeg, png, webp.',
            'banner_image.max'       => 'The Banner Image must not be greater than 2MB.',
            'gallery_image.*.image'  => 'Each Gallery Image must be an image file.',
            'gallery_image.*.mimes'  => 'Each Gallery Image must be of type: jpg, jpeg, png, webp.',
            'gallery_image.*.max'    => 'Each Gallery Image must not be greater than 2MB.',
        ]);

        try {
            $partner = HomePartner::findOrFail($id);

            // ✅ Update Banner Image if provided
            if ($request->hasFile('banner_image')) {
                // delete old banner if exists
                $oldBannerPath = public_path('uploads/home/' . $partner->banner_image);
                if ($partner->banner_image && file_exists($oldBannerPath)) {
                    unlink($oldBannerPath);
                }

                $bannerImageName = time() . '_banner.' . $request->banner_image->extension();
                $request->banner_image->move(public_path('uploads/home'), $bannerImageName);
                $partner->banner_image = $bannerImageName;
            }

            // ✅ Handle Gallery Images
            $existingGallery = $request->input('existing_gallery_images', []); // keep only the ones still in form

            // Add newly uploaded images
            if ($request->hasFile('gallery_image')) {
                foreach ($request->file('gallery_image') as $image) {
                    $imageName = time() . '_' . uniqid() . '.' . $image->extension();
                    $image->move(public_path('uploads/home'), $imageName);
                    $existingGallery[] = $imageName; // append new images
                }
            }

            $partner->gallery_images = json_encode($existingGallery);

            $partner->section_title       = $request->section_title;
            $partner->section_description = $request->section_description;
            $partner->modified_by          = Auth::id();
            $partner->modified_at          = Carbon::now();
            $partner->save();

            return redirect()->route('manage-our-partners.index')
                ->with('message', 'Partner details updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Something went wrong: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = HomePartner::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-our-partners.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}