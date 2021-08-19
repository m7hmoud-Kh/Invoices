<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    const NOT_PAID = 1;
    const PAID = 2;
    const PAID_PARTIAL = 3;

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $count_total_invoices = $this->count_total_invoices();
        $sum_total_invoices = $this->sum_total_invoices();
        $sum_notpaid_invoices = $this->sum_invoices(self::NOT_PAID);
        $count_notpaid_invoices = $this->count_invoices(self::NOT_PAID);
        $percent_notpaid_invoices = $this->invoices_percent(self::NOT_PAID);
        $sum_paid_invoices = $this->sum_invoices(self::PAID);
        $count_paid_invoices = $this->count_invoices(self::PAID);
        $percent_paid_invoices = $this->invoices_percent(self::PAID);
        $sum_paid_partial_invoices = $this->sum_invoices(self::PAID_PARTIAL);
        $count_paid_partial_invoices = $this->count_invoices(self::PAID_PARTIAL);
        $percent_paid_partial_invoices = $this->invoices_percent(self::PAID_PARTIAL);

        $data = [
            'paid' => $percent_paid_invoices,
            'not_paid' => $percent_notpaid_invoices,
            'paid_partial' => $percent_paid_partial_invoices,
        ];


        $chart_invoices = $this->chart_invoices($data);
        $chart_section = $this->chart_section($data);


        return view('home', compact(
            'count_total_invoices',
            'sum_total_invoices',
            'sum_notpaid_invoices',
            'count_notpaid_invoices',
            'percent_notpaid_invoices',
            'sum_paid_invoices',
            'count_paid_invoices',
            'percent_paid_invoices',
            'sum_paid_partial_invoices',
            'count_paid_partial_invoices',
            'percent_paid_partial_invoices',
            'chart_invoices',
            'chart_section'
        ));
    }


    private function count_invoices($status)
    {
        return invoices::where('value_status', $status)->count();
    }

    private function sum_invoices($status)
    {
        return  number_format(invoices::where('value_status', $status)->sum('total'), 2);
    }

    private function invoices_percent($status)
    {
        return round($this->count_invoices($status) / $this->count_total_invoices()  * 100);
    }


    private function count_total_invoices()
    {
        return invoices::count();
    }

    private function sum_total_invoices()
    {
        return number_format(invoices::sum('total'), 2);
    }


    private function chart_invoices($data)
    {
        return  app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['Not Paid', 'Paid', 'Paid partial'])
            ->datasets([
                [
                    'backgroundColor' => ['#f85873', '#35c496', '#f28d4a'],
                    'hoverBackgroundColor' => ['#f85873', '#35c496', '#f28d4a'],
                    'data' => [$data['not_paid'], $data['paid'], $data['paid_partial']]
                ]
            ])
            ->options([]);
    }

    private function chart_section($data)
    {

        return app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['','label y','label z'])
            ->datasets([
                [
                    "label" => "Paid",
                    'backgroundColor' => ['#35c496'],
                    'data' => [$data['paid']]
                ],
                [
                    "label" => "Paid partial",
                    'backgroundColor' => ['#f28d4a'],
                    'data' => [$data['paid_partial']]
                ],
                [
                    "label" => "Not Paid",
                    'backgroundColor' => ['#f85873'],
                    'data' => [$data['not_paid']]
                ]
            ])
            ->options([]);
    }
}
