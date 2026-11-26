<?php

namespace App\Http\Controllers;

use App\Invoice;

class InvoiceController extends Controller
{
    public function show($id)
    {
        $invoice = Invoice::findOrFail($id);

        $ownsInvoice = auth()->user()->orders()
            ->where('invoice_id', $invoice->id)
            ->exists();

        abort_unless($ownsInvoice, 404);

        return view('site.accounts.invoice')->with('invoice', $invoice);
    }
}
