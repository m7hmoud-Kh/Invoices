<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;

use function Complex\inverse;
use function Ramsey\Uuid\v1;

class ReportController extends Controller
{

    const SEREACH_WITH_STATUS = 1;
    const SEREACH_WITH_NUMBER_INVOICE = 2;
    const PAGE_INVOICES_WITH_STATUS = 'report.report_invoice';
    const PAGE_INVOICES_WITH_CUSTOMER = 'report.report_customer';


    public function index()
    {
        return view(self::PAGE_INVOICES_WITH_STATUS);
    }

    public function sereach_invoice(Request $request)
    {

        if ($request->rdio == self::SEREACH_WITH_STATUS) {

            if ($request->start_at == null && $request->end_at == null) {
                return $this->sereach_invoice_with_Only_Status($request->type);
            } else {
                return $this->sereach_invoice_with_date($request->start_at, $request->end_at, $request->type);
            }
        } elseif ($request->rdio == self::SEREACH_WITH_NUMBER_INVOICE) {
            return $this->sereach_with_number_invoices($request->invoice_number);
        }
    }


    public function report_with_product_and_section()
    {
        $sections = section::select('id', 'name_section')->get();
        return view(self::PAGE_INVOICES_WITH_CUSTOMER, compact('sections'));
    }

    public function send_Product($id)
    {
        return product::where('section_id', $id)->select('id', 'name')->get();
    }

    public function sereach_customer(Request $request)
    {
        if ($request->start_at == null && $request->end_at == null) {
            if ($request->product == "All") {
                return $this->sereach_with_only_section($request->Section);
            } else {
                return $this->sereach_with_section_and_product($request->Section, $request->product);
            }
        } else {
            return $this->sereach_with_section_and_product_and_date($request->Section,$request->product,$request->start_at,$request->end_at);
        }
    }





    private function sereach_with_section_and_product_and_date($Section, $product, $start, $end)
    {
        $start_at = $this->FromDate($start);
        $end_at = $this->ToDate($end);
        $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('section_id', $Section)->where('product_id', $product)->get();
        $sections = section::select('id', 'name_section')->get();
        return view(self::PAGE_INVOICES_WITH_CUSTOMER, compact('invoices', 'sections','start_at','end_at'));
    }


    private function sereach_with_section_and_product($Section, $product)
    {
        $invoices = invoices::where('section_id', $Section)->where('product_id', $product)->get();
        $sections = section::select('id', 'name_section')->get();
        return view(self::PAGE_INVOICES_WITH_CUSTOMER, compact('invoices', 'sections'));
    }

    private function sereach_with_only_section($Section)
    {
        $invoices = invoices::where('section_id', $Section)->get();
        $sections = section::select('id', 'name_section')->get();
        return view(self::PAGE_INVOICES_WITH_CUSTOMER, compact('invoices', 'sections'));
    }

    private function sereach_with_number_invoices($invoice_number)
    {
        $invoices = invoices::where('invoice_number', $invoice_number)->get();
        return view(self::PAGE_INVOICES_WITH_STATUS, compact('invoices'));
    }


    private function sereach_invoice_with_date($start, $end, $type)
    {
        $start_at = $this->FromDate($start);
        $end_at = $this->ToDate($end);
        $invoices = invoices::whereBetween('invoice_date', [$start_at, $end_at])->where('value_status', $type)->get();
        $type =  $this->Know_Name_Status($type);
        return view(self::PAGE_INVOICES_WITH_STATUS, compact('invoices', 'type', 'start_at', 'end_at'));
    }

    private function sereach_invoice_with_Only_Status($status)
    {
        $type = $status;
        $invoices =  invoices::where('value_status', $type)->get();
        $type =  $this->Know_Name_Status($type);
        return view(self::PAGE_INVOICES_WITH_STATUS, compact('invoices', 'type'));
    }

    private function Know_Name_Status($type)
    {
        switch ($type) {
            case 1:
                return 'Not Paid';
                break;
            case 2:
                return 'Paid';
                break;
            case 3:
                return 'Paid partial';
                break;
            default:
                # code...
                break;
        }
    }

    private function FromDate($start)
    {
        return date("Y-m-d", strtotime($start));
    }

    private function ToDate($end)
    {
        return date("Y-m-d", strtotime($end));
    }
}
