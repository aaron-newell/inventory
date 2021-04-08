<?php

namespace Trexology\Inventory\Traits;

use Trexology\Inventory\Helper;
use Illuminate\Database\Eloquent\Model;

trait InventoryTransactionHistoryTrait
{
    /**
     * Make sure we try and assign the current user if enabled.
     *
     * @return void
     */
    public static function bootInventoryTransactionHistoryTrait()
    {
        static::creating(function (Model $model) {
            $model->setAttribute('user_id', $model->user_id);
        });
    }

    /**
     * The belongsTo stock relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    abstract public function transaction();
}
