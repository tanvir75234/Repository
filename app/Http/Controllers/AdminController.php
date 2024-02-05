<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\ExpensesChart;


class AdminController extends Controller{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(ExpensesChart $chart){
        return view('admin.dashboard.home',['chart' => $chart->build()]);
    }
}
