<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function index()
    {
        $template = 'backend.dashboard.index';
        $config = $this->config();

        return view('layouts.admin', compact('template', 'config'));
    }

    private function config()
    {
        return [
            'breadcrumb' => [
                'index' => config('breadcrumb.dashboard.index'),
            ]
        ];
    }
}
