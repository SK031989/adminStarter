@extends('dashboard::layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    
    <!-- ========================================== -->
    <!-- ROW 1: HEADER SECTION                      -->
    <!-- ========================================== -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900 dark:text-white">Dashboard</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-1">Welcome back, {{ auth()->user()->name ?? 'Administrator' }}! Here is what's happening with your SaaS platform today.</p>
        </div>
        
        <!-- Controls: Date Range Selector & Export -->
        <div class="flex items-center gap-3 self-start md:self-auto">
            <div class="relative">
                <select id="date-range-select" class="appearance-none pl-10 pr-8 py-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl text-sm font-semibold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-purple-500 cursor-pointer">
                    <option value="7">Last 7 Days</option>
                    <option value="30" selected>Last 30 Days</option>
                    <option value="90">Last 9 months</option>
                    <option value="365">This Year</option>
                </select>
                <div class="absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <i data-lucide="calendar" class="w-4 h-4"></i>
                </div>
                <div class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400">
                    <i data-lucide="chevron-down" class="w-4 h-4"></i>
                </div>
            </div>

            <button type="button" class="flex items-center gap-2 px-4 py-2 bg-purple-600 hover:bg-purple-700 active:scale-95 text-white text-sm font-semibold rounded-xl shadow-md transition duration-150">
                <i data-lucide="download" class="w-4 h-4"></i>
                <span>Export</span>
            </button>
        </div>
    </div>

    <!-- ========================================== -->
    <!-- ROW 2: KPI CARDS SECTION                   -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-2 xl:grid-cols-4 gap-6">
        
        <!-- Total Sales Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 border-l-4 border-l-purple-500 p-4 rounded-2xl shadow-xs flex items-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
            <div class="p-3 bg-purple-100 dark:bg-purple-500/10 text-purple-600 rounded-2xl shadow-inner shrink-0">
                <i data-lucide="badge-dollar-sign" class="w-6 h-6"></i>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Sales</span>
                <h3 class="text-xl xl:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $metrics['sales']['value'] }}</h3>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-100 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded-full">
                        <i data-lucide="trending-up" class="w-3 h-3"></i>
                        {{ $metrics['sales']['change'] }}
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">vs last month</span>
                </div>
            </div>
        </div>

        <!-- Total Users Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 border-l-4 border-l-blue-500 p-4 rounded-2xl shadow-xs flex items-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
            <div class="p-3 bg-blue-100 dark:bg-blue-50/10 text-blue-600 rounded-2xl shadow-inner shrink-0">
                <i data-lucide="users" class="w-6 h-6"></i>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Total Users</span>
                <h3 class="text-xl xl:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $metrics['users']['value'] }}</h3>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-100 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded-full">
                        <i data-lucide="trending-up" class="w-3 h-3"></i>
                        {{ $metrics['users']['change'] }}
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">vs last month</span>
                </div>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 border-l-4 border-l-orange-500 p-4 rounded-2xl shadow-xs flex items-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
            <div class="p-3 bg-orange-100 dark:bg-orange-500/10 text-orange-600 rounded-2xl shadow-inner shrink-0">
                <i data-lucide="shopping-bag" class="w-6 h-6"></i>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Orders</span>
                <h3 class="text-xl xl:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $metrics['orders']['value'] }}</h3>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-rose-600 bg-rose-100 dark:bg-rose-500/10 px-1.5 py-0.5 rounded-full">
                        <i data-lucide="trending-down" class="w-3 h-3"></i>
                        {{ $metrics['orders']['change'] }}
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">vs last month</span>
                </div>
            </div>
        </div>

        <!-- Revenue Card -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 border-l-4 border-l-emerald-500 p-4 rounded-2xl shadow-xs flex items-center gap-3 transition-all duration-300 hover:shadow-lg hover:-translate-y-0.5">
            <div class="p-3 bg-emerald-100 dark:bg-emerald-500/10 text-emerald-600 rounded-2xl shadow-inner shrink-0">
                <i data-lucide="line-chart" class="w-6 h-6"></i>
            </div>
            <div class="space-y-1">
                <span class="text-xs font-semibold text-slate-500 uppercase tracking-wider">Revenue</span>
                <h3 class="text-xl xl:text-2xl font-bold tracking-tight text-slate-900 dark:text-white">{{ $metrics['revenue']['value'] }}</h3>
                <div class="flex items-center gap-1.5">
                    <span class="inline-flex items-center gap-0.5 text-xs font-bold text-emerald-600 bg-emerald-100 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded-full">
                        <i data-lucide="trending-up" class="w-3 h-3"></i>
                        {{ $metrics['revenue']['change'] }}
                    </span>
                    <span class="text-[11px] text-slate-400 font-medium">vs last month</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- ROW 3: CHARTS SECTION                      -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Sales Overview Chart (Area/Line) -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 p-6 rounded-2xl shadow-xs flex flex-col justify-between">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h5 class="font-bold text-sm text-slate-900 dark:text-white">Sales Overview</h5>
                    <p class="text-xs text-slate-400">Monthly revenue compared with total monthly sales figures</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-2.5 h-2.5 rounded-full bg-purple-500"></span>
                    <span class="text-xs font-medium text-slate-500 mr-3">Sales</span>
                    <span class="w-2.5 h-2.5 rounded-full bg-blue-500"></span>
                    <span class="text-xs font-medium text-slate-500">Revenue</span>
                </div>
            </div>
            <div class="flex-grow w-full min-h-[310px] relative">
                <div id="sales-area-chart" class="w-full min-h-[310px]"></div>
            </div>
        </div>

        <!-- Order Status Chart (Donut) -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 p-6 rounded-2xl shadow-xs flex flex-col justify-between">
            <div>
                <h5 class="font-bold text-sm text-slate-900 dark:text-white">Order Status</h5>
                <p class="text-xs text-slate-400 mb-4 font-medium">Distribution of current order statuses</p>
            </div>
            <div class="flex-grow flex items-center justify-center w-full min-h-[240px] relative">
                <div id="order-donut-chart" class="w-full min-h-[240px] flex justify-center"></div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4 pt-4 border-t border-slate-100 dark:border-slate-800/60">
                <div class="text-center">
                    <span class="text-[10px] text-slate-400 block font-semibold">SUCCESS RATE</span>
                    <span class="text-xs font-bold text-emerald-600">95.2%</span>
                </div>
                <div class="text-center border-l border-slate-100 dark:border-slate-800/60">
                    <span class="text-[10px] text-slate-400 block font-semibold">TOTAL ORDERS</span>
                    <span class="text-xs font-bold text-slate-800 dark:text-slate-200">1,482</span>
                </div>
            </div>
        </div>

    </div>

    <!-- ========================================== -->
    <!-- ROW 4: RECENT ORDERS & TOP PRODUCTS        -->
    <!-- ========================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Recent Orders Table -->
        <div class="lg:col-span-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 p-6 rounded-2xl shadow-xs overflow-hidden flex flex-col">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h5 class="font-bold text-sm text-slate-900 dark:text-white">Recent Orders</h5>
                    <p class="text-xs text-slate-400">Overview of the last transactions processed through your gateway</p>
                </div>
                <a href="#" class="px-3.5 py-1.5 bg-slate-50 hover:bg-slate-100 dark:bg-slate-850 dark:hover:bg-slate-800 text-slate-600 dark:text-slate-300 text-xs font-semibold rounded-xl transition duration-150 no-underline">View All</a>
            </div>

            <!-- Table content -->
            <div class="overflow-x-auto -mx-6">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-100 dark:border-slate-800/80 text-[10px] uppercase font-bold text-slate-400 tracking-wider">
                            <th class="py-3 px-6">Order ID</th>
                            <th class="py-3 px-6">Customer</th>
                            <th class="py-3 px-6">Product</th>
                            <th class="py-3 px-6">Amount</th>
                            <th class="py-3 px-6 text-center">Status</th>
                            <th class="py-3 px-6">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800/50">
                        @foreach($recentOrders as $order)
                        <tr class="text-sm hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition duration-100">
                            <td class="py-3.5 px-6 font-semibold text-slate-900 dark:text-white text-xs">{{ $order['id'] }}</td>
                            <td class="py-3.5 px-6">
                                <div class="flex items-center gap-2.5">
                                    <img src="{{ $order['avatar'] }}" alt="Avatar" class="w-7 h-7 rounded-lg">
                                    <div>
                                        <div class="font-semibold text-xs text-slate-800 dark:text-slate-200">{{ $order['customer'] }}</div>
                                        <div class="text-[10px] text-slate-400">{{ $order['email'] }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-6 text-xs font-medium text-slate-600 dark:text-slate-300">{{ $order['product'] }}</td>
                            <td class="py-3.5 px-6 text-xs font-bold text-slate-800 dark:text-slate-200">{{ $order['amount'] }}</td>
                            <td class="py-3.5 px-6 text-center">
                                @if($order['status'] === 'Completed')
                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-bold text-emerald-600 dark:text-emerald-400 bg-emerald-100 dark:bg-emerald-500/10 rounded-full">Completed</span>
                                @elseif($order['status'] === 'Pending')
                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-bold text-amber-600 dark:text-amber-400 bg-amber-100 dark:bg-amber-500/10 rounded-full">Pending</span>
                                @else
                                    <span class="inline-flex px-2 py-0.5 text-[10px] font-bold text-rose-600 dark:text-rose-400 bg-rose-100 dark:bg-rose-500/10 rounded-full">Cancelled</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-6 text-[11px] text-slate-400 font-medium">{{ $order['date'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Products List -->
        <div class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800/80 p-6 rounded-2xl shadow-xs flex flex-col justify-between">
            <div>
                <h5 class="font-bold text-sm text-slate-900 dark:text-white">Top Products</h5>
                <p class="text-xs text-slate-400 mb-4">SaaS subscription shares based on customer conversions</p>
            </div>
            
            <div class="space-y-4 flex-grow">
                @foreach($topProducts as $prod)
                <div class="space-y-1.5">
                    <div class="flex items-center justify-between text-xs font-medium">
                        <div>
                            <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $prod['name'] }}</span>
                            <span class="text-[10px] text-slate-400">{{ $prod['category'] }}</span>
                        </div>
                        <div class="text-right">
                            <span class="font-bold text-slate-800 dark:text-slate-200 block">{{ $prod['revenue'] }}</span>
                            <span class="text-[10px] text-slate-400">{{ $prod['sales'] }} sales</span>
                        </div>
                    </div>
                    <!-- Custom progress bar container -->
                    <div class="w-full h-1.5 bg-slate-100 dark:bg-slate-800 rounded-full overflow-hidden">
                        <div class="h-full rounded-full {{ $prod['color'] }}" style="width: {{ $prod['percentage'] }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Fetch current theme state
        function getIsDarkMode() {
            return document.documentElement.classList.contains('dark');
        }

        // ApexChart Options Helper for theme adaptation
        function getChartColorsTheme(isDark) {
            return {
                gridColor: isDark ? '#1e293b' : '#f1f5f9',
                labelColor: isDark ? '#94a3b8' : '#64748b'
            };
        }

        // ----------------------------------------------------
        // Chart 1: Sales Overview (Area Chart)
        // ----------------------------------------------------
        const salesChartData = @json($salesChart);
        let chartTheme = getChartColorsTheme(getIsDarkMode());

        const salesOptions = {
            chart: {
                type: 'area',
                height: 310,
                toolbar: { show: false },
                zoom: { enabled: false },
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                background: 'transparent'
            },
            theme: {
                mode: getIsDarkMode() ? 'dark' : 'light'
            },
            colors: ['#a855f7', '#3b82f6'],
            dataLabels: { enabled: false },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            series: [
                {
                    name: 'Sales ($)',
                    data: salesChartData.sales
                },
                {
                    name: 'Revenue ($)',
                    data: salesChartData.revenue
                }
            ],
            fill: {
                type: 'gradient',
                gradient: {
                    shadeIntensity: 1,
                    opacityFrom: 0.35,
                    opacityTo: 0.05,
                    stops: [0, 90, 100]
                }
            },
            xaxis: {
                categories: salesChartData.categories,
                labels: {
                    style: {
                        colors: chartTheme.labelColor,
                        fontSize: '11px',
                        fontWeight: 500
                    }
                },
                axisBorder: { show: false },
                axisTicks: { show: false }
            },
            yaxis: {
                labels: {
                    formatter: function(val) {
                        return '$' + val.toLocaleString();
                    },
                    style: {
                        colors: chartTheme.labelColor,
                        fontSize: '11px',
                        fontWeight: 500
                    }
                }
            },
            grid: {
                borderColor: chartTheme.gridColor,
                strokeDashArray: 5,
                xaxis: { lines: { show: false } },
                yaxis: { lines: { show: true } }
            },
            tooltip: {
                theme: getIsDarkMode() ? 'dark' : 'light',
                y: {
                    formatter: function(val) {
                        return '$' + val.toLocaleString();
                    }
                }
            },
            legend: { show: false }
        };

        const salesChart = new ApexCharts(document.querySelector("#sales-area-chart"), salesOptions);
        salesChart.render();

        // ----------------------------------------------------
        // Chart 2: Order Status (Donut Chart)
        // ----------------------------------------------------
        const donutChartData = @json($orderStatusChart);
        
        const donutOptions = {
            chart: {
                type: 'donut',
                height: 240,
                fontFamily: 'Plus Jakarta Sans, sans-serif',
                background: 'transparent'
            },
            theme: {
                mode: getIsDarkMode() ? 'dark' : 'light'
            },
            series: donutChartData.series,
            labels: donutChartData.labels,
            colors: ['#10b981', '#f59e0b', '#3b82f6', '#ef4444'], // green, orange, blue, red
            legend: {
                show: true,
                position: 'bottom',
                fontSize: '11px',
                fontWeight: 600,
                markers: { radius: 12 },
                itemMargin: { horizontal: 8, vertical: 4 }
            },
            dataLabels: {
                enabled: false
            },
            plotOptions: {
                pie: {
                    donut: {
                        size: '75%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '12px',
                                fontWeight: 500
                            },
                            value: {
                                show: true,
                                fontSize: '20px',
                                fontWeight: 700,
                                formatter: function(val) {
                                    return val + '%';
                                }
                            },
                            total: {
                                show: true,
                                label: 'Completed',
                                formatter: function(w) {
                                    return '65%';
                                }
                            }
                        }
                    }
                }
            },
            tooltip: {
                theme: getIsDarkMode() ? 'dark' : 'light'
            }
        };

        const donutChart = new ApexCharts(document.querySelector("#order-donut-chart"), donutOptions);
        donutChart.render();

        // ----------------------------------------------------
        // Theme Switcher Sync Event Listener
        // ----------------------------------------------------
        window.addEventListener('theme-changed', (e) => {
            const isDark = e.detail.isDark;
            const updatedTheme = getChartColorsTheme(isDark);
            
            // Update Sales Chart
            salesChart.updateOptions({
                theme: {
                    mode: isDark ? 'dark' : 'light'
                },
                xaxis: {
                    labels: {
                        style: { colors: updatedTheme.labelColor }
                    }
                },
                yaxis: {
                    labels: {
                        style: { colors: updatedTheme.labelColor }
                    }
                },
                grid: {
                    borderColor: updatedTheme.gridColor
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light'
                }
            });

            // Update Donut Chart
            donutChart.updateOptions({
                theme: {
                    mode: isDark ? 'dark' : 'light'
                },
                tooltip: {
                    theme: isDark ? 'dark' : 'light'
                }
            });
        });
    });
</script>
@endpush
