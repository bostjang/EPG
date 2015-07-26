<h3>Urejanje kategorij</h3>
<div class="wrap">

	
	<div id="col-container">

		<div id="col-right">

			<div class="col-wrap">
				
				<div class="inside">
				<h3>Vse kategorije:</h3>
		<?php 

			edit_category();
		?>

		<h3>Vrsta programa:</h3>

			<?php
				show_type();
			 ?>
				</div>

			</div>
			<!-- /col-wrap -->

		</div>
		<!-- /col-right -->

		<div id="col-left">


			<div class="col-wrap">
				<h3>Dodaj kategorijo</h3>
				<div class="inside">
					
							<form name="epg_add_category" method="post" action="">							

							<table class="form-table">
								<tr>
									<td>
										<label for="epg_category">Dodaj kategorijo:<br><input name="cat" type="text" value="" class="regular-text" /></label>
										
										<input class="button-primary" type="submit" name="epg_add_category_submit" value="Shrani" /> 
										
									</td>

								</tr>								
							</table>


							</form>

							<form name="epg_add_type" method="post" action="">							

							<table class="form-table">
								<tr>
									<td>
										<label for="epg_type">Dodaj vrsto programa:<br><input name="type" type="text" value="" class="regular-text" /></label>
										<input class="button-primary" type="submit" name="epg_add_type_submit" value="Shrani" /> 
									</td>

								</tr>								
							</table>


							</form>

				<!--<label>Dodaj kategorijo:<input type="text" value="" class="regular-text" /></label>
				<input class="button-primary" type="submit" name="shrani_cat" value="Shrani"/>
				-->
				</div>
			</div>
			<!-- /col-wrap -->

		</div>
		<!-- /col-left -->

	</div>
	<!-- /col-container -->

</div> <!-- .wrap -->
