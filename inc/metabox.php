<?php
// Control core classes for avoid errors
function map_register_metabox(){


if (class_exists('CSF')) {

	//
	// Set a unique slug-like ID
	$prefix = 'map';

	//
	// Create a metabox
	CSF::createMetabox($prefix, array(
		'id'			 	 => 'map_my_audio_info',
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
				'id'   => $prefix . 'audio-repeat',
				'title' => __('Audio Repeat', 'my-audio-player'),
				'type' => 'radio',
				'inline' => true,
				'options'  => array(
					'option-1' => 'Yes',
					'option-2' => 'No',
				),
			),
			array(
				'id'   => $prefix . 'audio-mute',
				'title' => __('Audio Muted', 'my-audio-player'),
				'type' => 'checkbox',
			)

		)
	));
	//

}
}
add_action('csf_init','map_register_metabox');