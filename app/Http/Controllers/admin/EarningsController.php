<?php

namespace App\Http\Controllers\admin;

use App\Earning;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EarningsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $earnings = Earning::latest()->paginate(env('ITEMS_PER_PAGE'));
        return view('admin.earnings.index',['earnings'=>$earnings]);
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
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function show(Earning $earning)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function edit(Earning $earning)
    {
        $data['earning'] = $earning;
        return view('admin.earnings.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Earning $earning)
    {
        $request->validate(
                [
                'amount' => 'required|numeric|min:0',
                'status' => 'required|in:ISSUED,APPROVED,DECLINED',
                'admin_notes' => 'nullable',
            ],
            $this->customValidationMessages(), 
            $this->fieldNames()
        );
        
        $earning->amount = $request->amount;
        $earning->status = $request->status;
        $earning->admin_notes = $request->admin_notes;

        $earning->save();

        return redirect()->route('admin.earnings.edit',$earning)->withSuccess('Earning has been updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Earning  $earning
     * @return \Illuminate\Http\Response
     */
    public function destroy(Earning $earning)
    {
        return redirect()->route('admin.earnings.index')->withError('Currently deleting earnings is disabled');
    }

    public function fieldNames()
    {
        return [
        ];
    }

    public function customValidationMessages()
    {
        return [

        ];
    }
}
