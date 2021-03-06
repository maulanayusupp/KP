<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redirect;
use App\Mail\TestEmail;

class KelolaAomController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:kelola-aom');

    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataAOM = $this->statistikAOM();
        // print_r($dataAOM);
        return view('kelolaAom')
            ->with('data', $dataAOM)
            ->with('i', ($request->input('page', 1) - 1) * 5);

    }
    public function statistikAOM()
    {
        return DB::table('masters')->select(DB::raw('Id_Account_Management as aom, COUNT(NO_REKENING) noa, sum(Jml_Pinjaman) jumlah'))
            ->whereRaw('Jml_Pinjaman > 0 and TipeKredit <> "3R" and Id_Account_Management is not null')->groupBy('Id_Account_Management')->orderBy('jumlah', 'desc')->paginate(10);
    }
//SELECT Id_Account_Management as aom, COUNT(NO_REKENING) noa, sum(Jml_Pinjaman) jumlah FROM `masters` WHERE Jml_Pinjaman > 0 and TipeKredit <> ' 3 R' and Id_Account_Management is not null GROUP by Id_Account_Management

}
