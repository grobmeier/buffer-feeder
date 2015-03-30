# Buffer Feeder

A small lib which let's you auto-publish from RSS to Buffer
using the command line.

This code is in pretty early stages and may change. Your input
and suggestions are welcome.

You'll need to create a Buffer application and get an access
token from there.

## Examples

### Showing profiles

```
bin/buffer profiles <access token>
```

Shows a list with all connected profiles.

### Configuration file

This is a basic configuration file:

```
[
  {
    "url": "http://feeds.feedburner.com/dartosphere",
    "service": [
      {
        "profile": "xxx",
        "text": "%title% - %url% %hashtags%",
        "limit": 100,
        "hashtags": "#dartlang"
      }
    ],
    "archive": "archive.json"
  }
]
```

You can have as many job definitions as you want (in theory).
The URL is the url to a valid feed. The service section is the
definition of the services you want to connect. Think
of services as connected social media accounts.

The "profile" fields names the Buffer-id of a service. You can find
out about it using the previously mentioned profile-request.

Text is the format of the text. %title% etc will be replaced with
the corresponding values.

"limit" names the maximum number of characters which is allowed. Please note, this
is not bug free. Otherwise it's useful for Twitter.

The "archive" file is a file in which is stored what RSS items
were sent out.

## License

The code is licensed [Apache License 2.0](https://www.apache.org/licenses/LICENSE-2.0.html).