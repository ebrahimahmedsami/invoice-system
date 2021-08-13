<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Models\InvoicesDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $invoices = Invoices::onlyTrashed()->get();
        return view('invoices.archiveinvoices',compact('invoices'));
    }

    public function restoreArchive($invoice_id){
        $invoice = Invoices::withTrashed()->find($invoice_id);
        $invoice->restore();

        return redirect()->back()->with(['restore' => 'تم إستعادة الفاتورة بنجاح']);
    }

    public function addToArchive($invoice_id){
        $invoice = Invoices::find($invoice_id);
        $invoice->delete();

        return redirect()->back()->with(['archived' => 'تم أرشفة الفاتورة بنجاح']);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoice_id)
    {
        $invoice = Invoices::withTrashed()->find($invoice_id);
        $details = InvoicesDetails::where('invoice_id',$invoice_id)->get();
        $attachment = InvoicesAttachment::where('invoice_id',$invoice_id)->get();

        if(!$invoice){
            return redirect()->back();
        }

        foreach ($details as $d){
            $d->delete();
        }
        foreach ($attachment as $a){
            $a->delete();
            $files = Storage::disk('invoice_uploads')->delete($a->file_name);
        }
        $invoice->forceDelete();

        return redirect()->back()->with(['success_deleted' => 'تم حذف الفاتورة بنجاح']);
    }
}
