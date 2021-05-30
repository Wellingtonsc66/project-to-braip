<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meus Eventos
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white">
                    @if(!$meus_eventos)
                        <div class="b-promo">
                            <h3 class="no-atrr">Não há eventos para serem listados.</h3>
                            Clique em Adicionar Evento para criar novo evento.
                        </div>
                    @else
                        <table class="table-p">
                            <thead>
                            <tr>
                                <td colspan="1" style="visibility: hidden"></td>
                                <td colspan="4">SEUS EVENTOS</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>DESCRIÇÃO</td>
                                <td>DATA DO EVENTO</td>
                                <td>CANCELAR</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($meus_eventos as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value['descricao']}}</td>
                                    <td>{{date_format(date_create($value['data_evento']), 'd/m/Y')}}</td>
                                    <td width="150px">
                                        <x-button id="btn-save">
                                            <a href="{{ route('evento.excluir').'/'.$value['id'] }}">
                                                {{ __('Cancelar') }}
                                            </a>
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
                @if($eventos_convidados)
                    <div class="p-6 bg-white">
                        <table class="table-p">
                            <thead>
                            <tr>
                                <td colspan="1" style="visibility: hidden"></td>
                                <td colspan="5">CONVITES</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>DESCRIÇÃO</td>
                                <td>AUTOR DO EVENTO</td>
                                <td>SITUAÇÃO</td>
                                <td>DATA DO EVENTO</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($eventos_convidados as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value['descricao']}}</td>
                                    <td>{{$value['name']}}</td>
                                    <td>{{$value['convite_aceito'] == 'sim'? 'Aceito' : 'Recusado'}}</td>
                                    <td>{{date_format(date_create($value['data_evento']), 'd/m/Y')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
