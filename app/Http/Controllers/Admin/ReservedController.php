<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reserved;
use Illuminate\Http\Request;

class ReservedController extends Controller
{
    public function index()
    {
        $reserved = Reserved::latest()->paginate(15);
        return view('management.portal.admin.reserved.index', compact('reserved'));
    }

    public function show(Reserved $reserved)
    {
        return view('management.portal.admin.reserved.view', compact('reserved'));
    }
}