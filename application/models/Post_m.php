<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
* 
*/
class Post_m extends CI_Model
{

	public function get_site_post($site_id='',$limit=false,$start=false)
	{
		$post = $this->db->dbprefix('post');
		$this->db->select('post.*,YEAR('.$post.'.date_posted) as post_year,DATE_FORMAT('.$post.'.date_posted,"%b") as post_month,DAY('.$post.'.date_posted) as post_day,site.site_path')
			->from('post')
			->join('site','site.site_id = post.site_id','LEFT')
			->where('post.site_id',$site_id)
			->order_by('post.date_posted desc');
			if($limit && $start){
			$this->db->limit($start,$limit);
			}elseif($limit){
			$this->db->limit($limit);
			}
			$query = $this->db->get();

		return $query->result();
	}

	public function posted_by($id=0)
	{
		$query = $this->db->get_where('users',array('user_id'=>$id));
		if($result = $query->result()){
			return $result[0]->user_name;
		}else{
			return null;
		}
	}

	public function get_categories()
	{
		$this->db->select('*');
		$query = $this->db->get('category');
		return $query->result();
			
	}
	public function get_postBySlug($slug='')
	{
		$query = $this->db->get_where('post',array('slug'=>$slug));
		if($result = $query->result()){
			return $result;
		}else{
			return false;
		}
	}

	public function recent_post($site_id=false)
	{
		if($site_id){
			$query = $this->db->select('post.post_title,post.slug,site.site_path')
					->from('post')
					->join('site','site.site_id = post.site_id','LEFT')
					->where('site_id',$site_id)
					->order_by('post.date_posted desc')
					->limit(10)
					->get();
			return $query->result();
		}else{

			$query = $this->db->select('post.post_title,post.slug,site.site_path')
					->from('post')
					->join('site','site.site_id = post.site_id','LEFT')
					->order_by('post.date_posted desc')
					->limit(10)
					->get();
			return $query->result();
		}
	}
	public function save_post_info($info,$desc=false)
	{
		if (is_array($info)) {
			# code...
			$this->db->insert('post',$info);
			$id = $this->db->insert_id();
			
			return $id;

		}
		return false;

	}

	public function save_file($post_id=0,$u_key=0)
	{
		if($post_id > 0){
			$this->db->set('post_id',$post_id);
			$this->db->where('u_key',$u_key);
			$this->db->update('post_file');
		}
	}
	public function save_tag($tags=false,$id)
	{
		# code...
		if ($tags) {
			# code...
			$this->db->insert('post_tag',array('keyword'=>$tags,'post_id'=>$id));
			return;
		}
	}

	public function remove_tags($id)
	{
		# code...
		if (is_numeric($id)) {
			# code...
			$this->db->where('post_id',$id);	
			$this->db->delete('post_tag');
			return;
		}
	}


	public function title($title = false){

		if($title){
			
		$result = $this->db->select('*')->from('post')->where('post_title',$title)->get()->result();
		return count($result);
		}else{
			return 0;
		}

	}


	public function allow_user($post_id=false,$status = false)
	{
		# code...
		if ($post_id) {
			# code...
			if($status < 1){

			$this->db->set('status',1);
			$this->db->WHERE('page_id',$post_id);
			return $this->db->update('post');
			}else{

			$this->db->set('status',0);
			$this->db->WHERE('page_id',$post_id);
			return $this->db->update('post');
			}
		}
	}

	public function save_file_array($data)
	{
		if (is_array($data)) {
			return $this->db->insert_batch('post_file',$data);
		}
	
		
	}

	public function free_space($time=0)
	{
		$q = $this->db->get_where('post_file',array('post_id'=>0,'gallery_id'=>0));
		if($result = $q->result()){
			foreach ($result as $key) {
				/* remove not use in post or gallery image */
				if((int)$key->u_key + 1200 < $time){

					$this->db->where('id',$key->id);	
					$this->db->delete('post_file');

				}
			}

		}
	}


}