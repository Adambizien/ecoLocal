@extends('project-leader.index')

@section('project-leader-content')
<div class="container-fluid px-0">
    <div class="row mx-0">
        <main class="col-12 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2">Mes Statistiques Éco-Local</h1>
            </div>

            <div class="row mx-0 mb-4">
                <div class="col-md-6 col-lg-3 mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Projets</span>
                            <i class="fas fa-project-diagram text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['total_projects'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success" >
                            <span class="text-white">Dons Totaux</span>
                            <i class="fas fa-euro-sign text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ number_format($stats['total_donations'], 0, ',', ' ') }} €</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success" >
                            <span class="text-white">Donateurs</span>
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['total_donors'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-3 mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">En Validation</span>
                            <i class="fas fa-clock text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['pending_projects'] }}</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mx-0 mb-4">
                <div class="col-lg-6 mb-4 px-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Financement mensuel ({{ date('Y') }})</span>
                        </div>
                        <div class="card-body p-0 d-flex align-items-center">
                            <div id="monthlyDonationsChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4 px-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Top 5 projets financés</span>
                        </div>
                        <div class="card-body p-0 d-flex align-items-center">
                            <div id="topProjectsChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        new ApexCharts(document.querySelector("#monthlyDonationsChart"), {
            series: [{
                name: "Montant",
                data: @json($monthlyDonationsData)
            }],
            chart: {
                type: 'area',
                height: '100%',
                toolbar: { show: false },
                zoom: { enabled: false }
            },
            colors: ['#27ae60'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"],
                labels: { style: { colors: '#6c757d' } }
            },
            yaxis: {
                labels: { 
                    formatter: function(val) { return val + "€"; },
                    style: { colors: '#6c757d' }
                }
            },
            tooltip: {
                y: { formatter: function(val) { return val + " € collectés"; } }
            },
            grid: { borderColor: '#f1f1f1' }
        }).render();

        new ApexCharts(document.querySelector("#topProjectsChart"), {
            series: [{ 
                name: "Montant",
                data: @json($topProjects->pluck('donations_sum_amount')->toArray()) 
            }],
            chart: { 
                type: 'bar', 
                height: '100%',
                toolbar: { show: false }
            },
            colors: ['#2ecc71'],
            plotOptions: {
                bar: { 
                    borderRadius: 8,
                    horizontal: false,
                    columnWidth: '55%',
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) { return val + " €"; },
                offsetY: -20,
                style: {
                    fontSize: '12px',
                    colors: ["#2c3e50"]
                }
            },
            xaxis: {
                categories: @json($topProjects->pluck('title')->toArray()),
                labels: { 
                    style: { colors: '#6c757d' },
                    formatter: function(value) {
                        return value.length > 15 ? value.substring(0, 15) + '...' : value;
                    }
                }
            },
            yaxis: {
                labels: { 
                    formatter: function(val) { return val + "€"; },
                    style: { colors: '#6c757d' }
                }
            },
            tooltip: {
                y: { formatter: function(val) { return val + " € collectés"; } }
            }
        }).render();
       
    });
</script>
@endsection