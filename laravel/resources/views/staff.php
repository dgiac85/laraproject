<h1>
	<?=$title?>
</h1>
<?php
	if(!empty($staff)){
		foreach ($staff as $person){
			echo "<li> {$person['name']} {$person['lastname']} </li>";
		}
	}