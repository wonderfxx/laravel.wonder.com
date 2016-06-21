<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/24
 * Time: 下午6:24
 */

namespace database\seeds;

use App\Models\GameList;
use Illuminate\Database\Seeder;

class GameListSeeder extends Seeder
{
    public function run()
    {

        GameList::create([
                             'game_code'       => 'loapk',
                             'game_name'       => 'Magic Card',
                             'game_status'     => 'Y',
                             'game_coins_name' => 'Kreds',
                             'game_type'       => 'web',
                             'created_at'      => time()
                         ]);
    }
}