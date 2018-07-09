<?php
/*
Plugin Name: FoxForm
Description: custom pluginas
*/
function FoxFoma(){
// form content
$content = "<form method=post action=''>
                <label>Vardas</label></br>
                <input type=text name=user value='' style=width: 80%;>
                </br></br>
                <label>žinutė</label>
                </br>
                <textarea name=cont value='' style=width: 80%; height: 250px;resize: none;></textarea>
                </br></br>
                <input type=submit name=submit value=Send>
                </form>";

return $content; // return content

}

add_shortcode('Form','FoxFoma');

$table_testas = $wpdb->prefix . "testas"; // prefix for custom table in mysqldb

if(isset($_POST['submit'])&& !empty($_POST["user"])&& !empty($_POST["cont"])){ 

global $wpdb; // connection to wp database

$notrue = false; 

// get info from input fields

$user = $_POST['user']; 
$cont = $_POST['cont'];

// insert data to wp database table 
if($wpdb->insert(
	"$table_testas",
	array('id'=>'','title'=>$user,'content'
		=>$cont,'status'=>"open")
) == $notrue) wp_die("nepavyko");
//else echo "<center>pavyko</center>"; // for testing

// redirect to post page
else echo '<script type="text/javascript">window.location = "custom-posts"</script>';
}


function response(){

  $res = "";

  global $wpdb;

  $table_testas = $wpdb->prefix . "testas";


  $users = $wpdb->get_results( " SELECT  * FROM $table_testas" );


  //var_dump($users);
  echo "<table><thead><tr><th>Id</th><th>Title</th><th>Post</th><th>Delete</th></tr></thead>";
  foreach ($users as $result) :
  echo "<form method=post action=>";
  echo "<tbody><tr><td>".$result->id."</td><td>".$result->title."</td> <td>".$result->content."</td>";
  echo "<td><a href=custom-posts?id=".$result->id." target=self><input type=submit name=delete Value=Delete></a></td></tbody>";
  echo "</form>";
  endforeach;
  echo "</table>";
// delete fucntion here

$id = $result->id;

$table = $wpdb->prefix . "testas";

if(isset($_POST['delete'])){

  //echo "asd";
$wpdb->delete( $table, array( 'id' => $id ) );

echo '<script type="text/javascript">
           window.location = "custom-posts"
      </script>';
}
	
	return $res;
}

add_shortcode('Response','response');


?>