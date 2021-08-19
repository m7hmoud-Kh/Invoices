<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\product;
use App\Models\section;
use App\Models\invoices;
use Illuminate\Http\Request;
use App\Models\invoices_details;
use Illuminate\Support\Facades\DB;
use App\Notifications\Add_invoices;
use App\Http\Controllers\Controller;
use App\Models\invoices_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;

class InvoicesController extends Controller
{

    const PATH = 'images\\invoices\\';
    const PAID = 2;
    const UNPAID = 1;
    const PARTIALPAID = 3;


    public function __construct()
    {
        $this->middleware('permission:add_invoice')->only(['store', 'add']);
    }

    public function index()
    {
        $invoices = invoices::with(['product' => function ($q) {
            $q->select('id', 'name');
        }])->with(['section' => function ($q) {
            $q->select('id', 'name_section');
        }])->get();
        return view('invoices.allinvoices', compact('invoices'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate($this->rules(), $this->messages());
        invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product_id' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'value_status' => 1,
            'total' => $request->Total,
            'note' => $request->note,
            'created_by' => Auth::user()->name,
        ]);

        $id = invoices::latest()->first()->id;

        $file_extension = $request->pic->getClientOriginalExtension();
        $file_name = $id . time() . '.' . $file_extension;
        $path = self::PATH . $id . '\\';
        $request->pic->move(public_path($path), $file_name);

        invoices_attachments::create([
            'file_name' => $file_name,
            'invoices_id' => $id,
        ]);

        invoices_details::create([
            'invoices_id' => $id,
            'value_status' => 1,
            'note' => $request->note,
        ]);

        $testNotification = [
            'id' => $id,
            'username' => Auth::user()->name,
            'number_invoice' => $request->invoice_number,
        ];

        $user = User::all();
        Notification::send($user, new Add_invoices($testNotification));

        return redirect()->back()->with(['success' => 'the invocies added successfully']);
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoices =  $this->getAllInfoInvoices($id);
        $sections = section::select('id', 'name_section')->get();
        return view('invoices.editInvoices', compact('invoices', 'sections'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice = invoices::find($request->invoice_id);
        $request->validate($this->rulesUpdate($request->invoice_id));
        $invoice->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product_id' => $request->product,
            'section_id' => $request->Section,
            'Amount_collection' => $request->Amount_collection,
            'Amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'note' => $request->note,
            'created_by' => Auth::user()->name,
        ]);
        return redirect()->back()->with(['update' => 'invoice updated Successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $checkId = invoices_attachments::find($request->id_file);
        if ($checkId) {
            $checkId->delete();
            Storage::disk('public_upload')->delete(
                '\\' . $request->invoices_id . '\\' . $request->file_name
            );
            return redirect()->back()->with([
                'delete' => 'file [ ' . $request->file_name . ' ] deleted successfully',
            ]);
        }
    }

    public function add()
    {
        $sections = section::select('id', 'name_section')->get();
        return view('invoices.addInvoices', compact('sections'));
    }

    public function getproducts($id)
    {
        $product = product::where('section_id', $id)->select('id', 'name')->get();
        return json_decode($product);
    }

    public function details($id)
    {

        $this->markAsRead_for_one_notification($id);
        
        $invoices_details = invoices_details::with(['invoices' => function ($q) {
            $q->select('id', 'invoice_number', 'created_by');
        }])->where('invoices_id', $id)->orderBy('id', 'desc')->get();
        // retrieving data ording DESC

        $invoices_attachments = invoices_attachments::with(['invoices' => function ($q) {
            $q->select('id', 'invoice_number', 'created_by');
        }])->where('invoices_id', $id)->get();

        $invoices = $this->getAllInfoInvoices($id);



        return view('invoices.detailsInvoices', compact('invoices', 'invoices_details', 'invoices_attachments'));
    }

    public function edit_invoices_Ajax($id)
    {
        return product::where('section_id', $id)->get();
    }

    public function View_file($invoices_id, $file_name)
    {
        $path = self::PATH . $invoices_id . '\\' . $file_name;
        return response()->file(public_path($path));
    }

    public function download($invoices_id, $file_name)
    {
        $path = self::PATH . $invoices_id . '\\' . $file_name;
        return response()->download(public_path($path));
    }

    public function destoryInvoices(Request $request)
    {
        $invoice_id = invoices::find($request->invoice_id);
        // when use softdelete in invoice Model comment line 206 because save in image in server...or use forceDelete
        Storage::disk('public_upload')->deleteDirectory($request->invoice_id);
        $invoice_id->forceDelete();
        return redirect()->back()->with(['deleted' => 'invoices Deleted successfully']);
    }


    public function allInvoices_paid()
    {
        $invoices = invoices::where('value_status', self::PAID)->get();
        return view('invoices.paidInvoices', compact('invoices'));
    }

    public function allInvoices_unpaid()
    {
        $invoices = invoices::where('value_status', self::UNPAID)->get();
        return view('invoices.unpaidInvoices', compact('invoices'));
    }

    public function allInvoices_partial_paid()
    {
        $invoices = invoices::where('value_status', self::PARTIALPAID)->get();
        return view('invoices.partialpaid', compact('invoices'));
    }

    private function rulesUpdate($id)
    {
        return [
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $id,
        ];
    }

    private function rules()
    {
        return [
            'invoice_number' => 'required|unique:invoices,invoice_number',
            'Section' => 'required|numeric',
            'product' => 'required|numeric',
            'pic' => 'required|image|mimes:png,jpg',
        ];
    }

    private function messages()
    {
        return [
            'pic.mimes' => 'you must upload only image',
            'invoice_number.unique' => 'invoice number allready token',
        ];
    }

    private function getAllInfoInvoices($id)
    {
        return  invoices::with(['product' => function ($q) {
            $q->select('id', 'name');
        }])->with(['section' => function ($q) {
            $q->select('id', 'name_section');
        }])->find($id);
    }

    private function markAsRead_for_one_notification($invoice_id)
    {
        $id_not = DB::table('notifications')->select('id')->where('data', 'like', '{\"invoice_id\":' . $invoice_id . '%')->where('notifiable_id', Auth::user()->id)->first();
        DB::table('notifications')->where('id', $id_not->id)->update([
            'read_at' => now(),
        ]);
    }

    public function makeAsread()
    {
        $user = User::find(Auth::user()->id);

        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return back();
    }
}
