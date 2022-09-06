<?php

$total = count($server_list);
$pageNums = ceil($total/$per_page_num);

if ($pageid < 1 || $pageid > $pageNums)
{
	$pageid = 1;
}

$cur_page_before = ($pageid -1 ) * $per_page_num; 
$offset = $cur_page_before >= $total ? 0 : $cur_page_before;
$server_list = array_slice($server_list, $offset, $per_page_num);
	
if (!empty($pageid) && !empty($pageNums))
{
	$pre_pageid = $pageid - 1;
	$next_pageid = $pageid + 1;

	if ($pre_pageid >= 1)
	{
		$smarty->assign('pre_pageid', $pre_pageid);
	}

	if ($next_pageid <= $pageNums)
	{
		$smarty->assign('next_pageid', $next_pageid);
	}

	$smarty->assign('show_page', 1);
}

