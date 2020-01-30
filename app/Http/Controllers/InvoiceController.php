<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Invoice;

class InvoiceController extends Controller
{
    public function show($id) {
        $invoice = Invoice::find($id);

        return view('site.accounts.invoice')->with('invoice', $invoice);
    }
}
