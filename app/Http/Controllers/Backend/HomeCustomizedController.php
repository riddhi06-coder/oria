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
use App\Models\HomeCustomized;

class HomeCustomizedController extends Controller
{

    public function index()
    {
        $customizedSections = HomeCustomized::wherenull('deleted_by')->get(); 
        return view('backend.home.customized.index', compact('customizedSections'));
    }

    public function create(Request $request)
    {
        return view('backend.home.customized.create');
    }

    public function store(Request $request)
    {
        // ✅ Step 1: Validate Request
        $validatedData = $request->validate([
            'section_title' => 'required|string|max:255',
            'banner_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description'   => 'required|string',
        ], [
            'section_title.required' => 'The Section Title is required.',
            'banner_image.required'  => 'The Banner Image is required.',
            'banner_image.image'     => 'The Banner Image must be a valid image file.',
            'banner_image.mimes'     => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for Banner Image.',
            'banner_image.max'       => 'The Banner Image size must not exceed 2MB.',
            'description.required'   => 'The Description field is required.',
        ]);


        // ✅ Step 2: Handle File Uploads
        $bannerPath = null;
        $logoPath   = null;

        if ($request->hasFile('banner_image')) {
            $filename   = time() . '_' . uniqid() . '.' . $request->file('banner_image')->getClientOriginalExtension();
            $request->file('banner_image')->move(public_path('uploads/home/'), $filename);
            $bannerPath = 'uploads/home/' . $filename;
        }

        // ✅ Step 3: Save Data
        $customized = new HomeCustomized();
        $customized->section_title = $validatedData['section_title'];
        $customized->banner_image  = $bannerPath;
        $customized->description   = $validatedData['description'];
        $customized->inserted_by  = Auth::id();
        $customized->inserted_at  = Carbon::now();
        $customized->save();

        // ✅ Step 4: Redirect
        return redirect()
            ->route('manage-customized.index')
            ->with('message', 'Customized section has been added successfully.');
    }

    public function edit($id)
    {
        $customize = HomeCustomized::findOrFail($id);
        return view('backend.home.customized.edit', compact('customize'));
    }

    public function update(Request $request, $id)
    {
        $customized = HomeCustomized::findOrFail($id);

        $validatedData = $request->validate([
            'section_title' => 'required|string|max:255',
            'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description'   => 'required|string',
        ], [
            'section_title.required' => 'The Section Title is required.',
            'banner_image.image'     => 'The Banner Image must be a valid image file.',
            'banner_image.mimes'     => 'Only JPG, JPEG, PNG, and WEBP formats are allowed for Banner Image.',
            'banner_image.max'       => 'The Banner Image size must not exceed 2MB.',
            'description.required'   => 'The Description field is required.',
        ]);

        // ✅ Step 3: Handle File Uploads (replace old if new is uploaded)
        if ($request->hasFile('banner_image')) {

            if ($customized->banner_image && file_exists(public_path($customized->banner_image))) {
                unlink(public_path($customized->banner_image));
            }

            $filename   = time() . '_' . uniqid() . '.' . $request->file('banner_image')->getClientOriginalExtension();
            $request->file('banner_image')->move(public_path('uploads/home/'), $filename);
            $customized->banner_image = 'uploads/home/' . $filename;
        }

        $customized->section_title = $validatedData['section_title'];
        $customized->description   = $validatedData['description'];
        $customized->modified_by    = Auth::id();
        $customized->modified_at    = Carbon::now();
        $customized->save();

        return redirect()
            ->route('manage-customized.index')
            ->with('message', 'Customized section has been updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = HomeCustomized::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-customized.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}