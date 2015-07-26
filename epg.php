<?php
/*
Plugin name: EPG
Description: EPG. Opozorilo ob dekativaciji bodo izbrisani vsi vnešeni podatki!
Author: Bostjan Gotar
Version 0.1
*/

$options = array();

global $epg_version;
$epg_version = '0.1';


/*
 *	Dodatne tabele
*/

function epg_install_db_epg(){

if(!file_exists("../wp-content/plugins/EPG/inc/file.txt")){
$ourFileName = "../wp-content/plugins/EPG/inc/file.txt";
$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
fclose($ourFileHandle);
}

	global $wpdb;
	global $epg_version;

	$table_name = $wpdb->prefix . 'epg';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		naslov text NOT NULL,
		kanal text NOT NULL,
		trajanje mediumint(9) NOT NULL,
		tip text NOT NULL,
		kategorija text NOT NULL,
		opis text NOT NULL,
		slika_path text,
		datum text NOT NULL,
		zacetek_ura text NOT NULL,
		konec_ura text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'epg_version', $epg_version );

}register_activation_hook( __FILE__, 'epg_install_db_epg' );

function epg_install_db(){

	global $wpdb;
	global $epg_version;

	$table_name = $wpdb->prefix . 'kategorije';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		category text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'epg_version', $epg_version );

}register_activation_hook( __FILE__, 'epg_install_db' );


function epg_install_db_kanali(){

	global $wpdb;
	global $epg_version;

	$table_name = $wpdb->prefix . 'kanali';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		channel text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'epg_version', $epg_version );

}register_activation_hook( __FILE__, 'epg_install_db_kanali' );


function epg_install_db_shows(){

	global $wpdb;
	global $epg_version;

	$table_name = $wpdb->prefix . 'oddaje_filmi';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		naslov text NOT NULL,
		trajanje mediumint(9) NOT NULL,
		tip text NOT NULL,
		kategorija text NOT NULL,
		opis text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'epg_version', $epg_version );

}register_activation_hook( __FILE__, 'epg_install_db_shows' );

function epg_install_db_type(){

	global $wpdb;
	global $epg_version;

	$table_name = $wpdb->prefix . 'vrsta_programa';
	
	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		vrsta text NOT NULL,
		UNIQUE KEY id (id)
	) $charset_collate;";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );

	add_option( 'epg_version', $epg_version );

}register_activation_hook( __FILE__, 'epg_install_db_type' );

/*
 *Konec dodatne tabele
*/


//Menuji v admin delu worpdressa
function epg_plugin_menu(){
	/*
	 *add_menu_page( $page_title, $menu_title, $capability, $menu_slug, $function, $icon_url, $position );
	*/

	/*
	 *<?php add_submenu_page( $parent_slug, $page_title, $menu_title, $capability, $menu_slug, $function ); ?>
	*/

	add_menu_page( 'EPG', 'EPG', 'manage_options', 'epg', 'epg_plugin_options_page' );

	add_submenu_page( 'epg', 'Kategorije in vrste programa', 'Kategorije in vrste programa', 'manage_options', 'category', 'epg_category' );
	
	add_submenu_page( 'epg', 'Urejanje kanalov', 'Urejanje kanalov', 'manage_options', 'add-channel', 'epg_channels' );

	add_submenu_page( 'epg', 'Oddaje/Filmi', 'Oddaje/Filmi', 'manage_options', 'movies-shows', 'epg_movies_shows' );


}add_action( 'admin_menu', 'epg_plugin_menu' );

