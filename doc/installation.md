Here are the steps to install the columnsexport module.

1. <b>install the module</b>
   
Do the installation of the module as one would do for any icingaweb2 module

3. <b>make a copy of the file to php-icinga2</b>
```
cp /usr/share/icingaweb2/modules/columnexport/doc/extra/usr/share/php/Icinga/Web/Widget/Tabextension/ColumnExport.php usr/share/php/Icinga/Web/Widget/Tabextension/ColumnExport.php 
```
3. <b>create the config file</b>

Create the file : /etc/icingaweb2/module/columnexport/config.ini

See also config.ini file in the doc section for more information.

4. <b>modify the icingaweb2 code to expand the menu</b>

Edit file /usr/share/icinga-php/ipl/vendor/ipl/web/src/Widget/Tabs.php

Add the use line : 
```
use Icinga\Web\Widget\Tabextension\ColumnExport;
```

Add the line in the function assemble :

->extend(new ColumnExport())
```
    protected function assemble()
    {
        if ($this->legacyExtensionsEnabled) {
            $this->tabs->extend(new OutputFormat(
                $this->dataExportsEnabled
                    ? []
                    : [OutputFormat::TYPE_CSV, OutputFormat::TYPE_JSON]
            ))
                ->extend(new DashboardAction())
                ->extend(new ColumnExport())
                ->extend(new MenuAction());
        }
```
