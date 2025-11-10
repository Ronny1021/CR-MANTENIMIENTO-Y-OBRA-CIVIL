<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>{{ config('app.', 'Desprendible De Nómina') }}</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo_icon.ico') }}">

    <!-- Incluir estilos desde archivo físico -->
    <style>
        {!! file_get_contents(public_path('css/pdf_nomina.css')) !!}
    </style>
</head>

<body>
    <img src="{{ public_path('images/logo_icon.png') }}" alt="Logo" style="width: 80px; height: auto; margin-bottom: 10px;">
    <div class="payroll-container">
        
        <div class="header">
            COMPROBANTE DE PAGO DE NÓMINA
        </div>

        <div style="text-align: right; font-size: 9pt; margin-bottom: 10px;">
            <strong>Generado por:</strong> {{ $desprendible['generado_por'] ?? 'N/A' }}<br>
            <strong>Fecha de generación:</strong> {{ $desprendible['fecha_generacion'] ?? 'N/A' }}<br>
            <strong>Periodo:</strong> {{ \Carbon\Carbon::parse($desprendible['periodo']['inicio'])->format('d/m/Y') }}
            al {{ \Carbon\Carbon::parse($desprendible['periodo']['fin'])->format('d/m/Y') }}
        </div>

        <table class="data-header-table">
            <tr>
                <td class="company-info">
                    <p style="font-size: 14pt; font-weight: bold; color: #000;">
                        {{ $desprendible['empresa']['nombre'] ?? 'NOMBRE DE LA COMPAÑÍA' }}
                    </p>
                    <p>NIT: {{ $desprendible['empresa']['nit'] ?? '256.820.100-2' }}</p>
                    <p>Dirección: {{ $desprendible['empresa']['direccion'] ?? 'Carrera 1 # 1-1, Cali/Valle Del Cauca' }}
                    </p>
                    <p>Periodo de Pago: {{ $desprendible['periodo']['inicio'] ?? 'DD/MM/AAAA' }}
                        al {{ $desprendible['periodo']['fin'] ?? 'DD/MM/AAAA' }}</p>
                </td>
                <td class="employee-info">
                    <p><strong class="label">Nombres:</strong> <span
                            class="value">{{ $desprendible['empleado']['nombres'] ?? 'N/A' }}</span></p>
                    <p><strong class="label">Cédula:</strong> <span
                            class="value">{{ $desprendible['empleado']['cedula'] ?? 'N/A' }}</span></p>
                    <p><strong class="label">Cargo:</strong> <span
                            class="value">{{ $desprendible['empleado']['cargo'] ?? 'N/A' }}</span></p>
                    <p><strong class="label">Salario Base:</strong>
                        <span
                            class="value">${{ number_format($desprendible['empleado']['salario_base'] ?? 0, 0, ',', '.') }}</span>
                    </p>
                    <p><strong class="label">Banco / Cuenta:</strong>
                        <span class="value">{{ $desprendible['empleado']['banco'] ?? 'N/A' }} /
                            {{ $desprendible['empleado']['cuenta'] ?? 'N/A' }}</span>
                    </p>
                </td>
            </tr>
        </table>

        <div class="section-title ingresos">DEVENGOS</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="concept">Concepto</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @php $totalDevengos = 0; @endphp
                @foreach ($desprendible['devengos'] ?? [] as $devengo)
                    <tr>
                        <td class="concept">{{ $devengo['concepto'] }}</td>
                        <td>${{ number_format($devengo['valor'], 0, ',', '.') }}</td>
                    </tr>
                    @php $totalDevengos += $devengo['valor']; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>TOTAL DEVENGOS</td>
                    <td>${{ number_format($totalDevengos, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <div class="section-title deducciones">DEDUCCIONES</div>
        <table class="data-table">
            <thead>
                <tr>
                    <th class="concept">Concepto</th>
                    <th>Valor</th>
                </tr>
            </thead>
            <tbody>
                @php $totalDeducciones = 0; @endphp
                @foreach ($desprendible['deducciones'] ?? [] as $deduccion)
                    <tr>
                        <td class="concept">{{ $deduccion['concepto'] }}</td>
                        <td>${{ number_format($deduccion['valor'], 0, ',', '.') }}</td>
                    </tr>
                    @php $totalDeducciones += $deduccion['valor']; @endphp
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td>TOTAL DEDUCCIONES</td>
                    <td>${{ number_format($totalDeducciones, 0, ',', '.') }}</td>
                </tr>
            </tfoot>
        </table>

        <table class="footer-totals-table">
            <tr>
                <td>
                    <table class="neto-a-pagar-box">
                        <tr>
                            <th>NETO A PAGAR</th>
                            <td class="neto-value">
                                ${{ number_format($totalDevengos - $totalDeducciones, 0, ',', '.') }}</td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>

        <div class="signature-section">
            <p class="disclaimer">
                Recibí la cantidad líquida de la presente nómina y declaro haber recibido el salario correspondiente al
                período indicado.
            </p>
            <table style="width: 100%; margin-top: 50px;">
                <tr>
                    <td style="width: 50%; text-align: center;">
                        <div class="signature-line"></div>
                        <div class="signature-label">Firma del Empleador</div>
                    </td>
                    <td style="width: 50%; text-align: center;">
                        <div class="signature-line"></div>
                        <div class="signature-label">Firma del Empleado</div>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>

</html>
