<!DOCTYPE html>
<html>
<head>
    <title>Sensor Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { padding: 20px; background-color: #f8f9fa; }
        .table-container { background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
        h1 { margin-bottom: 20px; color: #333; }
        .last-updated { font-size: 0.85rem; color: #6c757d; }
        .nav-tabs { margin-bottom: 20px; }
        .status-badge { font-size: 0.75rem; }
        .sensor-value { font-weight: bold; }
        .hidden { display: none; }
        .team-member { text-align: center; margin-bottom: 20px; }
        .team-photo { 
            width: 150px; 
            height: 150px; 
            object-fit: cover; 
            border-radius: 50%; 
            margin-bottom: 10px;
            border: 3px solid #0d6efd;
        }
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Gas Sensor Dashboard</h1>
        
        <ul class="nav nav-tabs" id="mainTabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-tab="all-sensors">All Sensors</a>
            </li>
            @foreach(['MQ135', 'MQ2', 'MQ4', 'MQ5'] as $sensor)
            <li class="nav-item">
                <a class="nav-link" href="#" data-tab="{{ $sensor }}-sensor">{{ $sensor }}</a>
            </li>
            @endforeach
            <li class="nav-item">
                <a class="nav-link" href="#" data-tab="about-us">About Us</a>
            </li>
        </ul>

        <div class="table-container">
            <!-- All Sensors Table -->
            <div id="all-sensors">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Sensor</th>
                            <th>Type</th>
                            <th>Current Value</th>
                            <th>Status</th>
                            <th>Last Updated</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sensors as $sensorId => $data)
                        <tr>
                            <td>{{ $sensorId }}</td>
                            <td>{{ $sensorNames[$sensorId] }}</td>
                            <td class="sensor-value">
                                @if($data)
                                    {{ $data['value'] }} {{ $data['unit'] }}
                                @else
                                    --
                                @endif
                            </td>
                            <td>
                                <span class="badge rounded-pill bg-{{ $data ? 'success' : 'danger' }} status-badge">
                                    {{ $data ? 'ACTIVE' : 'OFFLINE' }}
                                </span>
                            </td>
                            <td>
                                @if($data)
                                    <span class="last-updated">
                                        {{ \Carbon\Carbon::parse($data['timestamp'])->diffForHumans() }}
                                    </span>
                                @else
                                    N/A
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Individual Sensor Tables -->
            @foreach(['MQ135', 'MQ2', 'MQ4', 'MQ5'] as $sensor)
            <div id="{{ $sensor }}-sensor" class="hidden">
                <h3>{{ $sensor }} - {{ $sensorNames[$sensor] }}</h3>
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Timestamp</th>
                            <th>Value</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($historyData[$sensor]['data'] as $reading)
                        <tr>
                            <td>{{ $reading['timestamp'] }}</td>
                            <td class="sensor-value">{{ $reading['value'] }} {{ $reading['unit'] }}</td>
                            <td>
                                <span class="badge rounded-pill bg-success status-badge">
                                    RECORDED
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endforeach

            <!-- About Us Section -->
     <!-- Updated About Us Section with correct paths -->
<div id="about-us" class="hidden">
    <h2>Our Team</h2>
    
    <div class="team-grid">
        <div class="team-member">
            <img src="{{ asset('IMG/pic1.png') }}" class="team-photo" alt="Pol Andrei L. Bulong">
            <h3>POL ANDREI L. BULONG</h3>
            <p class="text-primary">TEAM LEADER</p>
        </div>
        
        <div class="team-member">
            <img src="{{ asset('IMG/pic3.png') }}" class="team-photo" alt="John Michael Giong-an">
            <h3>JOHN MICHAEL GIONG-AN</h3>
            <p class="text-primary">MEMBER 1</p>
        </div>
        
        <div class="team-member">
            <img src="{{ asset('IMG/pic2.png') }}" class="team-photo" alt="Jayser Joy M. Marquez">
            <h3>JAYSER JOY M. MARQUEZ</h3>
            <p class="text-primary">MEMBER 2</p>
        </div>
        
        <div class="team-member">
            <img src="{{ asset('IMG/j.jpg') }}" class="team-photo" alt="Jessie Garde">
            <h3>JESSIE GARDE</h3>
            <p class="text-primary">MEMBER 3</p>
        </div>
    </div>
</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabLinks = document.querySelectorAll('#mainTabs .nav-link');
            const allSections = document.querySelectorAll('.table-container > div');
            
            tabLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    // Update active tab styling
                    tabLinks.forEach(t => t.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Hide all sections
                    allSections.forEach(section => section.classList.add('hidden'));
                    
                    // Show selected section
                    const tab = this.dataset.tab;
                    document.getElementById(tab).classList.remove('hidden');
                });
            });
        });
    </script>
</body>
</html>