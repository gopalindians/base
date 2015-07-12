# Exceptions

This file lists all possible exceptions and error codes thrown by base.

| php/js | Exception | Code | Description |
| ------ | --------- | ---- | ----------- |
| php | RoutePathException | 1 | Exception thrown when a path can not be parsed. |
| php | RouteUnresolvedException | 2 | Exception thrown when a route cannot be resolved an not 404 page is set. |
| php | DbConnectionException | 3 | Exception thrown when database class cannot connect to database. |
| php | DbSelectException | 4 | Exception thrown when database class cannot select database. |
| php | RouteFileNotFoundException | 5 | Exception thrown when a route file cannot be found. |
| php | RouteFileParseException | 6 | Exception thrown when a route file cannot be parsed. |
| js | AjaxStatusException | - | Thrown if a bad status was returned by ajax request. |
| js | DataNoJsonException | - | Thrown if an json object cannot be parsed. |
| js | MethodNotImplementedException | - | Thrown if a "abstract" JavaScript method must be implemented, but hasen't. |
