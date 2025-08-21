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
use App\Models\HomeFeatures;

class HomeFeaturesController extends Controller
{

    public function index()
    {
        $features = HomeFeatures::wherenull('deleted_by')->get();
        return view('backend.home.features.index', compact('features'));
    }

    public function create(Request $request)
    {
        return view('backend.home.features.create');
    }

    public function store(Request $request)
    {
        // ✅ Step 1: Validation
        $request->validate([
            'section_title' => 'required|string|max:255',
            'gallery_image.*' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'info_title.*' => 'required|string|max:255',
            'info_information.*' => 'required|string|max:255',
            'info_description.*' => 'required|string',
        ], [
            // Custom Messages
            'section_title.required' => 'Section Title is required.',
            'gallery_image.*.required' => 'At least one gallery image is required.',
            'gallery_image.*.image' => 'Each file must be an image.',
            'gallery_image.*.mimes' => 'Only JPG, JPEG, PNG, WEBP formats are allowed.',
            'gallery_image.*.max' => 'Image size must be less than 2MB.',
            'info_title.*.required' => 'Feature title is required.',
            'info_information.*.required' => 'Feature information is required.',
            'info_description.*.required' => 'Feature description is required.',
        ]);

        // ✅ Step 2: Handle Gallery Images
        $galleryImages = [];
        if ($request->hasFile('gallery_image')) {
            foreach ($request->file('gallery_image') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/home/'), $filename);
                $galleryImages[] = 'uploads/home/' . $filename;
            }
        }

        // ✅ Step 3: Handle Company Features (JSON Encode)
        $features = [];
        if ($request->info_title && $request->info_information && $request->info_description) {
            foreach ($request->info_title as $key => $title) {
                $features[] = [
                    'title' => $title,
                    'information' => $request->info_information[$key] ?? '',
                    'description' => $request->info_description[$key] ?? '',
                ];
            }
        }

        // ✅ Step 4: Save in Database
        $feature = new HomeFeatures();
        $feature->section_title = $request->section_title;
        $feature->gallery_images = json_encode($galleryImages); 
        $feature->features = json_encode($features); 
        $feature->inserted_by  = Auth::id();
        $feature->inserted_at  = Carbon::now();
        $feature->save();

        // ✅ Step 5: Redirect with Success Message
        return redirect()->route('manage-our-features.index')->with('message', 'Our Features added successfully!');
    }

    public function edit($id)
    {
        $feature = HomeFeatures::findOrFail($id);
        $galleryImages = json_decode($feature->gallery_images, true);
        $companyFeatures = json_decode($feature->features, true); 
        return view('backend.home.features.edit', compact('feature', 'galleryImages', 'companyFeatures'));
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        // ✅ Step 1: Validation
        $request->validate([
            'section_title' => 'required|string|max:255',
            'gallery_image.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'info_title.*' => 'required|string|max:255',
            'info_information.*' => 'required|string|max:255',
            'info_description.*' => 'required|string',
        ], [
            'section_title.required' => 'Section Title is required.',
            'gallery_image.*.image' => 'Each file must be an image.',
            'gallery_image.*.mimes' => 'Only JPG, JPEG, PNG, WEBP formats are allowed.',
            'gallery_image.*.max' => 'Image size must be less than 2MB.',
            'info_title.*.required' => 'Feature title is required.',
            'info_information.*.required' => 'Feature information is required.',
            'info_description.*.required' => 'Feature description is required.',
        ]);

        // ✅ Step 2: Fetch existing record
        $feature = HomeFeatures::findOrFail($id);

        // Step 1: Existing images
        $galleryImages = $request->input('gallery_image_existing', []);

        // Step 2: Append newly uploaded images
        if ($request->hasFile('gallery_image')) { // <- match your input name
            foreach ($request->file('gallery_image') as $image) {
                $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/home/'), $filename);
                $galleryImages[] = 'uploads/home/' . $filename;
            }
        }

        // Step 3: Save
        $feature->gallery_images = json_encode($galleryImages);


        // ✅ Step 4: Handle Company Features (JSON Encode)
        $features = [];
        if ($request->info_title && $request->info_information && $request->info_description) {
            foreach ($request->info_title as $key => $title) {
                $features[] = [
                    'title' => $title,
                    'information' => $request->info_information[$key] ?? '',
                    'description' => $request->info_description[$key] ?? '',
                ];
            }
        }

        // ✅ Step 5: Update Database
        $feature->section_title = $request->section_title;
        $feature->features = json_encode($features);
        $feature->modified_by = Auth::id();
        $feature->modified_at = Carbon::now();
        $feature->save();

        // ✅ Step 6: Redirect with Success Message
        return redirect()->route('manage-our-features.index')->with('message', 'Our Features updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = HomeFeatures::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-our-features.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }



}