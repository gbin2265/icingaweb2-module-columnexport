# icingaweb2-module-columnexport

Currently, it is only possible to export CSV/JSON with all columns.
I have requested an adjustment to make it possible to export only the columns provided in the URL (&columns=...).

See : Support ?columns also for CSV and JSON exports  (https://github.com/Icinga/icingadb-web/issues/1011)

The idea is that after applying a filter on host/service/hostgroup/servicegroup/..., one can have an additional page where they can choose which columns they want to see in the export.
