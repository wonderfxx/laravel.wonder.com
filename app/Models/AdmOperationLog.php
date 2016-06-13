<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmOperationLog
 *
 * @property integer $id 自增编号
 * @property integer $userid 用户ID
 * @property string $sql_text 执行sql
 * @property string $oper_type 操作类型
 * @property string $oper_table 操作表格
 * @property \Carbon\Carbon $created_at 操作时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmOperationLog whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmOperationLog whereUserid($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmOperationLog whereSqlText($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmOperationLog whereOperType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmOperationLog whereOperTable($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmOperationLog whereCreatedAt($value)
 * @mixin \Eloquent
 */
class AdmOperationLog extends Model
{
    //
}
