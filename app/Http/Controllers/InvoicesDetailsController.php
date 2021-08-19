<?php

namespace App\Http\Controllers;

use App\Exports\InvoicesExport;
use App\Models\invoices;
use Illuminate\Http\Request;
use Laravel\Ui\Presets\React;
use App\Models\invoices_details;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function show(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function edit(invoices_details $invoices_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = invoices::find($request->invoice_id);
        if ($id) {
            $chek = $this->checkStatusValue($request->payment_status);
            if ($chek) {

                $id->update([
                    'value_status' => $request->payment_status
                ]);

                invoices_details::create([
                    'invoices_id' => $request->invoice_id,
                    'value_status' => $request->payment_status,
                    'note' => $id->note,
                ]);

                return redirect()->back()->with(['change' => 'Payment Status change successfully']);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices_details  $invoices_details
     * @return \Illuminate\Http\Response
     */
    public function destroy(invoices_details $invoices_details)
    {
        //
    }

    public function archive()
    {
        $invoices = invoices::onlyTrashed()->get();
        return view('invoices.archivesInvoices', compact('invoices'));
    }

    public function addArchive(Request $request)
    {
        $invoice_id = invoices::find($request->invoice_id);
        if ($invoice_id) {
            $invoice_id->delete();
        }
        return redirect()->back()->with(['archive' => 'Invoices Archived Successfully']);
    }


    public function canclArchive(Request $request)
    {
        invoices::find($request->invoice_id);
        invoices::onlyTrashed()->where('id', $request->invoice_id)->restore();
        return redirect()->back()->with(['archive' => 'Invoices Cancle Archive Successfully']);
    }


    public function deleteArchive(Request $request)
    {
        $info =  invoices::onlyTrashed()->where('id', $request->invoice_id)->first();
        Storage::disk('public_upload')->deleteDirectory($info->id);
        $info->forceDelete();
        return redirect()->back()->with(['deleted' => 'Invoice Deleted All']);
    }

    public function changeStatus(Request $request)
    {
        $check = $this->checkStatusValue($request->payment_status);
        if ($check) {
            $info = invoices::onlyTrashed()->where('id', $request->invoice_id)->first();

            $info->update([
                'value_status' => $request->payment_status,
            ]);

            invoices_details::create([
                'invoices_id' => $request->invoice_id,
                'value_status' => $request->payment_status,
                'note' => $info->note,
            ]);

            return redirect()->back()->with(['change' => 'Payment Status change successfully']);
        }
    }

    public function Print_invoice($id)
    {
        $invoices =  invoices::find($id);
        return view('invoices.print_invoice',compact('invoices'));
    }

    public function export()
    {
        return Excel::download(new InvoicesExport,'invoices.xlsx');
    }


    private function checkStatusValue($status)
    {
        return $status == 1 || $status == 2 || $status == 3  ? true : false;
    }
}
