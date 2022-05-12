<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

/**
 * Widget para renderizar selects. Quando chamado, pode ser adicionado um array como segundo
 * parametro para alterar as configurações padrão. @see $this::$config
 */
class Select extends AbstractWidget
{
    /**
     * @var array
     * Array contendo as configurações. Podem ser substituidas ao chamar o Widget. Segue
     * abaixo o formato das configurações aceitas:
     * ```php
     * [
     *     'data' => Default: []. Array contendo as opções do select. Se informado as chaves do array,
     * elas serão os valores das opções e o valores do array as labels. Caso contrário, os itens do
     * array serão tanto a label e o valor das opções do select.
     *     'name' => Default: ''. String contendo o atributo html name do select.
     *     'value' => Default: ''. String contendo o valor selecionado do select.
     *     'emptyOptionsMessage' => Default: null. String contendo texto ao realizar uma busca sem
     * resultado nas opções do select. Caso não fornecido, um texto padrão será usado.
     *     'placeholder' => Default: null. String contendo o placeholder do select
     *     'multiple' => Default: false. Boolean informando se o select aceita multiplos valores ou apenas um.
     * ]
     * ```
     */
    protected $config = [
        'data' => [],
        'name' => '',
        'value' => null,
        'emptyOptionsMessage' => null,
        'placeholder' => null,
        'multiple' => false,
    ];

    /**
     * Exibe o conteúdo do Widget
     * @return \Illuminate\Http\Response
     */
    public function run()
    {
        $keys = array_keys($this->config['data']);
        $values = array_map('strval', array_values($this->config['data']));

        if ($keys === range(0, count($values) - 1)) {
            $keys = array_map(function($e) { return (string) $e; }, $values);
        }

        return view('widgets.select', [
            'data' => json_encode(array_combine($keys, $values)),
            'name' => $this->config['name'],
            'value' => $this->config['value'],
            'emptyOptionsMessage' => json_encode($this->config['emptyOptionsMessage']),
            'placeholder' => json_encode($this->config['placeholder']),
            'multiple' => json_encode($this->config['multiple']),
        ]);
    }
}
