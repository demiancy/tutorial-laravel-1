<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <title>Reporte de Ventas</title>

        <!-- Styles -->
        <link href="{{ public_path('theme/css/custom_pdf.css') }}" rel="stylesheet" type="text/css" />
    </head>
    <body>
        <div class="row">
            <div class="col-xs-4">
                <div class="invoice-logo-container">
                    <img class="invoice-logo" src="{{ public_path('theme/img/livewire_logo.png') }}">
                </div>
            </div>
            <div class="col-xs-8">
                <h1 class="font-weight-bold">
                    Sistema LWPOS
                </h1>
                <div class="text-company">
                    <div class="font-weight-bold fs-18">
                        Reporte de Ventas
                    </div>
                    <div class="fs-16">
                        Fecha: {{ $from->eq($to) ? $from->format('d/m/Y') : "{$from->format('d/m/Y')} al {$to->format('d/m/Y')}" }}
                    </div>
                    <div class="fs-16">Usuario: {{ $user }}</div>
                </div>
            </div>
        </div>

        <div class="row m-180">
            <div class="col-xs-12">
                <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
                    <thead>
                        <tr>
                            <th width="10%">FOLIO</th>
                            <th width="12%">IMPORTE</th>
                            <th width="10%">ITEMS</th>
                            <th width="12%">ESTADO</th>
                            <th>USUARIO</th>
                            <th width="18%">FECHA</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($sales as $sale)
                            <tr>
                                <td align="center">{{ $sale->id }}</td>
                                <td align="center">
                                    {{ number_format($sale->total, 2) }}
                                </td>
                                <td align="center">{{ $sale->items }}</td>
                                <td align="center">{{ $sale->status }}</td>
                                <td align="center">{{ $sale->user->name }}</td>
                                <td align="center">{{ $sale->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-center">
                                <span class="font-weight-bold">
                                    TOTALES:
                                </span>
                            </td>
                            <td colspan="1" class="text-center">
                                <span class="font-weight-bold">
                                    ${{ number_format($sales->sum('total'), 2) }}
                                </span>
                            </td>
                            <td class="text-center">
                                {{ $sales->sum('items') }}
                            </td>
                            <td colspan="3"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="footer">
            <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
                <tr>
                    <td width="20%">
                        <span>Sistema LWPOS V1</span>
                    </td>
                    <td width="60%" class="text-center">
                        <span>Tutorial Laravel</span>
                    </td>
                    <td width="20%" class="text-center">
                        Pagina <span class="pagenum"></span>
                    </td>
                </tr>
            </table>
        </div>

    </body>
</html>