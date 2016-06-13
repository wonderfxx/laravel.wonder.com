<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmMenuParentList
 *
 * @property integer $id 菜单ID
 * @property string $menu_name 菜单名称
 * @property string $menu_icon 菜单地址
 * @property integer $menu_order 排序ID
 * @property string $menu_status 启用状态
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuParentList whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuParentList whereMenuName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuParentList whereMenuIcon($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuParentList whereMenuOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuParentList whereMenuStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuParentList whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuParentList whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class AdmMenuParentList extends Model
{
    //
}