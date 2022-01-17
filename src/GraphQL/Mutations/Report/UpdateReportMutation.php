<?php

/**
 * Изменение отчета stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Mutations\Report;

use DRVAS\GraphQL\Facades\GraphQL;
use DRVAS\GraphQL\lib\Field;
use DRVAS\NSI\Core\Requests\GraphQLRequestAggregator;
use DRVAS\Stimulsoft\Application\DTO;
use DRVAS\Stimulsoft\Application\Exceptions\CanNotFindReportForUpdate;
use DRVAS\Stimulsoft\Application\Services;
use DRVAS\Stimulsoft\Domain\Entities;
use DRVAS\Stimulsoft\Domain\Exceptions\InvariantViolation;
use DRVAS\Stimulsoft\Domain\ValueObjects;
use DRVAS\Stimulsoft\Infrastructure\Exceptions\UpdateReportFailed;
use GraphQL\Type\Definition\Type as GraphqlType;
use Ramsey\Uuid\Uuid;

/**
 * Изменение отчета stimulsoft
 *
 * Class UpdateReportMutation
 * @package App\GraphQL\Mutations\Products
 */
class UpdateReportMutation extends Field
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'UpdateReportMutation',
        'description' => 'Изменение записи отчета стимулсофт'
    ];

    /**
     * @var Services\ReportService
     */
    private $reportService;

    /**
     * UpdateReportMutation constructor.
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
     * @return array[]
     */
    public function args(): array
    {
        return [
            'id' => [
                'type' => GraphqlType::nonNull(GraphQL::type('uuid')),
                'description' => 'Идентификатор',
                'rules' => ['required']
            ],
            'params' => [
                'type' => GraphQL::type('reportUpdateType'),
                'description' => 'Документ',
                'rules' => ['required']
            ],
        ];
    }

    /**
     * @param $parent
     * @param $args
     * @return Entities\Report
     * @throws CanNotFindReportForUpdate
     * @throws InvariantViolation
     * @throws UpdateReportFailed
     */
    public function resolve($parent, $args): Entities\Report
    {
        /** @var GraphQLRequestAggregator $request */
        $request = app(GraphQLRequestAggregator::class);
        $request->prepareRequestArguments($args);

        $requestParams = $request->getRawRequest()['params'];

        $updateReportDto = new DTO\UpdateReportRequest(
            new ValueObjects\ReportId(Uuid::fromString($request->getRawRequest()['id'])),
            new ValueObjects\ReportCode($requestParams['code']),
            $requestParams['name'],
            $requestParams['config']
        );

        return $this->reportService->updateReport($updateReportDto);
    }
}
