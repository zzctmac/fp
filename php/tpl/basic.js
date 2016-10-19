/**
 * Created by <?=$owner?> on <?=$date?>.
 */

var <?=$name?> = {
    api : '<?=$api?>',
    validate: function(<?=$v_p_str?>) {
        var res = true;
        do{
            <? foreach($validate as $vaItem) { ?>
                <?=$vaItem."\n"?>
            <? } ?>
        }while (false);
        return res;
    },
    validTip: function(msg) {
        <?=$vt."\n"?>
    },
    makeData: function(<?=$m_p_str?>) {
        return {
        <?=$md."\n"?>
        };
    },
    callback:function(res) {
        if(res.code == 1) {

        } else {
            alert(res.msg);
        }
    },
    action:function(<?=$p_str?>) {
        var isValid = this.validate(<?=$v_p_str?>);
        if(true !== isValid) {
            this.validTip(isValid);
            return ;
        }
        var data = this.makeData(<?=$m_p_str?>);
        var url = base_url + this.api;
        var type = 'GET';
        var dataType = 'JSON';
        $.ajax({
            url:url,
            type:type,
            dataType:dataType,
            data:data
        }).done(this.callback);
    }


};
