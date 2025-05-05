<?php

namespace App\Http\Controllers;

use App\Services\FirebaseService;

class SensorController extends Controller
{
    protected $firebase;

    public function __construct(FirebaseService $firebase)
    {
        $this->firebase = $firebase;
    }

    public function index()
    {
        // Current readings
        $sensors = $this->firebase->getAllSensorsLatestData();
        
        $sensorNames = [
            'MQ135' => 'Air Quality',
            'MQ2' => 'Flammable Gas',
            'MQ4' => 'Methane',
            'MQ5' => 'Natural Gas'
        ];

        // Historical data with pagination
        $historyData = [];
        $perPage = 10;
        
        foreach (['MQ135', 'MQ2', 'MQ4', 'MQ5'] as $sensor) {
            $page = request()->input("{$sensor}_page", 1);
            $historyData[$sensor] = $this->firebase->getSensorDataPaginated($sensor, $page, $perPage);
        }

        return view('sensors.dashboard', [
            'sensors' => $sensors,
            'sensorNames' => $sensorNames,
            'historyData' => $historyData
        ]);
    }
}