<?php

namespace App\Models;

use CodeIgniter\Model;

class StockMovementModel extends Model
{
    protected $table      = 'stock_movements';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'product_id',
        'movement_type',
        'qty',
        'unit_cost',
        'ref_type',
        'ref_id',
        'reason',
        'user_id',
    ];
}

