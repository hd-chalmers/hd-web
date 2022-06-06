# hd-web
This is the website seen in [hd.chalmers.se](https://hd.chalmers.se) or in the staging server [diod.hd.chalmers.se](diod.hd.chalmers.se) and is dependent on the REST API [HD DB API](https://github.com/hd-chalmers/hd-db-api) while the databse is edited with [HD Web Loehk](https://github.com/hd-chalmers/hd-web-loehk). This project uses Vue.js + Nuxt where Vue is a templating framework and Nuxt is a framework that handles configuration for various configuration regarding a vue web app. There's also support for SCSS styling and Typescript for type checking in JavaScript.
## Build Setup
To run make sure you have NodeJS and yarn installed. Yarn can be installed via NPM as seen below. To run in a container then docker needs to be installed.
Also make sure that a `.env` is present in the **web** directory of the project, otherwise it can be created by copying the `.env.example` file.

```bash
# install dependencies
$ yarn install

# serve with hot reload at localhost:3000
$ yarn dev

# generate static project to run with client rendering or as a Web app (PWA)
$ yarn generate

# build for production and launch server with server side rendering (may require a change in nuxt config)
$ yarn build
$ yarn start

# Render code documentation into a static HTML file
$ yarn styleguide:build
$ yarn styleguide # starts server with live reload

# to build and run the website in a server in a docker container
$ docker-compose up
```

For detailed explanation on how things work in Nuxt, check out the [documentation](https://nuxtjs.org).

## Directories
The web files will be found in `web/` and acts as the source directory refrenced as `@` so if a vue file wants to access interfaces.ts in the assets directory then it's written as `@/assets/interfaces.ts`. However the static directory works differently and will be mapped at root (`/`).

#### `nginx-config`
This is used by the docker container to configure the nginx server inside the container. The directory will be copied to `/etc/nginx/` in the container.

### Nuxt directories
You can create the following extra directories, some of which have special behaviors. Only `pages` is required; you can delete them if you don't want to use their functionality.

#### `assets`

The assets directory contains your uncompiled assets such as Stylus or Sass files, images, or fonts.

More information about the usage of this directory in [the documentation](https://nuxtjs.org/docs/2.x/directory-structure/assets).

#### `components`

The components directory contains your Vue.js components. Components make up the different parts of your page and can be reused and imported into your pages, layouts and even other components.

More information about the usage of this directory in [the documentation](https://nuxtjs.org/docs/2.x/directory-structure/components).

#### `layouts`

Layouts are a great help when you want to change the look and feel of your Nuxt app, whether you want to include a sidebar or have distinct layouts for mobile and desktop.

More information about the usage of this directory and how the routing works in [the documentation](https://nuxtjs.org/docs/2.x/directory-structure/layouts).


#### `pages`

This directory contains your application views and routes. Nuxt will read all the `*.vue` files inside this directory and setup Vue Router automatically.

More information about the usage of this directory in [the documentation](https://nuxtjs.org/docs/2.x/get-started/routing).

#### `plugins`

The plugins directory contains JavaScript plugins that you want to run before instantiating the root Vue.js Application. This is the place to add Vue plugins and to inject functions or constants. Every time you need to use `Vue.use()`, you should create a file in `plugins/` and add its path to plugins in `nuxt.config.js`.

More information about the usage of this directory in [the documentation](https://nuxtjs.org/docs/2.x/directory-structure/plugins).

#### `static`

This directory contains your static files. Each file inside this directory is mapped to `/`.

Example: `/static/robots.txt` is mapped as `/robots.txt`.

More information about the usage of this directory in [the documentation](https://nuxtjs.org/docs/2.x/directory-structure/static).

#### `store`

This directory contains your Vuex store files. Creating a file in this directory automatically activates Vuex.

More information about the usage of this directory in [the documentation](https://nuxtjs.org/docs/2.x/directory-structure/store).
