<?php

namespace App\Http\Controllers;

use App\Models\Invoices;
use App\Models\InvoicesAttachment;
use App\Models\InvoicesDetails;
use App\Models\Sections;
use App\Traits\OfferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\In;

class InvoicesController extends Controller
{
    use OfferTrait;
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getAllInvoices(){
        $invoices = Invoices::with('sections')->get();

       return view('invoices.allinvoices',compact('invoices'));
    }

    public function paidInvoices(){
        $invoices = Invoices::where('value_status',1)->with('sections')->get();
        return view('invoices.paidinvoices',compact('invoices'));
    }

    public function unpaidInvoices(){
        $invoices = Invoices::where('value_status',2)->with('sections')->get();
        return view('invoices.unpaidinvoices',compact('invoices'));
    }

    public function partpaidInvoices(){
        $invoices = Invoices::where('value_status',3)->with('sections')->get();
        return view('invoices.partpaidinvoices',compact('invoices'));
    }

    public function getEditInvoices(){
        $sections = Sections::all();
        return view('invoices.edit-invoice',compact('sections'));
    }
    public function getProducts($section_id){
        $products = Sections::find($section_id);
        if (!$products){
            return abort('404');
        }
        return json_encode($products->products);
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
        $invoice = Invoices::create([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'product' => $request->product,
            'section' => $request->section,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        $invoice_id = Invoices::latest()->first()->id;
        $invoice_details = InvoicesDetails::create([
            'invoice_id' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'section' => $request->section,
            'product' => $request->product,
            'status' => 'غير مدفوعة',
            'value_status' => 2,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);
        if($request->hasFile('pic')){
            $invoice_id = Invoices::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $this->saveimage($image,'images/invoices');

            $invoice_attachments = InvoicesAttachment::create([
                'invoice_id' => $invoice_id,
                'invoice_number' => $request->invoice_number,
                'file_name' => $file_name,
                'user' => Auth::user()->name,
            ]);
        }

        return redirect()->back()->with(['success' => 'تم حفظ الفاتورة بنجاح']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function show(Invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function edit($invoice_id)
    {
        $invoice = Invoices::find($invoice_id)->first();
        if(!$invoice){
            return redirect()->back();
        }
        $sections = Sections::all();
        return view('invoices.editallinvoice',compact('invoice','sections'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $invoice = Invoices::find($request->invoice_id)->first();
        $invoice->where('id', $request->invoice_id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_date' => $request->invoice_Date,
            'due_date' => $request->Due_date,
            'section' => $request->section,
            'product' => $request->product,
            'amount_collection' => $request->Amount_collection,
            'amount_commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'rate_vat' => $request->Rate_VAT,
            'value_vat' => $request->Value_VAT,
            'total' => $request->Total,
            'note' => $request->note,
        ]);

        $invoice_details = InvoicesDetails::where('invoice_id', $request->invoice_id)->update([
            'invoice_number' => $request->invoice_number,
            'section' => $request->section,
            'product' => $request->product,
            'note' => $request->note,
            'user' => Auth::user()->name,
        ]);

        $invoice_attachments = InvoicesAttachment::where('invoice_id', $request->invoice_id)->update([
            'invoice_number' => $request->invoice_number,
            'user' => Auth::user()->name,
        ]);

        return redirect()->back()->with(['success' => 'تم تعديل الفاتورة بنجاح']);

    }

    public function editStatus($invoice_id){

        $invoice = Invoices::find($invoice_id);
        return view('invoices.editstatus',compact('invoice'));
    }

    public function updateStatus(Request $request){

        $invoice = Invoices::find($request->invoice_id);

        if($request->status === 'مدفوعة'){
            $invoice->update([
                'status' => $request->status,
                'value_status' => 1,
                'payment_date' => $request->payment_date,
            ]);
            $invoice_details = InvoicesDetails::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $invoice->invoice_number,
                'section' => $invoice->section,
                'product' => $invoice->product,
                'status' => $request->status,
                'value_status' => 1,
                'payment_date' => $request->payment_date,
                'note' => $invoice->note,
                'user' => Auth::user()->name,
            ]);
            return redirect()->back()->with(['success_status' => 'تم تعديل حالة الفاتورة بنجاح']);
        }else{
            $invoice->update([
                'status' => $request->status,
                'value_status' => 3,
                'payment_date' => $request->payment_date,
            ]);
            $invoice_details = InvoicesDetails::create([
                'invoice_id' => $request->invoice_id,
                'invoice_number' => $invoice->invoice_number,
                'section' => $invoice->section,
                'product' => $invoice->product,
                'status' => $request->status,
                'value_status' => 3,
                'payment_date' => $request->payment_date,
                'note' => $invoice->note,
                'user' => Auth::user()->name,
            ]);
            return redirect()->back()->with(['success_status' => 'تم تعديل حالة الفاتورة بنجاح']);
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoices  $invoices
     * @return \Illuminate\Http\Response
     */
    public function destroy($invoice_id)
    {
        $invoice = Invoices::find($invoice_id);
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

        return redirect()->back()->with(['success_status' => 'تم حذف الفاتورة بنجاح']);

    }
}
