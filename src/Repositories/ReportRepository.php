<?php

/**
 * Реализация репозитория для работы с отчетами stimulsoft
 */

declare(strict_types=1);

namespace DRVAS\L5Stimulsoft\Repositories;

use DRVAS\L5Stimulsoft\Models;
use DRVAS\Stimulsoft\Domain\Exceptions\InvariantViolation;
use DRVAS\Stimulsoft\Infrastructure\Repository\ReportRepositoryInterface;
use DRVAS\Stimulsoft\Domain\Entities;
use DRVAS\Stimulsoft\Domain\ValueObjects;
use DRVAS\Stimulsoft\Infrastructure\DTO;
use DRVAS\Stimulsoft\Infrastructure\Exceptions;
use DRVAS\NSI\Core\Repositories\BaseRepository;
use DRVAS\NSI\Core\Requests\GraphQLRequestAggregator;
use Illuminate\Pagination\LengthAwarePaginator;
use Prettus\Repository\Exceptions\RepositoryException;
use Ramsey\Uuid\Uuid;

/**
 * Реализация репозитория для работы с отчетами stimulsoft
 *
 * Class ReportRepository
 * @package DRVAS\L5Stimulsoft\Repositories
 */
class ReportRepository extends BaseRepository implements ReportRepositoryInterface
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Models\Report::class;
    }

    /**
     * @param ValueObjects\ReportId $reportId
     * @return Entities\Report|null
     * @throws InvariantViolation
     */
    public function findReport(ValueObjects\ReportId $reportId)
    {
        $reportModel = $this->find($reportId->getValue());

        if (!$reportModel) {
            return null;
        }

        return $this->makeReportEntityFromModel($reportModel);
    }

    /**
     * @param string $reportCode
     * @return Entities\Report|null
     * @throws InvariantViolation
     */
    public function findReportByCode(string $reportCode)
    {
        $reportModel = $this->findByField('code', $reportCode)->first();
        if ($reportModel) {
            return $this->makeReportEntityFromModel($reportModel);
        }

        return null;
    }

    /**
     * @param int $limit
     * @param int $page
     * @return DTO\PaginateReportsResult
     * @throws RepositoryException
     */
    public function paginateReports(int $limit, int $page): DTO\PaginateReportsResult
    {
        /**
         * @var LengthAwarePaginator $paginator
         */
        // legacy затычка для репозитория
        $this->setRequest(app(GraphQLRequestAggregator::class));

        $paginator = $this->paginate($limit, $page);
        $reportCollection = $paginator->getCollection()->map(
            function ($reportModel) {
                return $this->makeReportEntityFromModel($reportModel);
            }
        );

        return new DTO\PaginateReportsResult(
            $reportCollection->toArray(),
            $paginator->currentPage(),
            $paginator->perPage(),
            $paginator->total()
        );
    }

    /**
     * @param Entities\Report $report
     * @return Entities\Report
     */
    public function storeReport(Entities\Report $report): Entities\Report
    {
        $this->makeReportModelFromEntity($report)->save();

        return $report;
    }

    /**
     * @param Entities\Report $report
     * @return Entities\Report
     * @throws Exceptions\UpdateReportFailed
     */
    public function updateReport(Entities\Report $report): Entities\Report
    {
        $reportModel = $this->find($report->getId()->getValue());

        if (!$reportModel) {
            throw new Exceptions\UpdateReportFailed($report->getId(), 'запись не найдена');
        }

        $reportModel->name = $report->getName();
        $reportModel->code = $report->getCode()->getValue();
        $reportModel->config = $report->getConfig();

        $reportModel->save();

        return $report;
    }

    /**
     * @param Entities\Report $report
     * @return bool
     * @throws Exceptions\DeleteReportFailed
     */
    public function deleteReport(Entities\Report $report): bool
    {
        $reportModel = $this->find($report->getId()->getValue());

        if (!$reportModel) {
            throw new Exceptions\DeleteReportFailed($report->getId(), 'запись не найдена');
        }

        return (bool)$this->delete($report->getId()->getValue());
    }

    /**
     * @param Models\Report $reportModel
     * @return Entities\Report
     * @throws InvariantViolation
     */
    private function makeReportEntityFromModel(Models\Report $reportModel): Entities\Report
    {
        return new Entities\Report(
            new ValueObjects\ReportId(Uuid::fromString($reportModel->id)),
            new ValueObjects\ReportCode($reportModel->code),
            $reportModel->name,
            $reportModel->config,
            $reportModel->created_at
        );
    }

    /**
     * @param Entities\Report $report
     * @return Models\Report
     */
    private function makeReportModelFromEntity(Entities\Report $report): Models\Report
    {
        $model = new Models\Report();
        $model->id = $report->getId();
        $model->code = $report->getCode();
        $model->name = $report->getName();
        $model->config = $report->getConfig();
        $model->created_at = $report->getCreatedAt();

        return $model;
    }
}
