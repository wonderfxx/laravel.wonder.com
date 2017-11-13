<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmMenuList
 *
 * @property integer        $id             菜单ID
 * @property string         $menu_name      菜单名称
 * @property integer        $menu_parent_id 分类名称
 * @property string         $menu_address   菜单地址
 * @property integer        $menu_order     排序ID
 * @property string         $menu_status    启用状态
 * @property \Carbon\Carbon $created_at     创建时间
 * @property \Carbon\Carbon $updated_at     更新时间
 * @method static AdmMenuList whereMenuName($value)
 * @method static AdmMenuList whereMenuParentId($value)
 * @method static AdmMenuList whereMenuAddress($value)
 * @method static AdmMenuList whereMenuOrder($value)
 * @method static AdmMenuList whereMenuStatus($value)
 * @method static AdmMenuList whereCreatedAt($value)
 * @method static AdmMenuList whereUpdatedAt($value)
 * @mixin \Eloquent
 * @method static AdmMenuList whereId($value)
 */
class AdmMenuList extends Model
{
    public $timestamps = false;

    public static function getColumns()
    {
        $data   = preg_split("/[\n]+/", (new \ReflectionClass(self::class))->getDocComment());
        $return = [];
        foreach ($data as $k => $value)
        {
            if (strstr($value, '@property'))
            {
                $temp           = preg_split("/[\s]+/", trim(str_replace(' * @property ', '', $value)));
                $index          = str_replace('$', '', $temp[1]);
                $return[$index] = [
                    'field' => $index,
                    'title' => ($temp[2]),
                    'align' => 'center',
                ];
            }
        }
        $return['operation'] = [
            'field' => 'operation',
            'title' => '操作',
            'align' => 'center',
        ];

        return $return;
    }

}
