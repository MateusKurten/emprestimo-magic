<table class="table-auto border shadow-lg mt-4 w-full">
    <thead>
        <tr>
            @foreach ($config['columns'] as $column)
                <th class="border border-gray-400 px-4 py-2 bg-gray-100 {{ $column['text-style'] ?? ''}}">
                    {{$column['header']}}
                </th>
            @endforeach
            @if (count($config['actions']) > 0)
                <th class="border border-gray-400 px-4 py-2 bg-gray-100">
                    Ações
                </th>
            @endif
        </tr>
    </thead>
    <tbody>
        @foreach ($config['dataProvider'] as $data)
            <tr>
                @foreach( $config['columns'] as $column)
                    @php
                        $value = $column['value'];
                        $value = !is_string($value) ? $value($data) : (is_array($data) ? $data[$value] : $data->$value);

                        $class = null;
                        if (isset($column['class'])) {
                            $class = $column['class'];
                            $class = !is_string($class) ? $class($data) : $class;
                        }
                    @endphp

                    <td
                        class="border border-gray-400 px-4 py-2 {{ $column['text-style'] ?? 'text-center'}} {{ $class ?? '' }}"
                        @if (isset($column['width'])) width="{{ $column['width'] }}" @endif
                    >
                        {!! $value !!}
                    </td>
                @endforeach
                @if (count($config['actions']) > 0)
                    <td class="border border-gray-400 px-4 py-2 text-center" width='120px'>
                        @foreach($config['actions'] as $action)
                            @php
                                $action['routeParams'] = $action['routeParams'] ?? [];
                                $confirm = $action['confirm'] ?? null;
                                $params = [];

                                foreach($action['routeParams'] as $k => $param) {
                                    $params[$k] = !is_string($param) ?
                                        $value($param) :
                                        (is_array($data) ? $data[$param] : $data->$param);
                                }
                            @endphp
                            @if (isset($confirm))
                                <form
                                    class="inline"
                                    method="POST"
                                    action="{{route( $action['route'], $params)}}"
                                    @if (isset($action['target'])) target="{{ $action['target'] }}" @endif
                                >
                                    @csrf
                                    <button
                                        type="submit"
                                        class="cursor-pointer"
                                        onclick="return confirm('{{ strval($confirm) }}');"
                                        style="border: 0; background: none;"
                                    >
                                        <i data-feather="{{ $action['icon'] }}" class="inline" width="20px" height="20px"></i>
                                    </button>
                                </form>
                            @else
                                <a
                                    href="{{ route($action['route'], $params) }}"
                                    @if (isset($action['target'])) target="{{ $action['target'] }}" @endif
                                >
                                    <i data-feather="{{ $action['icon'] }}" class="inline" width="20px" height="20px"></i>
                                </a>
                            @endif
                        @endforeach
                    </td>
                @endif
            </tr>
        @endforeach
    </tbody>
</table>
