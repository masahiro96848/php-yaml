<?php

class Map 
{
    public $valueMap;

    public function __construct()
    {
        $this->valueMap = self::valueMapping();
    }

    public function valueMapping() :array
    {
        return [
            //　ジャンル
            'genre' => 1,
            // 名前
            'name' => 2,
            // 内容
            'content' => 3
        ];
    }

}


?>