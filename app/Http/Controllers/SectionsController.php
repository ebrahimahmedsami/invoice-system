<?php

namespace App\Http\Controllers;

use App\Http\Requests\SectionsRequest;
use App\Models\Sections;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    public function getAllSections(){

        $sections = Sections::get();
        return view('sections.allsections',compact('sections'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SectionsRequest $request)
    {
        $section = Sections::create([
            'section_name' => $request->section_name,
            'description' => $request->section_desc,
            'created_by' => Auth::user()->name,
        ]);

        return redirect()->back()->with(['success' => 'تم حفظ القسم بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function show(Sections $sections)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function edit(Sections $sections,$section_id)
    {
        $section = $sections::find($section_id);
        if(!$section){
            return redirect()->back();
        }
        return view('sections.editsection',compact('section'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function update(SectionsRequest $request, Sections $sections)
    {
        $section = $sections::find($request->id);
        if(!$section){
            return redirect()->back();
        }
        $section->update([
            'section_name' => $request->section_name,
            'description' => $request->section_desc,
        ]);
        return redirect()->back()->with(['success' => 'تم تعديل القسم بنجاح']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Sections  $sections
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sections $sections,$section_id)
    {
        $section = $sections::find($section_id);
        if(!$section){
            return redirect()->back();
        }

        $section->products()->delete();
        $section->delete();

        return redirect()->back()->with(['delete' => 'تم حذف القسم بنجاح']);
    }
}
