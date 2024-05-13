<?php

namespace Icinga\Module\Columnexport\Controllers;

use Icinga\Module\Icingadb\Web\Controller;
use ipl\Web\Url;
use ipl\Html\Html;
use ipl\Web\Compat\CompatController;
use Icinga\Application\Config;

class ColumnexportController extends Controller
{

   public function columnexportAction()
    {  

           $config = $this->Config();

           $param_url_base = Url::fromRequest()->getBasePath();
           $param_url_without = Url::fromRequest()->getParams()->without('columns')->without('pagetype')->without('exportformat')->toString();
           $param_pagetype = $this->params->get('pagetype');
           $param_exportformat = $this->params->get('exportformat');

           /**
           Create Page info
           **/
           $this->addTitleTab(t($param_pagetype . '/' . $param_exportformat));
           $div = Html::tag('div',['class'=>"content"]);
           $headertext = Html::tag('h2', Html::tag('u',t('List of Exports')));
           $div->add($headertext);
           $this->addContent($div);

           /**
           Add Export Lines
           **/
           $exportlinesarray = [];
           for ($i = 1; $i <= 10; $i++) {

                   $exportname = $config->get($param_pagetype . '/' . $param_exportformat . '/' . $i, 'exportname' );
                   if (empty($exportname)) {
                      break;
                   }  
                   $exportcolumns = $config->get($param_pagetype . '/' . $param_exportformat . '/' . $i, 'exportcolumns');
                   if ( $param_exportformat == "json" ) { $exportclass = 'icon-doc-text'; } else { $exportclass = 'icon-file-excel'; };

                   $columnexport_class = $exportclass;
                   $columnexport_content = $exportname . 'columns =' . $exportcolumns;
                   $columnexport_url = $param_url_base . '/' . $param_pagetype . '?' . $param_url_without . '&columns=' . $exportcolumns . '&format=' . $param_exportformat;
                   $columnexport_html = Html::tag('li', null , Html::tag('a', ['href' => $columnexport_url , 'class' => $columnexport_class], $columnexport_content));
                   $div->add($columnexport_html);

           }

    }
}
