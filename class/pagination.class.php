<?php
	class Paginator{
		var $items_per_page;
		var $items_total;
		var $current_page;
		var $num_pages;
		var $mid_range;
		var $low;
		var $high;
		var $limit;
		var $return;
		var $default_ipp;
		var $querystring;
		var $url_next;
		var $web_url;
		
		function Paginator()
		{
			$this->current_page = 1;
			$this->mid_range = 7;
			$this->items_per_page = $this->default_ipp;
			$this->url_next = $this->url_next;
		}
		function paginate()
		{
			if(!is_numeric($this->items_per_page) OR $this->items_per_page <= 0) $this->items_per_page = $this->default_ipp;
			$this->num_pages = ceil($this->items_total/$this->items_per_page);
			
			if($this->current_page < 1 Or !is_numeric($this->current_page)) $this->current_page = 1;
			if($this->current_page > $this->num_pages) $this->current_page = $this->num_pages;
			$prev_page = $this->current_page-1;
			$next_page = $this->current_page+1;
			
			if($_GET['s']){
				$haveGET = isset($_GET['s']) ? '?s='.$_GET['s'] : '';
			}
			
			if($this->num_pages > 1)
			{
				if($this->current_page <= 2){
					$this->return = ($this->current_page != 1 And $this->items_total >= 1) ? '<li><a href="'.$this->web_url.$haveGET.'">&laquo; กลับ</a></li>':'<li class="disabled"><a href="#">&laquo; กลับ</a></li>';
				}
				else{
					$this->return = ($this->current_page != 1 And $this->items_total >= 1) ? '<li><a href="'.$this->url_next.$prev_page.'/'.$haveGET.'">&laquo; กลับ</a></li>':'<li class="disabled"><a href="#">&laquo; กลับ</a></li>';
				}
				
				$this->start_range = $this->current_page - floor($this->mid_range/2);
				$this->end_range = $this->current_page + floor($this->mid_range/2);
				
				if($this->start_range <= 0)
				{
					$this->end_range += abs($this->start_range)+1;
					$this->start_range = 1;
				}
				if($this->end_range > $this->num_pages)
				{
					$this->start_range -= $this->end_range-$this->num_pages;
					$this->end_range = $this->num_pages;
				}
				$this->range = range($this->start_range,$this->end_range);
				
				for($i=1;$i<=$this->num_pages;$i++)
				{
					if($this->range[0] > 2 And $i == $this->range[0]) $this->return .= "<li class=\"disabled\"><span> ... </span></li>";
				if($i==1 Or $i==$this->num_pages Or in_array($i,$this->range))
				{
					if($i==1){
						$this->return .= ($i == $this->current_page And $_GET['Page'] != 'All') ? '<li class="active"><a href="#">'.$i.'</a></li>':'<li><a href="'.$this->web_url.$haveGET.'">'.$i.'</a></li>';
					}
					else{
						$this->return .= ($i == $this->current_page And $_GET['Page'] != 'All') ? '<li class="active"><a href="#">'.$i.'</a></li>':'<li><a href="'.$this->url_next.$i.'/'.$haveGET.'">'.$i.'</a></li>';
					}
				}
				if($this->range[$this->mid_range-1] < $this->num_pages-1 And $i == $this->range[$this->mid_range-1]) $this->return .= "<li class=\"disabled\"><span> ... </span></li>";
				}
				$this->return .= (($this->current_page != $this->num_pages And $this->items_total >= 1) And ($_GET['Page'] != 'All')) ? '<li><a href="'.$this->url_next.$next_page.'/'.$haveGET.'">ต่อไป &raquo;</a></li>':'<li class="disabled"><a href="#">&raquo; ต่อไป</a></li>';
			}
			else
			{
				for($i=1;$i<=$this->num_pages;$i++)
				{
					$this->return .= ($i == $this->current_page) ? '<li class="active"><a href="#">'.$i.'</a></li>':'<li><a href="'.$this->url_next.$i.'/'.$haveGET.'">'.$i.'</a></li>';
				}
			}
			//$this->low = ($this->current_page-1) * $this->items_per_page;
			//$this->high = ($_GET['ipp'] == 'All') ? $this->items_total:($this->current_page * $this->items_per_page)-1;
			//$this->limit = ($_GET['ipp'] == 'All') ? "":" LIMIT $this->low,$this->items_per_page";
		}
		
		function display_pages()
		{
			return $this->return;
		}
	}
?>