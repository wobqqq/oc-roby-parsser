<?php

declare(strict_types=1);

namespace BlackSeaDigital\Parser\Controllers;

use Backend\Classes\Controller;
use BackendMenu;

final class Pages extends Controller
{
    /** @var string[] */
    public $implement = [
        \Backend\Behaviors\FormController::class,
        \Backend\Behaviors\ListController::class,
    ];

    public string $formConfig = 'config_form.yaml';

    public string $listConfig = 'config_list.yaml';

    public function __construct()
    {
        parent::__construct();

        BackendMenu::setContext('BlackSeaDigital.Parser', 'parser', 'pages');
    }
}
