<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

use DB;
use App\UserRequests;

class InvoiceController extends Controller
{
    /**
     * Display a Invoice page.
     *
     * @return \Illuminate\Http\Response
     */
    public function print_invoice(Request $request)
    {
        return $request;
        // $order = UserRequests::where('id','=',$id)->first();
        // $logo = asset('uploads/Puryau-logo-black.png');
        
        //$order->qrcode = \QrCode::size(90)->format('svg')->backgroundColor(245, 245, 245)->generate($order->booking_id);

        //$order->barcode = \DNS1D::getBarcodeSVG(['4445645656', 'PHARMA2T']);
        //$order->barcode = \DNS1D::getBarcodeHTML('4445645656', 'PHARMA2T');
        //$order->barcode = \DNS1D::getBarcodeSVG("4445645656", "C39");
        //$order->barcode = \DNS1D::getBarcodeSVG('4445645656', 'PHARMA2T',3,33,'green', true);
        //$order->barcode = \DNS1D::getBarcodeHTML('4445645656', 'C39+');
        //$order->barcode = \DNS1D::getBarcodeHTML('4445645656', 'C39E');
        //$order->barcode = \DNS1D::getBarcodePNGPath($order->booking_id, 'PHARMA2T',3,33);
        // $order->barcode = \DNS1D::getBarcodePNGPath($order->booking_id, 'PHARMA2T',3,33,array(255,255,0));
        
        //$order->barcode = \DNS2D::getBarcodePNGPath('4445645656', 'PDF417');


        //$barcode = new BarcodeGenerator();
        //$barcode->setText("IL333173");
        //$barcode->setType(BarcodeGenerator::Code128);
        //$barcode->setType(BarcodeGenerator::Code11);
        //$barcode->setType(BarcodeGenerator::Code39Extended);

        // $barcode->setType(BarcodeGenerator::Codabar);
        // $barcode->setScale(2);
        // $barcode->setThickness(25);
        // $barcode->setFontSize(10);
        // $code = $barcode->generate();

        //$order->barcode = $barcode->generate($order->booking_id);
        
        // $order->qrcode = explode("\n", $order->qrcode);
        // $order->qrcode = $order->qrcode[1];
        // dd($order->qrcode[1]);
        
        
       // $order->qrbooking_id = $order->qr[0];
        //dd($order->qrcode);
        //dd($order);

        return view('admin.invoice.invoice');

        // $pdf = \PDF::loadView('admin.invoice.invoice', compact('order'));
        // return $pdf->download('invoice.pdf');

        // $pdf = \PDF::loadView('admin.invoice.invoice', compact('order'));
        // return $pdf->stream('invoice.pdf');
        
    }
    public function sortcenter_invoice(Request $request)
    {
        // return response()->json($request);
        $orders = [];
        foreach($request->order_id as $id){
            $orders[] = UserRequests::where('id','=',$id)->first();
            // if ($order->status=="PENDING" || $order->status=="ACCEPTED" || $order->status=="PICKEDUP"){
            //     $order->provider_id = null;
            //     $order->status = "SORTCENTER";
            //     $order->save();
            // }
        }
        // $order = UserRequests::where('id','=',$id)->first();
        // if ($order->status=="PENDING" || $order->status=="ACCEPTED" || $order->status=="PICKEDUP"){
        //     $order->provider_id = null;
        //     $order->status = "SORTCENTER";
        //     $order->save();
        // }
        return view('sortcenter.invoice.invoice', compact('orders'));
    }
    public function pickup_invoice(Request $request)
    {
        // return response()->json($request);
        $orders = [];
        foreach($request->order_id as $id){
            $orders[] = UserRequests::where('id','=',$id)->first();
            // if ($order->status=="PENDING" || $order->status=="ACCEPTED" || $order->status=="PICKEDUP"){
            //     $order->provider_id = null;
            //     $order->status = "SORTCENTER";
            //     $order->save();
            // }
        }
        // $order = UserRequests::where('id','=',$id)->first();
        // if ($order->status=="PENDING" || $order->status=="ACCEPTED" || $order->status=="PICKEDUP"){
        //     $order->provider_id = null;
        //     $order->status = "SORTCENTER";
        //     $order->save();
        // }
        return view('pickup.invoice.invoice', compact('orders'));
    }
    public function singleSortCenterInvoice(Request $request, $id)
    {
        $order = UserRequests::where('id',$id)->first();
        return view('sortcenter.invoice.singleInvoice',compact('order'));
    }
}
