<?php 

namespace app\Models\Composite;

class EventReservation extends ReservableComponent{
    protected $eventDetails;

    public function __construct($eventDetails)
    {
        $this->eventDetails = $eventDetails;
    }

    public function reserve()
    {
        foreach ($this->eventDetails as $event) {
            $event->reserve();
        }
    }

    public function cancel()
    {
        foreach ($this->eventDetails as $event) {
            $event->cancel();
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

