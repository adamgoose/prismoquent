# Prismic.io for Laravel

> [prismic.io](http://prismic.io) is a web software you can use to manage content in any kind of website or app. API-driven, it is the easiest way to integrate your content with no technology or design constraint. It is also the easiest way for content writers to edit, preview and plan updates.

## Installation

To install Prismic.io for Laravel, add `"adamgoose/prismic-io" : "dev-master"` to your `composer.json` file, and execute `composer update`.

Next, open `/app/config/app.php`, and add `'Adamgoose\PrismicIo\PrismicIoServiceProvider',` to the `providers` array and `'Prismic' => 'Adamgoose\PrismicIo\Facades\Prismic',` to the `aliases` array.

Finally, execute `php artisan config:publish adamgoose/prismic-io` to publish the configuration files.

## Configuration

After installation, you'll want to configure Prismic.io for Laravel by editing `/app/config/packages/adamgoose/prismic-io/config.php`. Add your Prismic.io Repository ID and an Application Token.

## Usage

Prismic.io for Laravel assist you in accessing your Prismic.io Repository. It is essentially an API wrapper designed for Laravel developers. It will remind you a lot of Eloquent!

To get all of the documents in a Prismic.io Collection, you can use the `collection()` method:

    $documents = Prismic::collection('my-collection')->get();

> The get() method will execute the API call and return an array of \Prismic\Document (see the [Prismic.io php-kit](http://github.com/prismicio/php-kit)).

To get all of the documents using a particular mask, you can use the `mask()` method:

    $documents = Prismic::mask('my-mask')->get();

To get all of the documents using one or more tags, you can use the `tags()` method:

    $documents = Prismic::tags(array('my-tag', 'my-tag-2', 'my-tag-3'))->get();

To use a custom predicated query (see the [Prismic.io API Documentation](https://developers.prismic.io/documentation/UjBe8bGIJ3EKtgBZ/api-documentation)), you can use the `query()` method:

    $documents = Prismic::query('your-predicated-query')->get();

To sort the results by a particular date field, you can use the `getBy()` method *instead of the `get()` method*:

    $documents = Prismic::collection('your-collection')->getBy('your-date-field');

To fetch the document matching a particular slug, you can use the `getSlug()` method *instead of the `get()` method*:

    $document = Prismic::getSlug('your-document-slug');

> Note that the `getSlug()` method only returns a single instance of `\Prismic\Document` rather than array. Additionally, the slug matching is done on the basis of the `\Prismic\Document::slug()` method, therefore to generate a link, you can utilize `$document->slug()`.

To fetch a document by its ID, you can use the `getId()` method *instead of the `get()` method*:

    $document = Prismic::getId('your-document-id');

> Note that the `getId()` method only returns a single instance of `\Prismic\Document` rather than an array.

You can also fetch a bookmarked document, by using the `getBookmark()` method *instaed of the `get()` method*:

    $document = Prismic::getBookmark('home');

In addition to all of these methods, if you have an Application Token that has access to past and future releases, you can use the `ref()` method to declare whith release you'd like to use before the `collection()`, `mask()`, `tags()`, or `query()` method:

    $documents = Prismic::ref('your-revision-id')->collection('your-collection-id')->get();

Finally, you can combine these methods any way you'd like:

    $documents = Prismic::collection('your-collection-id')->tags(array('my-tag-1', 'my-tag-2'));

## License

Prismic.io for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Troubleshooting and Support

Please feel free to create a GitHub Issue, and we'll do our best to help you out.

## Contributing

Feel free to fork and submit a pull request if you think there's anything else Prismic.io for Laravel could do!