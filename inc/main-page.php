<script>  
jQuery(document).ready(function() {	
		jQuery('#zacetek_ura').datetimepicker({
  
  			datepicker:false,
  			format:'H:i',
  			step:5
		});
		jQuery('#konec_ura').datetimepicker({
  
  			datepicker:false,
  			format:'H:i',
  			step:5
		});
		jQuery('#datum').datetimepicker({
  			timepicker:false,
  			format:'d.m.Y'
		});
});
	</script>
<h1>Urejanje sporeda</h1>
	<form enctype="multipart/form-data" name="epg_add" method="post" action="">							

						
		<label for="epg">Naslov:<br><input name="epg_title" type="text" value="<?php if (isset($_POST["load"])){echo esc_html(trim($naslov));} ?>" class="regular-text" /></label>
		<laber for="seznam_filmov_oddaj">Seznam filmov in oddaj
		<select name="seznam_filmi_oddaje">
			<option value=""></option>
			<?php show_movies_shows(); ?>
		</select></label>
		<input class="button-primary" type="submit" name="load" value="Naloži" /> 

		<br><br>
		<laber for="epg_channel">Kanal:
			<select name="epg_kanal">
				<?php show_channel(); ?>
			</select>
		<label for"epg_movie_show_type">Vrsta programa:
			<select name="type">
				<?php if (isset($_POST['load'])){
					echo "<option>" . esc_html(trim($tip)) . "</option>";
					} ?>
				<?php show_type(); ?>
			</select></label>
		<label for="epg_category">Kategorija:
			<select name ="cat">
				<?php if (isset($_POST['load'])){
					echo "<option>" . esc_html(trim($kategorija)) . "</option>";
					} ?>
				<?php show_category(); ?>
			</select>
		<label for="epg_duration">Trajanje (v minutah):<input type="text"  class="small-text" name="duration_movie_show" value='<?php if (isset($_POST["load"])){echo $trajanje;} ?>'/><br></label>
		<br>

			<label for="datum">Datum:<input id="datum" type="text" name="izbrani_datum"/></label>
			<laber for="zacetek">Začetek:<input id="zacetek_ura" type="text" name="ura_zacetek" ></label>
			<laber for="konec">Konec:<input id="konec_ura" type="text" name="ura_konec" ></label>

			</select>
			<br>
			</span><br>
  				<label>Opis:</label><br>
				<textarea name="epg_description" rows="10" cols="82" ><?php if (isset($_POST["load"])){echo esc_html(trim($opis));} ?></textarea><br>
				<label for="movie_show_picture">Naloži sliko:</label><br>
				<input type="hidden" name="MAX_FILE_SIZE" value="2000000">
				<input name="userfile" type="file" id="userfile"> 
							
			</form><br><br>
			<input class="button-primary" type="submit" name="epg_add_movie_show_submit" value="Shrani" /> 
