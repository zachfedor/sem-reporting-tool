<?php

class YouTubeDemographics extends SimpleComponent
{
	protected $views, $estimated_minutes_watched, $new_subscribers, $likes, $dislikes
		, $comments, $sharess, $favorites_added, $favorites_removed, $age_of_subscribers;
	
	function __construct( $views, $estimated_minutes_watched, $new_subscribers, $likes, $dislikes
		, $comments, $sharess, $favorites_added, $favorites_removed, $age_of_subscribers )
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
}