function epg_plugin_options_page(){

	if( !current_user_can( 'manage_options' ) ) {

		wp_die( 'Nimate pravice za dostop do željene strani.' );

	}

		if(isset($_POST['load'])){

			global $wpdb;

			$table_name = $wpdb->prefix . 'oddaje_filmi';
			

			$searchq = esc_html($_POST['seznam_filmi_oddaje']);

			
			$shows_movies = $wpdb->get_results("SELECT * FROM $table_name where naslov = '$searchq'");
			
		
			foreach($shows_movies as $show_movie){
 						$naslov =  $show_movie->naslov; 
 						$trajanje = $show_movie->trajanje;
 						$tip = $show_movie->tip;
 						$kategorija = $show_movie->kategorija;
 						$opis = $show_movie->opis;
 										
	}
		}

		if(isset($_POST['epg_add_movie_show_submit'])){


			global $wpdb;

			$table_name = $wpdb->prefix . 'epg';

			$naslov = esc_html(trim($_POST['epg_title']));
			$kanal = esc_html(stripslashes(trim($_POST['epg_kanal'])));
			$tip = esc_html(stripslashes(trim($_POST['type'])));
			$kategorija = esc_html(stripslashes(trim($_POST['cat'])));
			$dolzina = esc_html(stripslashes(trim($_POST['duration_movie_show'])));
			$datum = esc_html(stripslashes(trim($_POST['izbrani_datum'])));
			$ura_zacetek = esc_html(stripslashes(trim($_POST['ura_zacetek'])));
			$ura_konec = esc_html(stripslashes(trim($_POST['ura_konec'])));
			$opis = esc_textarea(stripslashes(trim($_POST['epg_description'])));
			$content = $_FILES['userfile'];
			


			$opis = stripslashes(str_replace(array("\r", "\n"), " ", $opis));
			$naslov = str_replace(array("\\"), " ", $naslov);
			$tip = str_replace(array("\\"), " ", $tip);
			$kategorija = str_replace(array("\\"), " ", $kategorija);
			$kanal = str_replace(array("\\"), " ", $kanal);


			if($naslov == "" || $tip =="" || $kategorija == "" || $dolzina =="" ||  $opis == "" || $datum == "" || $ura_zacetek == "" || $ura_konec == "" ){
				echo "<script>jQuery(document).ready(function($){
    			alert('Izpolnite prazna polja oziroma naložite sliko!');
				});</script>";
			}else{

				if ( ! function_exists( 'wp_handle_upload' ) ) {
				    require_once( ABSPATH . 'wp-admin/includes/file.php' );
				}

				$uploadedfile = $_FILES['userfile'];

				$upload_overrides = array( 'test_form' => false );

				$movefile = wp_handle_upload( $uploadedfile, $upload_overrides );

				if ( $movefile && !isset( $movefile['error'] ) ) {
					$path =  $movefile['url'];
					$wpdb -> insert($table_name, array(
												'naslov' => $naslov,
												'kanal' => $kanal,
												'trajanje' => $dolzina,
												'tip' => $tip,
												'kategorija' => $kategorija,
												'opis' => $opis,
												'datum' => $datum,
												'zacetek_ura' => $ura_zacetek,
												'konec_ura' => $ura_konec,
												'slika_path' => $path
					));
				  				
					echo "<script>jQuery(document).ready(function($){
	    			alert('Uspešno dodano!');
					});</script>";
					export_data();
				} else {
				    /**
				     * Error generated by _wp_handle_upload()
				     * @see _wp_handle_upload() in wp-admin/includes/file.php
				     */
				    echo "<script>jQuery(document).ready(function($){
    				alert('Naložite sliko!');
					});</script>";
				}	

			
			}
		}

	require ( 'inc/main-page.php' );

}

//Dodajanje novih kanalov
function epg_channels(){
	if( !current_user_can( 'manage_options' ) ) {

		wp_die( 'Nimate pravice za dostop do željene strani.' );

	}

	if(isset($_POST['epg_add_channel_submit'])){
			
			global $wpdb;
			$kanal = esc_html(stripslashes_deep(trim($_POST['channel'])));
			$kanal = str_replace(array("\\"), " ", $kanal);
			$table_name = $wpdb->prefix . 'kanali';
			
			if($kanal ==""){
				echo "<script>jQuery(document).ready(function($){
    			alert('Vnesite kanal');
				});</script>";
			}else {
			$wpdb -> insert($table_name, array('channel' => $kanal));
			echo "<script>jQuery(document).ready(function($){
    			alert('Kanal je bil uspešno dodan');
				});</script>";
		}
	}

	  require ( 'inc/add-channel.php' );
}

function edit_channel(){
	global $wpdb;
			$table_name = $wpdb->prefix . 'kanali';

			$channels = $wpdb->get_results("SELECT * FROM $table_name");
			

				echo "<table>";
				foreach($channels as $channel){
				echo "<tr>";
				echo "<td>".$channel->channel."</td>";
				
				echo "</tr>";
				}
				echo "</table>";




	}
