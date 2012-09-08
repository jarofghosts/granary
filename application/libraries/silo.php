<?php

class Silo {

	public static function search( $search_term, $table_name, $column_names, $take = 0, $skip = 0 )
	{
		$query = DB::table($table_name);

		if (strlen($search_term) > 0) {

			foreach ( $column_names as $column_name )
			{
				$query->where( $column_name, 'LIKE', '%' . $search_term . '%');
			}

		}

		$query->where('active', '=', 1);

		if ($take > 0)
		{
			$query->take( $take )->skip( $skip );
		}

		return $query->get();

	}
	
	public static function categories( $search_term )
	{

		$results = Cache::get('catsearch&' . $search_term);

		if (!$results)
		{
			$query = self::search($search_term, 'categories',
				array(
					'handle', 'title'
				));

			$results = array();

			foreach ($query as $query_result)
			{

				$response = new stdClass;
				$response->name = $query_result->title;
				$response->id = $query_result->id;

				array_push($results, $response);

			}

			Cache::put('catsearch&' . $search_term, $results, 5);

		}
			
		return Response::json(array('results' => $results));

	}

	public static function users( $search_term )
	{

	}

	public static function groups( $search_term )
	{

	}

}