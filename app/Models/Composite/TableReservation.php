<?php

namespace app\Models\Composite;

use app\Models\Table;

class TableReservation extends ReservableComponent {
    protected $tables = [];

    public function __construct($number_of_tables)
    {
        for($i = 0; $i < $number_of_tables; $i++){
            $this->tables[] = new Table();
        }
    }

    public function reserve()
    {
        foreach ($this->tables as $table) {
            $table->reserve();
        }
    }

    public function cancel()
    {
        foreach ($this->tables as $table) {
            $table->cancel();
        }
    }

    public function getDetails()
    {
        return [
            'type' => 'table',
            'tables' => count($this->tables)
        ];
    }
}