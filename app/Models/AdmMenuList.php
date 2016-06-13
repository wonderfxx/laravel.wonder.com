<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmMenuList
 *
 * @property integer $menu_id 菜单ID
 * @property string $menu_name 菜单名称
 * @property string $menu_index 菜单标识
 * @property integer $menu_parent_id 父级菜单ID
 * @property string $menu_address 菜单地址
 * @property integer $menu_order 排序ID
 * @property string $menu_status 启用状态
 * @property \Carbon\Carbon $created_at 创建时间
 * @property \Carbon\Carbon $updated_at 更新时间
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereMenuId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereMenuName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereMenuIndex($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereMenuParentId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereMenuAddress($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereMenuOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereMenuStatus($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property integer $id 菜单ID
 * @method static \Illuminate\Database\Query\Builder|\App\Models\AdmMenuList whereId($value)
 */
class AdmMenuList extends Model
{
    //
}
