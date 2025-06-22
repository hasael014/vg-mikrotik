<?php

use App\Helpers\Functions;

// Functions::_getPlans();
?>

<section>

	<h2>Perfiles</h2>
	
	<?php
	Functions::_table(Functions::_getPlans(), ["Id"=>".id","nombre"=>"name", "Duracion" => "session-timeout", "rate" => "rate-limit" ], "/app/profile/");
	?>

</section>