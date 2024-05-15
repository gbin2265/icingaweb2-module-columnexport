<?php

namespace Icinga\Module\Columnexport\Controllers;

use Icinga\Module\Icingadb\Web\Controller;
use ipl\Web\Url;
use ipl\Html\Html;
use ipl\Web\Compat\CompatController;
use Icinga\Application\Config;

class ColumnexportController extends Controller
{
   /**
     * Get URL base (Like .../icingaweb2)
     *
     * @var param_url_base
   **/
     public $param_url_base;

   /**
     * Get URL without the colums option
     *
     * @var param_url_without_columns
   **/
     public $param_url_without_columns;

   /**
     * Get URL without the colums option
     *
     * @var param_url_with_columns
   **/
     public $param_url_with_columns;

   /**
     * Get URL option pagetype
     *         Like : icingadb/hosts
     *         Like : icingadb/services
     *         Like : icingadb/hostgroups
     *         Like : icingadb/servicegroups
     *
     * @var param_url_pagetype
   **/
     public $param_url_pagetype;

   /**
     *
     * Array with config.ini
     *
   **/
     public $columnexport_config_ini;

   /**
     * Action columnexport
     *
   **/
     public function columnexportAction()
     {  
         /**
         Get Parameters URL
         **/

         $this->param_url_base = Url::fromRequest()->getBasePath();
         $this->param_url_without_columns = Url::fromRequest()->getParams()->without('columns')->without('pagetype')->toString();
         $this->param_url_with_columns = Url::fromRequest()->getParams()->without('pagetype')->toString();
         $this->param_url_pagetype = $this->params->get('pagetype');

         /**
         Create Page
         **/
         $this->addTitleTab(t($this->param_url_pagetype));

         $this->readColumnExportIniFile ( $this->param_url_pagetype );

         $this->createColumnExportHtml( 'csv' );
         $this->createColumnExportHtml( 'json' );
         $this->createColumnExportHtml( 'pdf' );
         $this->createColumnExportHtml( 'sql' );
     }

   /**
     * Read config.ini file
     *
   **/
     protected function readColumnExportIniFile ( $filter_urltype ) 
     {
         /** columnexport/config.ini **/
         $config = $this->Config();

         /** Clean Array columnexport_config_ini **/
         $this->columnexport_config_ini = [];
    
         /** Read every key form config.ini where urltype is ... **/ 
         foreach ($config as $key => $part) {
            $ini_urltype = $part->get('urltype');
            if ( $filter_urltype === $ini_urltype ) { 
               $config_ini = [
                               'config_ini_title' => $part->get('title'),
                               'config_ini_urltype' => $ini_urltype,
                               'config_ini_exporttype' => $part->get('exporttype'),
                               'config_ini_columns' => $part->get('columns')
                              ];
               array_push($this->columnexport_config_ini , $config_ini );
            }
         }
     }


   /**
     * Create Html Page
     *
   **/
     protected function createColumnExportHtml ( $TypeColumnExport ) {

           /** Header for Type Export **/
           $div = Html::tag('div',['class'=>"content"]);
           $headertext = Html::tag('h2', Html::tag('u',strtoupper($TypeColumnExport)));
           $div->add($headertext);
           $this->addContent($div);

           /** Create every html line for Type Export **/
           foreach ($this->columnexport_config_ini as $index => $item) {
              $ini_urltype = $item['config_ini_urltype'];
              if ( $this->param_url_pagetype === $ini_urltype ) { 
                   $ini_exporttype = $item['config_ini_exporttype'];
                   if ( $TypeColumnExport === $ini_exporttype ) { 
                        switch ($TypeColumnExport) {
                          case "json":
                               $exportclass = 'icon-doc-text'; 
                               break;
                          case "pdf":
                                $exportclass = 'icon-file-pdf'; 
                                break;
                          case "sql":
                                $exportclass = 'icon-database'; 
                                break;
                          default:
                                $exportclass = 'icon-file-excel';
                        }    
                        $ini_title = $item['config_ini_title'];
                        $ini_columns = $item['config_ini_columns'];
                        if ( ! empty($ini_columns) ) {
                             $columnexport_content = $ini_title . ' (columns =' . $ini_columns . ')';
                             $columnexport_url = $this->param_url_base . '/' . $this->param_url_pagetype . '?' . $this->param_url_without_columns . '&columns=' . $ini_columns . '&format=' . $TypeColumnExport;
                        }
                        else {
                             $columnexport_content = $ini_title;
                             $columnexport_url = $this->param_url_base . '/' . $this->param_url_pagetype . '?' . $this->param_url_with_columns . '&format=' . $TypeColumnExport;
                        }
                        $columnexport_html = Html::tag('li', null , Html::tag('a', ['href' => $columnexport_url , 'target' => '_blank' , 'class' => $exportclass], $columnexport_content));
                        $div->add($columnexport_html);
                   }
              }
           }
     }

}

