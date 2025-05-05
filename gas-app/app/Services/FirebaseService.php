<?php

namespace App\Services;

use Kreait\Firebase\Factory;
use Kreait\Firebase\Database;

class FirebaseService
{
    protected $database;
    protected $sensors = ['MQ135', 'MQ2', 'MQ4', 'MQ5'];
    protected $perPage = 10;

    public function __construct()
    {
        $firebase = (new Factory)
            ->withServiceAccount(base_path(env('FIREBASE_CREDENTIALS')))
            ->withDatabaseUri(env('FIREBASE_DATABASE_URL'));

        $this->database = $firebase->createDatabase();
    }

    public function getSensorUnit($sensorName)
    {
        $units = [
            'MQ135' => 'ppm',
            'MQ2' => 'ppm',
            'MQ4' => 'ppm',
            'MQ5' => 'ppm',
        ];
        return $units[$sensorName] ?? null;
    }

    public function getSensorDataPaginated($sensorName, $page = 1, $perPage = 10)
{
    $reference = $this->database->getReference('Main/' . $sensorName);
    $snapshot = $reference->orderByKey()->getSnapshot();
    
    if (!$snapshot->exists()) {
        return [
            'data' => [],
            'total' => 0,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => 1
        ];
    }

    $allData = $snapshot->getValue();
    krsort($allData); // Sort by timestamp descending
    
    $total = count($allData);
    $offset = ($page - 1) * $perPage;
    $paginatedData = array_slice($allData, $offset, $perPage, true);
    
    $formattedData = [];
    foreach ($paginatedData as $timestamp => $entry) {
        $formattedData[] = [
            'value' => $entry['value'] ?? null,
            'timestamp' => str_replace('_', ' ', $timestamp),
            'unit' => $this->getSensorUnit($sensorName),
            'raw_timestamp' => $timestamp
        ];
    }

    return [
        'data' => $formattedData,
        'total' => $total,
        'per_page' => $perPage,
        'current_page' => (int)$page,
        'last_page' => ceil($total / $perPage)
    ];
}

    public function getAllSensorsLatestData()
    {
        $result = [];
        foreach ($this->sensors as $sensor) {
            $result[$sensor] = $this->getLatestSensorData($sensor);
        }
        return $result;
    }

    protected function getLatestSensorData($sensorName)
    {
        $reference = $this->database->getReference('Main/' . $sensorName);
        $snapshot = $reference->orderByKey()->limitToLast(1)->getSnapshot();
        
        if ($snapshot->exists()) {
            $data = $snapshot->getValue();
            $latestTimestamp = array_key_last($data);
            
            return [
                'value' => $data[$latestTimestamp]['value'] ?? null,
                'timestamp' => str_replace('_', ' ', $latestTimestamp),
                'unit' => $this->getSensorUnit($sensorName),
                'raw_timestamp' => $latestTimestamp
            ];
        }
        
        return null;
    }
}