//Prikaze kanele
function show_channel(){

			global $wpdb;
			$table_name = $wpdb->prefix . 'kanali';

			$channels = $wpdb->get_results("SELECT * FROM $table_name");
			
					foreach($channels as $channel){
 						echo "<option value='" . $channel->channel . "'>" . $channel->channel . "</option>";
}
						
}
//Dodajanje novih kategorij
function epg_category(){

	if( !current_user_can( 'manage_options' ) ) {

		wp_die( 'Nimate pravice za dostop do željene strani.' );

	}

		global $options;

		if(isset($_POST['epg_add_category_submit'])){
			
			global $wpdb;
			$kategorija = esc_html(stripslashes(trim($_POST['cat'])));
			$kategorija = str_replace(array("\\"), " ", $kategorija);
			$table_name = $wpdb->prefix . 'kategorije';
			
			if($kategorija ==""){
				echo "<script>jQuery(document).ready(function($){
    			alert('Vnesite kategorijo');
				});</script>";
			}else {
			$wpdb -> insert($table_name, array('category' => $kategorija));
			echo "<script>jQuery(document).ready(function($){
    			alert('Kategorijo uspešno dodana');
				});</script>";
		}
	}

	if(isset($_POST['epg_add_type_submit'])){

		global $wpdb;
		$tip = esc_html(stripslashes(trim($_POST['type'])));
		$tip = str_replace(array("\\"), " ", $tip);
		$table_name = $wpdb->prefix .'vrsta_programa';

			if($tip ==""){
				echo "<script>jQuery(document).ready(function($){
    			alert('Vnesite vrsto programa');
				});</script>";
			}else {
			$wpdb -> insert($table_name, array('vrsta' => $tip));
			echo "<script>jQuery(document).ready(function($){
    			alert('Vrsta programa uspešno dodana');
				});</script>";
		}
	}


		

		require ( 'inc/category.php' );
}
		
function edit_category(){
	global $wpdb;
			$table_name = $wpdb->prefix . 'kategorije';

			$cats = $wpdb->get_results("SELECT * FROM $table_name");
			

				echo "<table>";
				foreach($cats as $cat){
				echo "<tr>";
				echo "<td>".$cat->category."</td>";
				
				echo "</tr>";
				}
				echo "</table>";

}
//Prikaze kategorije
function show_category(){

	global $wpdb;
	$table_name = $wpdb->prefix . 'kategorije';

	$category = $wpdb->get_results("SELECT * FROM $table_name;");
			
					foreach($category as $cat){
 						echo "<option  value='" . $cat->category . "'>" . $cat->category . "</option>";
}
}
//Prikaze vrsto programov
function show_type(){

	global $wpdb;

	$table_name = $wpdb->prefix . 'vrsta_programa';

	$type = $wpdb->get_results("SELECT * FROM $table_name");

		foreach ($type as $typ) {
			echo "<option  value='" . $typ->vrsta . "'>" . $typ->vrsta . "</option>";
		}


}

function epg_movies_shows(){

		if( !current_user_can( 'manage_options' ) ) {

		wp_die( 'Nimate pravice za dostop do željene strani.' );

	}

		if(isset($_POST['epg_add_movie_show_submit'])){

				global $wpdb;
				$naslov = esc_html(trim($_POST['movie_show']));
				$kategorija = esc_html(trim($_POST['cat']));
				$tip = esc_html(trim($_POST['type']));
				$dolzina = esc_html(trim($_POST['duration_movie_show']));
				$opis = esc_html(trim($_POST['description_movie_show']));
		
				$naslov = str_replace(array("\\"), " ", $naslov);
				
				$table_name = $wpdb->prefix . 'oddaje_filmi';

				if($naslov == "" || $dolzina =="" || $opis ==""){
					echo "<script>jQuery(document).ready(function($){
    			alert('Izpolnite prazna polja');
				});</script>";
				}

				else{

				$wpdb -> insert($table_name, array(
													'naslov' => $naslov,
													'trajanje' => $dolzina,
													'tip' => $tip,
													'kategorija' => $kategorija,
													'opis' => $opis,
													
					));
				echo "<script>jQuery(document).ready(function($){
    				alert('Uspešno ste dodali film ali oddajo');
					});</script>";

		}
	}


	  require ( 'inc/movies-shows.php' );
}

function show_movies_shows(){

	global $wpdb;

	$table_name = $wpdb->prefix . 'oddaje_filmi';

	$type = $wpdb->get_results("SELECT * FROM $table_name");

	foreach ($type as $typ) {
			echo "<option  value='" . $typ->naslov . "'>" . $typ->naslov . "</option>";
		}


}


