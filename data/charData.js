var charData = [
	{
		"name": "Friendly",
		"location": {
			"nw": {
				"lat": 42,
				"lon": -85
			},
			"se": {
				"lat": 42,
				"lon": -85
			}
		},
		"equip": {
			"head": false,
			"torso": [
				{
					"backpack": ["bottle", "food"]
				}
			],
			"arms": false,
			"legs": false,
			"rhand": false,
			"lhand": false
		},
		"stats": {
			"atk": 999,
			"def": 999,
			"hp": 999
		},
		"description": "traveller",
		"image": "friendly.png",
		"function": "charFriendly"
	},
	{
		"name": "Enemy",
		"location": {
			"nw": {
				"lat": 42,
				"lon": -85
			},
			"se": {
				"lat": 42,
				"lon": -85
			}
		},
		"equip": {
			"head": false,
			"torso": [{"leather_armor"}],
			"arms": false,
			"legs": false,
			"rhand": [{"knife"}],
			"lhand": false
		},
		"stats": {
			"atk": 30,
			"def": 20,
			"hp": 100
		},
		"description": "bandit",
		"image": "enemy.png",
		"function": "charEnemy"
	}
];