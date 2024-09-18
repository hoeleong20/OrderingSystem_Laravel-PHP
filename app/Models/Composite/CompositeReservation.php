<?php

namespace app\Models\Composite;

class CompositeReservation extends ReservableComponent
{

    protected $components = [];

    public function add(ReservableComponent $component)
    {
        $this->components[] = $component;
    }

    public function remove(ReservableComponent $component)
    {
        $this->components = array_filter($this->components, function ($item) use ($component) {
            return $item !== $component;
        });
    }

    public function reserve()
    {
        foreach ($this->components as $component) {
            $component->reserve();
        }
    }

    public function cancel()
    {
        foreach ($this->components as $component) {
            $component->cancel();
        }
    }

    public function getDetails()
    {
        $details = [];
        foreach ($this->components as $component) {
            $details[] = $component->getDetails();
        }
        return $details;
    }
}
