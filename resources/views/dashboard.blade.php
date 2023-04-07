<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
            overflow: auto, !important;
        }

        th,
        td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #dddddd;
        }

        th:first-child,
        td:first-child {
            position: sticky;
            left: 0;
            z-index: 1;
            background-color: white;
        }

        thead th {
            position: -webkit-sticky;
            position: sticky;
            left: 0;
            z-index: 1;
            background-color: #ddd;
        }

        tbody td:first-child {
            position: -webkit-sticky;
            position: sticky;
            left: 0;
            z-index: 1;
            background-color: #ddd;
            border-right: none;
        }

        .primary {
            background-color: yellow;
            color: green;

        }

        .danger {
            background-color: yellow;
            color: red;

        }
    </style>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-auto shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <div class="table-responsive">
                        <table class="table w-full text-sm text-left text-gray-500">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                                <tr>
                                    <td colspan="14">ANO</td>
                                </tr>
                                <tr>
                                    <th>
                                        <div class="py-3 px-6 flex items-center">
                                            Categoria
                                        </div>
                                    </th>
                                    <th>Jan</th>
                                    <th>Fev</th>
                                    <th>Mar</th>
                                    <th>Abr</th>
                                    <th>Mai</th>
                                    <th>Jun</th>
                                    <th>Jul</th>
                                    <th>Ago</th>
                                    <th>Set</th>
                                    <th>Out</th>
                                    <th>Nov</th>
                                    <th>Dez</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total = 0;
                                $total_jan = 0;
                                $total_fev = 0;
                                $total_mar = 0;
                                $total_abr = 0;
                                $total_mai = 0;
                                $total_jun = 0;
                                $total_jul = 0;
                                $total_ago = 0;
                                $total_set = 0;
                                $total_out = 0;
                                $total_nov = 0;
                                $total_dez = 0;
                                @endphp
                                @foreach ($lancamentos as $lancamento)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <div class="flex-1">
                                        <td class="{{$lancamento->color}}">{{ $lancamento->categoria_nome }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->jan }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->fev }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->mar }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->abr }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->mai }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->jun }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->jul }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->ago }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->set }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->out }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->nov }}</td>
                                        <td class="{{$lancamento->color}}">{{ $lancamento->dez }}</td>
                                        <td>{{ $lancamento->valor_total }}</td>
                                    </div>
                                </tr>
                                @php
                                $total_jan += $lancamento->jan;
                                $total_fev += $lancamento->fev;
                                $total_mar += $lancamento->mar;
                                $total_abr += $lancamento->abr;
                                $total_mai += $lancamento->mai;
                                $total_jun += $lancamento->jun;
                                $total_jul += $lancamento->jul;
                                $total_ago += $lancamento->ago;
                                $total_set += $lancamento->set;
                                $total_out += $lancamento->out;
                                $total_nov += $lancamento->nov;
                                $total_dez += $lancamento->dez;
                                $total += $lancamento->valor_total;
                                @endphp
                                @endforeach
                                <tr>
                                    <td align="right"> Total:</td>
                                    <td>{{ $total_jan }}</td>
                                    <td>{{ $total_fev }}</td>
                                    <td>{{ $total_mar }}</td>
                                    <td>{{ $total_abr }}</td>
                                    <td>{{ $total_mai }}</td>
                                    <td>{{ $total_jun }}</td>
                                    <td>{{ $total_jul }}</td>
                                    <td>{{ $total_ago }}</td>
                                    <td>{{ $total_set }}</td>
                                    <td>{{ $total_out }}</td>
                                    <td>{{ $total_nov }}</td>
                                    <td>{{ $total_dez }}</td>
                                    <td>{{ $total }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
                <div class="p-6 text-gray-900">
                    @foreach ($chirps as $chirp)
                    <div class="flex-1">
                        <p class="mt-4 text-lg text-gray-900">{{ $chirp->message }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

</x-app-layout>