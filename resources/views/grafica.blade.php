@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('content')
    <p>Graficos de soporte</p>
    @parent <!-- Conserva los scripts anteriores si los hubiera -->

    <form action="{{ route('grafica.index') }}" method="GET">
        <label for="start_date">Fecha de inicio:</label>
        <input type="date" id="start_date" name="start_date" value="{{ $startDate }}">

        <label for="end_date">Fecha de fin:</label>
        <input type="date" id="end_date" name="end_date" value="{{ $endDate }}">

        <button type="submit">Filtrar</button>
    </form>

    <canvas id="lineChart" width="800" height="400"></canvas>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const dataDiferencia = {!! json_encode($dataDiferencia) !!};

        const labels = dataDiferencia.map(entry => entry.fecha);
        const valoresDiferencia = dataDiferencia.map(entry => entry.diferencia);

        const ctx = document.getElementById('lineChart').getContext('2d');
        const lineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Diferencia (Positivos - Negativos)',
                        data: valoresDiferencia,
                        borderColor: 'blue',
                        backgroundColor: 'rgba(0, 0, 255, 0.2)',
                        tension: 0.3,
                    },
                ],
            },
            options: {
                // Configuración adicional del gráfico
            },
        });
    </script>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop
