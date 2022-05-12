<div class="absolute top-20 right-10 float-right overflow-hidden animate-largura-75 md:animate-largura-25">

@foreach($alerts as $key => $alert)

@php
switch ($alert['preset']) {
            case 'info':
                $style = 'bg-blue-100 border-blue-400 text-blue-700';
                break;
            case 'success':
                $style = 'bg-green-100 border-green-400 text-green-700';
                break;
            case 'warning':
                $style = 'bg-yellow-100 border-yellow-400 text-yellow-700';
                break;
            case 'danger':
                $style = 'bg-red-100 border-red-400 text-red-700';
                break;
            default:
                $style = '';
        }

@endphp
<div class="{{ $style }} border px-4 py-3 rounded relative mb-4" role="alert" id="alerta-operacao-{{ $key }}">
    <div style="margin-right: 30px">
        <strong class="font-bold">{!! $alert['title'] !!}</strong>
        @if(isset($alert['subtitle']))
            <div>
                {!! $alert['subtitle'] !!}
            </div>
        @endif
    </div>
    <button onclick="document.getElementById('alerta-operacao-{{ $key }}').remove()" class="absolute top-0 right-0 px-4 py-3">
        <i data-feather="x" style="width: 22px; height: 22px"></i>
    </button>
</div>

@endforeach

</div>
