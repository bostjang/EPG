<h3>Urejanje kanalov</h3>
<div class="wrap">

	
	<div id="col-container">

		<div id="col-right">

			<div class="col-wrap">
				
				<div class="inside">
				<h3>Vsi kanali</h3>
		<?php 

				edit_channel();
		?>
				</div>

			</div>
			<!-- /col-wrap -->

		</div>
		<!-- /col-right -->

		<div id="col-left">


			<div class="col-wrap">
				<h3>Dodaj kanal</h3>
				<div class="inside">
					
							<form name="epg_add_channel" method="post" action="">							

							<table class="form-table">
								<tr>
									<td>
										<label for="epg_channel">Dodaj kanal:<br><input name="channel" type="text" value="" class="regular-text" /></label>
										<input class="button-primary" type="submit" name="epg_add_channel_submit" value="Shrani" /> 
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
