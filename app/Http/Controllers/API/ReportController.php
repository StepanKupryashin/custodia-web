<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index() {
        return $this->susscesResponse(Report::reports());
    }

    public function store(Request $request) {
        $data =
        Report::create([
            'title' => $request->get('title'),
            'body' => $request->get('body'),
            'user_id' => auth()->user()->id
        ]);
    }

    public function show(int $id, Request $request) {
        return $this->susscesResponse(Report::report($id));
    }
}
