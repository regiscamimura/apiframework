<div id="login">
	<div id="logo">
		API Framework
	</div>
	<div id="form">
		<?php echo form_open('user/login') ?>
			<?php echo message() ?>
			<table>
				<tr>
					<td>Username</td><td><input name="rec[username]" /></td>
				</tr>
				<tr>
					<td>Password</td><td><input name="rec[password]" type="password" /></td>
				</tr>
				<tr>
					<td></td><td><input name="submit" type="submit" value=" Submit " /></td>
				</tr>
			</table>
		</form>
	</div>
</div>