<?php

namespace Helper;

use DI\BaseHelper as Helper;

class Database extends Helper
{
    public $databases = array('課程大綱', '博碩士論文資訊網', '報紙資料庫', '雜誌資料庫', '維基百科', 'Webometrics');
    
    /**
     * getDatabases description
     *
     * @param  string
     * @param  string
     * @param  string
     *
     * @return  string  getDatabasesReturn
     *
     * @since  1.0
     */
    public function getDatabases()
    {
        return $this->databases;
    }
}
