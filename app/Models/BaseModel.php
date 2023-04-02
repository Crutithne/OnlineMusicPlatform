<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BaseModel extends Model
{
    use SoftDeletes; // 启用软删除功能

    protected $dates = ['deleted_at']; // 定义软删除字段

    /**
     * 格式化日期时间
     *
     * @param string $date
     * @return string
     */
    public function formatDate($date)
    {
        return date('Y-m-d H:i:s', strtotime($date));
    }

    /**
     * 根据状态码获取状态文本
     *
     * @param int $statusCode
     * @return string
     */
    public function getStatusText($statusCode)
    {
        $statusTexts = [
            0 => '正常',
            1 => '下架',
            2 => '封禁'
        ];

        return $statusTexts[$statusCode] ?? '未知';
    }
}
