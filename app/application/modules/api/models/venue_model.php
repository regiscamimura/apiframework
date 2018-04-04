<?php 

class Venue_model extends CI_Model {

    function __construct()
    {
        // Call the Model constructor
        parent::__construct();
    }
    
	 /**
     * Retrieves the venue records based on a circle area
	 * The "params" argument contains all data needed, including query limit,
	 * offset, lat/lng, radius, category, tags.
     * 
     * @param  array  $params
     * @return array
     */
	function get($params=null)
	{
		if (!$params['radius']) $params['radius'] = 100;
		if (!$params['limit']) $params['limit'] = 50;
		if (!$params['page']) $params['page'] = 0;
		$params['offset'] = $params['page']*$params['limit'];		
			
		$this->db->select('venue.id, venue.name, venue.address, venue.city, venue.state, venue.zipcode');
		$this->db->select('X(location) AS lat, Y(location) AS lng');
		$this->db->select('GROUP_CONCAT(DISTINCT(category.name)) AS category');
		$this->db->select('GROUP_CONCAT(DISTINCT(tag.name)) AS tag');
		$this->db->select('COUNT(DISTINCT(venue_review.id)) as number_of_reviews'); 
		
		// calculates the distance in miles
		$this->db->select("
			(((acos(sin((".$params['lat']."*pi()/180)) * sin((X(location)*pi()/180))+cos((".$params['lat']."*pi()/180)) * cos((X(location)*pi()/180)) * cos(((".$params['lng']."- Y(location))*pi()/180))))*180/pi())*60*1.1515) 
			as distance
		");
		
		$this->db->where('venue.status', 'active');
		if ($params['category']) $this->db->like('category.name', $params['category']);
		if ($params['tag']) $this->db->like('tag.name', $params['tag']);		
		
		$this->db->where("(((acos(sin((".$params['lat']."*pi()/180)) * sin((X(location)*pi()/180))+cos((".$params['lat']."*pi()/180)) * cos((X(location)*pi()/180)) * cos(((".$params['lng']."- Y(location))*pi()/180))))*180/pi())*60*1.1515) < {$params['radius']}");
				
		$this->db->join('venue_category', 'venue_category.venue_id = venue.id', 'left');
		$this->db->join('category', 'category.id = venue_category.category_id');
		$this->db->join('venue_tag', 'venue_tag.venue_id = venue.id', 'left');
		$this->db->join('tag', 'tag.id = venue_tag.tag_id');
		$this->db->join('venue_review', 'venue_review.venue_id = venue.id', 'left');
		
		$this->db->group_by('venue.id');
		
		$this->db->limit($params['limit'], $params['offset']);		
		
		$query = $this->db->get('venue');
		
		return $query->result_array();
	}
}
