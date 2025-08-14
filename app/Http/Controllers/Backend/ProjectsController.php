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
use App\Models\Projects;

class ProjectsController extends Controller
{

    public function index()
    {
        $projects = Projects::wherenull('deleted_by')->get(); 
        return view('backend.projects.list.index', compact('projects'));
    }

    public function create(Request $request)
    {
        return view('backend.projects.list.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'project_name' => 'required|string|max:255',
            'banner_image'     => 'required|image|mimes:jpg,jpeg,png,webp|max:2048', 
        ];

        $messages = [
            'project_name.required' => 'Please enter a Projects Category.',
            'project_name.max'      => 'Projects Category must not exceed 255 characters.',

            'banner_image.required'     => 'Please upload a Thumbnail Image.',
            'banner_image.image'        => 'Thumbnail must be an image file.',
            'banner_image.mimes'        => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'banner_image.max'          => 'Thumbnail image must not exceed 2MB.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $slug = Str::slug($request->project_name);

        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/projects/'), $bannerImageName);
            $bannerImagePath = 'uploads/projects/' . $bannerImageName;
        }

        Projects::create([
            'project_name' => $request->project_name,
            'slug'             => $slug,
            'banner_image'     => $bannerImagePath,
            'inserted_at'       => Auth::id(),
            'inserted_by'       => Carbon::now(),
        ]);

        return redirect()->route('manage-projects.index')->with('message', 'Project created successfully.');
    }

    public function updateStatus(Request $request)
    {
        $project = Projects::find($request->id);
        if ($project) {
            $project->status = $request->status;
            $project->save();

            return response()->json([
                'success' => true,
                'message' => 'Project status updated successfully!'
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Project not found!'
        ]);
    }

    public function edit($id)
    {
        $appIntro = Projects::findOrFail($id);
        return view('backend.projects.list.edit', compact('appIntro'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'project_name' => 'required|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ];

        $messages = [
            'project_name.required' => 'Please enter a Projects Category.',
            'project_name.max'      => 'Projects Category must not exceed 255 characters.',

            'banner_image.image'    => 'Thumbnail must be an image file.',
            'banner_image.mimes'    => 'Only JPG, JPEG, PNG, and WEBP formats are allowed.',
            'banner_image.max'      => 'Thumbnail image must not exceed 2MB.',
        ];

        $validatedData = $request->validate($rules, $messages);

        $project = Projects::findOrFail($id);

        $slug = Str::slug($request->project_name);

        // Handle banner image update
        $bannerImagePath = $project->banner_image; // keep old if not replaced
        if ($request->hasFile('banner_image')) {
            // delete old image if exists
            if ($project->banner_image && file_exists(public_path($project->banner_image))) {
                unlink(public_path($project->banner_image));
            }

            $bannerImage = $request->file('banner_image');
            $bannerImageName = time() . rand(10, 999) . '.' . $bannerImage->getClientOriginalExtension();
            $bannerImage->move(public_path('uploads/projects/'), $bannerImageName);
            $bannerImagePath = 'uploads/projects/' . $bannerImageName;
        }

        $project->update([
            'project_name'  => $request->project_name,
            'slug'          => $slug,
            'banner_image'  => $bannerImagePath,
            'modified_at'    => Carbon::now(),
            'modified_by'    => Auth::id(),
        ]);

        return redirect()->route('manage-projects.index')->with('message', 'Project updated successfully.');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Projects::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-projects.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }

}