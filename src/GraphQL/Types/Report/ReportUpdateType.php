<?php

/**
 * Тип обновления отчета stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Types\Report;

use DRVAS\GraphQL\lib\InputType;
use GraphQL\Type\Definition\Type;

/**
 * Тип обновления отчета stimulsoft
 *
 * Class ReportUpdateType
 * @package App\GraphQL\Types\Product
 */
class ReportUpdateType extends InputType
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'ReportUpdateType',
        'description' => 'Тип обновления для записи отчета стимулсофт'
    ];

    /**
     * @return array
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
