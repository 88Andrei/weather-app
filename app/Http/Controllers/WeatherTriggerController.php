<?php

namespace App\Http\Controllers;

use App\Events\WeatherTriggerCreated;
use App\Models\Location;
use App\Models\WeatherTrigger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WeatherTriggerController extends Controller
{
    public function index()
    {
        $triggers = WeatherTrigger::where('user_id', Auth::id())->with('location')->get();
        $locations = $triggers->pluck('location')->unique('id');
        
        return view('dashboard/triggers/triggers' , compact('triggers', 'locations'));
    }

    public function showMessages()
    {
        $notifications = Auth::user()->getTriggerNotifications();

        return view('dashboard/triggers/messages', compact('notifications'));  
    }

    public function create()
    {
        $this->authorize('create', WeatherTrigger::class);

        return view('dashboard/triggers/create');
    }

    public function store(Request $request)
    {
        $this->authorize('create', WeatherTrigger::class);
        
        $validated = $request->validate([
            'name' => 'required|string',
            'location_id' => 'required|numeric|exists:locations,id', 
            'parameter' => 'required|string', 
            'value' => 'required|numeric', 
            'condition' => 'required|string|in:above,below',
            'period' => 'required|numeric',
        ]);

        $weatherTrigger = WeatherTrigger::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'location_id' => $validated['location_id'], 
            'parameter' => $validated['parameter'],
            'value' => $validated['value'],
            'condition' => $validated['condition'],
            'period' => $validated['period'], 
        ]);

        WeatherTriggerCreated::dispatch($weatherTrigger);

        return redirect()->route('triggers.index')->with('success', 'Trigger created successfully!');
    }

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
