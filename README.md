## Analytical JS

Open source, transparent, simple and free for all website analytics.

## About the project

Analytical JS aims to be a simple, transparent and open source website statistics that anyone can use for free.

Either download the source or use it at https://analyticaljs.com for free and help make the internet more open and transparent. Just enter your website domain and install Analytical JS.

See the statistics of iDev.Games here:
https://analyticaljs.com/site/idev.games

## How to Install

First clone the project into your local environment. You will need to point your development domain towards the public_html folder within the cloned repository folder:

```
git clone https://github.com/AnalyticalJS/AnalyticalJS.git
```

Then navigate to your folder through command line. Something like the below example depending on OS:

```
cd /home/usr/code/AnalyticalJS
```

And then run composer install (Install composer if not installed):

```
composer install
```


Then change the .env.example into .env. Then fill the details in for the database, APP_URL and APP_URL_PROD. Then run the key generate command in the Analytical JS repository folder:

```
php artisan key:generate
```


And then run npm install (Install node if not installed):

```
npm install
```


After this you can either use:

```
npm run dev
```

OR

```
npm run watch
```

These development build of the assets will include URLs from what you entered into APP_URL in the .env file. Allowing Analytical JS to work from your local setup. Visiting the site locally and viewing the domain page for the local domain should show the statistics.

If you run:

```
npm run production
```

You'll build the asset files with the APP_URL_PROD environment variable. Which should be your production URL. So this should always be run before pushing up.

