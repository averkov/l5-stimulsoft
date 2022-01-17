<?php

/**
 * Удаление отчета stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\GraphQL\Mutations\Report;

use DRVAS\GraphQL\Facades\GraphQL;
use DRVAS\GraphQL\lib\Field;
use DRVAS\NSI\Core\Requests\GraphQLRequestAggregator;
use DRVAS\Stimulsoft\Application\Exceptions\CanNotFindReportForUpdate;
use DRVAS\Stimulsoft\Application\Services;
use DRVAS\Stimulsoft\Domain\ValueObjects;
use DRVAS\Stimulsoft\Infrastructure\Exceptions\DeleteReportFailed;
use GraphQL\Type\Definition\Type as GraphqlType;
use Ramsey\Uuid\Uuid;

/**
 * Удаление отчета stimulsoft
 *
 * Class DeleteReportMutation
 * @package App\GraphQL\Mutations\Products
 */
class DeleteReportMutation extends Field
{
    /**
     * @var array
     */
    protected $attributes = [
        'name' => 'DeleteReportMutation',
        'description' => 'Удаление записи отчета стимулсофт'
    ];
    /**
     * @var Services\ReportService
     */
    private $reportService;

    /**
     * DeleteReportMutation constructor.
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
        return GraphqlType::boolean();
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
        ];
    }

    /**
     * @param $parent
     * @param $args
     * @return bool
     * @throws CanNotFindReportForUpdate
     * @throws DeleteReportFailed
     */
    public function resolve($parent, $args): bool
    {
        /** @var GraphQLRequestAggregator $request */
        $request = app(GraphQLRequestAggregator::class);
        $request->prepareRequestArguments($args);

        return $this->reportService->deleteReport(
            new ValueObjects\ReportId(
                Uuid::fromString(
                    $request->getRawRequest()['id']
                )
            )
        );
    }
}
