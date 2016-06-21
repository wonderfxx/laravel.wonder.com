<?php

namespace test;

use TestCase;

class BillingsControllerTest extends TestCase
{

    public function createApplication()
    {

        // TODO: Implement createApplication() method.


    }

    /**
     * 创建下单信息
     *
     * @return \Illuminate\Http\Response
     */
    public function testCreate()
    {
        $response = $this->call('Post', '/placed', [
            'user_id' => '123456'
        ]);

//        $this->makeRequest('POST','/placed' ,[
//            'user_id' => '123456'
//        ]);
    }

}
