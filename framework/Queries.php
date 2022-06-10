<?php

namespace Framework;

abstract class Queries
{
    public static function tableExists(string $tableName): string
    {
        return 'SELECT * 
            FROM information_schema.tables
            WHERE table_schema = "' . program()->configuration->sqlDatabase . '" 
            AND table_name = "' . $tableName . '"
            LIMIT 1;';
    }
}