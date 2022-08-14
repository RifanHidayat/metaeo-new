<?php

use Illuminate\Database\Eloquent\Model;

function printTest()
{
    return 'test';
}

function getRecordNumber($model, $prefix = '')
{
    // $number = null;
    // do {
    //     $dataCount = $model::withTrashed()->where('date', date("Y-m-d"))->get()->count();
    //     $number = $prefix . '-' . date('d') . date('m') . date("y") . sprintf('%04d', $dataCount + 1);

    //     $numberExist = $model::where('number', $number)->first();
    // } while ($numberExist !== null);
    $dataCount = $model::withTrashed()->where('date', date("Y-m-d"))->get()->count();
    $number = $prefix . '-' . date('d') . date('m') . date("y") . sprintf('%04d', $dataCount + 1);

    return $number;
}
