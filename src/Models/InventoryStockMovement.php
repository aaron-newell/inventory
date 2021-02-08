<?php

namespace Trexology\Inventory\Models;

use Trexology\Inventory\Traits\InventoryStockMovementTrait;

class InventoryStockMovement extends BaseModel
{
    use InventoryStockMovementTrait;

    protected $casts = [
        'serial' => 'array',
    ];

    /**
     * The belongsTo stock relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function stock()
    {
        return $this->belongsTo(InventoryStock::class);
    }

    /**
     * Returns the change of a stock
     *
     * @return string
     */
    public function getChangeAttribute()
    {
        if ($this->before > $this->after) {

            return sprintf('-%s', $this->before - $this->after);

        } else if($this->after > $this->before) {

            return sprintf('+%s', $this->after - $this->before);

        } else {
            return 'None';
        }
    }
}
