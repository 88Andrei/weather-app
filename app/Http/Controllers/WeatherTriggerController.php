<?php

namespace App\Http\Controllers;

use App\Models\WeatherTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeatherTriggerController extends Controller
{
    public function index()
    {
        $triggers = WeatherTrigger::where('user_id', Auth::id())->paginate(10);

        return view('triggers/triggers' , compact('triggers'));
    }

    public function create()
    {
        return view('triggers/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'city' => 'required|string', 
            'parameter' => 'required|string', 
            'value' => 'required|numeric', 
            'condition' => 'required|string',
            'period' => 'required|numeric'
        ]);

        WeatherTrigger::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'city' => $validated['city'], 
            'parameter' => $validated['parameter'],
            'value' => $validated['value'],
            'condition' => $validated['condition'],
            'period' => $validated['period'], 
        ]);

        return redirect()->route('triggers.index')->with('success', 'Trigger created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Http\Response
     */
    public function show(WeatherTrigger $weatherTrigger)
    {
        return view('triggers/show' , compact('weatherTrigger'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WeatherTrigger $weatherTrigger)
    {
        
        dd($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $weatherTrigger = WeatherTrigger::find($id);
    
        $weatherTrigger->delete();

        return redirect()->route('triggers.index')->with('success', 'Trigger deleted successfully');

    }
    
    
}
