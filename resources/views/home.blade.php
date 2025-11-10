@extends('layouts.app')

@section('content')
<div class="row">
    <!-- Tabla de Resumen - Ancho completo -->
    <div class="col-12">
        <div class="card mb-4">
            <h5 class="card-header">Resumen de Próximos Pagos</h5>
            <div class="table-responsive text-nowrap">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th class="hide-mobile">Empresa</th>
                            <th>Próximo Pago</th>
                            <th class="hide-mobile">Estado</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @forelse ($clients as $client)
                            <tr>
                                <td>
                                    <strong>{{ $client->name }}</strong>
                                    <div class="d-block d-md-none small text-muted">
                                        {{ $client->company }}
                                    </div>
                                </td>
                                <td class="hide-mobile">{{ $client->company }}</td>
                                <td>
                                    {{ $client->next_payment_date->format('d/m/Y') }}
                                    @if ($client->payment_status == 'pagado')
                                        <span class="badge bg-label-success me-1 d-block d-md-none mt-1">Pagado</span>
                                    @else
                                        <span class="badge bg-label-warning me-1 d-block d-md-none mt-1">Pendiente</span>
                                    @endif
                                </td>
                                <td class="hide-mobile">
                                    @if ($client->payment_status == 'pagado')
                                        <span class="badge bg-label-success me-1">Pagado</span>
                                    @else
                                        <span class="badge bg-label-warning me-1">Pendiente</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="{{ route('clients.confirmPayment', $client) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="bx bx-check d-inline d-md-none"></i>
                                            <span class="d-none d-md-inline">Confirmar Pago</span>
                                        </button>
                                    </form>

                                    <form action="{{ route('clients.recordCourtesy', $client) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-secondary"
                                            onclick="return confirm('¿Seguro que quieres registrar un mes de cortesía (sin pago)?')">
                                            <i class="bx bx-gift d-inline d-md-none"></i>
                                            <span class="d-none d-md-inline">Cortesía</span>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center">No hay clientes registrados todavía.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Columna izquierda: Calendario -->
    <div class="col-lg-7 col-md-12 mb-4">
        <div class="card calendar-card-container">
            <div class="card-header">
                <h5 class="card-title">Calendario de Pagos</h5>
            </div>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>

    <!-- Columna derecha: Gráfica de Pastel -->
    <div class="col-lg-5 col-md-12 mb-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Resumen Financiero del Mes</h5>
                <small class="text-muted">{{ \Carbon\Carbon::now()->locale('es')->isoFormat('MMMM YYYY') }}</small>
            </div>
            <div class="card-body">
                <div id="pieChart" style="min-height: 350px;"></div>
                
                <div class="mt-4">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="d-flex align-items-center">
                            <span class="badge badge-dot bg-success me-2"></span>
                            <span>Ingresos</span>
                        </span>
                        <span class="text-success fw-semibold">${{ number_format($totalIngresos, 2) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="d-flex align-items-center">
                            <span class="badge badge-dot bg-danger me-2"></span>
                            <span>Gastos</span>
                        </span>
                        <span class="text-danger fw-semibold">${{ number_format($totalGastos, 2) }}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="fw-bold">Ganancia Neta:</span>
                        @if ($totalGanancias >= 0)
                            <span class="text-primary fw-bold h5 mb-0">${{ number_format($totalGanancias, 2) }}</span>
                        @else
                            <span class="text-danger fw-bold h5 mb-0">-${{ number_format(abs($totalGanancias), 2) }}</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('page-scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Calendario FullCalendar
            try {
                var calendarEl = document.getElementById('calendar');
                var events = @json($calendarEvents);

                var calendar = new FullCalendar.Calendar(calendarEl, {
                    initialView: 'dayGridMonth',
                    locale: 'es',
                    headerToolbar: {
                        left: 'prev,next today',
                        center: 'title',
                        right: 'dayGridMonth,dayGridWeek,listMonth'
                    },
                    buttonText: {
                        today: 'Hoy',
                        month: 'Mes',
                        week: 'Semana',
                        list: 'Lista'
                    },
                    dayMaxEvents: true,
                    events: events,
                    eventClick: function(info) {
                        var props = info.event.extendedProps;
                        var status = props.status == 'pendiente' ?
                            'Pendiente ⚠️' :
                            'Pagado ✅';

                        var message =
                            '📋 Cliente: ' + info.event.title + '\n' +
                            '💰 Monto: ' + props.amount + '\n' +
                            '📞 Teléfono: ' + props.phone + '\n' +
                            '🔧 Servicio: ' + props.service + '\n' +
                            '📊 Estado: ' + status + '\n' +
                            '📅 Fecha: ' + info.event.start.toLocaleDateString('es-ES');

                        alert(message);
                    },
                    eventContent: function(arg) {
                        var props = arg.event.extendedProps;
                        var statusIcon = props.status == 'pendiente' ? '⚠️' : '✅';
                        
                        return {
                            html: '<div class="fc-event-main-frame">' +
                                '<div class="fc-event-title-container">' +
                                '<div class="fc-event-title fc-sticky">' + statusIcon + ' ' + arg.event.title + '</div>' +
                                '</div></div>'
                        };
                    },
                    // Aplicar colores según el estado del pago
                    eventDidMount: function(info) {
                        var status = info.event.extendedProps.status;
                        if (status == 'pendiente') {
                            info.el.style.backgroundColor = '#ff9f43'; // Amarillo/Naranja para pendientes
                            info.el.style.borderColor = '#ff9f43';
                        } else {
                            info.el.style.backgroundColor = '#28c76f'; // Verde para pagados
                            info.el.style.borderColor = '#28c76f';
                        }
                    },
                    // Marcar los días con pagos programados
                    dayCellDidMount: function(info) {
                        var dateStr = info.date.toISOString().split('T')[0];
                        var hasEvent = events.find(function(event) {
                            return event.start === dateStr;
                        });
                        
                        if (hasEvent) {
                            var status = hasEvent.extendedProps.status;
                            var dayNumber = info.el.querySelector('.fc-daygrid-day-number');
                            
                            if (dayNumber) {
                                if (status == 'pendiente') {
                                    dayNumber.style.backgroundColor = '#ff9f43';
                                    dayNumber.style.color = '#fff';
                                    dayNumber.style.borderRadius = '50%';
                                    dayNumber.style.width = '30px';
                                    dayNumber.style.height = '30px';
                                    dayNumber.style.display = 'flex';
                                    dayNumber.style.alignItems = 'center';
                                    dayNumber.style.justifyContent = 'center';
                                    dayNumber.style.fontWeight = 'bold';
                                } else {
                                    dayNumber.style.backgroundColor = '#28c76f';
                                    dayNumber.style.color = '#fff';
                                    dayNumber.style.borderRadius = '50%';
                                    dayNumber.style.width = '30px';
                                    dayNumber.style.height = '30px';
                                    dayNumber.style.display = 'flex';
                                    dayNumber.style.alignItems = 'center';
                                    dayNumber.style.justifyContent = 'center';
                                    dayNumber.style.fontWeight = 'bold';
                                }
                            }
                        }
                    }
                });

                calendar.render();
            } catch (e) {
                console.error("Error al renderizar FullCalendar:", e);
            }

            // Gráfica de Pastel con ApexCharts
            try {
                var ingresos = {{ $totalIngresos }};
                var gastos = {{ $totalGastos }};
                var ganancias = {{ $totalGanancias }};

                var options = {
                    series: [ingresos, gastos],
                    chart: {
                        type: 'donut',
                        height: 350,
                        fontFamily: 'inherit'
                    },
                    labels: ['Ingresos', 'Gastos'],
                    colors: ['#28c76f', '#ea5455'],
                    legend: {
                        show: true,
                        position: 'bottom',
                        fontSize: '14px',
                        labels: {
                            colors: '#6e6b7b'
                        }
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                size: '70%',
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '16px',
                                        fontWeight: 600
                                    },
                                    value: {
                                        fontSize: '20px',
                                        fontWeight: 700,
                                        formatter: function(val) {
                                            return '$' + parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                                        }
                                    },
                                    total: {
                                        show: true,
                                        label: 'Ganancia',
                                        fontSize: '16px',
                                        fontWeight: 600,
                                        color: ganancias >= 0 ? '#28c76f' : '#ea5455',
                                        formatter: function(w) {
                                            return '$' + ganancias.toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                                        }
                                    }
                                }
                            }
                        }
                    },
                    dataLabels: {
                        enabled: true,
                        formatter: function(val, opts) {
                            return val.toFixed(1) + '%';
                        }
                    },
                    responsive: [{
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 300
                            },
                            legend: {
                                position: 'bottom'
                            }
                        }
                    }]
                };

                var chart = new ApexCharts(document.querySelector("#pieChart"), options);
                chart.render();
            } catch (e) {
                console.error("Error al renderizar gráfica de pastel:", e);
            }
        });
    </script>
@endpush
