# Lehigh Valley Current Temp Widget

This plugin uses the [Dark Sky API](https://darksky.net/dev/) to retrieve the current temperature for Lehigh Valley (specifically: lat `37.8267`, lng `-122.4233`).

## Project URL

https://github.com/salcode/fe-lehigh-valley-current-temp

## Troubeshooting

### ? instead of actual temperature

If you're getting a `?` instead of the temperature, e.g. 

> Outdoor temperature is ?° F

There is a problem retrieving the current temperature from Dark Sky. Most often this is caused by __not__ having a Dark Sky API Key in `wp-config.php`.

#### Step 1: Get an API Key

Go to the [Dark Sky API](https://darksky.net/dev/) page and sign up for an API key. The API key will be an alphanumeric string that looks something like

```
abcdefghi1234567890jklmnopqrstuv
```

#### Step 2: Set the Dark Sky API Key in wp-config.php

In `wp-config.php` add a line like the following:

```
define( 'FE_DARK_SKY_API', 'abcdefghi1234567890jklmnopqrstuv' );
```

replacing `abcdefghi1234567890jklmnopqrstuv` with the API key you got in Step 1.

## Credits

[Sal Ferrarello](https://salferrarello.com) / [@salcode](https://twitter.com/salcode)
