{include file="header.tpl"}

<div class="container">


    <fieldset>
        <legend>魔域一各大区对应IP地址映射</legend>

        <table class="table table-hover">
            <tr>
                <td class="success">域名</td>
            </tr>
            {section name=sec loop=$data_list}
                <tr>
                    <td class="active">{$data_list[sec]}</td>
                </tr>
            {/section}
        </table>
    </fieldset>

</div>

{include file="footer.tpl"}
