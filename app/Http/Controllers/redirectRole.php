<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class redirectRole extends Controller
{
    //
    public function index()
    {
        switch (auth()->user()->getRoleNames()->first()) {
            case 'Kepala Asrama':
                return redirect()->route('beranda');
                break;
            case 'Pamong Putra':
                return redirect()->route('dashboard_pamong');
                break;
            default:
                # code...
                break;
        }

       // dd(auth()->user()->getRoleNames());
    }
}