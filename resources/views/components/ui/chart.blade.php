@props([
    'type' => 'line',
    'series' => [],
    'labels' => [],
    'colors' => null,
    'height' => 300,
    'showYAxis' => true,
    'options' => []
])

@php
    $chartId = 'chart-' . Str::random(8);
@endphp

<div class="w-full" x-data="chartComponent({
    id: '{{ $chartId }}',
    type: '{{ $type }}',
    series: @js($series),
    labels: @js($labels),
    colors: @js($colors),
    height: '{{ $height }}',
    showYAxis: @js($showYAxis),
    customOptions: @js($options)
})">
    <div id="{{ $chartId }}" class="w-full" style="min-height: {{ $height }}px;"></div>
</div>

@once
    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
        <script>
            document.addEventListener('alpine:init', () => {
                Alpine.data('chartComponent', (config) => ({
                    chart: null,
                    
                    init() {
                        // Palette warna premium (Slate, Indigo, Emerald, Amber, Rose)
                        const baseColors = config.colors || ['#0f172a', '#6366f1', '#10b981', '#f59e0b', '#f43f5e'];
                        
                        let options = {
                            chart: {
                                id: config.id,
                                type: config.type,
                                height: config.height,
                                fontFamily: 'Satoshi, sans-serif',
                                toolbar: { show: false },
                                zoom: { enabled: false },
                                background: 'transparent'
                            },
                            colors: baseColors,
                            dataLabels: {
                                enabled: false
                            },
                            theme: { mode: 'light' },
                            stroke: {
                                curve: 'smooth',
                                width: config.type === 'line' || config.type === 'area' ? 3 : 0
                            },
                            grid: {
                                borderColor: '#f1f5f9',
                                strokeDashArray: 4,
                                padding: { top: 0, right: 0, bottom: 0, left: 10 }
                            },
                            tooltip: {
                                theme: 'light',
                                x: { show: true },
                                y: {
                                    formatter: function(val, opts) {
                                        if (val === null || val === undefined) return val;
                                        const seriesIdx = opts ? opts.seriesIndex : 0;
                                        if (seriesIdx === 0 && val >= 1000) {
                                            return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                                        }
                                        if (seriesIdx === 1) {
                                            return new Intl.NumberFormat('id-ID').format(val) + ' Booking';
                                        }
                                        return new Intl.NumberFormat('id-ID').format(val);
                                    }
                                },
                                style: {
                                    fontSize: '12px',
                                    fontFamily: 'Satoshi, sans-serif'
                                }
                            }
                        };
                        
                        // Penyesuaian opsi per tipe grafik
                        if (config.type === 'line' || config.type === 'area' || config.type === 'bar') {
                            options.xaxis = {
                                categories: config.labels,
                                axisBorder: { show: false },
                                axisTicks: { show: false },
                                labels: {
                                    style: {
                                        colors: '#94a3b8',
                                        fontSize: '11px',
                                        fontFamily: 'Satoshi, sans-serif',
                                        fontWeight: 500
                                    }
                                }
                            };

                            // Dual Y-Axis handling for multi-series with vastly different numerical scales (e.g. Millions vs Small integer count)
                            if (Array.isArray(config.series) && config.series.length === 2) {
                                const data1 = config.series[0].data || [];
                                const data2 = config.series[1].data || [];
                                const max1 = Math.max(...data1, 0);
                                const max2 = Math.max(...data2, 0);

                                if (max1 > 100 && max2 < 1000) {
                                    options.yaxis = [
                                        {
                                            show: true,
                                            seriesName: config.series[0].name,
                                            labels: {
                                                show: true,
                                                formatter: function(val) {
                                                    if (val >= 1000000) return (val / 1000000).toFixed(1).replace(/\.0$/, '') + ' Jt';
                                                    if (val >= 1000) return (val / 1000).toFixed(0) + 'k';
                                                    return val;
                                                },
                                                style: { colors: '#64748b', fontSize: '11px', fontFamily: 'Satoshi, sans-serif' }
                                            }
                                        },
                                        {
                                            show: false,
                                            opposite: true,
                                            seriesName: config.series[1].name,
                                            labels: {
                                                show: false
                                            }
                                        }
                                    ];
                                } else {
                                    options.yaxis = {
                                        show: true,
                                        labels: {
                                            show: true,
                                            style: {
                                                colors: '#94a3b8',
                                                fontSize: '11px',
                                                fontFamily: 'Satoshi, sans-serif',
                                                fontWeight: 500
                                            }
                                        }
                                    };
                                }
                            } else {
                                options.yaxis = {
                                    show: true,
                                    labels: {
                                        show: true,
                                        style: {
                                            colors: '#94a3b8',
                                            fontSize: '11px',
                                            fontFamily: 'Satoshi, sans-serif',
                                            fontWeight: 500
                                        }
                                    }
                                };
                            }
                        }
                        
                        if (config.type === 'area') {
                            options.fill = {
                                type: 'gradient',
                                gradient: {
                                    shadeIntensity: 1,
                                    opacityFrom: 0.4,
                                    opacityTo: 0.05,
                                    stops: [0, 100]
                                }
                            };
                        }
                        
                        if (config.type === 'bar') {
                            options.plotOptions = {
                                bar: {
                                    horizontal: false,
                                    columnWidth: '50%',
                                    borderRadius: 5,
                                    borderRadiusApplication: 'end'
                                }
                            };
                        }
                        
                        if (config.type === 'donut' || config.type === 'pie') {
                            options.labels = config.labels;
                            options.legend = {
                                position: 'bottom',
                                fontFamily: 'Satoshi, sans-serif',
                                labels: { colors: '#475569' }
                            };
                            options.stroke = { show: true, width: 2, colors: ['#ffffff'] };
                        }
                        
                        if (config.type === 'radialBar') {
                            options.labels = config.labels;
                            options.plotOptions = {
                                radialBar: {
                                    dataLabels: {
                                        name: {
                                            fontSize: '16px',
                                            fontFamily: 'Satoshi, sans-serif',
                                            color: '#475569'
                                        },
                                        value: {
                                            fontSize: '14px',
                                            fontFamily: 'Satoshi, sans-serif',
                                            color: '#1e293b',
                                            formatter: function (val) {
                                                return val + "%"
                                            }
                                        },
                                        total: {
                                            show: true,
                                            label: 'Average',
                                            fontFamily: 'Satoshi, sans-serif',
                                            color: '#475569',
                                            formatter: function (w) {
                                                const sum = w.config.series.reduce((a, b) => a + b, 0);
                                                return Math.round(sum / w.config.series.length) + '%';
                                            }
                                        }
                                    },
                                    track: {
                                        background: '#f8fafc',
                                        strokeWidth: '97%',
                                    }
                                }
                            };
                        }
                        
                        // Set data series
                        options.series = config.series;
                        
                        // Merge opsi kustom jika dikirimkan
                        if (config.customOptions) {
                            options = this.deepMerge(options, config.customOptions);
                        }
                        
                        // Inisialisasi chart secara asinkron setelah DOM siap
                        setTimeout(() => {
                            const el = document.getElementById(config.id);
                            if (el) {
                                this.chart = new ApexCharts(el, options);
                                this.chart.render();
                            }
                        }, 50);
                    },
                    
                    deepMerge(target, source) {
                        for (const key in source) {
                            if (source[key] instanceof Object && key in target) {
                                Object.assign(source[key], this.deepMerge(target[key], source[key]));
                            }
                        }
                        Object.assign(target || {}, source);
                        return target;
                    }
                }));
            });
        </script>
    @endpush
@endonce
