<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

/**
 * Widget para renderizar tables. Quando chamado, pode ser adicionado um array como segundo
 * parametro para alterar as configurações padrão. @see $this::$config
 */
class Table extends AbstractWidget
{
    /**
     * @var array
     * Array contendo as configurações. Podem ser substituidas ao chamar o Widget. Segue
     * abaixo o formato das configurações aceitas:
     * ```php
     * [
     *     'dataProvider' => Default: []. Array contendo todas as linhas que serão exibidas na tabela.
     * Podendo ser um array de objetos ou não.
     *     'columns' => Default: []. Array contendo as informações de cada coluna, no formato:
     *     [
     *         'header' => Obrigatório. String contendo o nome do cabeçalho da coluna.
     *         'value' => Obrigatório. Valor da coluna a ser exibido. Podendo ser uma função, que terá
     *             como parâmetro um elemento do array 'columns', ou uma string contendo uma
     *             propriedade ou chave desse elemento que será exibido.
     *         'width' => Opcional. Uma string contendo o valor de width da coluna.
     *         'class' => Opcional. Valor da classe css que a célula possui. Podendo ser uma função,
     *             que terá como parâmetro um elemento do array 'columns', ou uma string contendo
     *             a classe css.
     *     ]
     *     'actions' => Default: []. Array contendo as possíveis ações da tabela. Todas serão
     *             exibidas na mesma colunas chamada 'ações'. O array possui o seguinte formato:
     *     [
     *         'route' => Obrigatorio. String com o nome da rota da ação.
     *         'routeParams' => Opcional. Array contendo os parametros enviados para rota. As chaves
     *                 do array serão os parametros enviados e os values do array os valores. Os
     *                 valores, podem tanto ser uma função, que terá como parâmetro um elemento do
     *                 array 'columns', ou uma string contendo uma propriedade ou chave desse elemento
     *                 que será retornado.
     *         'icon' => Obrigatorio. String contendo o nome do icone para a ação. A biblioteca de icones
     *                 usada é feathericons. @see https://feathericons.com/.
     *         'confirm' => Opcional. String contendo a confirmação da ação, se necessário.
     *         'target' => Opcional. String contendo o atributo html target do link da ação.
     *     ]
     * ]
     * ```
     */
    protected $config = [
        'dataProvider' => [],
        'columns' => [],
        'actions' => [],
    ];

    /**
     * Exibe o conteúdo do Widget
     * @return \Illuminate\Http\Response
     */
    public function run()
    {
        return view('widgets.table', [
            'config' => $this->config,
        ]);
    }
}
