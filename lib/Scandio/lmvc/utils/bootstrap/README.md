# Boostrap

A Butler and an Interface for a Bootstrap file used in lmvc to bootstrap modules or utils. The BootstrapInterface's
implementation will be called when giving the `Butler::initialize($namespace)` a correct implementation.

Used in every lmvc application to initialize e.g. their modules. Here every modules' `Boostrap.php` `initialize()` under the:

```json
"modules": [
   "Scandio\\lmvc\\modules\\session",
   "Scandio\\lmvc\\modules\\upload",
   "Scandio\\lmvc\\modules\\assetpipeline",
   "Scandio\\lmvc\\modules\\security",
   "Scandio\\lmvc\\modules\\registration"
],
```

directive will called allowing the module to set itself up.

The module protects itself against passing in namespaces having an incorrect \Boostrap by checking their instance against
the `BoostrapInterface`.

Lastly, the `Butler.php` allows for later on initializing something by passing in a string or an array of to be
bootstrapped namespaces as in `Butler::initialize(['name\space])`.