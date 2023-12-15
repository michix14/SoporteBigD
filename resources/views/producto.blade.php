@extends('adminlte::page')

@section('title', 'Gráfica de Productos')

@section('content_header')
    <h1>Gráfica de Productos</h1>
@stop

@section('content')
    <form action="{{ route('producto.index') }}" method="get">
        @csrf
        <label for="from">Desde:</label>
        <input type="date" name="from" value="{{ app('request')->input('from') }}" required>

        <label for="to">Hasta:</label>
        <input type="date" name="to" value="{{ app('request')->input('to') }}" required>

        <button type="submit">Filtrar</button>
    </form>

    <div style="width: 80%; margin: auto;">
        <canvas id="barChart" width="800" height="400"></canvas>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const productos = {!! json_encode($productos) !!};
        const repeticiones = {!! json_encode($repeticiones) !!};

        const ctx = document.getElementById('barChart').getContext('2d');
        const barChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: productos,
                datasets: [{
                    label: 'Repeticiones',
                    data: repeticiones,
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@stop
