<?php

namespace Simple\Lumen\Utils;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration as Illuminate_Migration;

class Migration extends Illuminate_Migration {
    /* RESET:
     * php artisan migrate:refresh
     * php artisan migrate:reset --force
     */
    
    protected $table = "migrations";
    protected $connection = 'mysql';

    protected function col($tablename, $type, $column, $extra = null) {
        if(!is_array($column)){
            $column = [$column];
        }

        if (!Schema::hasColumn($tablename, $column[0])) {
            Schema::table($tablename, function (Blueprint $table) use ($type, $column, $extra) {
                $col = call_user_func_array([$table, $type], $column);
                if($extra){
                    $col->$extra();
                }
            });
        }
    }

}
