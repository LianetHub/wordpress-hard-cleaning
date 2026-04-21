<?php

if (function_exists('acf_add_options_page')) {
	acf_add_options_page([
		'page_title'    => 'Настройки темы',
		'menu_title'    => 'Настройки темы',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	]);

	acf_add_options_page([
		'page_title'    => 'Управление ценами',
		'menu_title'    => 'Цены на услуги',
		'menu_slug'     => 'services-prices',
		'capability'    => 'edit_posts',
		'redirect'      => false,
		'icon_url'      => 'dashicons-money-alt',
	]);
}

function acf_load_services_prices_fields($field)
{
	$args = [
		'post_type'      => 'services',
		'posts_per_page' => -1,
		'post_status'    => 'publish',
		'orderby'        => 'title',
		'order'          => 'ASC',
	];

	$services = get_posts($args);
	if (!$services) return $field;

	$field['sub_fields'] = [];

	foreach ($services as $service) {
		$sid = $service->ID;


		$field['sub_fields'][] = [
			'key'   => 'acc_' . $sid,
			'label' => $service->post_title,
			'name'  => 'acc_' . $sid,
			'_name' => 'acc_' . $sid,
			'type'  => 'accordion',
		];


		$field['sub_fields'][] = [
			'key'        => 'group_' . $sid,
			'name'       => 'service_data_' . $sid,
			'_name'      => 'service_data_' . $sid,
			'label'      => '',
			'type'       => 'group',
			'layout'     => 'block',
			'sub_fields' => [
				[
					'key'   => 'service_main_price_' . $sid,
					'name'  => 'service_price',
					'_name' => 'service_price',
					'label' => 'Основная стоимость услуги',
					'type'  => 'text',
					'wrapper' => ['width' => '100'],
				],
				[
					'key'          => 'repeater_' . $sid,
					'name'         => 'additional_services',
					'_name'        => 'additional_services',
					'label'        => 'Таблица цен',
					'type'         => 'repeater',
					'layout'       => 'table',
					'button_label' => 'Добавить строку',
					'sub_fields'   => [
						[
							'key'   => 'add_name_' . $sid,
							'name'  => 'name',
							'_name' => 'name',
							'label' => 'Наименование',
							'type'  => 'textarea',
							'rows'  => 2,
							'new_lines' => '',
						],
						[
							'key'   => 'add_price_' . $sid,
							'name'  => 'price',
							'_name' => 'price',
							'label' => 'Стоимость',
							'type'  => 'text',
						],
						[
							'key'   => 'add_comment_' . $sid,
							'name'  => 'comment',
							'_name' => 'comment',
							'label' => 'Комментарий',
							'type'  => 'textarea',
							'rows'  => 2,
							'new_lines' => '',
						]
					]
				]
			]
		];
	}

	return $field;
}
add_filter('acf/load_field/name=all_services_prices_list', 'acf_load_services_prices_fields');

// add_filter('acf/load_value/name=additional_services', function ($value, $post_id, $field) {

// 	if ((empty($value) || $value === false) && is_admin()) {


// 		preg_match('/\d+/', $field['key'], $matches);
// 		$sid = $matches[0] ?? '';

// 		$value = [
// 			[
// 				'add_name_' . $sid    => 'Консультация',
// 				'add_price_' . $sid   => 'Бесплатно',
// 				'add_comment_' . $sid => 'Оставьте заявку или позвоните нам',
// 			],
// 			[
// 				'add_name_' . $sid    => 'Выезд на осмотр для составления сметы',
// 				'add_price_' . $sid   => 'Бесплатно',
// 				'add_comment_' . $sid => 'Бесплатно в пределах Санкт-Петербурга.',
// 			]
// 		];
// 	}
// 	return $value;
// }, 10, 3);

function my_acf_admin_head()
{
?>
	<style type="text/css">
		.acf-accordion .acf-accordion-title label {
			text-transform: uppercase;
			color: #000;
		}

		.acf-field-group {
			border: 1px solid #282D41 !important;
			margin-bottom: 10px !important;
		}

		/* .acf-field-repeater[data-name="additional_services"] tbody tr:nth-child(1) .acf-row-handle .acf-icon.-minus,
		.acf-field-repeater[data-name="additional_services"] tbody tr:nth-child(2) .acf-row-handle .acf-icon.-minus {
			display: none !important;
			pointer-events: none;
		} */
	</style>
<?php
}
add_action('acf/input/admin_head', 'my_acf_admin_head');
