
Classes utils for Lumen

### composer.json:
```
"repositories": [
    {
        "type":"package",
        "package": {
          "name": "simpl-e/lumen-utils",
          "version":"master",
          "source": {
              "url": "https://github.com/simpl-e/lumen-utils.git",
              "type": "git",
              "reference":"master"
            }
        }
    }
],
"require": {
    "simpl-e/lumen-utils": "master"
}
```
composer install

### Import:
```
use Simple\Migration;

class Create[...]Table extends Migration {
  ...
}
```

### Usage:
```
public function up() {
  $this->col("tableName", "string", "columnName", "unique");
}
```
