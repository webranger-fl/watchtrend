<?php

namespace App\Helpers;

class ControllerGenerator {


  public static function generateController($resource) {
    //dd('generateController');
    $contents = '';
    $model = ucfirst($resource);
    $resource = lcfirst($resource);
    //$crudName = $modelSingular . "Crud";
    $controllerName = $model . "Controller";
  
    $contents .= "<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\\$model;

class $controllerName extends Controller
{
  public \$fields;

  public function __construct()
  {
    \$this->fields = [
      ['title' => 'Название', 'key' => 'name', 'type' => 'text', 'required' => true],
      ['title' => 'URL', 'key' => 'url', 'type' => 'text', 'required' => true],
    ];
  }

    public function index()
    {
        \$items = $model::all();

        return view('admin.$resource.index', compact('items'));
    }

    public function create()
    {
      \$fields = \$this->fields;
        return view('admin.$resource.create', compact('fields'));
    }

    public function store(Request \$req)
    {
      $model::create(\$req->all());

      return redirect()->route('admin.$resource.index');
    }

    public function edit($model $$resource)
    {
      \$fields = \$this->fields;
        return view('admin.$resource.edit', compact('$resource', 'fields'));
    }

    public function update(Request \$req, $model $$resource)
    {
      \$resource->update(\$req->all());

      return redirect()->route('admin.$resource.index');
    }

    public function destroy($model $$resource)
    {
        \$resource->delete();
        return redirect()->route('admin.$resource.index');
    }
}
";
    $contents = str_replace('resource', $resource, $contents);
    
    file_put_contents(base_path() . '/app/Http/Controllers/Admin/' . $model . 'Controller.php', $contents);
  
  }

}

