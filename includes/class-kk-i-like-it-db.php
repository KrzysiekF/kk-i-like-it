<?php

class Kk_I_Like_It_DB {
    private $wpdb;
	private $tableLike;
	private $tableLikeUser;
	
	public function __construct(){
		global $wpdb;
		$this->wpdb = $wpdb;
		$this->tableLike = $wpdb->prefix . 'kklike';
		$this->tableLikeUser = $wpdb->prefix . 'kklikeuser';
		$this->tableWPUsers = $wpdb->prefix . 'users';
		$this->tableWPPosts = $wpdb->prefix . 'posts';
		$this->metaLikes = 'kklike_value';
		$this->tablePostMeta = $wpdb->prefix . 'postmeta';
	}
	
	public function addLike($idPost, $idUser, $type){
		$ip = $_SERVER['REMOTE_ADDR'];
		$data = date('Y-m-d H:i:s');
		$isLike = $this->checkIsLike($idPost,$type);

		if($isLike){
			$userRate = $this->checkUserRating($idPost, $idUser, $ip);
			
			if(!$userRate){
			
				$rating = $this->getPostRating($idPost);
				$rating++;
				
				$result = update_post_meta($idPost, $this->metaLikes, $rating);
				
				if($result !== FALSE){
					$result = $this->wpdb->insert( $this->tableLikeUser, array( 'idwpuser' => $idUser, 'idlike' => $idPost, 'ip' => $ip, 'date' => $data ));
						
					$odp = array('hasError' => FALSE, 'rating' => $rating);
				}else{
					$odp = array('hasError' => TRUE, 'rating' => $rating);
				}
			
			}else{
				$odp = array('hasError' => TRUE, 'rating' => '', 'dbg' => '1');
			}
			
			return json_encode($odp);
		}else{
			$ip = $_SERVER['REMOTE_ADDR'];
			$data = date('Y-m-d H:i:s');
			
			$result = add_post_meta($idPost, $this->metaLikes, '1', true);

			if(!empty($result)){
				$id_last = mysql_insert_id();
				$result = $this->wpdb->insert( $this->tableLikeUser, array( 'idwpuser' => $idUser, 'idlike' => $idPost, 'ip' => $ip, 'date' => $data ));
				$odp = array('hasError' => FALSE, 'rating' => '1');
			}else{
				$odp = array('hasError' => TRUE, 'rating' => '', 'dbg' => '2');
			}
			
			return json_encode($odp);
		}
		
	}
	
	public function removeLike($idPost, $idUser, $type){
		$ip = $_SERVER['REMOTE_ADDR'];
		$isLike = $this->checkIsLike($idPost,$type);
		
		if($isLike != '0'){
			$userRate = $this->checkUserRating($idPost, $idUser, $ip);
			if($userRate != '0'){
				
				if($idUser != $userRate->idwpuser){
					$odp = array('hasError' => TRUE, 'rating' => '', 'msg' => 'You must be logged in to remove data.');
				}else{
				 
					$sql = "DELETE FROM ". $this->tableLikeUser ." WHERE id = '". $userRate->id ."'";
					$result = $this->wpdb->query($sql);
					if($result == 1){
						$rating = $this->getPostRating($idPost);
						$rating--;
						
						$result = update_post_meta($idPost, $this->metaLikes, $rating);
						
						if(!empty($result) || $result == 0){
							$odp = array('hasError' => FALSE, 'rating' => $rating);
						}else{
							$odp = array('hasError' => TRUE, 'rating' => $rating);
						}
					}else{
						$odp = array('hasError' => TRUE, 'rating' => '');
					}
					
				}
			}
		}else{
			$odp = array('hasError' => TRUE, 'rating' => '');
		}
		
		return json_encode($odp);
	}
	
	public function checkIsLike($id){
		$val = get_post_meta($id, $this->metaLikes, true);
		
		if(empty($val) && $val != 0){
			$val = false;
		}else{
			$val = true;
		}
		
		return $val;
	}
	
	public function checkUserRating($idLike, $idUser, $ip){
		if($idUser != '0'){
			$val = $this->wpdb->get_row("SELECT id, count(id) as count, idwpuser FROM $this->tableLikeUser WHERE idlike = $idLike AND idwpuser = $idUser");
		}else{
			$val = $this->wpdb->get_row("SELECT id, count(id) as count, idwpuser FROM $this->tableLikeUser WHERE idlike = $idLike AND ip = '". $ip ."'");			
		}

		if(empty($val) || $val->count == 0){
			$val = false;
		}
		
		return $val;
	}
	
	public function getPostRating($id){
		$val = get_post_meta($id, $this->metaLikes, true);
				
		if(empty($val)){
			$val = 0;
		}
		
		return $val;
	}

	public function getPostVoters($id){

		$sql = "SELECT * FROM ". $this->tableLikeUser ." 
				LEFT JOIN (". $this->tableWPUsers .") 
				ON (". $this->tableWPUsers .".ID = ". $this->tableLikeUser .".idwpuser) 
				WHERE ". $this->tableLikeUser .".idlike = ". $id ." 
				ORDER BY ". $this->tableLikeUser .".date DESC";

		$dane = $this->wpdb->get_results($sql);

		if($dane === NULL){
			$dane = 0;
		}
		
		return $dane;
	}
	
