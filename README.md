<p align="center"><a href="https://pharaonic.io" target="_blank"><img src="https://raw.githubusercontent.com/Pharaonic/logos/main/has-images.jpg"></a></p>

<p align="center">
<a href="https://github.com/Pharaonic/laravel-has-images" target="_blank"><img src="http://img.shields.io/badge/source-pharaonic/laravel--has--images-blue.svg?style=flat-square" alt="Source"></a> <a href="https://packagist.org/packages/pharaonic/laravel-has-images" target="_blank"><img src="https://img.shields.io/packagist/v/pharaonic/laravel-has-images?style=flat-square" alt="Packagist Version"></a><br>
<a href="https://laravel.com" target="_blank"><img src="https://img.shields.io/badge/Laravel->=6.0-red.svg?style=flat-square" alt="Laravel"></a> <img src="https://img.shields.io/packagist/dt/pharaonic/laravel-has-images?style=flat-square" alt="Packagist Downloads"> <img src="http://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Source">
</p>


#### Laravel images provides a quick and easy way to link images with a model.

###### 



## Install

Install the latest version using [Composer](https://getcomposer.org/):

```bash
$ composer require pharaonic/laravel-has-images
```

then publish the migration & config images
```bash
# if you didn't publish Pharaonic\laravel-uploader before.

$ php artisan vendor:publish --tag=laravel-uploader
```

```bash
$ php artisan vendor:publish --tag=laravel-has-images
$ php artisan migrate
```



## Usage
- [Including it in a Model](#INC)
- [How to use](#HTU)
- [Uploader Options](#UP)




<a name="INC"></a>

#### Including it in a Model
```php
// An example
// Using HasImages in Article Model
...
use Pharaonic\Laravel\Images\HasImages;


class Article extends Model
{
    use HasCustomAttributes, HasImages;
    ...
}
```



<a name="HTU"></a>

#### How to use

```php
$article = Article::find(1); 		// Model
$images = $article->images 		// Article Images
$article->addImage($request->fileName);	// Setting New Single Image

echo $article->images[0]->url; 	        // Getting image URL

// Create Article
$article = new Article;
...
$article->images = [			// Setting Images List
	$request->file1,
	$request->file2,
	$request->file3
];
$article->save();

echo $article->images[2]->url;



// Delete Images
$article->delete(); 			// Delete Article with all related images
// OR
$article->clearImages();		// Delete all related images
// OR
$article->images[2]->delete();		// Delete image with Index

```



<a name="UP"></a>

#### Uploader Options

###### $article->images[index number] is retrieving Uploader Object.

###### That's allow for us use all [Pharaonic/laravel-uploader](https://github.com/Pharaonic/laravel-uploader) options.



```php
$image = $article->images[0];
```
```php
// Information
echo $image->hash; 			// Image's Hash
echo $image->name; 			// Image's Name
echo $image->path; 			// Image's Path
echo $image->size; 			// Image's Size in Bytes
echo $image->readableSize(); 		// Image's Readable Size [B, KB, MB, ...] (1000)
echo $image->readableSize(false); 	// Image's Readable Size [B, KiB, MiB, ...] (1024)
echo $image->extension; 		// Image's Extension
echo $image->mime; 			// Image's MIME

echo $image->visits; 			// Image's visits (Visitable Image)


// Getting URL
echo $image->url; 			// Getting Uploaded Image's URL


// Deleting The Image
$image->delete();


// Permits (Private Image)
$permits = $image->permits; 			// Getting Permits List
$permitted = $image->isPermitted($user); 	// Checking if permitted (App\User)

$image->permit($user, '2021-02-01'); 		// Permitting a user
$image->forbid($user); 				// Forbidding a user
```





## License

[MIT license](LICENSE.md)
