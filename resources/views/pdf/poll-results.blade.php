<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados - {{ $poll->title }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'DejaVu Sans', sans-serif;
            padding: 40px;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }

        .header h1 {
            color: #1e40af;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .header p {
            color: #666;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .stats {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
            text-align: center;
        }

        .stats h2 {
            color: #1e40af;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            margin-top: 10px;
        }

        .stat-item {
            display: table-cell;
            text-align: center;
            padding: 10px;
        }

        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
        }

        .stat-label {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }

        .results-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        .results-table thead {
            background-color: #2563eb;
            color: white;
        }

        .results-table th {
            padding: 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
        }

        .results-table td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 13px;
        }

        .results-table tbody tr:hover {
            background-color: #f3f4f6;
        }

        .candidate-name {
            font-weight: bold;
            color: #1f2937;
        }

        .party-info {
            color: #6b7280;
            font-size: 11px;
        }

        .votes-bar {
            height: 20px;
            background-color: #e5e7eb;
            border-radius: 4px;
            position: relative;
            overflow: hidden;
        }

        .votes-bar-fill {
            height: 100%;
            border-radius: 4px;
            background-color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            padding-right: 8px;
            color: white;
            font-size: 11px;
            font-weight: bold;
        }

        .percentage {
            font-size: 18px;
            font-weight: bold;
            color: #2563eb;
        }

        .votes-count {
            color: #6b7280;
            font-size: 12px;
        }

        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1e40af;
            margin-top: 30px;
            margin-bottom: 15px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 8px;
        }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 11px;
        }

        .page-break {
            page-break-after: always;
        }

        .rank-badge {
            display: inline-block;
            width: 25px;
            height: 25px;
            border-radius: 50%;
            background-color: #2563eb;
            color: white;
            text-align: center;
            line-height: 25px;
            font-weight: bold;
            font-size: 12px;
            margin-right: 10px;
        }

        .rank-badge.gold {
            background: linear-gradient(135deg, #ffd700, #ffed4e);
            color: #854d0e;
        }

        .rank-badge.silver {
            background: linear-gradient(135deg, #c0c0c0, #e8e8e8);
            color: #1f2937;
        }

        .rank-badge.bronze {
            background: linear-gradient(135deg, #cd7f32, #e6a85c);
            color: #78350f;
        }

        .additional-row td {
            font-style: italic;
            color: #4b5563;
        }

        .additional-label {
            font-weight: bold;
            color: #374151;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $poll->title }}</h1>
        @if($poll->description)
            <p style="white-space: pre-line;">{{ $poll->description }}</p>
        @endif
        <p><strong>Fecha de generación:</strong> {{ now()->format('d/m/Y H:i') }}</p>
        <p><strong>Ámbito:</strong> {{ $scope_label }}</p>
        @if($ubicacion_detalle)
            <p>{{ $ubicacion_detalle }}</p>
        @endif
    </div>

    <div class="stats">
        <h2>Resumen General</h2>
        <div class="stats-grid">
            <div class="stat-item">
                <div class="stat-value">{{ number_format($total_votos) }}</div>
                <div class="stat-label">Total de Votos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ count($candidatos) }}</div>
                <div class="stat-label">Candidatos</div>
            </div>
            <div class="stat-item">
                <div class="stat-value">{{ $poll->status }}</div>
                <div class="stat-label">Estado</div>
            </div>
        </div>
    </div>

    <h2 class="section-title">Resultados Completos</h2>

    <table class="results-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 35%;">Candidato</th>
                <th style="width: 25%;">Partido Político</th>
                <th style="width: 15%;">Votos</th>
                <th style="width: 20%;">Porcentaje</th>
            </tr>
        </thead>
        <tbody>
            @foreach($candidatos as $index => $candidato)
                <tr>
                    <td>
                        @if($index === 0)
                            <span class="rank-badge gold">{{ $index + 1 }}</span>
                        @elseif($index === 1)
                            <span class="rank-badge silver">{{ $index + 1 }}</span>
                        @elseif($index === 2)
                            <span class="rank-badge bronze">{{ $index + 1 }}</span>
                        @else
                            <span class="rank-badge">{{ $index + 1 }}</span>
                        @endif
                    </td>
                    <td>
                        <div class="candidate-name">{{ $candidato['nombre'] }}</div>
                    </td>
                    <td>
                        <div>{{ $candidato['partido'] }}</div>
                        <div class="party-info">{{ $candidato['partido_acronimo'] }}</div>
                    </td>
                    <td>
                        <div class="votes-count">{{ number_format($candidato['votos']) }}</div>
                    </td>
                    <td>
                        <div class="percentage">
                            {{ $candidato['porcentaje'] }}%
                        </div>
                        <div class="votes-bar">
                            <div class="votes-bar-fill" style="width: {{ $candidato['porcentaje'] }}%;"></div>
                        </div>
                    </td>
                </tr>
            @endforeach

            <tr class="additional-row">
                <td></td>
                <td colspan="2">
                    <span class="additional-label">Votos "No sabe"</span>
                </td>
                <td>
                    <div class="votes-count">{{ number_format($votos_no_sabe) }}</div>
                </td>
                <td>
                    <div class="percentage">
                        {{ $porcentaje_no_sabe }}%
                    </div>
                    <div class="votes-bar">
                        <div class="votes-bar-fill" style="width: {{ $porcentaje_no_sabe }}%;"></div>
                    </div>
                </td>
            </tr>

            <tr class="additional-row">
                <td></td>
                <td colspan="2">
                    <span class="additional-label">Votos "Ninguno"</span>
                </td>
                <td>
                    <div class="votes-count">{{ number_format($votos_ninguno) }}</div>
                </td>
                <td>
                    <div class="percentage">
                        {{ $porcentaje_ninguno }}%
                    </div>
                    <div class="votes-bar">
                        <div class="votes-bar-fill" style="width: {{ $porcentaje_ninguno }}%;"></div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <div class="footer">
        <p>Documento generado automáticamente por el sistema de encuestas electorales</p>
        <p>{{ $siteSettings['site_name'] }} - {{ now()->format('Y') }}</p>
    </div>
</body>
</html>
