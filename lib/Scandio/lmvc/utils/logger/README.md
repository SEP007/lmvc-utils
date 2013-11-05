# Logger

An PSR-3 compliant convention-over-configuration logger which can be easily integrated into any lmvc application.
Configuration is accomplished through a `config.json` directive. Moreover, this implementation offers multiple
independent scribes per instance all having a custom *local* LogLevel.

A basic configuration for the logger would be:

```json
{
    "logger": {
        "level": "ERROR",
        "logRoot": null,
        "scribes": [{
            "namespace": "\\Scandio\\lmvc\\utils\\logger\\scribes\\FileScribe",
            "formatter": "\\Scandio\\lmvc\\utils\\logger\\formatters\\LineFormatter",
            "level": "EMERGENCY",
            "path": "logs"
        }]
    }
}
```

Here it becomes obvious that every logger has a global level in e.g. `ERROR` and each sribe a local one `EMERGENCY`.
Important to note that *the global level overwrites the local one*. The sole purpose of this is to be able to define
a global "high" (log most things) threshold and then on the scribe's level to decide if the message should
be logged using the scribe.

Moreover, every scribe must come with a formatter to format the log-messages in a possible special manner.
Scibes and Formatters must be implemented using their interface and will not be added at the `Logger::instance()->initialize()`.
Anyhow, both come with an abstract extension already aggregating most of the redundant work.

Currently the logger supports the following levels:

```php
const DEBUG     = 100;
const INFO      = 200;
const NOTICE    = 250;
const WARNING   = 300;
const WARN      = 300;
const EMERGENCY = 350;
const ALERT     = 400;
const CRITICAL  = 450;
const ERROR     = 500;
```

the constants' value implicating their threshold whenever configuring a `level` in the config file.

Every constant has an equivalent log-level method as given by the PSR-3 standards specification.

```php
public function emergency($message, array $context = array())
public function alert($message, array $context = array())
public function critical($message, array $context = array())
public function error($message, array $context = array())
public function warning($message, array $context = array())
public function notice($message, array $context = array())
public function info($message, array $context = array())
public function debug($message, array $context = array())
```

Callable with e.g. `Logger::instance()->warn` which also shows that the Logger is a singleton, so no need
to instanciate it everywhere.

The `logRoot` from the config file is null and should be set in your application's `Boostrap` which should call
the logger's `configure($rootPath)`.

That'll be all.