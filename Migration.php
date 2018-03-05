<?php

namespace Simple;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration as Illuminate_Migration;

class Migration extends Illuminate_Migration {

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
