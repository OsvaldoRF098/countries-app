<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Lista de Países</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        img { width: 50px; }
    </style>
</head>
<body>
    <h1>Lista de Países - {{ now()->format('d/m/Y') }}</h1>
    <table>
        <thead>
            <tr>
                <th>Bandera</th>
                <th>País</th>
                <th>Capital</th>
                <th>Población</th>
                <th>Región</th>
            </tr>
        </thead>
        <tbody>
            @foreach($countries as $country)
            <tr>
                <td>@if($country->flag_url)<img src="{{ $country->flag_url }}" alt="flag">@endif</td>
                <td>{{ $country->name }}</td>
                <td>{{ $country->capital ?? 'N/A' }}</td>
                <td>{{ number_format($country->population ?? 0) }}</td>
                <td>{{ $country->region ?? 'N/A' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>