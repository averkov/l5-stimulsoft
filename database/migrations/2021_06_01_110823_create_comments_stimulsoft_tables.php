<?php

/**
 * Миграции по коментированию сущностей в схеме БД nsi_admin_data
 */

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * Класс миграции по коментированию сущностей в схеме БД nsi_admin_data
 * Class CreateCommentsStimulsoftTables
 */
class CreateCommentsStimulsoftTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $sql = <<<SQL
comment on schema SCHEMA_NAME is 'Схема для отчетов стимулсофта';        
comment on column SCHEMA_NAME.reports.id is 'Уникальный код типа сущностей';
comment on column SCHEMA_NAME.reports.code is 'Код';
comment on column SCHEMA_NAME.reports.name is 'Название';
comment on column SCHEMA_NAME.reports.config is 'Конфиг';
comment on column SCHEMA_NAME.reports.created_at is 'Время создания';
SQL;
        DB::unprepared(str_replace('SCHEMA_NAME', $this->getSchemaName(), $sql));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }

    protected function getSchemaName()
    {
        return 'stimulsoft';
    }
}
