<?php

namespace base;

/**
 * Abstract base class for database drivers.
 *
 * @author Marvin Blum
 */
abstract class Database{
	const DEFAULT_CHARSET = 'ISO-8859-1';
    const PREFIX_PATTERN = '{prefix}';

    protected $con = null;
    protected $prefix;
}
?>
