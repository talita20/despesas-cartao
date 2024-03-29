<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExpensesRequest;
use App\Models\Expense;
use Illuminate\Http\Request;

class ExpensesController extends Controller
{
    public function index()
    {
        return Expense::all();
    }

    public function store(ExpensesRequest $request)
    {
        Expense::create($request->all());
        return response()->json($request->all(), 201);       
    }
}
