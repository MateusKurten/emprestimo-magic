<div id="sidebar" class="border-end bg-white" style="width: 300px">
  <div class="text-center align-middle p-2"><h4 class="m-0">Bem vindo, {{session('usuario')}}</h4></div>
  <hr class="m-0" style="color: light-gray">
  <div id="sidebar-nav" class="list-group min-vh-100">
    <a href="{{route('decks.index')}}"
       class="list-group-item border-0 d-inline-block text-truncate my-1 hover-overlay {{ request()->is('decks') ? 'active' : '' }}">
      <span style="font-size: 16px">Meus Decks</span>
      <div class="mask" style="background-color: #92a8d1"></div>
    </a>
    <a href="#"
       class="list-group-item border-0 d-inline-block text-truncate my-1 hover-overlay ripple"
       data-mdb-ripple-color="light">
      <span style="font-size: 16px">Onde estão minhas cartas?</span>
      <div class="mask" style="background-color: #92a8d1"></div>
    </a>
    <a href="#"
       class="list-group-item border-0 d-inline-block text-truncate my-1">
      <span style="font-size: 16px">Cartas emprestadas</span>
    </a>
    <a href="{{route('formatos.index')}}"
       class="list-group-item border-0 d-inline-block text-truncate my-1 {{ request()->is('formatos') ? 'active' : '' }}">
      <span style="font-size: 16px">Formatos</span>
    </a>
    <a href="{{route('usuarios.logout')}}"
       class="list-group-item border-0 d-inline-block text-truncate my-1">
      <span style="font-size: 16px">Logout</span>
    </a>
  </div>
</div>
