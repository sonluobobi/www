<nav>
  <ul class="pager">
  	{if $pre_pageid}
    <li class="previous"><a href="?p={$p}&auth_user={$auth_user}&auth_sign={$auth_sign}&pageid={$pre_pageid}">Previous</a></li>
    {/if}
    {if $next_pageid}
    <li class="next"><a href="?p={$p}&auth_user={$auth_user}&auth_sign={$auth_sign}&pageid={$next_pageid}">Next</a></li>
    {/if}
  </ul>
</nav>

