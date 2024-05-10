Here are the steps to install the columnsexport module.

1. install the module as one would do for any icingaweb2 module.

2. make a copy of the file to php-icinga2:
```
cp /usr/share/icingaweb2/modules/columnexport/doc/extra/usr/share/php/Icinga/Web/Widget/Tabextension/ColumnExport.php usr/share/php/Icinga/Web/Widget/Tabextension/ColumnExport.php 
```
3. modify the icingaweb2 code to expand the menu:
open the file:
Change the line
to
