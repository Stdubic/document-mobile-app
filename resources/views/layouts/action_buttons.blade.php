<?php

if(isset($actions))
{
	$action_types = [
		'remove' => [
			'label' => 'Remove',
			'method' => 'DELETE',
			'state_class' => 'danger',
			'icon_class' => 'fa fa-trash'
		],
		'activate' => [
			'label' => 'Activate',
			'method' => 'PATCH',
			'state_class' => 'warning',
			'icon_class' => 'fa fa-toggle-on'
		],
		'deactivate' => [
			'label' => 'Deactivate',
			'method' => 'PATCH',
			'state_class' => 'warning',
			'icon_class' => 'fa fa-toggle-off'
		],
        'fire-notification' => [
            'label' => 'Send',
            'method' => 'POST',
            'state_class' => 'info',
            'icon_class' => 'fa fa-broadcast-tower'
        ],
		'modal' => [
			'label' => 'Change state',
			'method' => 'PATCH',
			'state_class' => 'success',
			'icon_class' => 'fa fa-refresh',
			'attributes' => [
				'data-toggle' => 'modal',
				'data-target' => '#modal_id'
			]
		]
	];

	foreach($actions as $action)
	{
		$form_action = trim($action['action']);
		$type = trim($action['type']);
		$method = $action_types[$type]['method'];

		if(!array_key_exists($type, $action_types) || !Auth::user()->canViewRoute($form_action, $method)) continue;

		$state_class = $action_types[$type]['state_class'];
		$icon_class = $action_types[$type]['icon_class'];
		$label = $action_types[$type]['label'];
		$form_id = mt_rand();

		if(isset($action_types[$type]['attributes']))
		{
			$attributes = $action_types[$type]['attributes'];
			foreach($attributes as $key => &$value)
			{
				if(is_bool($value))
				{
					if($value) $value = $key;
					else continue;
				}
				else $value = $key.'="'.$value.'"';
			}

			$attributes = implode(' ', $attributes);
		}
		else $attributes = 'onclick="gatherFormInputs(this.form);"';

		?>
		<button type="button" form="form-{{ $form_id }}" <?= $attributes; ?> class="dropdown-item">
			<i class="{{ $icon_class }}"></i>
			<span class="m--font-{{ $state_class }}">{{ $label }}</span>
			<form action="{{ $form_action }}" method="post" id="form-{{ $form_id }}" hidden>
				@csrf
				{{ method_field($method) }}
			</form>
		</button>
		<?php
	}
}