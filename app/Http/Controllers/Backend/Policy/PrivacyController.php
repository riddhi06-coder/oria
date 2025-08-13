<?php

namespace App\Http\Controllers\Backend\Policy;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use Carbon\Carbon;
use App\Models\Privacy;


class PrivacyController extends Controller
{

    public function index()
    {
        $terms = Privacy::whereNull('deleted_at')->get(); 
        return view('backend.policies.privacy.index', compact('terms'));
    }
    
    public function create(Request $request)
    { 
        return view('backend.policies.privacy.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'heading' => 'nullable|string|max:255',
            'introduction' => 'nullable|string',
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ], [
            'heading.string' => 'The heading must be a valid string.',
            'heading.max' => 'The heading may not be greater than 255 characters.',
            'introduction.string' => 'The introduction must be a valid string.',
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.'
        ]);
    
        $term = new Privacy();
        $term->heading = $request->heading;
        $term->introduction = $request->introduction;
        $term->title = $request->title;
        $term->description = $request->description;
        $term->inserted_by = Auth::user()->id;
        $term->inserted_at = Carbon::now();
        $term->save();
    
        return redirect()->route('privacy.index')->with('message', 'Privacy details added successfully!');
    }

    public function edit($id)
    {
        $term = Privacy::findOrFail($id);
        return view('backend.policies.privacy.edit', compact('term'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string'
        ], [
            'title.required' => 'The title field is required.',
            'title.string' => 'The title must be a valid string.',
            'title.max' => 'The title may not be greater than 255 characters.',
            'description.required' => 'The description field is required.',
            'description.string' => 'The description must be a valid string.'
        ]);

        $term = Privacy::findOrFail($id);
        $term->heading = $request->heading;
        $term->introduction = $request->introduction;
        $term->title = $request->title;
        $term->description = $request->description;
        $term->modified_by = Auth::user()->id;
        $term->modified_at = Carbon::now();
        $term->save();

        return redirect()->route('privacy.index')->with('message', 'Privacy details updated successfully!');
    }

    public function destroy(string $id)
    {
        $data['deleted_by'] =  Auth::user()->id;
        $data['deleted_at'] =  Carbon::now();
        try {
            $industries = Privacy::findOrFail($id);
            $industries->update($data);

            return redirect()->route('privacy.index')->with('message', 'Privacy details deleted successfully!');
        } catch (Exception $ex) {
            return redirect()->back()->with('error', 'Something Went Wrong - ' . $ex->getMessage());
        }
    }
}