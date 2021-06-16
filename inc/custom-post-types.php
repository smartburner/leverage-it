<?php

/**
 * Registering Taxonomies for the Lessons CPT
 */
add_action( 'init', 'leverage_it_create_taxonomy' );
function leverage_it_create_taxonomy(){

	register_taxonomy( 'lessons-language', [ 'lessons' ], [
		'labels'                => [
			'name'              => 'Languages',
			'singular_name'     => 'Language',
			'search_items'      => 'Search Languages',
			'all_items'         => 'All Languages',
			'view_item '        => 'View Language',
			'parent_item'       => 'Parent Language',
			'parent_item_colon' => 'Parent Language:',
			'edit_item'         => 'Edit Language',
			'update_item'       => 'Update Language',
			'add_new_item'      => 'Add New Language',
			'new_item_name'     => 'New Language Name',
			'menu_name'         => 'Languages',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
	] );

	register_taxonomy( 'lessons-subject', [ 'lessons' ], [
		'labels'                => [
			'name'              => 'Subjects',
			'singular_name'     => 'Subject',
			'search_items'      => 'Search Subjects',
			'all_items'         => 'All Subjects',
			'view_item '        => 'View Subject',
			'parent_item'       => 'Parent Subject',
			'parent_item_colon' => 'Parent Subject:',
			'edit_item'         => 'Edit Subject',
			'update_item'       => 'Update Subject',
			'add_new_item'      => 'Add New Subject',
			'new_item_name'     => 'New Subject Name',
			'menu_name'         => 'Subjects',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		'show_admin_column'     => true, // авто-создание колонки таксы в таблице ассоциированного типа записи. (с версии 3.5)
	] );
}

// Lessons CPT
add_action( 'init', 'leverage_it_register_post_types' );
function leverage_it_register_post_types(){
	register_post_type( 'lessons', [
		'label'  => null,
		'labels' => [
			'name'               => 'Lessons', // основное название для типа записи
			'singular_name'      => 'Lesson', // название для одной записи этого типа
			'add_new'            => 'Add lesson', // для добавления новой записи
			'add_new_item'       => 'Add new lesson', // заголовка у вновь создаваемой записи в админ-панели.
			'edit_item'          => 'Edit lesson', // для редактирования типа записи
			'new_item'           => 'New lesson', // текст новой записи
			'view_item'          => 'View lesson', // для просмотра записи этого типа.
			'search_items'       => 'Search lessons', // для поиска по этим типам записи
			'not_found'          => 'There are no lessons found', // если в результате поиска ничего не было найдено
			'not_found_in_trash' => 'There are no lessons found in trash', // если не было найдено в корзине
			'menu_name'          => 'Lessons', // название меню
		],
		'description'         => '',
		'public'              => true,
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'supports'            => [ 'title', 'editor', 'author', 'thumbnail' ], // 'title','editor','author','thumbnail','excerpt','trackbacks','custom-fields','comments','revisions','page-attributes','post-formats'
		'taxonomies'          => [ 'lessons-language', 'lessons-subject' ],
		'has_archive'         => true,
	] );
}
