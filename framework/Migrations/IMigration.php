<?php

namespace Framework\Migrations;

interface IMigration
{
    public function run();

    public function rollback();
}