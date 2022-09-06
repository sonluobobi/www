<?php
/**
 * @filesource SubPages.php
 * @desc 分页类
 * @author Juezhong Long
 * @date 2010-07-05
 */

namespace common;
use ctrl;
class SubPages extends \ctrl\CtrlBase
{  
	private  $each_disNums;//每页显示的条目数  
	private  $nums;//总条目数  
	private  $current_page;// 当前被选中的页  
	private  $sub_pages;//每次显示的页数  
	private  $pageNums;//总页数  
	private  $page_array = array();//用来构造分页的数组  
	private  $subPage_link;//每个分页的链接  
	private  $subPage_type;// 显示分页的类型  

	/**
	 * __construct是SubPages的构造函数，用来在创建类的时候自动运行. 
	 * @param $each_disNums 每页显示的条目数 
	 * @param $nums 总条目数
	 * @param $current_page 当前被选中的页
	 * @param $sub_pages 每次显示的页数 
	 * @param $subPage_link 每个分页的链接
	 * @param $subPage_type 显示分页的类型 
	 * @return unknown_type
	 * 当@subPage_type=1的时候为普通分页模式 
     * example：   共4523条记录,每页显示 10条,当前第1/453页 [首页] [上页] [下页] [尾页] 
     * 当@subPage_type=2的时候为经典分页样式 
     * example：   当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页] 
	 */  
	function __construct($each_disNums,$nums,$current_page,$sub_pages=10,$subPage_link='pageGo',$subPage_type=3)
  	{  
  		parent::__construct();
   		$this->each_disNums = intval($each_disNums);  
   		$this->nums = intval($nums);  
   		$this->sub_pages = intval($sub_pages);  
   		$this->pageNums = ceil($nums/$each_disNums);  
    	if(!$current_page || ($current_page > $this->pageNums))
    	{  
    		$this->current_page = 1;  
    	}else{  
    		$this->current_page = intval($current_page);  
    	}  
   		$this->subPage_link = $subPage_link;
   		$this->subPage_type = $subPage_type;   
  	}  

  	/**
     *show_SubPages函数用在构造函数里面。而且用来判断显示什么样子的分页   
  	 */
  	public function show_SubPages()
  	{
  		$func = 'subPageCss'.$this->subPage_type;
  		return $this->$func();
  	}  
    
