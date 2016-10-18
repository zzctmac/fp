/**
 * Created by <?=$owner?> on <?=$date?>.
 */

var <?=$name?> = {
    api : '<?=$api?>',
    validate: function(tel) {
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
    makeData: function(tel) {
        return {
        <?=$md."\n"?>
        };
    },
    callback:function(res) {
        console.log(res);
    },
    action:function(tel) {
        var isValid = this.validate(tel);
        if(true !== isValid) {
            this.validTip(isValid);
            return ;
        }
        var data = this.makeData(tel);
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
