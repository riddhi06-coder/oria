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
use App\Models\Category;
use App\Models\Solutions;


class CategoryController extends Controller
{

    public function index()
    {
        $applications = Category::with('application') 
            ->orderBy('id', 'asc')
            ->whereNull('deleted_by')
            ->get()
            ->groupBy(function ($item) {
                return $item->application->solution_type ?? 'N/A';
            });

        return view('backend.solutions.category.index', compact('applications'));
    }

    public function create(Request $request)
    {
        $applications = Solutions::wherenull('deleted_by')->get();
        return view('backend.solutions.category.create', compact('applications'));
    }

    public function store(Request $request)
    {
        $rules = [
            'solution_type' => 'required|exists:solution_type,id',
            'banner_title'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'         => 'required|string|max:255',
            'thumbnail_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'banner_image.image'        => 'The uploaded banner must be an image.',
            'banner_image.mimes'        => 'Allowed banner formats: jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The banner image must be less than 2MB.',

            'thumbnail_image.required'  => 'The Thumbnail Image is required.',
            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',

            'category.required'         => 'The Category field is required.',
        ];

        $validatedData = $request->validate($rules, $messages);

        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . '_' . uniqid() . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/category/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);
            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = null;
        }

        // Handle thumbnail image upload
        $thumbnailImage = $request->file('thumbnail_image');
        $thumbnailImageName = time() . '_' . uniqid() . '.' . $thumbnailImage->getClientOriginalExtension();
        $thumbnailPath = 'uploads/category/';
        $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);
        $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;

        $slug = Str::slug($validatedData['category']);

        // Save to database
        Category::create([
            'banner_title'     => $validatedData['banner_title'],
            'banner_image'     => $validatedData['banner_image'],
            'solution_id'   => $validatedData['solution_type'],
            'category'         => $validatedData['category'],
            'thumbnail_image'  => $validatedData['thumbnail_image'],
            'slug'             => $slug,
            'created_by'       => Auth::id(),
            'created_at'       => Carbon::now(),
        ]);

        return redirect()->route('manage-category.index')->with('message', 'Category added successfully!');
    }

    public function edit($id)
    {
        $banner_details = Category::findOrFail($id);
        $applications = Solutions::whereNull('deleted_by')->get(); 

        return view('backend.solutions.category.edit', compact('banner_details', 'applications'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);

        $rules = [
            'solution_type' => 'required|exists:solution_type,id',
            'banner_title'     => 'nullable|string|max:255',
            'banner_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'category'         => 'required|string|max:255',
            'thumbnail_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'banner_image.image'        => 'The uploaded banner must be an image.',
            'banner_image.mimes'        => 'Allowed banner formats: jpg, jpeg, png, webp.',
            'banner_image.max'          => 'The banner image must be less than 2MB.',

            'thumbnail_image.image'     => 'The uploaded thumbnail must be an image.',
            'thumbnail_image.mimes'     => 'Allowed thumbnail formats: jpg, jpeg, png, webp.',
            'thumbnail_image.max'       => 'The thumbnail image must be less than 2MB.',

            'category.required'         => 'The Category field is required.',
        ];

        $validatedData = $request->validate($rules, $messages);

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . '_' . uniqid() . '.' . $bannerImage->getClientOriginalExtension();
            $bannerPath = 'uploads/category/';
            $bannerImage->move(public_path($bannerPath), $bannerImageName);

            // Optionally delete old banner
            if ($category->banner_image && file_exists(public_path($category->banner_image))) {
                unlink(public_path($category->banner_image));
            }

            $validatedData['banner_image'] = $bannerPath . $bannerImageName;
        } else {
            $validatedData['banner_image'] = $category->banner_image;
        }

        // Handle thumbnail image upload
        if ($request->hasFile('thumbnail_image')) {
            $thumbnailImage = $request->file('thumbnail_image');
            $thumbnailImageName = time() . '_' . uniqid() . '.' . $thumbnailImage->getClientOriginalExtension();
            $thumbnailPath = 'uploads/category/';
            $thumbnailImage->move(public_path($thumbnailPath), $thumbnailImageName);

            // Optionally delete old thumbnail
            if ($category->thumbnail_image && file_exists(public_path($category->thumbnail_image))) {
                unlink(public_path($category->thumbnail_image));
            }

            $validatedData['thumbnail_image'] = $thumbnailPath . $thumbnailImageName;
        } else {
            $validatedData['thumbnail_image'] = $category->thumbnail_image;
        }

        // Update slug if category name changed
        $slug = Str::slug($validatedData['category']);

        // Update database
        $category->update([
            'banner_title'     => $validatedData['banner_title'],
            'banner_image'     => $validatedData['banner_image'],
            'solution_id'   => $validatedData['solution_type'],
            'category'         => $validatedData['category'],
            'thumbnail_image'  => $validatedData['thumbnail_image'],
            'slug'             => $slug,
            'modified_by'      => Auth::id(),
            'modified_at'      => Carbon::now(),
        ]);

        return redirect()->route('manage-category.index')->with('message', 'Category updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Category::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-category.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}