  	/** 
     *用来给建立分页的数组初始化的函数。 
     */  
	private function initArray()
	{  
    	for($i=0;$i<$this->sub_pages;$i++)
    	{  
    		$this->page_array[$i]=$i;  
    	}  
    	return $this->page_array;  
   	}  
    
    
	/** 
     *construct_num_Page该函数使用来构造显示的条目 
   	 *即使：[1][2][3][4][5][6][7][8] [9][10] 
   	 */  
	private function construct_num_Page()
	{  
    	if($this->pageNums < $this->sub_pages)
    	{  
    		$current_array=array();  
     		for($i=0;$i<$this->pageNums;$i++)
     		{   
     			$current_array[$i]=$i+1;  
     		}  
    	}else{  
    		$current_array=$this->initArray();  
     		if($this->current_page <= 3)
     		{  
      			for($i=0;$i<count($current_array);$i++)
      			{  
      				$current_array[$i]=$i+1;  
      			}  
     		}elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1 ){  
      			for($i=0;$i<count($current_array);$i++)
      			{  
      				$current_array[$i]=($this->pageNums)-($this->sub_pages)+1+$i;  
      			}  
     		}else{  
      			for($i=0;$i<count($current_array);$i++)
      			{  
      				$current_array[$i]=$this->current_page-2+$i;  
      			}  
     		}  
    	}  
    	return $current_array;  
   }  
    
	/** 
   	 *构造普通模式的分页 
   	 *共4523条记录,每页显示10条,当前第1/453 页 [首页] [上页] [下页] [尾页] 
   	 */  
	private function subPageCss1()
	{  
   		$subPageCss1Str="";  
   		$subPageCss1Str.=" 共".$this->nums."条记录，";  
   		$subPageCss1Str.=" 每页显示".$this->each_disNums."条，";  
   		$subPageCss1Str.=" 当前第".$this->current_page."/".$this->pageNums." 页 ";  
    	if($this->current_page > 1)
    	{  
    		$firstPageUrl=$this->subPage_link."1";  
    		$prewPageUrl=$this->subPage_link.($this->current_page-1);  
    		$subPageCss1Str.="[<a href='$firstPageUrl'>首页</a>] ";  
    		$subPageCss1Str.="[<a href='$prewPageUrl'>上一页</a>] ";  
    	}else {  
    		$subPageCss1Str.="[首页] ";  
    		$subPageCss1Str.="[上一页] ";  
    	}  
     
    	if($this->current_page < $this->pageNums){  
    		$lastPageUrl=$this->subPage_link.$this->pageNums;  
    		$nextPageUrl=$this->subPage_link.($this->current_page+1);  
    		$subPageCss1Str.=" [<a href='$nextPageUrl'>下一页</a>] ";  
    		$subPageCss1Str.="[<a href='$lastPageUrl'>尾页</a>] ";  
    	}else {  
    		$subPageCss1Str.="[下一页] ";  
    		$subPageCss1Str.="[尾页] ";  
    	}  
     
    	return $subPageCss1Str;  
   }  
    
    
	/** 
   	 *构造经典模式的分页 
   	 *当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页] 
   	 */  
	private function subPageCss2()
  	{  
   		$subPageCss2Str="";  
   		$subPageCss2Str.=" 当前第".$this->current_page."/".$this->pageNums." 页 ";  
	    if($this->current_page > 1)
	    {  
    		$firstPageUrl=$this->subPage_link."1";  
    		$prewPageUrl=$this->subPage_link.($this->current_page-1);  
    		$subPageCss2Str.="[<a href='$firstPageUrl'>首页</a>] ";  
    		$subPageCss2Str.="[<a href='$prewPageUrl'>上一页</a>] ";  
    	}else {  
    		$subPageCss2Str.="[首页] ";  
    		$subPageCss2Str.="[上一页] ";  
    	}  
     
   		$a=$this->construct_num_Page();  
    	for($i=0;$i<count($a);$i++)
    	{  
    		$s=$a[$i];  
     		if($s == $this->current_page ){  
     			$subPageCss2Str.="[<span style='color:red;font-weight:bold;'>".$s."</span>]";  
     		}else{  
     			$url=$this->subPage_link.$s;  
     			$subPageCss2Str.="[<a href='$url'>".$s."</a>]";  
     		}  
    	}  
     
    	if($this->current_page < $this->pageNums)
    	{  
    		$lastPageUrl=$this->subPage_link.$this->pageNums;  
    		$nextPageUrl=$this->subPage_link.($this->current_page+1);  
    		$subPageCss2Str.=" [<a href='$nextPageUrl'>下一页</a>] ";  
    		$subPageCss2Str.="[<a href='$lastPageUrl'>尾页</a>] ";  
    	}else {  
    		$subPageCss2Str.="[下一页] ";  
    		$subPageCss2Str.=" [尾页] ";  
    	}  
    	return $subPageCss2Str;  
   }  

	/** 
   	 *构造经典模式的分页 ，JS方法调用方式
   	 *当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页] 
   	 */  
	private function subPageCss3()
  	{  
   		$subPageCss2Str="";
   		$subPageCss2Str.= sprintf($this->_LANG['page_CountResult'],$this->nums);
   		$subPageCss2Str.=sprintf($this->_LANG['page_Countnums'],$this->current_page,$this->pageNums);  
	    if($this->current_page > 1)
	    {  
    		$firstPageUrl=$this->subPage_link."1";  
    		$prewPageUrl=$this->subPage_link.($this->current_page-1);  
    		$subPageCss2Str.="[<a href='javascript:".$this->subPage_link."(1)'>".$this->_LANG['page_first']."</a>] ";  
    		$subPageCss2Str.="[<a href='javascript:".$this->subPage_link."(".($this->current_page-1).")'>".$this->_LANG['page_prev']."</a>] ";  
    	}else {  
    		$subPageCss2Str.="[".$this->_LANG['page_first']."] ";  
    		$subPageCss2Str.="[".$this->_LANG['page_prev']."] ";  
    	}  
     
   		$a=$this->construct_num_Page();  
    	for($i=0;$i<count($a);$i++)
    	{  
    		$s=$a[$i];  
     		if($s == $this->current_page ){  
     			$subPageCss2Str.="<span class='pagenum'>[<span style='color:red;font-weight:bold;'>".$s."</span>]</span>";  
     		}else{  
     			$url=$this->subPage_link.$s;  
     			$subPageCss2Str.="<span class='pagenum'>[<a href='javascript:".$this->subPage_link."(".$s.")'>".$s."</a>]</span>";  
     		}  
    	}  
     
    	if($this->current_page < $this->pageNums)
    	{  
    		$lastPageUrl=$this->subPage_link.$this->pageNums;  
    		$nextPageUrl=$this->subPage_link.($this->current_page+1);  
    		$subPageCss2Str.=" [<a href='javascript:".$this->subPage_link."(".($this->current_page+1).")'>".$this->_LANG['page_next']."</a>] ";  
    		$subPageCss2Str.="[<a href='javascript:".$this->subPage_link."(".$this->pageNums.")'>".$this->_LANG['page_last']."</a>] ";  
    	}else {  
    		$subPageCss2Str.="[".$this->_LANG['page_next']."] ";  
    		$subPageCss2Str.=" [".$this->_LANG['page_last']."] ";  
    	}  
    	return $subPageCss2Str;  
   }  
   
     /** 
     *__destruct析构函数，当类不在使用的时候调用，该函数用来释放资源。 
   	 */  
  	public function __destruct()
  	{  
    	unset($this->each_disNums);  
    	unset($this->nums);  
	    unset($this->current_page);  
	    unset($this->sub_pages);  
	    unset($this->pageNums);  
	    unset($this->page_array);  
	    unset($this->subPage_link);  
	    unset($this->subPage_type);  
   	}  
}

?>