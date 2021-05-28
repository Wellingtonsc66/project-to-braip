<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Novo Evento
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <x-auth-session-status class="mb-4" :status="session('status')"/>
                    <form method="POST" action="{{ route('evento.adicionar') }}">
                        @csrf
                        @if(!empty(session('avisos')))
                            @if( is_array(session('avisos') ))
                                @foreach(session('avisos') as $cada_mensagem)
                                    <li style="color: red">{{$cada_mensagem}}</li>
                                @endforeach
                            @else
                                <li style="color: red">{{session('avisos')}}</li>
                            @endif
                        @endif
                        <div class="flex flex-wrap" id="add">
                            <div class="mt-4 w-1/2 md:inline-block px-1">
                                <x-label for="descricao" :value="__('Descrição')" />
                                <x-input id="descricao" class="block mt-1 w-full" type="text" name="descricao" :value="old('descricao')" required autofocus/>
                            </div>
                            <div class="mt-4 w-1/2 md:inline-block px-1">
                                <x-label for="data_evento" :value="__('Data do evento')" />
                                <x-input id="data_evento" class="block mt-1 w-full" type="date" name="data_evento" :value="old('data_evento')" maxlength="10" required/>
                            </div>
                            <div style="" class="mt-4 w-1/2 md:inline-block px-1">
                                <x-label for="users" :value="__('Convidar usuários')" />
                                <select id="users" size="4" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="users[]" multiple required>
                                    @foreach($users as $key=>$value)
                                        <option value="{{$value['id']}}">{{$value['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="flex items-center justify-end mt-4">
                            <x-button class="ml-4" id="btn-save">
                                {{ __('Criar Evento') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script>
</script>
