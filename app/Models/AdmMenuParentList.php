<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\AdmMenuParentList
 *
 * @property integer        $id          菜单ID
 * @property string         $menu_name   分类名称
 * @property string         $menu_icon   菜单图标样式
 * @property integer        $menu_order  排序ID
 * @property string         $menu_status 启用状态
 * @property \Carbon\Carbon $created_at  创建时间
 * @property \Carbon\Carbon $updated_at  更新时间
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
    public $timestamps = false;

    /**
     * 当前表列名称
     *
     * @return array
     */
    public static function getColumns()
    {
        $data   = preg_split("/[\n]+/", (new \ReflectionClass(self::class))->getDocComment());
        $return = [];
        foreach ($data as $k => $value)
        {
            if (strstr($value, '@property'))
            {
                $temp     = preg_split("/[\s]+/", trim(str_replace(' * @property ', '', $value)));
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

    /**
     * 所有父级菜单名称
     *
     * @return array
     */
    public function getParentNames()
    {

        $all    = $this->all(['id', 'menu_name']);
        $return = [];
        foreach ($all as $item)
        {
            $return[$item->id] = $item->menu_name;
        }

        return $return;
    }
}