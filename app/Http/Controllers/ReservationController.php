<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        return view('reservations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'pax' => 'required|integer',
            'datetime' => 'required|date',
            'reservation_type' => 'required|in:table,table_with_dish,dish,event'
        ]);

        // Create the reservation
        $reservation = Reservation::create($request->all());

        // Redirect to the reservation summary page with the newly created reservation
        return redirect()->route('reservations.summary', $reservation->id);
    }

    public function show(Reservation $reservation)
    {
        return view('reservations.show', compact('reservation'));
    }

    public function edit(Reservation $reservation)
    {
        return view('reservations.edit', compact('reservation'));
    }

    public function update(Request $request, Reservation $reservation)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'pax' => 'required|integer',
            'datetime' => 'required|date',
            'reservation_type' => 'required|in:table,table_with_dish,dish,event'
        ]);

        $reservation->update($request->all());

        return redirect()->route('reservations.index')->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }

    public function summary($id)
    {
        // Retrieve the reservation
        $reservation = Reservation::findOrFail($id);

        // Return the summary view with the reservation details
        return view('reservations.summary', compact('reservation'));
    }
}
