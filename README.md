# icingaweb2-module-columnexport

Currently, it is only possible to export CSV/JSON with all columns.

I have requested an modification to make it possible to export only the columns provided in the URL (&columns=...).

See : Support ?columns also for CSV and JSON exports  (https://github.com/Icinga/icingadb-web/issues/1011)

The idea is that after applying a filter on host/service/hostgroup/servicegroup/..., 
that you will be redirected to another page where you can choose which columns you want to include in an export.

Here is the standard menu expanded with CSV/JSON Column : 
(See also doc installation)

![example_menu_hosts](https://github.com/gbin2265/icingaweb2-module-columnexport/assets/29303758/58a85b35-8141-4a20-a4ea-c75df96eb296)

If you choose 'Column Export', you'll be directed to a new page with the suggested exports.: 

![example_csv_hosts](https://github.com/gbin2265/icingaweb2-module-columnexport/assets/29303758/20139be0-6cd4-4cbf-bdcb-d7b35dad4e60)


You can configure the list of exports yourself in the config file.

FILE : /etc/icingaweb2/modules/columnexport/config.ini
```
[icingadb/hosts/csv/1]
title="Csv Export with host.name"
columns="host.name"
exporttype="csv"
urltype="icingadb/hosts"

[icingadb/hosts/csv/2]
title="Csv Export with address/displaname"
columns="host.address,host.display_name"
exporttype="csv"
urltype="icingadb/hosts"

[icingadb/hosts/json/1]
title="JSON Export with name/address"
columns="host.name,host.address"
exporttype="json"
urltype="icingadb/hosts"

[icingadb/hosts/sql]
title="SQL"
exporttype="sql"
urltype="icingadb/hosts"

[icingadb/hosts/pdf]
title="PDF"
exporttype="pdf"
columns="host.address,host.display_name"
urltype="icingadb/hosts"

[icingadb/services/sql]
title="SQL"
exporttype="sql"
urltype="icingadb/services"

[icingadb/hostgroups/sql]
title="SQL"
exporttype="sql"
urltype="icingadb/hostgroups"

[icingadb/servicegroups/sql]
title="SQL"
exporttype="sql"
urltype="icingadb/servicegroups"

....
```
