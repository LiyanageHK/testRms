@extends('layouts.app')

@section('content')
<div class="container-fluid px-4">
    <!-- Status Message -->
    @if($status)
    <div class="alert alert-success alert-dismissible fade show" role="alert" id="statusAlert">
        {{ $status }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Welcome Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="display-6 mb-0">Welcome Back, {{ Auth::user()->name }}!</h1>
            <p class="text-muted">Here's what's happening in your restaurant today.</p>
        </div>
        <div class="text-end">
            <p class="mb-0" id="currentTime"></p>
            <p class="text-muted mb-0" id="currentDate"></p>
        </div>
    </div>

    <!-- Dashboard Overview -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 zoom-on-hover">
                <div class="card-body position-relative">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon bg-primary text-white me-3">
                            <i class="fas fa-box fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Total Items</h6>
                            <h2 class="card-title mb-0 display-6">{{ $totalItems }}</h2>
                        </div>
                    </div>
                    <p class="mb-0 text-success">
                        <i class="fas fa-box-open me-1"></i>
                        Inventory Items
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 zoom-on-hover">
                <div class="card-body position-relative">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon bg-success text-white me-3">
                            <i class="fas fa-pizza-slice fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Total Products</h6>
                            <h2 class="card-title mb-0 display-6">{{ $totalProducts }}</h2>
                        </div>
                    </div>
                    <p class="mb-0 text-success">
                        <i class="fas fa-utensils me-1"></i>
                        Available Products
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 zoom-on-hover">
                <div class="card-body position-relative">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon bg-info text-white me-3">
                            <i class="fas fa-check-circle fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Active Products</h6>
                            <h2 class="card-title mb-0 display-6">{{ $activeProducts }}</h2>
                        </div>
                    </div>
                    <p class="mb-0 text-info">
                        <i class="fas fa-clock me-1"></i>
                        Currently Active
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 zoom-on-hover">
                <div class="card-body position-relative">
                    <div class="d-flex align-items-center mb-3">
                        <div class="stats-icon bg-warning text-white me-3">
                            <i class="fas fa-tags fa-lg"></i>
                        </div>
                        <div>
                            <h6 class="card-subtitle text-muted mb-1">Categories</h6>
                            <h2 class="card-title mb-0 display-6">{{ $totalCategories }}</h2>
                        </div>
                    </div>
                    <p class="mb-0 text-warning">
                        <i class="fas fa-layer-group me-1"></i>
                        Item Categories
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-0">Products Overview</h5>
                        <p class="text-muted small mb-0">Last 6 months activity</p>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-outline-secondary">
                            <i class="fas fa-download me-1"></i> Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="salesChart" height="300"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Product Status</h5>
                    <p class="text-muted small mb-0">Active vs Inactive products</p>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <canvas id="orderStatusChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-transparent border-0">
                    <h5 class="mb-0">Quick Actions</h5>
                    <p class="text-muted small mb-0">Frequently used actions</p>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-md-3">
                            <a href="{{ url('/admin/items/create') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-primary bg-opacity-10 rounded p-4 text-center zoom-on-hover">
                                    <i class="fas fa-plus-circle fa-2x text-primary mb-3"></i>
                                    <h6 class="mb-0 text-primary">Add New Item</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('/admin/production/create') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-success bg-opacity-10 rounded p-4 text-center zoom-on-hover">
                                    <i class="fas fa-pizza-slice fa-2x text-success mb-3"></i>
                                    <h6 class="mb-0 text-success">Create Product</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('/admin/categories/create') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-info bg-opacity-10 rounded p-4 text-center zoom-on-hover">
                                    <i class="fas fa-tags fa-2x text-info mb-3"></i>
                                    <h6 class="mb-0 text-info">Add Category</h6>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ url('/admin/role/create') }}" class="text-decoration-none">
                                <div class="quick-action-card bg-warning bg-opacity-10 rounded p-4 text-center zoom-on-hover">
                                    <i class="fas fa-user-plus fa-2x text-warning mb-3"></i>
                                    <h6 class="mb-0 text-warning">Add Role</h6>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.stats-icon {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.zoom-on-hover {
    transition: transform 0.2s ease-in-out;
}

.zoom-on-hover:hover {
    transform: translateY(-5px);
}

.quick-action-card {
    transition: all 0.3s ease;
    cursor: pointer;
}

.quick-action-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.display-6 {
    font-size: 1.8rem;
    font-weight: 600;
}
</style>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Update current time and date
        function updateDateTime() {
            const now = new Date();
            document.getElementById('currentTime').textContent = now.toLocaleTimeString();
            document.getElementById('currentDate').textContent = now.toLocaleDateString('en-US', { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            });
        }
        updateDateTime();
        setInterval(updateDateTime, 1000);

        // Status message fade out
        const statusAlert = document.getElementById('statusAlert');
        if (statusAlert) {
            setTimeout(() => {
                statusAlert.classList.remove('show');
                setTimeout(() => {
                    statusAlert.remove();
                }, 150);
            }, 3000);
        }

        // Monthly Products Chart
        const salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_column($monthlySales, 'month')) !!},
                datasets: [{
                    label: 'Products Added',
                    data: {!! json_encode(array_column($monthlySales, 'count')) !!},
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#0d6efd',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1,
                            font: {
                                size: 12
                            }
                        },
                        grid: {
                            display: true,
                            drawBorder: false
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        ticks: {
                            font: {
                                size: 12
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // Product Status Chart
        const orderCtx = document.getElementById('orderStatusChart').getContext('2d');
        new Chart(orderCtx, {
            type: 'doughnut',
            data: {
                labels: ['Inactive', 'Active'],
                datasets: [{
                    data: [
                        {{ $totalProducts - $activeProducts }},
                        {{ $activeProducts }}
                    ],
                    backgroundColor: [
                        'rgba(220, 53, 69, 0.8)',
                        'rgba(40, 167, 69, 0.8)'
                    ],
                    borderColor: [
                        'rgba(220, 53, 69, 1)',
                        'rgba(40, 167, 69, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                cutout: '75%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            font: {
                                size: 12
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endsection
