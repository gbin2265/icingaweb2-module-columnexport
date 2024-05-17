# icingaweb2-module-columnexport

Currently, it is only possible to export CSV/JSON with all columns.

I have requested an modification to make it possible to export only the columns provided in the URL (&columns=...).

See : Support ?columns also for CSV and JSON exports  (https://github.com/Icinga/icingadb-web/issues/1011)

The idea is that after applying a filter on host/service/hostgroup/servicegroup/..., 
that you will be redirected to another page where you can choose which columns you want to include in an export.

Here is the standard menu expanded with CSV/JSON Column : 
(See also doc installation)

![example_menu_hosts](https://github.com/gbin2265/icingaweb2-module-columnexport/assets/29303758/58a85b35-8141-4a20-a4ea-c75df96eb296)


If you choose CSV.JSON, you'll be directed to a new page with the suggested exports.: 

![example_csv_hosts](https://github.com/gbin2265/icingaweb2-module-columnexport/assets/29303758/a34853cd-a6ee-4e3e-8b2c-7066b25611fa)

You can configure the list of exports yourself in the config file.

Format :
  - icingadb/hosts , icingadb/services , icingadb/hostgroups , icingadb/servicegroups ...
  - csv or json
  - 1..20  (max 20 lines)

FILE : /etc/icingaweb2/modules/columnexport/config.ini
```
[icingadb/hosts/json/1]
exportname="JSON Export with name and address"
exportcolumns="host.name,host.address"

[icingadb/hosts/csv/1]
exportname="Csv Export with name and address"
exportcolumns="host.name,host.address"

[icingadb/hosts/csv/2]
exportname="Csv Export with address and displaname"
exportcolumns="host.address,host.display_name"
```
