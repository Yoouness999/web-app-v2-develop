# Read me, fool!

## Basic rules

- do not **ever** add something into `./public/assets/*` -> **always** do it in `/resources/assets/*`
- in Javascript, `use strict` is not an option but a mandatory (really, dude)


## Workflow

### Javascript

```
js/
    components/     -> project specific components
    lib/            -> custom utils components
    plugins/        -> plugins copied (manually) from "bower_components/" or other
    shared/         -> custom components
    main.js         -> entry point
```

All components are conceptualized `agnostic`.

We use a modified DOM routing (see `main.js`) in combination with `angular`.
(...)

Webpack and BabelJS are used to:

1. transpile ES6 to ES5 -> keep in mind that ES6 has some epic thing to work with
2. bundle all dependencies, so we can use `import` and `export` quite safely -> be warned that in some case you'll have to configure Webpack (see by example `gulpconfig.js` and `webpack external import`)


### Sass


### Fonts


### Images


## Todo

We use `@TODO`, `@NOTE` or `@FIXME` to communicate between us in source code. Be smart, concise and polite.
 
 

## @TODO

- [ ] Add sources and recommendations to write tests