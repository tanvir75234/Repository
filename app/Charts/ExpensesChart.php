<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;
use ArielMejiaDev\LarapexCharts\LarapexChart;
use Carbon\Carbon;

class ExpensesChart extends Chart{
    
    protected $chart;
    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }
    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $now=Carbon::now()->toDateTimeString();
        $month=date('m', strtotime($now));
        $year=date('y',strtotime($now));
        $date=date('d',strtotime($now));
        $monthName=date('F',strtotime($now));

        return $this->chart->barChart()
            ->setTitle($monthName. ' Month expense chart.')
            ->setSubtitle('Weekly expenses in july.')
            ->addData('House rent', [10000])
            ->addData('Shopping', [7000])
            ->addData('Salary',[200000])
            ->setXAxis([$monthName ]);
    }
}
