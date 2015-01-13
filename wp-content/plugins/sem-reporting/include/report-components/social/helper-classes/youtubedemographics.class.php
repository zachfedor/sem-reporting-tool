<?php

class YouTubeDemographics extends SimpleComponent
{
	protected $views, $estimated_minutes_watched, $new_subscribers, $likes, $dislikes
		, $comments, $shares, $favorites_added, $favorites_removed, $age_of_subscribers;
	
	function __construct( $views=0, $estimated_minutes_watched=0, $new_subscribers=0, $likes=0, $dislikes=0
		, $comments=0, $shares=0, $favorites_added=0, $favorites_removed=0, $age_of_subscribers=0 )
	{
		$this->views = $views;
		$this->estimated_minutes_watched = $estimated_minutes_watched;
		$this->new_subscribers = $new_subscribers;
		$this->likes = $likes;
		$this->dislikes = $dislikes;
		$this->comments = $comments;
		$this->shares = $shares;
		$this->favorites_added = $favorites_added;
		$this->favorites_removed = $favorites_removed;
		$this->age_of_subscribers = $age_of_subscribers;
	}

	public static function get_component( $client )
	{
		return Google::get_youtube_component( $client );
	}

	public function get_views()
	{
	    return $this->views;
	}

	public function get_estimated_minutes_watched()
	{
	    return $this->estimated_minutes_watched;
	}

	public function get_new_subscribers()
	{
	    return $this->new_subscribers;
	}

	public function get_likes()
	{
	    return $this->likes;
	}

	public function get_dislikes()
	{
	    return $this->dislikes;
	}

	public function get_comments()
	{
	    return $this->comments;
	}

	public function get_shares()
	{
	    return $this->shares;
	}

	public function get_favorites_added()
	{
	    return $this->favorites_added;
	}

	public function get_favorites_removed()
	{
	    return $this->favorites_removed;
	}

	public function get_age_of_subscribers()
	{
	    return $this->age_of_subscribers;
	}
}