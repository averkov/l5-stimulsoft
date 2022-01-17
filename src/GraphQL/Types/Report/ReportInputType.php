<?php

/**
 * Тип создания отчета stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Types\Report;

use DRVAS\GraphQL\lib\InputType;
use DRVAS\L5Stimulsoft\Models;
use GraphQL\Type\Definition\Type;

/**
 * Тип создания отчета stimulsoft
 *
 * Class ReportInputType
 * @package App\GraphQL\Types\Product
 */
class ReportInputType extends InputType
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'ReportInputType',
        'description' => 'Тип создания записи отчета стимулсофт',
        'model' => Models\Report::class
    ];

    /**
     * @return array[]
     */
    public function fields(): array
    {
        return [
            'code' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Код'
            ],
            'name' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Наименование отчета'
            ],
            'config' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Конфигурации отчета в JSON строке'
            ],
        ];
    }
}
