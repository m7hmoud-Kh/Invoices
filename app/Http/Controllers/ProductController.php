<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $products = product::with(['section' => function ($q) {
            $q->select('sections.id', 'name_section');
        }])->get();
        $sections = section::select('id', 'name_section')->get();
        return view('product.AllProduct', compact('products', 'sections'));
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
    public function store(Request $request)
    {
        $product = section::find($request->section_id);
        if ($product) {
            $request->validate($this->rules(), $this->messages());
            product::create([
                'name' => $request->name,
                'description' => $request->description,
                'section_id' => $request->section_id,
                'created_by' => Auth::user()->name,
            ]);
            return redirect()->back()->with(['success' => 'product added successfully']);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $checkForId = product::find($request->id);
        if ($checkForId) {
            $request->validate($this->rulesUpdate($request->id), $this->messages());
            $checkForId->update([
                'name' => $request->name,
                'description' => $request->description,
                'section_id' => $request->section_id,
            ]);
            return redirect()->back()->with(['success' => 'product Edited successfully']);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $id = product::find($request->id);
        $id->delete();
        return redirect()->back()->with(['success' => 'product deleted successfully']);

    }



    public function rules()
    {
        return [
            'name' => 'required|unique:products',
            'description' => 'required',
            'section_id' => 'numeric',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'name of this product required',
            'name.unique' => 'the name allready been taken',
            'description.required' => 'the description is required'
        ];
    }

    public function rulesUpdate($id)
    {
        return [
            'name' => 'required|unique:products,name,' . $id,
            'description' => 'required',
            'section_id' => 'numeric',
        ];
    }
}
