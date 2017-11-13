<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmOperationLog
 *
 * @property integer        $id         自增编号
 * @property integer        $userid     用户ID
 * @property string         $sql_text   执行sql
 * @property string         $oper_type  操作类型
 * @property string         $oper_table 操作表格
 * @property \Carbon\Carbon $created_at 操作时间
 * @method static AdmOperationLog whereId($value)
 * @method static AdmOperationLog whereUserid($value)
 * @method static AdmOperationLog whereSqlText($value)
 * @method static AdmOperationLog whereOperType($value)
 * @method static AdmOperationLog whereOperTable($value)
 * @method static AdmOperationLog whereCreatedAt($value)
 * @mixin \Eloquent
 */
class AdmOperationLog extends Model
{

    public $timestamps = false;
    //
}
