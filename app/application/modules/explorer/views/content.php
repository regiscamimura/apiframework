<div id="explorer">
	<h1>API Explorer</h1>
	<hr />	
	<div id="view_form">
		<form method='post' action='view'>
			<select name='method'>
				<option value='get'>GET</option>
				<option value='post'>POST</option>
				<option value='put'>PUT</option>
				<option value='delete'>DELETE</option>
			</select>
			<select name='protocol'>
				<option value='http'>http</option>
				<option value='https'>https</option>
			</select>
			<label>://<?php echo $provider ?></label>
			<!--
			<input type='text' name='provider' value='' />
			-->
			<input type='text' name='url' />
			<select name='format'>
				<option value='json'>JSON</option>
				<option value='xml'>XML</option>
			</select>
			<input type='submit' value=' view ' class='button' />
			<div id='debug'>
				<input type='checkbox' name='debug' /> Debug
			</div>
		</form>
		<div id='api_key'>
			( api key: <?php echo $this->auth->key() ?> )
		</div>
	</div>
	<hr />
	<div id="result">
	
	</div>
</div>