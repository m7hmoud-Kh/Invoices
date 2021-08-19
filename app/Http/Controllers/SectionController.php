<?php

namespace App\Http\Controllers;

use App\Http\Requests\SotreSection;
use App\Models\section;
use Illuminate\Http\Request;
use PHPUnit\Util\Xml\Validator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $allSection = section::get();
        return view('sections.AllSection', compact('allSection'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SotreSection $request)
    {
        section::create([
            'name_section' => $request->name_section,
            'description' => $request->description,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()->back()->with(['success' => 'section added seccessfully']);
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $request->validate($this->rules($request->id), $this->messages());

        $section = section::find($request->id);
        $section->update([
            'name_section' => $request->name_section,
            'description' => $request->description,
        ]);

        return redirect()->back()->with(['edit' => 'the section edited successfully']);
    }

    public function rules($id)
    {
        return [
            'name_section' => 'required|unique:sections,name_section,' . $id,
            'description' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name_section.required' => 'name of section required',
            'name_section.unique' => 'the name allready been taken',
            'description.required' => 'the description is required'
        ];
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\section  $section
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $section = section::find($request->id);
        if ($section) {
            $section->delete();
            return redirect()->back()->with(['delete' => 'the section deleted successfully']);
        }
    }
}
