<script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
<style>
    .table-p{
        width: 100%;
        margin: 20px 0;
        border: 1px solid #e2e2e2;
        border-collapse: collapse;
        cursor: default;
        box-shadow: 0 1px 1px rgb(0 0 0/5%);
        text-align: center;
    }
    .table-p thead tr {
        border-radius: 3px;
        background: #fdfdfd;
        background: -webkit-gradient(linear,left top,left bottom,color-stop(2%,#fdfdfd),color-stop(100%,#fbfbfb));
        background: -webkit-linear-gradient(top,#fdfdfd 2%,#fbfbfb 100%);
        background: linear-gradient(to bottom,#fdfdfd 2%,#fbfbfb 100%);
        color: #313538;
        font: 13px Arial, Helvetica, sans-serif;
        font-weight: bolder;
        text-align: center;
    }
    .table-p tr {
        -webkit-transition: background-color .2s ease;
        transition: background-color .2s ease;
        border-bottom: 1px solid #e2e2e2;
    }
    .table-p td {
        padding: 5px 7px;
        line-height: 1.5;
        border-right: 1px solid #e2e2e2;
    }
    .table-p tbody tr:hover {
        background: #f2f9fb;
        color: #62748b;
    }
    .b-promo {
        position: relative;
        margin: 20px 0;
        padding: 15px 25px 15px 25px;
        box-shadow: 0 1px 3px rgba(0,0,0,.02);
        background: #fff;
        background: -webkit-gradient(linear,left top,left bottom,color-stop(2%,#fff),color-stop(100%,#fbfbfb));
        background: -webkit-linear-gradient(top,#fff 2%,#fbfbfb 100%);
        background: linear-gradient(to bottom,#fff 2%,#fbfbfb 100%);
        border-radius: 0 3px 3px 0;
        border: 1px solid #e2e2e2;
        border-left: 0;
        cursor: default;
    }
    .b-promo:before {
        content: '';
        position: absolute;
        top: -1px;
        left: 0;
        bottom: -1px;
        border-left: 2px solid #1480dd;
    }
    .no-atrr {
        font-size: larger;
        font-weight: bolder;
    }
</style>
<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-10 w-auto fill-current text-gray-600" />
                    </a>
                </div>
                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Início
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('evento.adicionar')" :active="request()->routeIs('evento.adicionar')">
                        Adicionar Evento
                    </x-nav-link>
                </div>
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">
                    <x-nav-link :href="route('evento.meus-eventos')" :active="request()->routeIs('evento.meus-eventos')">
                        Meus Eventos
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ml-6">
                <div class="hidden sm:flex sm:items-center sm:ml-6 mr-2">
                    <x-dropdown align="right" width="48">
                        @php
                            $user = Illuminate\Support\Facades\Auth::user()->toArray();
                            $eventosUser = new \App\Models\EventoUser();
                            $convites = $eventosUser->where([['user_id', $user['id']], ['convite_aceito', 'aguardando']])->get()->toArray();
                        @endphp
                        <x-slot name="trigger">
                            @if($convites)
                                <figure style="width: 9px;border-radius: 20px;height: 9px;left: 15px;top: 15px;position: absolute;background: #df4a32;" class="notificacao"></figure>
                            @endif
                            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                                <div style="width: 25px">
                                    <img src="{{asset('img/nav-bar/icon_sin.png')}}">
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if(!$convites)
                                <x-dropdown-link>
                                    Não há notificações!
                                </x-dropdown-link>
                            @else
                                <x-dropdown-link>
                                    <ul>
                                        @foreach($convites as $value)
                                            @php
                                                $evento = \App\Models\Evento::find($value['evento_id'])->first()->toArray();
                                            @endphp
                                            <li>
                                                Você foi convidado para participar do evento: {{$evento['descricao']}}
                                            </li>
                                        @endforeach
                                    </ul>
                                </x-dropdown-link>
                            @endif
                        </x-slot>
                    </x-dropdown>
                </div>
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ml-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                Deslogar
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                <div class="flex-shrink-0">
                    <svg class="h-10 w-10 fill-current text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>

                <div class="ml-3">
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
