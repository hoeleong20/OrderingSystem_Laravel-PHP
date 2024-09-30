<?php

namespace App\Http\Controllers;

// Author Khor Zhi Ying 

use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Composite\CompositeReservation;
use App\Models\Composite\TableReservation;
use App\Models\Composite\DishReservation;
use App\Models\Composite\EventReservation;
use Illuminate\Support\Facades\Storage;

class ReservationController extends Controller
{
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservations.index', compact('reservations'));
    }

    public function create()
    {
        return view('reservations.book'); // This is the default view for table reservations
    }
    public function createDishReservation()
    {
        return view('reservations.dish_reservation');
    }

    public function createTableWithDishReservation()
    {
        return view('reservations.table_with_dish');
    }

    public function createEventReservation()
    {
        return view('reservations.event');
    }

    public function store(Request $request)
    {
        // Base validation that applies to all reservation types
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'datetime' => 'required|date',
            'reservation_type' => 'required|in:table,table_with_dish,dish,event',
        ]);

        // Additional validation for dish reservations
        if (in_array($request->reservation_type, ['dish', 'table_with_dish'])) {
            $request->validate([
                'dish_id' => 'required|array',
            ]);
        }

        // Set pax to 1 for dish reservations
        $pax = ($request->reservation_type === 'dish') ? 1 : $request->input('pax', 1);

        // For dish or table_with_dish reservations, store dish IDs as a string in extra_info
        $extraInfo = null;
        if (in_array($request->reservation_type, ['dish', 'table_with_dish'])) {
            $extraInfo = implode(',', $request->input('dish_id', []));
        } elseif ($request->reservation_type === 'table') {
            $extraInfo = 'Table Number 5';  // Example for table reservation
        } elseif ($request->reservation_type === 'event') {
            $extraInfo = 'Event details or remarks';  // Example for event reservation
        }

        // Create the reservation
        $reservation = Reservation::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'pax' => $pax,  // Auto-set pax to 1 for dish reservation
            'datetime' => $request->datetime,
            'reservation_type' => $request->reservation_type,
            'extra_info' => $extraInfo,  // Store the additional info here
        ]);

        return redirect()->route('reservations.summary', $reservation->id);
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

        // Update the composite pattern based on the reservation type
        $reservationComponent = null;

        if ($request->reservation_type == 'table') {
            $reservationComponent = new TableReservation(1);
        } elseif ($request->reservation_type == 'dish') {
            $reservationComponent = new DishReservation(['Updated Dish 1', 'Updated Dish 2']);
        } elseif ($request->reservation_type == 'event') {
            $reservationComponent = new EventReservation(['Updated Event details']);
        } elseif ($request->reservation_type == 'table_with_dish') {
            $reservationComponent = new CompositeReservation();
            $reservationComponent->add(new TableReservation(1));
            $reservationComponent->add(new DishReservation(['Updated Dish 1', 'Updated Dish 2']));
        }

        // Execute the reservation update logic (reserve/cancel)
        if ($reservationComponent) {
            $reservationComponent->reserve();  // Reserve updated details
        }

        // Update the reservation record in the database
        $reservation->update($request->all());

        return redirect()->route('reservations.summary', $reservation->id)->with('success', 'Reservation updated successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        // Use the composite pattern to cancel the reservation
        $reservationComponent = null;

        if ($reservation->reservation_type == 'table') {
            $reservationComponent = new TableReservation(1);
        } elseif ($reservation->reservation_type == 'dish') {
            $reservationComponent = new DishReservation(['Dish 1', 'Dish 2']);
        } elseif ($reservation->reservation_type == 'event') {
            $reservationComponent = new EventReservation(['Event details']);
        } elseif ($reservation->reservation_type == 'table_with_dish') {
            $reservationComponent = new CompositeReservation();
            $reservationComponent->add(new TableReservation(1));
            $reservationComponent->add(new DishReservation(['Dish 1', 'Dish 2']));
        }

        // Execute the cancellation logic
        if ($reservationComponent) {
            $reservationComponent->cancel();
        }

        // Delete the reservation record from the database
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

    public function exportReservationsToXML()
    {
        // Fetch all reservations
        $reservations = Reservation::all();

        // Create an XML structure
        $xml = new \SimpleXMLElement('<reservations/>');

        foreach ($reservations as $reservation) {
            $res = $xml->addChild('reservation');
            $res->addChild('name', $reservation->name);
            $res->addChild('email', $reservation->email);
            $res->addChild('phone', $reservation->phone);
            $res->addChild('pax', $reservation->pax);
            $res->addChild('datetime', $reservation->datetime);
            $res->addChild('reservation_type', $reservation->reservation_type);
            $res->addChild('extra_info', $reservation->extra_info);
        }

        // Save the XML to a file in the storage/app/ directory
        Storage::put('reservations.xml', $xml->asXML());

        return response()->download(storage_path('app/reservations.xml'));
    }

    public function transformXMLWithXSLT()
    {
        // Load the XML file
        $xmlFile = storage_path('app/reservations.xml');
        $xslFile = resource_path('xsl/reservation_template.xsl');

        // Load XML and XSL files
        $xml = new \DOMDocument();
        $xml->load($xmlFile);

        $xsl = new \DOMDocument();
        $xsl->load($xslFile);

        // Configure the XSLT processor
        $proc = new \XSLTProcessor();
        $proc->importStylesheet($xsl);

        // Transform the XML data
        $html = $proc->transformToXML($xml);

        // Return the transformed HTML
        return response($html);
    }

    public function searchReservationByXPath($customerName)
    {
        // Load the XML file
        $xmlFile = storage_path('app/reservations.xml');
        $xml = new \DOMDocument();
        $xml->load($xmlFile);

        // Initialize XPath
        $xpath = new \DOMXPath($xml);

        // Search for reservations by customer name
        $query = "//reservation[name='$customerName']";
        $reservations = $xpath->query($query);

        // Process and display results
        $results = [];
        foreach ($reservations as $reservation) {
            // Access elements under the reservation node using XPath directly
            $name = $xpath->evaluate('string(name)', $reservation);
            $email = $xpath->evaluate('string(email)', $reservation);
            $phone = $xpath->evaluate('string(phone)', $reservation);

            $results[] = "Name: $name, Email: $email, Phone: $phone";
        }

        return response()->json($results);
    }
}
