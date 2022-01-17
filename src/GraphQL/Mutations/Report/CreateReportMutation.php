<?php

/**
 * Создание отчета stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Mutations\Report;

use DRVAS\GraphQL\Facades\GraphQL;
use DRVAS\GraphQL\lib\Field;
use DRVAS\NSI\Core\Requests\GraphQLRequestAggregator;
use DRVAS\Stimulsoft\Application\DTO;
use DRVAS\Stimulsoft\Application\Services;
use DRVAS\Stimulsoft\Domain\Entities;
use DRVAS\Stimulsoft\Domain\Exceptions\InvariantViolation;
use DRVAS\Stimulsoft\Domain\ValueObjects;
use Exception;
use GraphQL\Type\Definition\Type as GraphqlType;

/**
 * Создание отчета stimulsoft
 *
 * Class CreateReportMutation
 * @package App\GraphQL\Mutations\Products
 */
class CreateReportMutation extends Field
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'CreateReportMutation',
        'description' => 'Создание записи отчета стимулсофт'
    ];

    /**
     * @var Services\ReportService
     */
    private $reportService;

    /**
     * CreateReportMutation constructor.
     * @param Services\ReportService $reportService
     */
    public function __construct(Services\ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * @return GraphqlType
     */
    public function type(): GraphqlType
    {
        return GraphQL::type('reportType');
    }

    /**
     * @return array
     */
    public function args(): array
    {
        return [
            'params' => [
                'type' => GraphQL::type('reportInputType'),
                'description' => 'Тип создания записи отчета стимулсофт',
                'rules' => ['required']
            ],
        ];
    }

    /**
     * @param $parent
     * @param $args
     * @return Entities\Report
     * @throws InvariantViolation
     * @throws Exception
     */
    public function resolve($parent, $args): Entities\Report
    {
        $request = app(GraphQLRequestAggregator::class);
        $request->prepareRequestArguments($args);
        $requestParams = $request->getRawRequest()['params'];

        $storeReportDto = new DTO\StoreReportRequest(
            new ValueObjects\ReportCode($requestParams['code']),
            $requestParams['name'],
            $requestParams['config']
        );

        return $this->reportService->storeReport($storeReportDto);
    }
}
