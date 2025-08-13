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
use App\Models\Solutions;
use App\Models\Category;
use App\Models\SubCategory;


class SubCategoryController extends Controller
{

    public function index()
    {
        $subProducts = DB::table('sub_category as sp')
            ->join('solution_type as s', 'sp.solution_id', '=', 's.id')
            ->select('sp.*', 's.solution_type')
            ->orderBy('s.solution_type')
            ->get()
            ->groupBy('solution_type');

        return view('backend.solutions.sub_category.index', compact('subProducts'));
    }

    public function create(Request $request)
    {
        $applications = Solutions::whereNull('deleted_by')->get();
        $categories = Category::whereNull('deleted_by')->get(); 

        return view('backend.solutions.sub_category.create', compact('applications', 'categories'));
    }

    public function store(Request $request)
    {
        // dd($request);
        // 1️⃣ Validation rules
        $rules = [
            'banner_title'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'solution_type'    => 'required|exists:solution_type,id',
            'parent_category'  => 'required|exists:category,id',
            'sub_category'     => 'required|string|max:255',
            'thumbnail_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        // 2️⃣ Custom messages
        $messages = [
            'solution_type.required'   => 'Please select a Solution Type.',
            'solution_type.exists'     => 'Selected Solution Type is invalid.',
            'parent_category.required' => 'Please select a Category.',
            'parent_category.exists'   => 'Selected Category is invalid.',
            'sub_category.required'    => 'Please enter a Sub Category.',
            'thumbnail_image.required' => 'Please upload a Thumbnail Image.',
            'thumbnail_image.image'    => 'Thumbnail Image must be an image file.',
            'thumbnail_image.mimes'    => 'Thumbnail Image must be jpg, jpeg, png, or webp.',
            'thumbnail_image.max'      => 'Thumbnail Image must be less than 2MB.',
        ];

        // 3️⃣ Validate
        $validatedData = $request->validate($rules, $messages);

        // 4️⃣ Handle banner image upload (optional)
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = null;
        }

        // 5️⃣ Handle thumbnail image upload (required)
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/products/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        }

        // 6️⃣ Generate slug from sub_category
        $slug = Str::slug($validatedData['sub_category']);
        $originalSlug = $slug;
        $counter = 1;
        while (SubCategory::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }

        // 7️⃣ Create and save model
        $subCategory = new SubCategory();
        $subCategory->banner_title    = $validatedData['banner_title'] ?? null;
        $subCategory->banner_image    = $validatedData['banner_image'];
        $subCategory->solution_id     = $validatedData['solution_type'];
        $subCategory->category_id     = $validatedData['parent_category'];
        $subCategory->sub_category    = $validatedData['sub_category'];
        $subCategory->thumbnail_image = $validatedData['thumbnail_image'];
        $subCategory->slug            = $slug;
        $subCategory->created_by      = Auth::id();
        $subCategory->created_at      = Carbon::now();

        $subCategory->save();

        // 8️⃣ Redirect with success message
        return redirect()->route('manage-sub-category.index')
            ->with('message', 'Sub Category created successfully!');
    }

    public function edit($id)
    {
        $applications = Solutions::whereNull('deleted_by')->get();

        $banner_details = SubCategory::findOrFail($id);

        // Fetch ALL categories so JS can filter dynamically
        $categories = Category::whereNull('deleted_by')->get();

        return view(
            'backend.solutions.sub_category.edit',
            compact('banner_details', 'applications', 'categories')
        );
    }

    public function update(Request $request, $id)
    {
        // 1️⃣ Find the record or fail
        $subCategory = SubCategory::findOrFail($id);

        // 2️⃣ Validation rules
        $rules = [
            'banner_title'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'solution_type'    => 'required|exists:solution_type,id',
            'parent_category'  => 'required|exists:category,id',
            'sub_category'     => 'required|string|max:255',
            'thumbnail_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048', // nullable now
        ];

        // 3️⃣ Custom messages
        $messages = [
            'solution_type.required'   => 'Please select a Solution Type.',
            'solution_type.exists'     => 'Selected Solution Type is invalid.',
            'parent_category.required' => 'Please select a Category.',
            'parent_category.exists'   => 'Selected Category is invalid.',
            'sub_category.required'    => 'Please enter a Sub Category.',
            'thumbnail_image.image'    => 'Thumbnail Image must be an image file.',
            'thumbnail_image.mimes'    => 'Thumbnail Image must be jpg, jpeg, png, or webp.',
            'thumbnail_image.max'      => 'Thumbnail Image must be less than 2MB.',
        ];

        // 4️⃣ Validate
        $validatedData = $request->validate($rules, $messages);

        // 5️⃣ Handle banner image upload (optional)
        if ($request->hasFile('banner_image')) {
            // Delete old image if exists
            if ($subCategory->banner_image && file_exists(public_path($subCategory->banner_image))) {
                unlink(public_path($subCategory->banner_image));
            }

            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/products/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = $subCategory->banner_image; // Keep old
        }

        // 6️⃣ Handle thumbnail image upload (optional)
        if ($request->hasFile('thumbnail_image')) {
            if ($subCategory->thumbnail_image && file_exists(public_path($subCategory->thumbnail_image))) {
                unlink(public_path($subCategory->thumbnail_image));
            }

            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . rand(10, 999) . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/products/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        } else {
            $validatedData['thumbnail_image'] = $subCategory->thumbnail_image; // Keep old
        }

        // 7️⃣ Update slug if sub_category changes
        if ($validatedData['sub_category'] !== $subCategory->sub_category) {
            $slug = Str::slug($validatedData['sub_category']);
            $originalSlug = $slug;
            $counter = 1;
            while (SubCategory::where('slug', $slug)->where('id', '!=', $id)->exists()) {
                $slug = $originalSlug . '-' . $counter;
                $counter++;
            }
            $validatedData['slug'] = $slug;
        } else {
            $validatedData['slug'] = $subCategory->slug;
        }

        // 8️⃣ Update other fields
        $subCategory->update([
            'banner_title'    => $validatedData['banner_title'] ?? null,
            'banner_image'    => $validatedData['banner_image'],
            'solution_id'     => $validatedData['solution_type'],
            'category_id'     => $validatedData['parent_category'],
            'sub_category'    => $validatedData['sub_category'],
            'thumbnail_image' => $validatedData['thumbnail_image'],
            'slug'            => $validatedData['slug'],
            'modified_by'      => Auth::id(),
            'modified_at'      => Carbon::now(),
        ]);

        // 9️⃣ Redirect with success message
        return redirect()->route('manage-sub-category.index')
            ->with('message', 'Sub Category updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = SubCategory::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-sub-category.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}