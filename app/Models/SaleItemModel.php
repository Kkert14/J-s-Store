<?php

namespace App\Models;

use CodeIgniter\Model;

class SaleItemModel extends Model
{
    protected $table      = 'sale_items';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sale_id',
        'product_id',
        'sku_snapshot',
        'name_snapshot',
        'unit_price',
        'qty',
        'discount',
        'line_total',
    ];
}

