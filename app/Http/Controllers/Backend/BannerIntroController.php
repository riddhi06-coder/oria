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
use App\Models\BannerIntro;

class BannerIntroController extends Controller
{

    public function index()
    {
        $banners = BannerIntro::whereNull('deleted_by')->get();
        return view('backend.home.banner.index', compact('banners'));
    }

    public function create(Request $request)
    {
        return view('backend.home.banner.create');
    }

    public function store(Request $request)
    {
        // 1️⃣ Validation
        $rules = [
            'banner_heading' => 'required|string|max:255',
            'banner_image'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'heading'        => 'required|string|max:255',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
        ];

        $messages = [
            'banner_heading.required' => 'Please enter a Banner Heading.',
            'banner_image.required'   => 'Please upload a Banner Image.',
            'banner_image.image'      => 'Banner Image must be an image file.',
            'banner_image.mimes'      => 'Only JPG, JPEG, PNG, WEBP formats are allowed.',
            'banner_image.max'        => 'Banner Image must be less than 2MB.',
            'heading.required'        => 'Please enter a Heading.',
            'title.required'          => 'Please enter a Title.',
            'description.required'    => 'Please enter a Description.',
        ];

        $validated = $request->validate($rules, $messages);

        // 2️⃣ Handle Banner Image Upload
        if ($request->hasFile('banner_image')) {
            $bannerImage      = $request->file('banner_image');
            $bannerImageName  = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath       = 'uploads/home/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validated['banner_image'] = $bannerPath . $bannerImageName;
        }

        // 3️⃣ Save to Database
        $bannerIntro = new BannerIntro();
        $bannerIntro->banner_heading = $validated['banner_heading'];
        $bannerIntro->banner_image   = $validated['banner_image'];
        $bannerIntro->heading        = $validated['heading'];
        $bannerIntro->title          = $validated['title'];
        $bannerIntro->description    = $validated['description'];
        $bannerIntro->created_by     = Auth::id();
        $bannerIntro->created_at     = Carbon::now(); 
        $bannerIntro->save();

        // 4️⃣ Redirect with Success
        return redirect()->route('manage-banner-intro.index')
            ->with('message', 'Banner Intro created successfully!');
    }

    public function edit($id)
    {
        $banner_details = BannerIntro::findOrFail($id);
        return view('backend.home.banner.edit', compact('banner_details'));
    }

    public function update(Request $request, $id)
    {
        // 1️⃣ Find the existing record
        $bannerIntro = BannerIntro::findOrFail($id);

        // 2️⃣ Validation
        $rules = [
            'banner_heading' => 'required|string|max:255',
            'banner_image'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // image optional for update
            'heading'        => 'required|string|max:255',
            'title'          => 'required|string|max:255',
            'description'    => 'required|string',
        ];

        $messages = [
            'banner_heading.required' => 'Please enter a Banner Heading.',
            'banner_image.image'      => 'Banner Image must be an image file.',
            'banner_image.mimes'      => 'Only JPG, JPEG, PNG, WEBP formats are allowed.',
            'banner_image.max'        => 'Banner Image must be less than 2MB.',
            'heading.required'        => 'Please enter a Heading.',
            'title.required'          => 'Please enter a Title.',
            'description.required'    => 'Please enter a Description.',
        ];

        $validated = $request->validate($rules, $messages);

        // 3️⃣ Handle Banner Image Upload (if new image is uploaded)
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($bannerIntro->banner_image && file_exists(public_path($bannerIntro->banner_image))) {
                unlink(public_path($bannerIntro->banner_image));
            }

            $bannerImage      = $request->file('banner_image');
            $bannerImageName  = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath       = 'uploads/home/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validated['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            // Keep the old image if no new one is uploaded
            $validated['banner_image'] = $bannerIntro->banner_image;
        }

        // 4️⃣ Update Database
        $bannerIntro->update([
            'banner_heading' => $validated['banner_heading'],
            'banner_image'   => $validated['banner_image'],
            'heading'        => $validated['heading'],
            'title'          => $validated['title'],
            'description'    => $validated['description'],
            'modified_by'     => Auth::id(),
            'modified_at'     => Carbon::now(),
        ]);

        // 5️⃣ Redirect with Success
        return redirect()->route('manage-banner-intro.index')
            ->with('message', 'Banner Intro updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = BannerIntro::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-banner-intro.index')->with('message', 'Banner Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }


}