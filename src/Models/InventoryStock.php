<?php

namespace Trexology\Inventory\Models;

use Trexology\Inventory\Traits\InventoryStockTrait;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class InventoryStock extends BaseModel
{
    use InventoryStockTrait;

    protected $casts = [
        'serial' => 'array',
    ];

    /**
     * The belongsTo inventory item relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id', 'id');
    }

    /**
     * The hasMany movements relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function movements()
    {
        return $this->hasMany(InventoryStockMovement::class, 'stock_id', 'id');
    }

    /**
     * The hasMany transactions relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function transactions()
    {
        return $this->hasMany(InventoryTransaction::class, 'stock_id', 'id');
    }

    /**
     * The hasOne location relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
<<<<<<< HEAD
        return $this->hasOne(Location::class);
=======
        return $this->belongsTo(Location::class);
>>>>>>> 8c735a7957f92f76b2dd38a5fda93d6bcb7b04b6
    }

    public function getWarehouse($stock_id)
    {
        return DB::table('inventory_stocks')->leftJoin('locations', 'locations.id', 'inventory_stocks.location_id')->where('inventory_stocks.id', $stock_id)->select('locations.name')->first();
    }

    /**
     * Accessor for viewing the last movement of the stock
     *
     * @return null|string
     */
    public function getLastMovementAttribute()
    {
        if ($this->movements->count() > 0) {
            //$movementa = $this->movements->all();
            // not working because it's returning on the first LOOPPP!!!
            $activity = array();
            foreach($this->movements as $movement){
                //echo($this->movements->count());
                if ($movement->after > $movement->before) {
                    $warehouseName = $this->getWarehouse($movement->stock_id);
                    $date = date_create($movement->created_at);
                    $newDate = date_format($date, "Y/m/d");
                    array_push($activity,array('action' => 'added', 'qty' => $movement->change, 'date' => $newDate, 'event' => $movement->reason, 'warehouse' => $warehouseName->name, "after" => $movement->after));
                   
                    //return sprintf('<b>%s</b> (Stock was added - %s) - <b>Reason:</b> %s - %s', $movement->change, $movement->created_at, $movement->reason, $warehouseName->name);
    
                } else if ($movement->before > $movement->after) {
                    $warehouseName = $this->getWarehouse($movement->stock_id);
                    $date = date_create($movement->created_at);
                    $newDate = date_format($date, "Y/m/d");
                    array_push($activity,array('action' => 'subtracted', 'qty' => $movement->change, 'date' => $newDate, 'event' => $movement->reason, 'warehouse' => $warehouseName->name, "after" => $movement->after));

                    //return sprintf('<b>%s</b> (Stock was removed - %s) - <b>Reason:</b> %s', $movement->change, $movement->created_at, $movement->reason);
    
                }
                else{
                    $warehouseName = $this->getWarehouse($movement->stock_id);
                    $date = date_create($movement->created_at);
                    $newDate = date_format($date, "Y/m/d");
                    array_push($activity,array('action' => 'noChange', 'qty' => $movement->change, 'date' => $newDate, 'event' => $movement->reason, 'warehouse' => $warehouseName->name, "after" => $movement->after));

                    //return sprintf('<b>%s</b> (No Change - %s) - <b>Reason:</b> %s', $movement->change, $movement->created_at, $movement->reason);
    
                }
            }
            return array_reverse($activity);

        }

        return NULL;
    }
}
