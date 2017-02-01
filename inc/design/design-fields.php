<?php
/**
 * 
 */

$response = wp_remote_get( MS_SITE . '/wp-json/makesite/v1/design_fields?site=' . site_url() );
if( is_array($response) ) {
	$panels = $response['body']; // use the content
}

if ( ! empty( $panels ) ) {
	$panels = json_decode( $panels, 'assoc_array' );

	if ( ! $panels ) return array();

	foreach ( $panels as $panel => &$fields ) {
		$ids = array_keys( $fields );
		foreach ( $fields as $id => $f ) {
			if ( 'all-custo' == $f['type'] ) {

				$i = array_search( $id, $ids );
				$all_custo_fields = array();

				unset( $panels[ $panel ][ $id ] );

				$label = $f['label'];
				$id_format = $id . '-%s';

				//Padding
				$id   = sprintf( $id_format, 'padding' );
				$f['type'] = 'spacing';
				$f['label'] = $label . ' Padding';
				$all_custo_fields[ $id ] = $f;
				$all_custo_fields[ $id ]['output'] = sprintf( $f['output'], 'padding:%s' );

				//BG Color
				$id   = sprintf( $id_format, 'bg-color' );
				$f['type'] = 'alpha-color';
				$f['label'] = $label . ' Background Color';
				$all_custo_fields[ $id ] = $f;
				$all_custo_fields[ $id ]['output'] = sprintf( $f['output'], 'background-color:%s' );

				//Border
				$id   = sprintf( $id_format, 'border' );
				$f['type'] = 'all-border';
				$f['label'] = $label . ' Border';
				$all_custo_fields[ $id ] = $f;

				//Rounded corners
				$id   = sprintf( $id_format, 'border-radius' );
				$f['type'] = 'slider';
				$f['label'] = $label . ' Rounded Corners';
				$all_custo_fields[ $id ] = $f;
				$all_custo_fields[ $id ]['output'] = sprintf( $f['output'], 'border-radius:%spx' );

				//Shadow
				$id   = sprintf( $id_format, 'shadow' );
				$f['type'] = 'shadow';
				$f['label'] = $label . ' Shadow';
				$all_custo_fields[ $id ] = $f;

				$fields = array_merge(
					array_slice( $fields, 0, $i ),
					$all_custo_fields,
					array_slice( $fields, $i, null )
				);
			}
		}
	}


	return apply_filters( 'makesite_design_fields', $panels );
}
return array();