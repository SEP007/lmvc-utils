# Config

A class offering the ability to load json files into a Config manager which will extend entries according to latest-entry
wins. Entries can then easily be used all over an application.

It comes with a default configuration which should make an lmvc application executable following the recommend
directory structure. Later more config files e.g. by modules can be loaded calling `Config::inititaize('config.json')`.
Values in that config will only replace existing once when passing in `Config::initialize('config.json', true)`. Mostly
reasoned in the fact that the application's configuration should be preserved over an modules' one - as in bottom
configurations should not replace top ones.

Getting values is also fairly easy in calling `Config::get()->some->value`.