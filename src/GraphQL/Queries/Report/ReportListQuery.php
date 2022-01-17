<?php

/**
 * Получение списка отчетов stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Queries\Report;

use DRVAS\NSI\Core\Interfaces\ResolverInterface;
use DRVAS\NSI\Core\Requests\GraphQLRequestAggregator;
use DRVAS\Stimulsoft\Application\DTO;
use DRVAS\Stimulsoft\Application\Services;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\Type;
use DRVAS\GraphQL\Facades\GraphQL;
use DRVAS\GraphQL\lib\Field;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * Получение списка отчетов stimulsoft
 *
 * Class ReportListQuery
 * @package App\GraphQL\Queries\Products
 */
class ReportListQuery extends Field implements ResolverInterface
{
    /**
     * @var string[]
     */
    protected $attributes = [
        'name' => 'ReportListQuery',
        'description' => 'Получение списка записей отчетов стимулсофт',
    ];
    /**
     * @var Services\ReportService
     */
    private $reportService;

    /**
     * ReportListQuery constructor.
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
        return GraphQL::paginate('reportType');
    }

    /**
     * @return array
     */
    public function args(): array
    {
        return [
            'page' => [
                'type' => Type::int(),
                'description' => 'Страница'
            ],
            'limit' => [
                'type' => Type::int(),
                'description' => 'Лимит'
            ]
        ];
    }

    /**
     * @param $root
     * @param $args
     * @param $context
     * @param ResolveInfo $info
     * @return LengthAwarePaginator
     */
    public function resolve($root, $args, $context, ResolveInfo $info)
    {
        $request = app(GraphQLRequestAggregator::class);
        $request->prepareRequestArguments($args);

        $paginateResult = $this->reportService->paginateReports(
            new DTO\PaginateReportsRequest(
                $request->getRequestLimit(),
                $request->getRequestPage()
            )
        );

        return new LengthAwarePaginator(
            $paginateResult->getReports(),
            $paginateResult->getTotal(),
            $paginateResult->getLimit(),
            $paginateResult->getPage()
        );
    }
}
