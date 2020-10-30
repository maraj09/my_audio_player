<?php
// Control core classes for avoid errors


if (class_exists('CSF')) {

	//
	// Set a unique slug-like ID
	//Dont change prefix or id  otherwise need to add data again 
	$prefix = 'add_audio_';

	//
	// Create a metabox
	CSF::createMetabox($prefix, array(
		'title'              => __('Configure your audio player', 'my-audio-player'),
		'post_type'          => array('myaudioplayer'),
		'context'            => 'normal',
		'priority'           => 'default',
	));

	//
	// Create a section
	CSF::createSection($prefix, array(
		'title' => __('upload your audio player', 'my-audio-player'),
		'fields' => array(

			//
			// A text field
			array(
				'id'   =>  'audio-file',
				'type' => 'upload',
				'title' => __('Upload audio', 'my-audio-player'),
				'desc' => __('Upload an mp3, Wav or Ogg file', 'my-audio-player'),
			),


			array(
				'id'   =>  'audio-text',
				'type' => 'text',
				'title' => __('Upload text', 'my-audio-player'),
				'desc' => __('Upload an mp3, Wav or Ogg file', 'my-audio-player'),
			),
			array(
				'id'   =>  'audio-repeat',
				'title' => __('Audio Repeat', 'my-audio-player'),
				'type' => 'radio',
				'inline' => true,
				'options'  => array(
					'0' => 'No',
					'1' => 'Yes',
				),
			),
			array(
				'id'   =>  'audio-inline',
				'title' => __('Audio Start/Stop Button Position', 'my-audio-player'),
				'type' => 'radio',
				'inline' => true,
				'options'  => array(
					'0' => 'Inline',
					'1' => 'Block',
				),
			),
			array(
				'id'   =>  'audio-download',
				'title' => __('Show Audio Download button', 'my-audio-player'),
				'type' => 'checkbox',
			),
			array(
				'id'   =>  'audio-shadow',
				'title' => __('Show Shadow', 'my-audio-player'),
				'type' => 'checkbox',
			),
			array(
				'id'   =>  'audio-width',
				'title' => __('Width', 'my-audio-player'),
				'type' => 'number',
				'default' => 500
			),
			array(
				'id'   =>  'audio-color',
				'title' => __('Player Color', 'my-audio-player'),
				'type' => 'select',
				'options'     => array(
					'green'  => 'Green',
					'red'  => 'Red',
					'black'  => 'Black',
					'orange'  => 'Orange',
					'blue'  => 'Blue',
				),
				'default' => 'blue'
			),
			array(
				'id'   =>  'audio-btn',
				'title' => __('Show Large Play/Pause Button', 'my-audio-player'),
				'type' => 'checkbox',
			),

		)
	));
};
