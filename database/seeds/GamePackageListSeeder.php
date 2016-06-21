<?php
/**
 * Created by PhpStorm.
 * User: wonder
 * Date: 16/6/24
 * Time: 下午6:24
 */

namespace database\seeds;

use App\Models\GamePackageList;
use Illuminate\Database\Seeder;

class GamePackageListSeeder extends Seeder
{
    public function run()
    {

        $data = [
            [150, 'kg_price_1.99', '1.99', '20'],
            [375, 'kg_price_4.99', '4.99', '50'],
            [750, 'kg_price_9.99', '9.99', '100'],
            [1600, 'kg_price_20.99', '20.99', '210'],
            [3700, 'kg_price_46.99', '46.99', '470'],
            [8500, 'kg_price_99.99', '99.99', '1000'],
        ];

        foreach ($data as $val)
        {

            GamePackageList::create([
                                        'game_code'           => 'loapk',
                                        'country'             => 'US',
                                        'channel_code'        => 'kongregate',
                                        'channel_sub_code'    => '',
                                        'amount'              => $val[3],
                                        'amount_usd'          => $val[2],
                                        'currency'            => 'KRD',
                                        'currency_show'       => 'KRD',
                                        'game_coins'          => $val[0],
                                        'game_coins_rewards'  => 0,
                                        'product_id'          => $val[1],
                                        'product_name'        => 'Kreds',
                                        'product_description' => '',
                                        'created_at'          => time()
                                    ]);
        }
    }
}