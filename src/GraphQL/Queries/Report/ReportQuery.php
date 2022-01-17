<?php

/**
 * Получение отчета stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Queries\Report;

use DRVAS\GraphQL\lib\Field;
use DRVAS\NSI\Core\Requests\GraphQLRequestAggregator;
use DRVAS\Stimulsoft\Application\Services;
use DRVAS\GraphQL\Facades\GraphQL;
use DRVAS\NSI\Core\Interfaces\ResolverInterface;
use DRVAS\Stimulsoft\Domain\Entities;
use DRVAS\Stimulsoft\Domain\ValueObjects;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use Ramsey\Uuid\Uuid;

/**
 * Получение отчета stimulsoft
 *
 * Class ReportQuery
 * @package App\GraphQL\Queries\Products
 */
class ReportQuery extends Field implements ResolverInterface
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'ReportQuery',
        'description' => 'Получение записи отчета стимулсофт'
    ];
    /**
     * @var Services\ReportService
     */
    private $reportService;

    /**
     * ReportQuery constructor.
     * @param Services\ReportService $reportService
     */
    public function __construct(Services\ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * @return Type
     */
    public function type(): Type
    {
        return GraphQL::Type('reportType');
    }

    /**
     * @return array
     */
    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::nonNull(GraphQL::type('uuid')),
                'rules' => ['required']
            ],
        ];
    }

    /**
     * @param $root
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return Entities\Report | Null
     */
    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $request = app(GraphQLRequestAggregator::class);
        $request->prepareRequestArguments($args);
        $reportId = new ValueObjects\ReportId(Uuid::fromString($request->getRequestParamByKey('id')));

        return $this->reportService->getReport($reportId);
    }
}
