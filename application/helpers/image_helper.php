<?php

function image_thumb( $image_path, $height, $width ) {
    // Get the CodeIgniter super object
    $CI =& get_instance();

    // Path to image thumbnail
	$imageinfo = pathinfo($image_path);
	
    $image_thumb = dirname( $image_path ) . '/' .$imageinfo['filename']. '_' . $height . '_' . $width . '.'.$imageinfo['extension'];

    if ( !file_exists( $image_thumb ) ) {
        // LOAD LIBRARY
        $CI->load->library( 'image_lib' );

        // CONFIGURE IMAGE LIBRARY
        $config['image_library']    = 'gd2';
        $config['source_image']     = $image_path;
        $config['new_image']        = $image_thumb;
        $config['maintain_ratio']   = TRUE;
        $config['height']           = $height;
        $config['width']            = $width;
		$config['master_dim']       = 'width';		
        $CI->image_lib->initialize( $config );
        $CI->image_lib->resize();
        $CI->image_lib->clear();
    }

    return $image_thumb;
}

/* End of file image_helper.php */
/* Location: ./application/helpers/image_helper.php */