<?php

if(isset($path) && !empty($path))
{
	?>
	<a href="{{ $path }}" title="Edit" class="m-portlet__nav-link btn m-btn m-btn--hover-primary m-btn--icon m-btn--icon-only m-btn--pill">
		<i class="fa fa-edit"></i>
	</a>
	<?php
}

if(isset($value) && !empty($value))
{
	?>
	<label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--primary">
		<input type="checkbox" name="values[]" value="{{ $value }}" class="options-form"><span></span>
	</label>
	<?php
}