	public function getInformation($limit = 0, $userID = 0){
		$result = array();
		
		if($limit > 0){
			$limit = " LIMIT ".$limit;
		}else{
			$limit = "";
		}
		
		if($userID){
			$userWhere = ' WHERE '. $this->tableLikeUser .'.idwpuser = '. $userID .' ';
		}else{
			$userWhere = '';
		}
		
		$sql = "SELECT * FROM ". $this->tableLikeUser ." 
				LEFT JOIN (". $this->tableWPPosts .") 
				ON (". $this->tableLikeUser .".idlike = ". $this->tableWPPosts .".ID) 
				".$userWhere."
				ORDER BY ". $this->tableLikeUser .".date DESC ".$limit;
		$dane = $this->wpdb->get_results($sql);
		
		$i = 0;
		foreach($dane as $row){
			
			if($row->idwpuser == '0'){
				$user = __('Guest', 'lang-kklike');
			}else{
				$user = $this->wpdb->get_var("SELECT display_name FROM $this->tableWPUsers WHERE ID = $row->idwpuser");
			}

			$result[$i] = array(
				'ip' 		=> 	$row->ip,
				'date'		=>	$row->date,
				'user'		=>	$user,
				'liked'		=>	get_post_meta($row->ID, $this->metaLikes, true),
				'post_name'	=>	$row->post_title
			);
			$i++;
		}
		return $result;
	}
	
	public function getTopPosts($limit = 0, $type = FALSE){
		if($limit > 0){
			$limit = " LIMIT ".$limit;
		}else{
			$limit = "";
		}
		
		//if($type){
			$typ = ' WHERE '. $this->tablePostMeta .'.meta_value >= "0" ';
		//}else{
		//	$typ = '';
		//}
		
		$sql = "SELECT * FROM " . $this->tableWPPosts . "
				LEFT JOIN (" . $this->tablePostMeta . ")
				ON (". $this->tableWPPosts .".ID = ". $this->tablePostMeta .".post_id AND ". $this->tablePostMeta .".meta_key = '". $this->metaLikes ."')
				". $typ ."
				ORDER BY CONVERT(". $this->tablePostMeta .".meta_value, UNSIGNED INTEGER) DESC ".$limit;
		$dane = $this->wpdb->get_results($sql);
		
		return $dane;
	}
	
	public function getRandomLikes($limit = 0, $type = FALSE){
		if($limit > 0){
			$limit = " LIMIT ".$limit;
		}else{
			$limit = "";
		}
		
		//if($type){
			$typ = ' WHERE '. $this->tablePostMeta .'.meta_value >= "0" ';
		//}else{
		//	$typ = '';
		//}
		
		
		$sql = "SELECT * FROM " . $this->tableWPPosts . "
				LEFT JOIN (". $this->tableLikeUser .") 
				ON (". $this->tableLikeUser .".idLike = ". $this->tableWPPosts .".ID) 
				LEFT JOIN (" . $this->tablePostMeta . ")
				ON (". $this->tableWPPosts .".ID = ". $this->tablePostMeta .".post_id AND ". $this->tablePostMeta .".meta_key = '". $this->metaLikes ."')
				". $typ ."
				ORDER BY ". $this->tableLikeUser .".date DESC ".$limit;
		$dane = $this->wpdb->get_results($sql);
		
		return $dane;
	}
	
	public function getLikesNumber(){
		$query = "SELECT COUNT(id) AS ilosc FROM ". $this->tableLikeUser;
		$dane = $this->wpdb->get_var($query);		
		
		return $dane; 
	}
	public function getTopLikesFrom($from = null, $days = null){
		if(empty($from)){
			$from = time();
		}else{
			$from = strtotime($from);
		}

		if($days === 0){
			$to_date = date('Y-m-d', $from);
		}else if(empty($days)){
			$days = 7;
			$to_date = date('Y-m-d', $from - ($days * 24 * 3600));
		}else{
			$to_date = date('Y-m-d', $from - ($days * 24 * 3600));
		}

		$from = date('Y-m-d H:i:s', $from);

		$query = "SELECT 
				COUNT(". $this->tableLikeUser .".id) AS count,
				". $this->tableLikeUser .".date,
				". $this->tableLikeUser .".idwpuser,
				". $this->tableWPPosts .".ID,
				". $this->tableWPPosts .".post_title

				FROM ". $this->tableLikeUser ." 
				LEFT JOIN (" . $this->tableWPPosts . ")
				ON (". $this->tableLikeUser .".idlike = ". $this->tableWPPosts .".ID)
				WHERE ". $this->tableLikeUser .".date <= '". $from ."' 
				AND ". $this->tableLikeUser .".date >= '". $to_date ."' 
				GROUP BY DAY(". $this->tableLikeUser .".date)";

		$data = $this->wpdb->get_results($query);

		return $data;
	}

	public function getTopLikedPostFrom($from = null, $days = null){
		if(empty($from)){
			$from = time();
		}else{
			$from = strtotime($from);
		}

		if($days === 0){
			$to_date = date('Y-m-d', $from);
		}else if(empty($days)){
			$days = 7;
			$to_date = date('Y-m-d', $from - ($days * 24 * 3600));
		}else{
			$to_date = date('Y-m-d', $from - ($days * 24 * 3600));
		}

		$from = date('Y-m-d H:i:s', $from);

		$query = "SELECT 
				COUNT(". $this->tableLikeUser .".id) AS count,
				". $this->tableLikeUser .".date,
				". $this->tableLikeUser .".idwpuser,
				". $this->tableWPPosts .".ID,
				". $this->tableWPPosts .".post_title

				FROM ". $this->tableLikeUser ." 
				LEFT JOIN (" . $this->tableWPPosts . ")
				ON (". $this->tableLikeUser .".idlike = ". $this->tableWPPosts .".ID)
				WHERE ". $this->tableLikeUser .".date <= '". $from ."' 
				AND ". $this->tableLikeUser .".date >= '". $to_date ."' 
				GROUP BY ". $this->tableWPPosts .".ID";

		$data = $this->wpdb->get_results($query);

		return $data;
	}
}