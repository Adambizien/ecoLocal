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

            <div class="row mx-0 mb-4">
                <div class="col mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Projets</span>
                            <i class="fas fa-leaf text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['total_projects'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Dons</span>
                            <i class="fas fa-euro-sign text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ number_format($stats['total_donations'], 0, ',', ' ') }} €</h5>
                        </div>
                    </div>
                </div>

                <div class="col mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Utilisateurs</span>
                            <i class="fas fa-user text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['total_users'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col mb-4 px-2">
                    <div class="card h-100 shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center py-2 bg-success">
                            <span class="text-white">Porteurs de projets</span>
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-0">{{ $stats['total_communities'] }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col mb-4 px-2">
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
                <div class="col-lg-4 mb-4 px-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Projets par thématique</span>
                        </div>
                        <div class="card-body p-0 d-flex align-items-center">
                            <div id="projectsByCategoryChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8 mb-4 px-2">
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

            <div class="row mx-0">
                <div class="col-lg-6 mb-4 px-2">
                    <div class="card shadow-sm h-100">
                        <div class="card-header py-2 bg-success">
                            <span class="text-white">Inscriptions mensuelles</span>
                        </div>
                        <div class="card-body p-0 d-flex align-items-center">
                            <div id="monthlyRegistrationsChart" style="width: 100%; height: 300px;"></div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6 mb-4 px-2">
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

        new ApexCharts(document.querySelector("#monthlyRegistrationsChart"), {
            series: [{
                name: "Inscriptions",
                data: @json($monthlyRegistrationsData)
            }],
            chart: {
                type: 'area',
                height: '100%',
                toolbar: { show: false }
            },
            colors: ['#2ecc71'],
            dataLabels: { enabled: false },
            stroke: { curve: 'smooth', width: 3 },
            xaxis: {
                categories: ["Jan", "Fév", "Mar", "Avr", "Mai", "Juin", "Juil", "Aoû", "Sep", "Oct", "Nov", "Déc"]
            },
            tooltip: {
                y: { formatter: function(val) { return val + " nouveaux utilisateurs"; } }
            },
            grid: {
                borderColor: '#f1f1f1',
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

        new ApexCharts(document.querySelector("#topProjectsChart"), {
            series: [{ 
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
                style: {
                    colors: ['#2c3e50']
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
@endpush

@push('styles')
<style>
    .card {
        border-radius: 0.5rem;
        overflow: hidden;
        border: none;
        box-shadow: 0 0.15rem 1rem rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.25rem 1.25rem rgba(0, 0, 0, 0.1);
    }
    
    .card-header {
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        padding: 0.75rem 1.25rem;
    }
    
    .row.mx-0 > .col {
        padding-left: 8px;
        padding-right: 8px;
    }
    
    @media (max-width: 768px) {
        .row.mx-0 > .col {
            flex: 0 0 50%;
            max-width: 50%;
        }
    }
    
    @media (max-width: 576px) {
        .row.mx-0 > .col {
            flex: 0 0 100%;
            max-width: 100%;
        }
        
        .card-header {
            padding: 0.5rem;
        }
        
        .card-body {
            padding: 1rem 0.5rem !important;
        }
    }
    
    .bg-success {
        background-color: #27ae60 !important;
    }
    
    .text-success {
        color: #27ae60 !important;
    }
    
    .alert {
        transition: all 0.3s ease;
    }
</style>
@endpush