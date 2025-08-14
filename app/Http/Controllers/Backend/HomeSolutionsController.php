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
use App\Models\HomeSolutions;
use App\Models\Solutions;

class HomeSolutionsController extends Controller
{

    public function index()
    {
        // Fetch all solutions with relation to solution type
        $solutions = DB::table('home_solutions as os')
            ->join('solution_type as st', 'os.solution_type_id', '=', 'st.id')
            ->select('os.*', 'st.solution_type')
            ->orderBy('os.id', 'asc')
            ->get();

        return view('backend.home.solutions.index', compact('solutions'));
    }


    public function create(Request $request)
    {
        $solutionTypes = Solutions::wherenull('deleted_by')->get(); 
        return view('backend.home.solutions.create', compact('solutionTypes'));
    }

    public function store(Request $request)
    {
        // ✅ Step 1: Validation
        $request->validate([
            'solution_type' => 'required|exists:solution_type,id', // must exist in solution_types table
            'banner_image'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Step 2: Handle File Upload
        $bannerImagePath = null;
        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $bannerImagePath = $file->move(public_path('uploads/home'), $filename);
            $bannerImagePath = 'uploads/home/' . $filename; 
        }

        // ✅ Step 3: Insert into DB
        HomeSolutions::insert([
            'solution_type_id' => $request->solution_type,
            'banner_image'     => $bannerImagePath,
            'inserted_by'       => Auth::id(),
            'inserted_at'       => Carbon::now(),
        ]);

        // ✅ Step 4: Redirect with success
        return redirect()->route('manage-our-solutions.index')
                        ->with('message', 'Solution added successfully!');
    }

    public function edit($id)
    {
        $appIntro = HomeSolutions::findOrFail($id);
        $solutionTypes = Solutions::wherenull('deleted_by')->get(); 
        return view('backend.home.solutions.edit', compact('appIntro','solutionTypes'));
    }


    public function update(Request $request, $id)
    {
        // ✅ Step 1: Find record
        $solution = HomeSolutions::findOrFail($id);

        // ✅ Step 2: Validation
        $request->validate([
            'solution_type' => 'required|exists:solution_type,id',
            'banner_image'  => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        // ✅ Step 3: Handle File Upload
        $bannerImagePath = $solution->banner_image; // keep old if not replaced
        if ($request->hasFile('banner_image')) {
            // delete old file if exists
            if ($solution->banner_image && file_exists(public_path($solution->banner_image))) {
                unlink(public_path($solution->banner_image));
            }

            $file = $request->file('banner_image');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/home'), $filename);
            $bannerImagePath = 'uploads/home/' . $filename;
        }

        // ✅ Step 4: Update DB
        $solution->update([
            'solution_type_id' => $request->solution_type,
            'banner_image'     => $bannerImagePath,
            'updated_by'       => Auth::id(),
            'updated_at'       => Carbon::now(),
        ]);

        // ✅ Step 5: Redirect with success
        return redirect()->route('manage-our-solutions.index')
                        ->with('message', 'Solution updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = HomeSolutions::findOrFail($id);
            $industries->update($data);

            return redirect()->route('manage-our-solutions.index')->with('message', 'Details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}