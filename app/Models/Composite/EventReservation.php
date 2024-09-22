<?php 

namespace app\Models\Composite;

use App\Models\Composite\ReservableComponent;

class EventReservation extends ReservableComponent {
    protected $eventDetails;

    // Instead of passing strings, pass objects of ReservableComponent or similar
    public function __construct(array $eventDetails)
    {
        $this->eventDetails = $eventDetails; // Ensure these are objects, not strings
    }

    public function reserve()
    {
        foreach ($this->eventDetails as $event) {
            if (method_exists($event, 'reserve')) {
                $event->reserve(); // Call reserve on valid objects
            }
        }
    }

    public function cancel()
    {
        foreach ($this->eventDetails as $event) {
            if (method_exists($event, 'cancel')) {
                $event->cancel(); // Call cancel on valid objects
            }
        }
    }

    public function getDetails()
    {
        return [
            'type' => 'event',
            'details' => $this->eventDetails
        ];
    }
}

