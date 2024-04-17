<?php

namespace App\Http\Controllers;

use App\Fare;
use App\Zones;
use Illuminate\Http\Request;

class FareController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fares=Fare::get();
        return view('admin.fare.application',compact('fares'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $zones=Zones::all();
        return view('admin.fare.create',compact('zones'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'zone1'        =>  'required|exists:zones,id',
            'zone2'       =>  'required|exists:zones,id',
            'fare'  =>  'required',
            'fare_half_kg' => 'required',
            'cargo' => 'required',
        ]);
        $request->km=$request->km?$request->km:1000;
        //check if similar data already exists
        $already=null;
        if($request->zone1==$request->zone2){
            $already=Fare::where('zone1_id',$request->zone1)
                        ->where('zone2_id',$request->zone2)
                        ->where('km',$request->km)
                        ->first();
        }
        else{
            $already=Fare::where('zone1_id',$request->zone1)
                        ->where('zone2_id',$request->zone2)
                        ->first();
        }

        //if not then add new
        if(!$already){
            // dd($request->person);
            $fare=new Fare;
            $fare->zone1_id=$request->zone1;
            $fare->zone2_id=$request->zone2;
            $fare->km=$request->km;
            $fare->fare_half_kg=$request->fare_half_kg;
            $fare->fare=$request->fare;
            $fare->delay_period=$request->delay_period?$request->delay_period:null;
            $fare->extremely_delay_period=$request->extremely_delay_period?$request->extremely_delay_period:null;
            $fare->cargo=$request->cargo;
            $fare->Percentage_increase=$request->person;
            $fare->save();
            return redirect()->route('admin.fare.index')->with('flash_success','Fare Created Successfully');
        }
        else{
            $already->zone1_id=$request->zone1;
            $already->zone2_id=$request->zone2;
            $already->km=$request->km;
            $already->fare_half_kg=$request->fare_half_kg;
            $already->fare=$request->fare;
            $already->delay_period=$request->delay_period?$request->delay_period:null;
            $already->extremely_delay_period=$request->extremely_delay_period?$request->extremely_delay_period:null;
            $already->cargo=$request->cargo;
            $already->Percentage_increase=$request->person;
            $already->save();
            return redirect()->route('admin.fare.index')->with('flash_success','Fare Edited Successfully');
        }
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
        $fare=Fare::findOrFail($id);
        $zones=Zones::all();
        return view('admin.fare.create',compact('zones','fare'));
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
    public function destroy($id)
    {
        Fare::find($id)->delete();
        return back()->with('message', 'Data deleted successfully');
    }
}
