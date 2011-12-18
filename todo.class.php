<?php
class ToDo{
  private $data;
  public function __construct($par){
    if(is_array($par))
      $this->data = $par;
  }
  public function __toString(){
    return '
      <li id="todo-'.$this->data['id'].'" class="todo">
        <div class="text">'.$this->data['text'].'</div>
        <div class="actions">
          <a href="#" class="edit">E</a>
          <a href="#" class="delete">D</a>
        </div>
      </li>';
  }
  public static function edit($id, $text){
    $text = self::esc($text);
    if(!$text) throw new Exception("wrong update text!");
    mysql_query("UPDATE labs_todo SET text='".$text."' WHERE id=".$id);
    if(mysql_affected_rows($GLOBALS['link'])!=1)
      throw new Exception("couldn't update item!");
  }
  public static function delete($id){
    mysql_query("DELETE FROM labs_todo WHERE id=".$id);
    if(mysql_affected_rows($GLOBALS['link'])!=1)
      throw new Exception("couldn't delete item!");
  }
  public static function rearrange($key_value){
    $updateVals = array();
    foreach($key_value as $k=>$v){
      $strVals[] = 'WHEN '.(int)$v.' THEN '.((int)$k+1).PHP_EOL;
    }
    if(!$strVals) throw new Exception("no data!");
    mysql_query("UPDATE labs_todo SET position = CASE id ".join($strVals)." ELSE position END");
    if(mysql_error($GLOBALS['link']))
      throw new Exception("error updating positions!");
  }
  public static function createNew($text){
    $text = self::esc($text);
    if(!$text) throw new Exception("wrong input data!");
    $posResult = mysql_query("SELECT MAX(position)+1 FROM labs_todo");
    if(mysql_num_rows($posResult))
      list($position) = mysql_fetch_array($posResult);
    if(!$position) $position = 1;
    mysql_query("INSERT INTO labs_todo SET text='".$text."', position = ".$position);
    if(mysql_affected_rows($GLOBALS['link'])!=1)
      throw new Exception("error inserting!");
    echo (new ToDo(array(
      'id'  => mysql_insert_id($GLOBALS['link']),
      'text'  => $text
    )));
    exit;
  }
  public static function esc($str){
    if(ini_get('magic_quotes_gpc'))
      $str = stripslashes($str);
    return mysql_real_escape_string(strip_tags($str));
  }
}
?>