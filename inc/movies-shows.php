						<h2>Dodajanje filmov in oddaj</h2>


						<form enctype="multipart/form-data" name="epg_add_movie" method="post" action="">							

						
										<label for="epg_movie_show">Naslov:<br><input name="movie_show" type="text" value="" class="regular-text" /></label><br><br>
										<label for"epg_movie_show_type">Vrsta programa:
										<select name="type">
											<?php show_type(); ?>
										</select></label>
								
										<label for="epg_category">Kategorija:
											<select name ="cat">
												<?php show_category(); ?>
											</select>
										<label for="epg_duration">Trajanje (v minutah):
										<input type="text"  class="small-text" name="duration_movie_show" /><br></label><br>
  										<label>Opis:</label><br>
										<textarea name="description_movie_show" rows="10" cols="69"></textarea>
									<br>

									
							</form>
							<input class="button-primary" type="submit" name="epg_add_movie_show_submit" value="Shrani" /> 