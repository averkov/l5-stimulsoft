<?php

/**
 * Тип отчета stimulsfot
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Types\Report;

use DRVAS\GraphQL\lib\Type as GraphQLType;
use DRVAS\L5Stimulsoft\Models;
use GraphQL\Type\Definition\Type;
use DRVAS\GraphQL\Facades\GraphQL;
use DRVAS\Stimulsoft\Domain\Entities;

/**
 * Тип отчета stimulsfot
 *
 * Class ReportType
 * @package App\GraphQL\Types\Product
 */
class ReportType extends GraphQLType
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'ReportType',
        'description' => 'Отчет стимулсофт',
        'model' => Entities\Report::class
    ];

    /**
     * @return array
     */
    public function fields(): array
    {
        return [
            'id' => [
                'type' => GraphQL::type('uuid'),
                'description' => 'ID Записи',
                'resolve' => function (Entities\Report $report) {
                    return $report->getId()->getValue();
                }
            ],
            'code' => [
                'type' => Type::string(),
                'description' => 'Код',
                'resolve' => function (Entities\Report $report) {
                    return $report->getCode()->getValue();
                }
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'Наименование отчета',
                'resolve' => function (Entities\Report $report) {
                    return $report->getName();
                }
            ],
            'config' => [
                'type' => Type::string(),
                'description' => 'Конфигурации отчета в JSON строке',
                'resolve' => function (Entities\Report $report) {
                    return $report->getConfig();
                }
            ],
        ];
    }
}
