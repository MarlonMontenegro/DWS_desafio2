<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reporte de Balance</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 12px;
            color: #222;
        }
        h2, h3 {
            margin: 6px 0;
        }
        p {
            margin: 4px 0 10px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 14px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }
        th {
            background: #f2f2f2;
            font-weight: bold;
        }
        .resume {
            margin-bottom: 10px;
            padding: 8px;
            border: 1px solid #ddd;
            background: #fafafa;
        }
    </style>
</head>
<body>
    <h2>
        Reporte de Balance
        @if($from || $to)
            ({{ $from ?? 'inicio' }} → {{ $to ?? 'hoy' }})
        @endif
    </h2>

    <div class="resume">
        <strong>Total Entradas:</strong> ${{ number_format($totalEntradas, 2) }} |
        <strong>Total Salidas:</strong> ${{ number_format($totalSalidas, 2) }} |
        <strong>Balance:</strong> ${{ number_format($balance, 2) }}
    </div>

    <h3>Entradas</h3>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entradas as $e)
                <tr>
                    <td>{{ $e->tipo_entrada }}</td>
                    <td>${{ number_format($e->monto, 2) }}</td>
                    <td>{{ $e->fecha }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Sin entradas</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <h3>Salidas</h3>
    <table>
        <thead>
            <tr>
                <th>Tipo</th>
                <th>Monto</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($salidas as $s)
                <tr>
                    <td>{{ $s->tipo_salida }}</td>
                    <td>${{ number_format($s->monto, 2) }}</td>
                    <td>{{ $s->fecha }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">Sin salidas</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
