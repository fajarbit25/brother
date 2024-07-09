<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ToolsController extends Controller
{
    public function index(): View
    {
        $data = [
            'title'     => 'Tools Inventory',
        ];
        return view('tools.index', $data);
    }

    public function master(): View
    {
        $data = [
            'title'     => 'Tools Inventory Data Master',
        ];
        return view('tools.master', $data);
    } 
}
