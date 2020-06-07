Inspired by [the ransack gem](https://github.com/activerecord-hackery/ransack) eloquent ransack's goal is to provide a simplistic filtering method on eloquent models.

## Usage

The Ransackable trait provides a ransack scope that you pass an array of input to. All filters should be of the form `column_name_predicate` where predicate is one of the options listed in the table below.

## Available Filtering Types

| predicate | example            | sql                            |
| --------- | ------------------ | ------------------------------ |
| eq        | name_eq            | where "name" = ?               |
| not_eq    | name_not_eq        | where "name" != ?              |
| cont      | name_cont          | where "name" LIKE ?            |
| in        | category_id_in     | where "category_id" in (?)     |
| not_in    | category_id_not_in | where "category_id" not in (?) |
| lt        | date_lt            | where "date" < ?               |
| lte       | date_lte           | where "date" <= ?              |
| gt        | date_gt            | where "date" > ?               |
| gte       | date_gte           | where "date" >= ?              |

## Example

Eloquent Model

```php
use Jdexx\EloquentRansack\Ransackable;

class Post
{
  use Ransackable;
}
```

Form

```html
<form>
  <input type="text" name="name_eq" />
</form>
```

Controller

```php
class PostsController
{
  public function index(Request $request)
  {
    $params = $request->all();
    $posts = Post::ransack($params)->get();
  }
}
```
