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
                                <td colspan="4">EVENTOS CRIADOS POR VOCÊ</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>Descrição</td>
                                <td>Data do evento</td>
                                <td>Cancelar</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($meus_eventos as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value['descricao']}}</td>
                                    <td width="200px">{{date_format(date_create($value['data_evento']), 'd/m/Y')}}</td>
                                    <td width="150px">
                                        <a href="{{ route('evento.excluir').'/'.$value['id'] }}">
                                            <button type="button" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if($eventos_convidados)
        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white">
                        <table class="table-p">
                            <thead>
                            <tr>
                                <td colspan="5">CONVITES</td>
                            </tr>
                            <tr>
                                <td>#</td>
                                <td>Descrição</td>
                                <td>Autor do evento</td>
                                <td>Status</td>
                                <td>Data do evento</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($eventos_convidados as $key=>$value)
                                <tr>
                                    <td>{{$key+1}}</td>
                                    <td>{{$value->descricao}}</td>
                                    <td>{{$value->autor}}</td>
                                    <td>{{$value->convite_aceito == 'sim'? 'Aceito' : 'Recusado'}}</td>
                                    <td width="200px">{{date_format(date_create($value->data_evento), 'd/m/Y')}}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
