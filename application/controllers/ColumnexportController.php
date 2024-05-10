<?php

namespace Icinga\Module\Columnexport\Controllers;

use Icinga\Module\Icingadb\Web\Controller;
use ipl\Web\Url;
use ipl\Web\Compat\CompatController;
use Icinga\Application\Config;

class ColumnexportController extends Controller
{

   public function columnexportAction()
    {  

           $this->addTitleTab(t('CSV Export'));

           $config = $this->Config();

           $param_url_base = Url::fromRequest()->getBasePath();
           $param_url_without = Url::fromRequest()->getParams()->without('columns')->without('pagetype')->without('exportformat')->toString();
           $param_pagetype = $this->params->get('pagetype');
           $param_exportformat = $this->params->get('exportformat');

           $exportlinesarray = [];
           for ($i = 1; $i <= 10; $i++) {

                   $exportname = $config->get($param_pagetype . '/' . $param_exportformat . '/' . $i, 'exportname' );
                   if (empty($exportname)) {
                      break;
                   }  
                   $exportcolumns = $config->get($param_pagetype . '/' . $param_exportformat . '/' . $i, 'exportcolumns');
                   if ( $param_exportformat == "json" ) { $exportclass = 'icon-doc-text'; } else { $exportclass = 'icon-file-excel'; };

                   $csvinfo = [ 
                               'exportname' => $exportname,
                               'exportcolumns' => $exportcolumns,
                               'exportclass' => $exportclass,
                               'exportformat' => $param_exportformat,
                               'exportpagetype' => $param_pagetype,
                               'exporturl' => $param_url_base . '/' . $param_pagetype . '?' . $param_url_without . '&columns=' . $exportcolumns . '&format=' . $param_exportformat
                               ];
                   array_push($exportlinesarray , $csvinfo );
           }

           $this->view->headerexportformat = $param_exportformat;
           $this->view->headerpagetype = $param_pagetype;
           $this->view->exportlinesarray = $exportlinesarray; 
    }
}
