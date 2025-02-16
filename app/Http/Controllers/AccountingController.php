<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class AccountingController extends Controller
{
    public function approval(): View
    {
        $data = [
            'title'     => 'Approval Kas',
        ];
        return view('accounting.approval', $data);
    }

    public function arusKhas(): View
    {
        $data = [
            'title'     => 'Arus Khas',
        ];
        return view('accounting.arus-kas', $data);
    }

    public function akun(): View
    {
        $data = [
            'title'     => 'Akun',
        ];
        return view('accounting.akun', $data);
    }
}
