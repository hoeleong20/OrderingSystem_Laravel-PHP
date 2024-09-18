<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use app\Models\Reservation;

class ReservationController extends Controller
{
    public function makeReservation(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'pax' => 'required|integer',
            'datetime' => 'required|date',
            'reservation_type' => 'required|string|in:table, table_with_dish, dish, event',
            'dish_id' => 'nullable|array',  // Dish IDs can be an array
            'dish_id.*' => 'exists:dishes,id',  // Each dish ID should exist in the dishes table
        ]);

        // Save reservation data
        $reservation = new Reservation();
        $reservation->name = $request->input('name');
        $reservation->phone = $request->input('phone');
        $reservation->email = $request->input('email');
        $reservation->pax = $request->input('pax');
        $reservation->reservation_date = $request->input('datetime');
        $reservation->reservation_type = $request->input('reservation_type');

        $reservation->save();

        // Save multiple dishes if the reservation type involves dishes
        if (in_array($request->input('reservation_type'), ['dish', 'combined'])) {
            $dishIds = $request->input('dish_id', []);
            foreach ($dishIds as $dishId) {
                // DB::table('reservation_dish')->insert([
                //     'reservation_id' => $reservation->id,
                //     'dish_id' => $dishId,
                // ]);
            }
        }

        return redirect()->back()->with('success', 'Reservation made successfully!');
    }
}
