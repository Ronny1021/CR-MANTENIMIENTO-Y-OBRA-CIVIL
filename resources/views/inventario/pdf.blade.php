<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inventario Disponible</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        h2 { text-align: center; margin-bottom: 10px; }
        p { margin: 5px 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #f2f2f2; }
        .footer { margin-top: 20px; text-align: right; font-size: 11px; color: #555; }
    </style>
</head>
<body>
    <h2>Inventario por Disponibilidad</h2>

    <p><strong>Fecha de generación:</strong> {{ \Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e Y, h:i A') }}</p>

    <p><strong>Total herramientas:</strong> {{ is_countable($inventario) ? count($inventario) : 0 }}</p>

    <table>
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Tipo</th>
                <th>Categoría</th>
                <th>Ubicación</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            @if(is_countable($inventario) && count($inventario))
                @foreach ($inventario as $item)
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{{ $item->tipo_herramienta }}</td>
                        <td>{{ $item->categoria }}</td>
                        <td>{{ $item->ubicacion }}</td>
                        <td>{{ $item->disponibilidad }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="5" style="text-align: center;">No hay herramientas registradas.</td>
                </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        Generado el {{ \Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e Y, h:i A') }}
    </div>
</body>
</html>