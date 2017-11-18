<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\UsersBillingChange
 *
 * @property integer $id
 * @property integer $fg_order_id
 * @property integer $created_time
 * @property integer $status
 * @property string  $remark
 * @method static UsersBillingChange whereId($value)
 * @method static UsersBillingChange whereFgOrderId($value)
 * @method static UsersBillingChange whereCreatedTime($value)
 * @method static UsersBillingChange whereStatus($value)
 * @method static UsersBillingChange whereRemark($value)
 * @mixin \Eloquent
 */
class UsersBillingChange extends Model
{

    public $timestamps = false;

    /**
     * 记录变更日志
     *
     * @param        $order_id
     * @param        $status
     * @param string $remark
     */
    public static function recordChange($order_id, $status, $remark = 'system')
    {
        self::insert([
                         'fg_orderid'   => $order_id,
                         'status'       => $status,
                         'created_time' => time(),
                         'remark'       => $remark,
                     ]);
    }
}
