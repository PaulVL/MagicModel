<?php namespace PaulVL\MagicModel;

class MagicModel extends \Eloquent {

  protected $tableName = null;
  
  public function __construct(array $attributes = []){
    parent::__construct($attributes);
    $this->tableName = parent::getTable();
  }
  
  public static function getTableName()
  {
    return with(new static)->tableName;
  }

  public function isReferenced()
  {
    $id = parent::getKey();
    $hasRefrences = false;
    $def = \Config::get('database.default');
    $constraint_schema = \Config::get("database.connections.$def.database");
    $referenced_data = \DB::table('INFORMATION_SCHEMA.KEY_COLUMN_USAGE')
      ->where('CONSTRAINT_SCHEMA', $constraint_schema)
      ->where('REFERENCED_TABLE_NAME', $this->tableName)
      ->select(array('TABLE_NAME' , 'COLUMN_NAME'))
      ->get();    
    foreach ($referenced_data as $r) {
      $validator = \DB::table($r->TABLE_NAME)->select('*')->where($r->COLUMN_NAME, $id)->get();
      if(count($validator)>0)
      {
        $hasRefrences= true;
        break;
      }
    }
    return $hasRefrences;
  }  

  public static function hasReferences($id)
  {
    $hasRefrences = false;
    $def = \Config::get('database.default');
    $constraint_schema = \Config::get("database.connections.$def.database");
    $referenced_data = \DB::table('INFORMATION_SCHEMA.KEY_COLUMN_USAGE')
      ->where('CONSTRAINT_SCHEMA', $constraint_schema)
      ->where('REFERENCED_TABLE_NAME', self::getTableName())
      ->select(array('TABLE_NAME' , 'COLUMN_NAME'))
      ->get();    
    foreach ($referenced_data as $r) {
      $validator = \DB::table($r->TABLE_NAME)->select('*')->where($r->COLUMN_NAME, $id)->get();
      if(count($validator)>0)
      {
        $hasRefrences= true;
        break;
      }
    }
    return $hasRefrences;
  }

}