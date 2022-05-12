<aside class="w-64 md:min-h-screen border-r border-gray-300">
    <div class="flex items-center justify-center shadow-lg p-4 h-16">
        <a href="#" class="flex justify-center">
            <span class="text-md font-semibold mx-2">Bem vindo, {{session('usuario')}}</span>
        </a>
    </div>
    <div class="px-2 py-6 md:block" >
        <ul>
            <li class="{{ request()->is('decks') ? 'bg-gray-200' : 'hover:bg-gray-200' }} px-2 py-3 rounded mt-2">
                <a href="{{ route('decks') }}">
                    <span class="mx-2">Meus Decks</span>
                </a>
            </li>
            <li class="{{ request()->is('detalhes') || request()->is('detalhes/*') ? 'bg-gray-200' : 'hover:bg-gray-200' }} px-2 py-3 rounded mt-2">
                <a href="{{ route('usuarios.onde_estao_minhas_cartas') }}">
                    <span class="mx-2">Onde estão minhas cartas?</span>
                </a>
            </li>
            <li class="{{ request()->is('tipos') || request()->is('tipos/*') ? 'bg-gray-200' : 'hover:bg-gray-200' }} px-2 py-3 rounded mt-2">
                <a href="{{ route('usuarios.cartas_emprestadas') }}">
                    <span class="mx-2">Cartas emprestadas</span>
                </a>
            </li>
            <li class="{{ request()->is('tipos') || request()->is('tipos/*') ? 'bg-gray-200' : 'hover:bg-gray-200' }} px-2 py-3 rounded mt-2">
                <a href="{{ route('amigos.create') }}">
                    <span class="mx-2">Cadastrar amigo</span>
                </a>
            </li>
            <li class="{{ request()->is('formatos') ? 'bg-gray-200' : 'hover:bg-gray-200' }} px-2 py-3 rounded mt-2">
                <a href="{{ route('formatos') }}">
                    <span class="mx-2">Formatos</span>
                </a>
            </li>
            <li class="hover:bg-gray-200 px-2 py-3 rounded mt-2">
                <a href="{{ route('usuarios.logout') }}">
                    <span class="mx-2">Logout</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
