<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Chartjs\Chart;

class COChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        parent::__construct();
        $this->container = 'charts::chartjs.container';
        $this->script = 'charts::chartjs.script';
        return $this->options([
            'type' => 'bar',
        ]);
    }
}
