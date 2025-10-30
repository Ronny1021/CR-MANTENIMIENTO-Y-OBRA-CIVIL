<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Certificado Laboral de cr</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 14px; line-height: 1.6; }
        .titulo { text-align: center; font-weight: bold; font-size: 18px; margin-bottom: 20px; }
        .contenido { text-align: justify; }
        .firma { margin-top: 60px; text-align: center; }
    </style>
</head>
<body>
    <div class="titulo">CERTIFICADO LABORAL</div>

    <div class="contenido">
        CR MANTENIMIENTO Y OBRACIVIL certifica que el(la) señor(a)
        <strong>{{ $empleado->Nombres }} {{ $empleado->Apellidos }}</strong>,
        identificado(a) con documento número <strong>{{ $empleado->Documento }}</strong>,
        ha trabajado con nosotros desempeñando funciones asignadas en diferentes proyectos de mantenimiento y obra civil este documento es para el cerficado.

        Durante su tiempo de vinculación, ha acumulado un total de <strong>{{ number_format($totalHoras, 2, ',', '.') }}</strong> horas trabajadas,
        según los registros de nómina de la empresa.

        Este certificado se expide a solicitud del interesado en la ciudad de Cali, el día {{ $fechaActual }}.
    </div>

    <div class="firma">
        ___________________________<br>
        Departamento de Talento Humano<br>
        CR MANTENIMIENTO Y OBRACIVIL
    </div>
</body>
</html>