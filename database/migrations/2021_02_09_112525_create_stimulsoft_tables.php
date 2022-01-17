<?php

/**
 * Миграция создания таблицы stimulsoft
 */

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;

/**
 * Миграция создания таблицы stimulsoft
 * Class CreateStimulsoftTables
 */
class CreateStimulsoftTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $schemaName = $this->getSchemaName();
        DB::unprepared(sprintf("create schema %s;", $schemaName));

        Schema::create(sprintf("%s.reports", $schemaName), function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('code')->comment('Уникальный код отчёта')->unique();
            $table->string('name')->comment('Наименование отчёта');
            $table->json('config')->comment('Конфигурация отчёта');
            $table->dateTime('created_at')->comment('Дата создания отчёта');
        });
        DB::unprepared(sprintf(
            "comment on table %s.reports is '%s'",
            $schemaName,
            'Данные об отчётах'
        ));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $schemaName = $this->getSchemaName();
        DB::unprepared(sprintf("drop schema %s cascade;", $schemaName));
    }

    /**
     * Должно совпадать с config('l5-stimulsoft.db.schema')
     *
     * @return string
     */
    private function getSchemaName(): string
    {
        return 'stimulsoft';
    }
}
