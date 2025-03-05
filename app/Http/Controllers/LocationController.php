<?php

namespace App\Http\Controllers;

use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $locations = Location::where('user_id', Auth::id())->get();

        return view('dashboard/locations/locations', compact('locations'));
    }

    public function create()
    {
        return view('dashboard/locations/create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreLocationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:locations,name|max:255',
            'lat' => 'required|numeric',
            'lng' => 'required|numeric',
        ]);

        Location::create([
            'user_id' => Auth::id(),
            'name' => $validated['name'],
            'lat' => $validated['lat'],
            'lng' => $validated['lng'],

        ]);

        return redirect()->route('locations.index')->with('success' , 'Location created successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location)
    {
        $location->delete();

        return redirect()->route('locations.index')->with('success', 'Location deleted successfully');
    }
}
