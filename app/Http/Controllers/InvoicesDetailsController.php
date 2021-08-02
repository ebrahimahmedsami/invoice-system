<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Models\InvoicesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function details($invoice_id){
        $invoice = Invoices::where('id',$invoice_id)->first();
        $details = InvoicesDetails::where('invoice_id',$invoice_id)->get();
        $attachment = InvoicesAttachment::where('invoice_id',$invoice_id)->get();
        return view('invoices.invoicedetails',compact('invoice','details','attachment'));

    }

    public function view_file($file_name){
        //to open any file in the browser
        // (invoice_uploads) in the config/filesystem.php
        $files = Storage::disk('invoice_uploads')->getDriver()->getAdapter()->applyPathPrefix($file_name);
        return response()->file($files);
    }

    public function download_file($file_name){
        //to download the file
         $files = Storage::disk('invoice_uploads')->getDriver()->getAdapter()->applyPathPrefix($file_name);
        return response()->download($files);
    }

    public function delete_file($attachment_id,$file_name){
        $attachment = InvoicesAttachment::find($attachment_id);
        $attachment->delete();
        $files = Storage::disk('invoice_uploads')->delete($file_name);

        return redirect()->back()->with(['delete' => 'تم حذف المرفق بنجاح']);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */
    public function show(InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, InvoicesDetails $invoicesDetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InvoicesDetails  $invoicesDetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoicesDetails $invoicesDetails)
    {
        //
    }
}
