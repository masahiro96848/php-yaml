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
        # ここでは取得する列だけをここに書き込む
        return [
            # テーブル名
            'table-name' => 0,
            # ジャンル
            'genre' => 1,
            # 名前
            'name' => 2,
            # 内容
            'content' => 3
        ];
    }

}


?>