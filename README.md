**MagicModel**
=============

This Laravel package provides extended functions for Eloquent.

## Installation

### Laravel 4.2

1. Begin by installing this package through Composer. Edit your project's `composer.json` file to require `paulvl/magicmodel`.

		"require-dev": {
			"paulvl/magicmodel": "dev-master"
		}

	> There is no support for Laravel 5.

2. Next, update Composer from the Terminal:

		composer update --dev

3. Once this operation completes, add the service provider. Open `app/config/app.php`, and add a new item to the providers array.

		'PaulVL\MagicModel\MagicModelServiceProvider'
  
4. And add a new item to the aliases array, on same `app/config/app.php` file.

	    'MagicModel' => 'PaulVL\MagicModel\MagicModel'
	    
3. Finally in order to use **MagicModel** properly you have to extend your **"Model"** from **MagicModel** instead of **Eloquent** like this for example:

	```php
	<?php
	. . .
	class User extends MagicModel implements UserInterface, RemindableInterface {
	. . .

	```

##Usage

**MagicModel** implements the following methods:

### To Verify References

**MagicModel** allows you to easily verify if a record is referenced by another one as a **foreing key**. You can use the static `Model::hasReferences($id)` method directly from your MagicModel's extended Model:

example...
```php
<?php
	return dd(Model::hasReferences(1));
	//returns True if primary key "1" is referenced in any table as FK.
	//returns False if primary key "1" is NOT referenced in any table as FK.
?>
```

Or you can either use `$object->isReferenced()` method from an instanced object:

example...
```php
<?php
	$object = Model::find(1);
	return dd($object->isReferenced());
	//returns True if the object is referenced in any table as FK.
	//returns False if the object is NOT referenced in any table as FK.
?>
```