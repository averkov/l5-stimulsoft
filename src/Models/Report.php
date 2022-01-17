<?php

/**
 * AR модель отчета stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * AR модель отчета stimulsoft
 *
 * Class Report
 * @package DRVAS\L5Stimulsoft\Models
 * @property string $id
 * @property string $code Уникальный код отчёта
 * @property string $name Наименование отчёта
 * @property string $config Сериализованный конфиг отчёта. Для типа 'stimulsoft' -- содержимое mrt-файла
 * @property Carbon $created_at Дата создания отчёта
 */
class Report extends Model
{
    /**
     * @var bool
     */
    public $timestamps = false;
    /**
     * @var string[]
     */
    protected $dates = [
        'created_at',
    ];
    /**
     * @var string[]
     */
    protected $fillable = [
        'id',
        'code',
        'name',
        'config',
        'created_at',
    ];

    /**
     * @return string
     */
    public function getTable()
    {
        return config('l5-stimulsoft.db.schema') . '.reports';
    }

    /**
     * @return bool
     */
    public function getIncrementing()
    {
        return false;
    }
}
