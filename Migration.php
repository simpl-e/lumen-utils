<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration as Illuminate_Migration;

class Migration extends Illuminate_Migration {
    /* RESET:
     * php artisan migrate:refresh --database=migrations
     * php artisan migrate:reset --force --database=migrations
     */
    
    protected $table = "migrations";
    protected $connection = 'migrations';

    protected function col($tablename, $type, $column, $extra = null) {
        if (!Schema::hasColumn($tablename, $column)) {
            Schema::table($tablename, function (Blueprint $table) use ($type, $column, $extra) {
                $col = $table->$type($column);
                if($extra){
                    $col->$extra();
                }
            });
        }
    }

}
