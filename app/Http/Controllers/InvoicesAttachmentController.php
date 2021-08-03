<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InvoicesAttachmentController extends Controller
{
    use OfferTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $invoice = Invoices::find($request->id);
        $invoice_number = $invoice->invoice_number;


        $this->validate($request,[
            'pic' => 'mimes:pdf,jpeg,png,jpg',
        ],[
            'pic.mimes' => 'pdf,jpeg,jpg,png صيغة الملف يجب أن تكون',
        ]);

       if ($request->hasFile('pic')) {
           $image = $request->file('pic');
           $file_name = $this->saveimage($image,'images/invoices');

            $invoice_attachment = InvoicesAttachment::create([
                'invoice_id' => $request->id,
                'invoice_number' => $invoice_number,
                'file_name' => $file_name,
                'user' => Auth::user()->name,
            ]);
            return redirect()->back()->with(['attach_success' => 'تم اضافة مرفق بنجاح']);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicesAttachment  $invoicesAttachment
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicesAttachment $invoicesAttachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicesAttachment  $invoicesAttachment
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicesAttachment $invoicesAttachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicesAttachment  $invoicesAttachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicesAttachment $invoicesAttachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicesAttachment  $invoicesAttachment
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicesAttachment $invoicesAttachment)
    {
        //
    }
}
