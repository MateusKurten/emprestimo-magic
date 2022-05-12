<?php

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;

/**
 * Widget para renderizar alerts. Quando chamado, deve ser adicionado um segundo
 * parametro para configurar o alert. @see $this::$config
 */
class Alert extends AbstractWidget
{
    /**
     * @var array
     * Array contendo as configurações. Ao chamar o Widget, é necessário fornecer um segundo
     * parâmetro com as configurações. O valores aceitos são:
     * - Uma string com o texto que aparecerá no alert.
     * - Um array no formato abaixo:
     * ```php
     * [
     *     'title' => Obrigatório. String com o texto que aparecerá no alert.
     *     'subtitle' => Opcional. String com o sub título que aparecerá no alert
     *     'preset' => Opcional. Default: 'info'. String contendo uma das cores pre-definidas do alert.
     * Os valores aceitos são: 'info', 'success', 'warning' e 'danger'.
     * ]
     * ```
     * - Um array onde os elementos estão num dos formatos acima.
     */
    protected $config = [];

    /**
     * Exibe o conteúdo do Widget
     * @return \Illuminate\Http\Response
     */
    public function run()
    {
        $alerts = [];

        if (isset($this->config['title'])) {
            $alerts[] = [
                'title' =>  $this->config['title'],
                'subtitle' => $this->config['subtitle'] ?? '',
                'preset' => $this->config['preset'] ?? 'info',
            ];
        } else {
            foreach ($this->config as $alert) {
                if (is_string($alert)) {
                    $alerts[] = [
                        'title' =>  $alert,
                        'preset' => 'info',
                    ];
                }

                if (isset($alert['title'])) {
                    $alerts[] = [
                        'title' =>  $alert['title'],
                        'subtitle' => $alert['subtitle'] ?? '',
                        'preset' => $alert['preset'] ?? 'info',
                    ];
                }
            }
        }

        return view('widgets.alert', [
            'alerts' => $alerts,
        ]);
    }
}
