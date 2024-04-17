<?php

namespace App\Http\Controllers;

use App\NextUserDashboard;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class NextUserDashobards extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users=NextUserDashboard::all();
        return view('admin.nextUser.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.nextUser.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'App_Name' => 'required|max:255',
            'email' => 'required|unique:next_user_dashboards,email|email|max:255',
            'mobile' => 'required',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'icon' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'location' => 'required',
            'white_App_logo' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'Company_Full_Name' => 'required',
        ]);
        try{
            $logo_url=$request->avatar->store('Domain/User/logo'.$request->App_Name);
            $white_logo_url=$request->white_App_logo->store('Domain/User/logo/'.$request->App_Name);
            $icon_url=$request->icon->store('Domain/User/icon/'.$request->App_Name);
            $user=new NextUserDashboard();
            $user->App_Name=$request->App_Name;
            $user->email=$request->email;
            $user->phone=$request->mobile;
            $user->location=$request->location;
            $user->App_logo=$logo_url;
            $user->App_icon=$icon_url;
            $user->support=$request->support;
            $user->finance=$request->finance;
            $user->marketing=$request->marketing;
            $user->White_App_logo=$white_logo_url;
            $user->Company_Full_Name=$request->Company_Full_Name;
            $user->websitelink=$request->websitelink;
            $user->website_instagram=$request->website_instagram;
            $user->website_facebook=$request->website_facebook;
            $user->website_linkedin=$request->website_linkedin;
            $user->subdomain_link=$request->subdomain_link;
            $user->save();
            
        return redirect()->route('admin.nextDashboardUser.index')
                        ->with('message','Domain User Details Saved Successfully');
        }catch(Exception $e){
            return back()->with('message', 'Something Went Wrong!');
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
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = NextUserDashboard::findOrFail($id);
        return view('admin.nextUser.edit',compact('user'));
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
        // dd($request->all());
        $this->validate($request, [
            'mobile' => 'required',
            'avatar' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'icon' => 'mimes:jpeg,jpg,bmp,png|max:5242880',
            'location' => 'required',
            'Company_Full_Name' => 'required',
        ]);
        try{
            $user = NextUserDashboard::findOrFail($id);
            if($request->hasFile('avatar')){
                $logo_url=$request->avatar->store('Domain/User/logo/'.$request->App_Name);
                $user->App_logo=$logo_url;
            }
            if($request->hasFile('icon')){
                $icon_url=$request->icon->store('Domain/User/icon/'.$request->App_Name);
                $user->App_icon=$icon_url;
            }
            if($request->hasFile('White_App_logo')){
                $white_logo_url=$request->White_App_logo->store('Domain/User/logo/'.$request->App_Name);
                $user->White_App_logo=$white_logo_url;
            }
            $user->Company_Full_Name=$request->Company_Full_Name;
            $user->App_Name=$request->App_Name;
            $user->phone=$request->mobile;
            $user->location=$request->location;
            $user->support=$request->support;
            $user->finance=$request->finance;
            $user->marketing=$request->marketing;
            $user->websitelink=$request->websitelink;
            $user->website_instagram=$request->website_instagram;
            $user->website_facebook=$request->website_facebook;
            $user->website_linkedin=$request->website_linkedin;
            $user->subdomain_link=$request->subdomain_link;
            $user->save();
             return redirect()->route('admin.nextDashboardUser.index')
                        ->with('message','Domain User Details Updated Successfully');

        }
        catch(Exception $e){
            return back()->with('message', 'Something Went Wrong!');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         try {

            NextUserDashboard::find($id)->delete();
            return back()->with('message', 'Domainn User deleted successfully');
        } 
        catch (Exception $e) {
            return back()->with('flash_error', 'User Not Found');
        }
    }
}
