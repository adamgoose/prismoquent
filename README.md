# Prismic.io for Laravel

> [prismic.io](http://prismic.io) is a web software you can use to manage content in any kind of website or app. API-driven, it is the easiest way to integrate your content with no technology or design constraint. It is also the easiest way for content writers to edit, preview and plan updates.

## Installation

To install Prismic.io for Laravel, add `"adamgoose/prismic-io" : "dev-master"` to your `composer.json` file, and execute `composer update`.

Next, add `"Prismic" => "Adamgoose\PrismicIo\Model"` to the `aliases` array in `/app/config/app.php`.

## Usage

> A full API documentation is available [here](http://adamgoose.github.io/prismic-io/).

Prismic.io for Laravel assist you in accessing your Prismic.io Repository. It is essentially an API wrapper designed for Laravel developers. It will remind you a lot of Eloquent! Let's learn by example!

Say you'd like to build a website for listing recipes. Let's start by creating the `Recipe` model.

    // /app/models/Recipe.php

    <?php

    class Recipe extends Prismic {
        /**
         |
         | The syntax `https://{REPOSITORY-ID}.prismic.io/api` is the current
         | standard, however Prismic.io has reserved the right to change this
         | in the future. You can always find the most up-to-date API endpoint
         | URL in your Repository Settings.
         |
         */
        protected $endpoint = 'https://my-recipe-blog.prismic.io/api';
        protected $token = '## TOKEN WITH MASTER ACCESS ##';

        public $collection = 'recipes';
    }

Now, in order to retreive all of the Recipes, you can simply run the following command:

    $recipes = Recipe::get();

This will execute the query that's predefined by the 'recipes' collection on Prismic.io, and return an instance of `Illuminate\Support\Collection` containing the documents (instances of `Prismic\Document`).

> See the [Laravel API](http://laravel.com/api/class-Illuminate.Support.Collection.html) for information on `Illuminate\Support\Collection`.

> See the [php-kit Documentation](https://github.com/prismicio/php-kit/blob/master/src/Prismic/Document.php) for information on `Prismic\Document`.

Since you have an instance of `Illuminate\Support\Collection`, you can now call methods like `sort()`, `filter()`, or `slice()` to sort, filter, or offset/limit your results.

Instead of defining `public $collection` in `Recipe.php`, we could define any of the following variables:

* public `$endpoint` - Sets API endpoint. *Required!*
* public `$mask` - Limits the results to on a particular mask
* public `$tags` - Array of tags by which to limit the query

> You could also define `protected $ref`, which would be you release ID. This is only recommended during development.

If none of the variables above are defined in your model that extends `Prismic`, your model will essentially be a wrapper for the entire Prismic.io Repository.

You can also define `$collection`, `$mask`, `$tags`, and `$ref` statically each time you call the model using `collection($collection)`, `mask($mask)`, `tags(array($tag, $tag2))`, and `ref($ref)` respectively. You may also chain these methods together to define the query however you'd like.

Say we'd like to get all of the "dessert" recipes. We could do something like this:

    $desserts = Recipe::tags(array('dessert'))->get();

Now we just need five desserts for the home-page slider:

    $slides = Recipe::tags(array('dessert'))->get()->slice(0, 5);

Furthermore, you can use the `at($key, $value)` or `any($key, array $values)` methods to append predicated queries to your API call.

> You can read up on predicated queries at the [Prismic.io Developer Center](https://developers.prismic.io/documentation/UjBe8bGIJ3EKtgBZ/api-documentation#predicate-based-queries).

Once you've defined all of your query parameters, use the `get()` method to return an instance of `Illuminate\Support\Collection` containing your results.

## Shortcuts

I've added a couple helper methods for you, to make querying a bit easier.

The `find($id)` method will return a document (matching the current query, as defined by either your extension of `Prismic` or the runtime static call) with the designated `$id`.

The `first()` method is the same as running `->get()->first()`. Remember: since `get()` returns an instance of `Illuminate\Support\Collection`, the `first()` method executed on the collection would retreive the first item in the collection. I've simply created an alias for you. You're welcome.

## License

Prismic.io for Laravel is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).

## Troubleshooting and Support

Please feel free to create a GitHub Issue, and we'll do our best to help you out.

## Contributing

Feel free to fork and submit a pull request if you think there's anything else Prismic.io for Laravel could do!