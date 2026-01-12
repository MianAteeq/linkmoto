<?php

namespace Modules\Vender\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;
use Modules\Vender\Entities\TradingUnit;
use Modules\Vender\Entities\WorkStream;

class WorkStreamController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function add($id)
    {
        $user=auth()->user();

    
        $trading_unit=TradingUnit::find($id);


    return view('vender::service_provider.trading_unit.app_setting.workstream.add',get_defined_vars());
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('vender::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function submit(Request $request)
    {
        $request->validate([
            'workstream_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('work_streams')->where(function ($query) use ($request) {
                    return $query->where('trading_id', $request->id);
                }),
            ],
        ]);
        $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
        $obj=WorkStream::create([
            "vender_id" => $vender_id,
            "trading_id" => $request['id'],
            'workstream_name'=> $request['workstream_name'],
            'status'=> $request['status'],

        ]);

        return  redirect()->route('vender.service.provider.trading.unit.app.setting',$request['id']);
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('vender::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function editWorkStream($id,$trading_id)
    {
        $user=auth()->user();

    
        $trading_unit=TradingUnit::find($trading_id);

        $workstream=WorkStream::find($id); 
        return view('vender::service_provider.trading_unit.app_setting.workstream.edit',get_defined_vars());
    }
  
    public function viewWorkStream($id,$trading_id)
    {
        $user=auth()->user();

    
        $trading_unit=TradingUnit::find($trading_id);

        $workstream=WorkStream::find($id); 
        return view('vender::service_provider.trading_unit.app_setting.workstream.view',get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $request->validate([
            'workstream_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('work_streams')->where(function ($query) use ($request) {
                    return $query->where('trading_id', $request->trading_unit_id)->where('id','!=',$request->id);    
                }),
            ],
        ]);
        $vender_id = $request->user()->vender_id == 0 ? $request->user()->id : $request->user()->vender_id;
        $obj=WorkStream::find($request['id'])->update([
            "vender_id" => $vender_id,
            "trading_id" => $request['trading_unit_id'],
            'workstream_name'=> $request['workstream_name'],
            'status'=> $request['status'],

        ]);

        return  redirect()->route('vender.service.provider.trading.unit.app.setting',$request['trading_unit_id']);
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
