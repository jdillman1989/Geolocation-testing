<?php
class Game_Data {

	public function return_game_data($id=0){

		// array(
		// 	'coords' => array(
		// 		'1' => array(
		// 			'nw' => array(
		// 				'lat' => $nwlat,
		// 				'lon' => $nwlon 
		// 			),
		// 			'se' => array(
		// 				'lat' => $selat,
		// 				'lon' => $selon
		// 			)
		// 		),
		// 		'2' => array(
		// 			'nw' => array(
		// 				'lat' => $nwlat,
		// 				'lon' => $nwlon 
		// 			),
		// 			'se' => array(
		// 				'lat' => $selat,
		// 				'lon' => $selon 
		// 			)
		// 		),
		// 		'3' => array(
		// 			'nw' => array(
		// 				'lat' => $nwlat,
		// 				'lon' => $nwlon 
		// 			),
		// 			'se' => array(
		// 				'lat' => $selat,
		// 				'lon' => $selon 
		// 			)
		// 		),
		// 		'4' => array(
		// 			'nw' => array(
		// 				'lat' => $nwlat,
		// 				'lon' => $nwlon 
		// 			),
		// 			'se' => array(
		// 				'lat' => $selat,
		// 				'lon' => $selon 
		// 			)
		// 		),
		// 		'5' => array(
		// 			'nw' => array(
		// 				'lat' => $nwlat,
		// 				'lon' => $nwlon 
		// 			),
		// 			'se' => array(
		// 				'lat' => $selat,
		// 				'lon' => $selon 
		// 			)
		// 		),
		// 		'6' => array(
		// 			'nw' => array(
		// 				'lat' => $nwlat,
		// 				'lon' => $nwlon 
		// 			),
		// 			'se' => array(
		// 				'lat' => $selat,
		// 				'lon' => $selon 
		// 			)
		// 		),
		// 	),
		// 	'data' => array(
		// 		'locations' => array(
		// 			'spot1' => array(
		// 				'name' => $name,
		// 				'description' => $description,
		// 				'image' => $image,
		// 				'coords' => '1'
		// 			),
		// 			'spot2' => array(
		// 				'name' => $name,
		// 				'description' => $description,
		// 				'image' => $image,
		// 				'coords' => '2'
		// 			)
		// 		),
		// 		'characters' => array(
		// 			'char1' => array(
		// 				'name' => $title,
		// 				'description' => $description,
		// 				'image' => $image,
		// 				'coords' => '3'
		// 			),
		// 			'char2' => array(
		// 				'name' => $title,
		// 				'description' => $description,
		// 				'image' => $image,
		// 				'coords' => '4'
		// 			)
		// 		),
		// 		'items' => array(
		// 			'item1' => array(
		// 				'name' => $title,
		// 				'description' => $description,
		// 				'image' => $image,
		// 				'coords' => '5'
		// 			),
		// 			'item2' => array(
		// 				'name' => $title,
		// 				'description' => $description,
		// 				'image' => $image,
		// 				'coords' => '6'
		// 			)
		// 		)
		// 	)
		// );

		$game_data = array();

		$coords_data = array();
		$coords_index = 0;

		$locations = get_field('locations', $id);
		$location_data = array();
		foreach ($locations as $location) {

			$location_data[$location['name']] = array(
				'name' => $location['name'],
				'description' => $location['description'],
				'image' => $location['image'],
				'coords' => $coords_index
			);
			$coords_data[$coords_index] = array(
				'nw' => array(
					'lat' => $location['nw_lat'],
					'lon' => $location['nw_lon']
				),
				'se' => array(
					'lat' => $location['se_lat'],
					'lon' => $location['se_lon']
				),
				'xref' => 'locations'
			);
			$coords_index++;
		}

		$characters = get_field('characters', $id);
		$character_data = array();
		foreach ($characters as $character) {

			$character_id = $character['select_character'];
			$character_title = get_the_title($character_id);

			$character_data[$character_title] = array(
				'name' => $character_title,
				'description' => get_field('description', $character_id),
				'image' => get_field('image', $character_id),
				'coords' => $coords_index
			);

			$coords_area = $this->coords_area($character['lat'], $character['lon']);

			$coords_data[$coords_index] = array(
				'nw' => array(
					'lat' => $coords_area['nw_lat'],
					'lon' => $coords_area['nw_lon']
				),
				'se' => array(
					'lat' => $coords_area['se_lat'],
					'lon' => $coords_area['se_lon']
				),
				'xref' => 'characters'
			);
			$coords_index++;
		}

		$items = get_field('items', $id);
		$item_data = array();
		foreach ($items as $item) {

			$item_id = $item['select_item'];
			$item_title = get_the_title($item_id);

			$item_data[$item_title] = array(
				'name' => $item_title,
				'description' => get_field('description', $item_id),
				'image' => get_field('image', $item_id),
				'coords' => $coords_index
			);

			$coords_area = $this->coords_area($item['lat'], $item['lon']);

			$coords_data[$coords_index] = array(
				'nw' => array(
					'lat' => $coords_area['nw_lat'],
					'lon' => $coords_area['nw_lon']
				),
				'se' => array(
					'lat' => $coords_area['se_lat'],
					'lon' => $coords_area['se_lon']
				),
				'xref' => 'items'
			);
			$coords_index++;
		}

		$game_data['coords'] = $coords_data;
		$game_data['data']['locations'] = $location_data;
		$game_data['data']['characters'] = $character_data;
		$game_data['data']['items'] = $item_data;

		return json_encode($game_data);
	}

	private function coords_area($lat_data, $lon_data){

		$lat = floatval($lat_data);
		$lon = floatval($lon_data);

		$return = array();
		$return['nw_lat'] = $lat + 0.0001;
		$return['nw_lon'] = $lon + 0.0001;
		$return['se_lat'] = $lat - 0.0001;
		$return['se_lon'] = $lon - 0.0001;

		return $return;
	}
}