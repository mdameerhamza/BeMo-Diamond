<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ExportController extends Controller
{
    public function export()
    {
        \Spatie\DbDumper\Databases\MySql::create()
            ->setDbName(env('DB_DATABASE'))
            ->setUserName(env('DB_USERNAME'))
            ->setPassword(env('DB_PASSWORD'))
            ->dumpToFile('dump.sql');
            $file="dump.sql";
            return Response::download($file);
    }
}
