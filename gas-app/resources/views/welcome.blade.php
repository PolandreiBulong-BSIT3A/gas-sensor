@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sensor Monitoring Dashboard</h1>
    
    <div class="row">
        @foreach($sensorData as $sensorName => $data)
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    {{ $sensorName }} Status
                </div>
                <div class="card-body">
                    @if($data)
                        <p class="card-text">
                            <strong>Value:</strong> {{ $data['value'] }}<br>
                            <strong>Timestamp:</strong> {{ $data['timestamp'] }}
                        </p>
                    @else
                        <p class="card-text text-danger">No data available</p>
                    @endif
                </div>
                <div class="card-footer">
                    Status: <span class="badge badge-success">Active</span>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection