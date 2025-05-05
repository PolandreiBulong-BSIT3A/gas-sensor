<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sensor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .sensor-card {
            transition: all 0.3s ease;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .sensor-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.15);
        }
        .sensor-value {
            font-size: 2.5rem;
            font-weight: bold;
        }
        .last-updated {
            font-size: 0.85rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <header class="text-center mb-5">
            <h1 class="display-4">🌡️ Sensor Dashboard</h1>
            <p class="lead">Real-time monitoring of environmental sensors</p>
        </header>

        <div class="row g-4">
            @foreach($sensorData as $sensorId => $data)
            <div class="col-md-6 col-lg-3">
                <div class="sensor-card p-4 bg-white">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="h5 mb-0">{{ $sensorNames[$sensorId] ?? $sensorId }}</h3>
                        <span class="badge rounded-pill bg-{{ $data ? 'success' : 'danger' }}">
                            {{ $data ? 'ONLINE' : 'OFFLINE' }}
                        </span>
                    </div>
                    
                    @if($data)
                    <div class="sensor-value text-primary mb-2">
                        {{ $data['value'] }} <small class="text-muted">{{ $data['unit'] ?? '' }}</small>
                    </div>
                    <div class="last-updated">
                        Updated: {{ \Carbon\Carbon::parse($data['timestamp'])->diffForHumans() }}
                    </div>
                    @else
                    <div class="text-danger py-3">
                        No data available
                    </div>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <footer class="mt-5 text-center text-muted">
            <p>Last refreshed: {{ now()->format('Y-m-d H:i:s') }}</p>
        </footer>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>