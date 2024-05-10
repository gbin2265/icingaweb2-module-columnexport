Here are the steps to install the columnsexport module.

The first step is to install the module as one would do for any icingaweb2 module.

The second step is to make a copy of the file to php-icinga2:
```
cp /usr/share/icingaweb2/modules/columnexport/doc/extra/usr/share/php/Icinga/Web/Widget/Tabextension/ColumnExport.php usr/share/php/Icinga/Web/Widget/Tabextension/ColumnExport.php 
```
The third step is to modify the icingaweb2 code to expand the menu:
open the file:
Change the line
to
