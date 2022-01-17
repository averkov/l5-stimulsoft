<?php

/**
 * Конфиг модуля l5-stimulsoft
 */

use DRVAS\L5Stimulsoft\GraphQL\Queries;
use DRVAS\L5Stimulsoft\GraphQL\Mutations;
use DRVAS\L5Stimulsoft\GraphQL\Types;

return [
    'graphql' => [
        'enabled' => true,
    ],
    'db' => [
        'schema' => 'stimulsoft',
    ],
    'graphQL' => [
        'schemas' => [
            'stimulsoft' => [
                'query' => [
                    'reports' => Queries\Report\ReportListQuery::class,
                    'report' => Queries\Report\ReportQuery::class,
                ],
                'mutation' => [
                    'createReport' => Mutations\Report\CreateReportMutation::class,
                    'updateReport' => Mutations\Report\UpdateReportMutation::class,
                    'deleteReport' => Mutations\Report\DeleteReportMutation::class,
                ]
            ],
            'method' => ['get', 'post'],
        ],
        'types' => [
            'general' => [
                'reportType' => Types\Report\ReportType::class,
            ],
            'stimulsoft' => [
                'reportInputType' => Types\Report\ReportInputType::class,
                'reportUpdateType' => Types\Report\ReportUpdateType::class,
            ]
        ]
    ],
];
