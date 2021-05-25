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
<<<<<<< HEAD
            $model->setAttribute('user_id', Helper::getCurrentUserId());
=======
            $model->setAttribute('user_id', $model->user_id);
>>>>>>> 8c735a7957f92f76b2dd38a5fda93d6bcb7b04b6
        });
    }

    /**
     * The belongsTo stock relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    abstract public function transaction();
}
