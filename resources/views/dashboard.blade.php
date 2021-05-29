<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Eventos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(!$convites)
                        <div class="b-promo">
                            <h3 class="no-atrr">Não há convites para você no momento.</h3>
                            Aproveite e crie um novo evento clicando em Adicionar Evento.
                        </div>
                    @else
                        <table class="table-p">
                            <thead>
                                <tr>
                                    <td colspan="6">CONVITES PARA PARTICIPAÇÃO DE EVENTOS</td>
                                </tr>
                                <tr>
                                    <td>#</td>
                                    <td>AUTOR</td>
                                    <td>DESCRIÇÃO</td>
                                    <td>DATA DO EVENTO</td>
                                    <td>SITUAÇÃO</td>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($convites as $key=>$value)
                                    <tr>
                                        <td>{{$value['eventoId']}}</td>
                                        <td>{{$value['autor']}}</td>
                                        <td>{{$value['descricao']}}</td>
                                        <td>{{date_format(date_create($value['data_evento']), 'd/m/Y')}}</td>
                                        <td width="220px">
                                            <x-button id="btn-save">
                                                <a href="{{ route('evento-user.editar').'/'.$value['id'].'/aceitar' }}">
                                                    {{ __('Aceitar') }}
                                                </a>
                                            </x-button>
                                            <x-button id="btn-save">
                                                <a href="{{ route('evento-user.editar').'/'.$value['id'].'/recusar' }}">
                                                    {{ __('Recusar') }}
                                                </a>
                                            </x-button>
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
</x-app-layout>
