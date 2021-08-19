<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\invoices_attachments;
use Illuminate\Http\Request;

class InvoicesAttachmentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $request->validate([
            'file_name' => 'mimes:png,jpeg,png',
        ],[
            'file_name.mimes' => 'please upload file with this extension [ .jpeg , .jpg , .png ]',
        ]);
        $id =  invoices::where('id', $request->invoice_id);
        if ($id) {

            $file_extention =  $request->file_name->getClientOriginalExtension();
            $file_name = $request->invoice_id . time() . '.' . $file_extention;
            $path = ('images\invoices\\');
            $request->file_name->move(public_path($path . $request->invoice_id), $file_name);


            invoices_attachments::create([
                'file_name' => $file_name,
                'invoices_id' => $request->invoice_id,
            ]);

            return redirect()->back()->with(['success'=>'Added File successfully']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, invoices_attachments $invoices_attachments)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_attachments  $invoices_attachments
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_attachments $invoices_attachments)
    {
        //
    }
}