function export_data(){

	if( !current_user_can( 'manage_options' ) ) {

		wp_die( 'Nimate pravice za dostop do željene strani.' );

	}
		global $wpdb;
	
		$table_name = $wpdb->prefix . 'epg';

		$exports = $wpdb->get_results("SELECT * FROM $table_name  ORDER BY kanal");
		$data = array();
		foreach ($exports as $export) {
			$json[] = $export;

	}
			$in = wp_json_encode($json, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);	
			$data = json_decode($in, true);
			$out = [];

			foreach($data as $element) {
        	$out[$element['kanal']][] = ['naslov' => $element['naslov'], 
							        	'kategorija' => $element['kategorija'], 
							        	'tip' => $element['tip'], 
							        	'trajanje' => $element['trajanje'], 
							        	'datum' => $element['datum'], 
							        	'zacetek_ura' => $element['zacetek_ura'], 
							        	'konec_ura' => $element['konec_ura'],  
							        	'opis' => $element['opis'], 
							        	'slika_path' => $element['slika_path']];
		}

		$dat =  wp_json_encode($out, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

		$myfile = fopen("../wp-content/plugins/EPG/inc/file.txt", "w") or die("Unable to open file!");
		fwrite($myfile, $dat);
		fclose($myfile);
		

			
}



function your_css_and_js() {
wp_register_style('your_css_and_js', plugins_url('jquery.datetimepicker.css',__FILE__ ));
wp_enqueue_style('your_css_and_js');
wp_register_script( 'your_css_and_js', plugins_url('jquery.datetimepicker.js',__FILE__ ));
wp_enqueue_script('your_css_and_js');
}
add_action( 'admin_init','your_css_and_js');


/*
 *Virtual page
*/
if (!class_exists('wp_virtual_page_setup')){
    class wp_virtual_page_setup
    {
        public $slug ='';
        public $args = array();

        function __construct($args){
            $this->args = $args;
            $this->slug = $args['slug'];
            add_filter('the_posts',array($this,'virtual_page'));
        }
        public function virtual_page($posts){
            global $wp,$wp_query;
            $page_slug = $this->slug;

            if(count($posts) == 0 && (strtolower($wp->request) == $page_slug || $wp->query_vars['page_id'] == $page_slug)){

                //virtual page
                $post = new stdClass;
                $post->post_author = 1;
                $post->post_name = $page_slug;
                $post->guid = get_bloginfo('wpurl' . '/' . $page_slug);
                $post->post_title = 'page title';
                //put your custom content here
                $post->post_content = 'Fake content';
                //just needs to be a number - negatives are fine
                $post->ID = -42;
                $post->post_status = 'static';
                $post->comment_status = 'closed';
                $post->ping_status = 'closed';
                $post->comment_count = 0;
                $post->post_date = current_time('mysql');
                $post->post_date_gmt = current_time('mysql',1);
                $post = (object) array_merge((array) $post, (array) $this->args);
                $posts = NULL;
                $posts[] = $post;
                $wp_query->is_page = true;
                $wp_query->is_singular = true;
                $wp_query->is_home = false;
                $wp_query->is_archive = false;
                $wp_query->is_category = false;
                unset($wp_query->query["error"]);
                $wp_query->query_vars["error"]="";
                $wp_query->is_404 = false;
            }

            return $posts;
        }
    }//end class
}//end if
$filename = plugins_url( 'inc/file.txt', __FILE__ );

$args = array(
        'slug' => 'export',
        'post_title' => 'export',
        'post_content' => file_get_contents($filename)
);

new wp_virtual_page_setup($args);

/*
 *	cleanup
*/

function pluginUninstall(){
global $wpdb;
     
    $table_name = $wpdb->base_prefix . "epg";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

    $table_name = $wpdb->base_prefix . "kategorije";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

    $table_name = $wpdb->base_prefix . "kanali";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);    

    $table_name = $wpdb->base_prefix . "oddaje_filmi";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

    $table_name = $wpdb->base_prefix . "vrsta_programa";
    $sql = "DROP TABLE IF EXISTS $table_name;";
    $wpdb->query($sql);

 $filename = "../wp-content/plugins/EPG/inc/file.txt";

 unlink($filename);


}register_deactivation_hook( __FILE__, 'pluginUninstall' );	

?>




