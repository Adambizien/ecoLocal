@extends('admin.index')

@section('admin-content')
<div class="container-fluid px-0">
    <div class="row mx-0">
        <main class="col-12 px-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3">
                <h1 class="h2">Tableau de Bord Éco-Local</h1>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Cartes statistiques -->
            <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4 mb-4">
                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Projets Éco</span>
                            <i class="fas fa-leaf text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['total_projects'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Dons Totaux</span>
                            <i class="fas fa-euro-sign text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">€{{ number_format($stats['total_donations'], 0, ',', ' ') }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Communautés Locales</span>
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['total_communities'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col">
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

            <!-- Première ligne de graphiques -->
            <div class="row mx-0 mb-4">
                <div class="col-lg-4 mb-4 px-0 px-md-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Projets par thématique</span>
                        </div>
                        <div class="card-body p-0 d-flex align-items-center">
                            <div id="projectsByCategoryChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-4 px-0 px-md-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Financement mensuel</span>
                        </div>
                        <div class="card-body p-0 d-flex align-items-center">
                            <div id="monthlyDonationsChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Deuxième ligne de graphiques -->
            <div class="row mx-0">
                <div class="col-lg-6 mb-4 px-0 px-md-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Impact environnemental</span>
                        </div>
                        <div class="card-body p-0 d-flex align-items-center">
                            <div id="environmentalImpactChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4 px-0 px-md-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Top 5 projets locaux</span>
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
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // 1. Graphique des financements mensuels
        new ApexCharts(document.querySelector("#monthlyDonationsChart"), {
            series: [{
                name: "Financements",
                data: @json($monthlyDonationsData)
            }],
            chart: {
                type: 'area',
                height: '100%',
                toolbar: { show: false }
            },
            colors: ['#2ecc71'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 2 },
            xaxis: {
                categories: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"]
            },
            tooltip: {
                y: { formatter: function(val) { return val + " €"; } }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.7,
                    opacityTo: 0.3,
                }
            }
        }).render();

        // 2. Graphique des projets par thématique
        new ApexCharts(document.querySelector("#projectsByCategoryChart"), {
            series: @json($projectsByCategory->pluck('projects_count')),
            chart: { 
                type: 'donut', 
                height: '100%',
            },
            labels: @json($projectsByCategory->pluck('name')),
            colors: ['#2ecc71', '#3498db', '#f1c40f', '#e67e22', '#e74c3c'],
            legend: { position: 'bottom' },
            plotOptions: {
                pie: {
                    donut: {
                        labels: {
                            show: true,
                            total: {
                                show: true,
                                label: 'Projets Éco',
                                color: '#2c3e50'
                            }
                        }
                    }
                }
            }
        }).render();

        // 3. Graphique d'impact environnemental
        new ApexCharts(document.querySelector("#environmentalImpactChart"), {
            series: [{
                name: "CO2 économisé (tonnes)",
                data: @json(array_values($environmentalImpact))
            }],
            chart: {
                type: 'radar',
                height: '100%',
                toolbar: { show: false }
            },
            colors: ['#2ecc71'],
            xaxis: {
                categories: @json(array_keys($environmentalImpact))
            },
            yaxis: {
                show: false
            },
            markers: {
                size: 5,
                hover: {
                    size: 7
                }
            }
        }).render();

        // 4. Graphique des top projets locaux
        new ApexCharts(document.querySelector("#topProjectsChart"), {
            series: [{ 
                data: @json($topProjects->pluck('donations_sum_amount')->toArray()) 
            }],
            chart: { type: 'bar', height: '100%' },
            colors: ['#3498db'],
            plotOptions: {
                bar: { 
                    borderRadius: 4, 
                    horizontal: true,
                    dataLabels: {
                        position: 'bottom'
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function(val) { return val + " €"; },
                style: {
                    colors: ['#2c3e50']
                }
            },
            xaxis: {
                categories: @json($topProjects->pluck('title')->toArray())
            },
            tooltip: {
                y: { formatter: function(val) { return val + " € collectés"; } }
            }
        }).render();
    });
</script>
@endpush

@push('styles')
<style>
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 0.15rem 1rem rgba(0, 0, 0, 0.05);
    }
    .card-header {
        background-color: #f8f9fa;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 0.75rem 1.25rem;
    }
    .badge {
        font-size: 0.75rem;
        font-weight: 500;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .bg-primary {
        background-color: #2ecc71 !important;
    }
    .bg-success {
        background-color: #27ae60 !important;
    }
    .bg-info {
        background-color: #3498db !important;
    }
    .bg-warning {
        background-color: #f39c12 !important;
    }
    
    /* Responsive adjustments */
    @media (max-width: 768px) {
        .row-cols-md-3 > * {
            flex: 0 0 auto;
            width: 50%;
        }
        #monthlyDonationsChart,
        #projectsByCategoryChart,
        #environmentalImpactChart,
        #topProjectsChart {
            height: 250px !important;
        }
    }
</style>
@endpush