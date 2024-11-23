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

    public function showMessages()
    {
        
        $notifications = Auth::user()->notifications;
        
        return view('triggers/messages', compact('notifications'));  
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
            'condition' => 'required|string|in:above,below',
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WeatherTrigger  $weatherTrigger
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $weatherTrigger = WeatherTrigger::find($id);
        $this->authorize('update', $weatherTrigger);
        $validated = $request->validate([
            'name' => 'required|string',
            'city' => 'sometimes|required|string', 
            'parameter' => 'sometimes|required|string', 
            'value' => 'sometimes|required|numeric', 
            'condition' => 'sometimes|required|string',
            'period' => 'sometimes|required|numeric',
            'status' => 'nullable|string|in:active,inactive',
            'oldStatus' => 'required|string',
        ]);
        

        if ($request->status !== $request->oldStatus) {
            $validated['status'] = $request->status ?? 'inactive';
        }
        
        $weatherTrigger->fill($validated)->save();

        return redirect()->route('triggers.index')->with('succes' , 'Trigger updated saccessfully');

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

        if (Auth::user()->cannot('delete' , $weatherTrigger)) {
            return redirect()->route('triggers.index')->with('error', 'You do nit have permission to delete this trigger');
        }
    
        $weatherTrigger->delete();

        return redirect()->route('triggers.index')->with('success', 'Trigger deleted successfully');

    }
    
    
}
